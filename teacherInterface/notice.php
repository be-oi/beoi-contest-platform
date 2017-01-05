<?php
/* Copyright (c) 2012 Association France-ioi, MIT License http://opensource.org/licenses/MIT */

require_once("../shared/common.php");
require_once("commonAdmin.php");
require_once('./config.php');
require_once('./i18n.php');

if ($config->customStringsName) {
   $translations = json_decode(file_get_contents('i18n/fr/translation.json'), true);
   $translations = array_merge($translations, json_decode(file_get_contents('i18n/fr/'.$config->customStringsName.'.json'), true));
} else {
   $translations = json_decode(file_get_contents('i18n/fr/translation.json'), true);
}

if (!isset($_SESSION["userID"])) {
   echo i18n()["session_expired"];
   exit;
}

$query = "
   SELECT 
      `contest`.`name` AS `contestName`,
      `contest`.`allowTeamsOfTwo`,
      `school`.`name` AS `schoolName`,
      `group`.`id` AS `groupID`, 
      `group`.`name` AS `groupName`, 
      `group`.`userID`, 
      `group`.`expectedStartTime`, 
      `group`.`grade`, 
      `group`.`code`, 
      `group`.`password`
   FROM `group` 
   LEFT JOIN `contest` 
   ON (`group`.`contestID` = `contest`.`ID`) 
   LEFT JOIN school 
   ON (`group`.`schoolID` = `school`.`ID`) 
   WHERE 1 = 1
";
$params = array();

// If a group is specified, restrict it to this group
if (isset($_GET["groupID"])) {
   $query .= " AND `group`.`ID` = :groupID";
   $params["groupID"] = $_GET["groupID"];
}

// If not admin, only allow access to the correct user
if (!$_SESSION["isAdmin"]) {
   $query .= " AND `group`.`userID` = :userID";
   $params["userID"] = $_SESSION["userID"];
}

// Choose order
$query .= " ORDER BY `contest`.level ASC, groupName ASC";

$stmt = $db->prepare($query);
$stmt->execute($params);

$aGroups = array();
while ($row = $stmt->fetchObject())
{

   $query = "UPDATE `group` SET `noticePrinted` = 1 WHERE  `group`.`ID` = :groupID";
   $stmtSub = $db->prepare($query);
   $stmtSub->execute(array("groupID" => $row->groupID));
   $aGroups[] = $row;
}

if (count($aGroups) == 0) {
   echo "Requête invalide";
   exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
   script_tag('/bower_components/jquery/jquery.min.js');
   script_tag('/bower_components/jquery-ui/jquery-ui.min.js');
   script_tag('/admin.js');
?>
<title>Impression de la notice</title>
<style>
   * {
      font-family: Arial, sans-serif;
   }
   .break { 
      page-break-before: always; 
   }
   .groupCode {
      text-align:center;
      color:gray;
      font-family: "Courier New", Courier, "Nimbus Mono L", monospace;
      font-size:1.3em;
   }

   h1 {
      text-align: center;
      margin: 0.1em 0;
   }

   li {
      line-height: 1.4em;
   }
   .red {
      color:red
   }
   .warning {
      text-align: center;
      font-size:1.5em;
      font-weight:bold;
   }
   .header {
      border: solid 1px black;
      text-align: center;
      font-size: 1.3em;
   }
   .footer {
      border: solid black 1px;
      padding:5px;
   }
   .centered {
      text-align: center;
   }
</style>
</head>
<body onload="window.print()">

<?php foreach ($aGroups as $id => $row): ?>
<h1 <?php if ($id !=0):?>class="break"<?php endif;?>>
<?php echo $translations['notice_title_contest'] ?><br/>
<?php echo $row->contestName ?><br/>
<span class="red"><?php echo i18n()["notice_title"]; ?></span>
</h1>

<div class="warning"><?php echo i18n()["notice_dont_show"]; ?></div>
<div class="header">
<?php echo $row->schoolName;?>
<br/>
Groupe <b>
<?php
   echo $row->groupName."</b> ";
   if ($row->expectedStartTime == "0000-00-00 00:00:00") {
      echo i18n()["notice_at_undetermined_date"];
   } else {
      $datetime = strtotime($row->expectedStartTime);
      if ($datetime == "") {
         echo i18n()["notice_at_undetermined_date"];
      } else {
         echo "le <b><script>document.write(utcDateFormatter('".$row->expectedStartTime."'));</script></b>";
      }
   }
?>
</div>

<ol>
<li><?php echo i18n()["notice_contestants_sit"]; ?>
<?php
   if ($row->allowTeamsOfTwo == 1) {
      echo i18n()["notice_by_teams"]." ";
   } else {
      echo i18n()["notice_alone"]." ";
   }
?>
<?php echo i18n()["notice_per_computer"]; ?></li>
<li>
<?php echo i18n()["notice_open_browser"]; ?> <br/>
<center><a href='<?php echo $config->contestOfficialURL; ?>'><?php echo $config->contestOfficialURL; ?></a></center>
</li>
<li>
<?php echo i18n()["notice_enter_code"]; ?><br/>
<div class="groupCode"><?php echo $row->code ?></div>
<?php echo i18n()["notice_code_validity"]; ?>
</li>
<li><?php echo i18n()["notice_start_contest"]; ?></li>
<?php
   if ($row->allowTeamsOfTwo == 1) {
      echo "<li>".i18n()["notice_choose_team_setup"]."</li>";
   }
?>
<li><?php echo i18n()["notice_enter_name"]; ?></li>
<li><?php echo i18n()["notice_get_code"]; ?></li>
<li><?php echo i18n()["notice_start"]; ?></li>
<li><?php echo i18n()["notice_time_start"]; ?></li>
<li><?php echo i18n()["notice_time_end"]; ?></li>
</ol>

<div class="footer">
   <b><?php echo i18n()["notice_issue_disconnect_title"]; ?></b>
   <ol>
   <li><?php echo i18n()["notice_back_on_website"]; ?> <a href='<?php echo $config->contestOfficialURL; ?>'><?php echo $config->contestOfficialURL; ?></a></li>
   <li><?php echo i18n()["notice_click_continue"]; ?></li>
   <li><?php echo i18n()["notice_enter_user_code"]; ?></li>
   <li><?php echo i18n()["notice_if_no_code"]; ?>
      <ul>
      <li><?php echo i18n()["notice_enter_group_code"]; ?> <span class="groupCode"><?php echo $row->code ?></span></li>
      <li><?php echo i18n()["notice_select_team"]; ?></li>
      <li><?php echo i18n()["notice_enter_backup_code"]; ?> <span class="groupCode"><?php echo $row->password ?></span></li>
      </ul>
   </li>
   </ol>
   <?php echo i18n()["notice_hotline_title"]; ?>
   <?php 
      if ($config->teacherInterface->sHotlineNumber != '') {
         echo $config->teacherInterface->sHotlineNumber." ; ";
      }
      echo $config->email->sInfoAddress;   
      if ($config->contestBackupURL != '') {
         $strBackup = "<br/><br/>".i18n()["notice_if_website_not_working"]."<a href='".$config->contestBackupURL."'>".$config->contestBackupURL."</a>";
		 for ($i = 2; $i <= 4; $i++) {
			 $property = "contestBackupURL".$i;
			 if (isset($config->$property) && ($config->$property != '')) {
				 $strBackup .= ", <a href='".$config->$property."'>".$config->$property."</a>";
			 }
		 }
		 echo $strBackup;
      }
   ?>
</div>

<?php endforeach; ?>

</body>
</html>
