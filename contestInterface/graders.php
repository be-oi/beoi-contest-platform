<?php 
/* Copyright (c) 2012 Association France-ioi, MIT License http://opensource.org/licenses/MIT */

require_once "../shared/common.php";
require_once "common_contest.php";
require_once "i18n.php";
use Aws\S3\S3Client;

initSession();

if (!isset($_SESSION["teamID"])) {
   if (!isset($_POST["groupPassword"])) {
      exitWithJsonFailure(i18n()["missing_password"]);
   }
   if (!isset($_POST["teamID"])) {
      exitWithJsonFailure(i18n()["missing_team"]);
   }
   if (!isset($_SESSION["groupID"])) {
      exitWithJsonFailure(i18n()["group_not_loaded"]);
   }
   $password = strtolower(trim($_POST["groupPassword"]));
   reloginTeam($db, $password, $_POST["teamID"]);
}

$teamID = $_SESSION["teamID"];
$query = "SELECT `contest`.`ID` as `ID`, `contest`.`folder` as `folder`, `contest`.`status` as `status`, `contest`.`fullFeedback` as `fullFeedback` FROM `team` JOIN `group` ON (`team`.`groupID` = `group`.`ID`) JOIN `contest` ON (`group`.`contestID` = `contest`.`ID`) WHERE `team`.`ID` = ?";
$stmt = $db->prepare($query);
$stmt->execute(array($teamID));
if (!($row = $stmt->fetchObject())) {
   echo json_encode(array(
      'status' => 'fail',
      'reason' => i18n()["cannot_find_contest"]
   ));
   exit;
}

if ($row->fullFeedback == 0 && (!isset($_SESSION["closed"]) || $row->status == 'RunningContest' || $row->status == 'FutureContest')) {
   echo json_encode(array(
      'status' => 'fail',
      'reason' => i18n()["official_no_direct_score"]
   ));
   exit;
}

$contestID = $row->ID;
$contestFolder = $row->folder;

$ieMode = (isset($_POST['ieMode']) && $_POST['ieMode'] == 'true') ? true : false;
$gradersUrl = null;
$graders = null;
if ($config->teacherInterface->generationMode == 'local') {
   $graders = file_get_contents(__DIR__.$config->teacherInterface->sContestGenerationPath.$contestFolder.'/contest_'.$contestID.'_graders.html');
} else if (!$row->fullFeedback && !$ieMode) {
   require '../vendor/autoload.php';
   $s3Client = S3Client::factory(array(
      'region' => $config->aws->s3region,
      'version' => '2006-03-01'
   ));
   $cmd = $s3Client->getCommand('GetObject', [
      'Bucket' => $config->aws->bucketName,
      'Key'    => 'contests/'.$contestFolder.'/contest_'.$contestID.'_graders.html'
   ]);
   $request = $s3Client->createPresignedRequest($cmd, '+10 minutes');
   $gradersUrl = (string) $request->getUri();
} else if ($ieMode) {
   $s3Client = S3Client::factory(array(
      'region' => $config->aws->s3region,
      'version' => '2006-03-01'
   ));
   $graders = $s3Client->getObject(array(
       'Bucket' => $config->aws->bucketName,
       'Key'    => 'contests/'.$contestFolder.'/contest_'.$contestID.'_graders.html'
   ));
   $graders = $graders['Body'].''; // need to cast to string
} else {
   $gradersUrl = $config->teacherInterface->sAbsoluteStaticPath.'/contests/'.$contestFolder.'/contest_'.$contestID.'_graders.html';
}

header("Content-Type: application/json");
header("Connection: close");

echo json_encode(array(
   'status' => 'success',
   'graders' => $graders,
   'gradersUrl' => $gradersUrl,
   'bonusScore' => $_SESSION["bonusScore"]
));
