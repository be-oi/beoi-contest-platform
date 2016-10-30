<?php 
/* Copyright (c) 2012 Association France-ioi, MIT License http://opensource.org/licenses/MIT */

require_once("../shared/common.php");
require '../vendor/autoload.php';
use Aws\S3\S3Client;

header("Content-Type: application/json");
header("Connection: close");

initSession();

if (!isset($_SESSION["teamID"])) {
   echo json_encode(array('success' => false, 'message' => 'team not logged'));
   exit;
}
if (!isset($_SESSION["closed"])) {
   echo json_encode(array('success' => false, 'message' => 'contest is not over (solutions)!'));
   exit;
}
if (!isset($_SESSION["contestShowSolutions"]) || !intval($_SESSION["contestShowSolutions"])) {
   echo json_encode(array('success' => false, 'message' => 'solutions non disponibles pour ce concours'));
   exit;
}
$teamID = $_SESSION["teamID"];
$query = "SELECT `contest`.`ID`, `contest`.`folder`, `team`.score FROM `team` LEFT JOIN `group` ON (`team`.`groupID` = `group`.`ID`) LEFT JOIN `contest` ON (`group`.`contestID` = `contest`.`ID`) WHERE `team`.`ID` = ?";
$stmt = $db->prepare($query);
$stmt->execute(array($teamID));
if (!($row = $stmt->fetchObject())) {
   echo json_encode(array('success' => false, 'message' => 'contestID inconnu'));
   exit;
}

// if ($row->score == null) {
//    echo json_encode(array('success' => false, 'message' => 'Afichage de la solution : action impossible', 'row'=> $row, 'teamID' => $teamID));
//    exit;
// }

$contestID = $row->ID;
$contestFolder = $row->folder;

$ieMode = (isset($_POST['ieMode']) && $_POST['ieMode'] == 'true') ? true : false;
$solutions = null;
$solutionsUrl = null;
$error = null;
if ($config->teacherInterface->generationMode == 'local') {
   $solutions = file_get_contents(__DIR__.$config->teacherInterface->sContestGenerationPath.$contestFolder.'/contest_'.$contestID.'_sols.html');
} else if ($ieMode) {
   try {
      $s3Client = S3Client::factory(array(
         'region' => $config->aws->s3region,
         'version' => '2006-03-01'
      ));
      $solutions = $s3Client->getObject(array(
          'Bucket' => $config->aws->bucketName,
          'Key'    => 'contests/'.$contestFolder.'/contest_'.$contestID.'_sols.html'
      ));
      $solutions = $solutions['Body'].''; // need to cast to string
   } catch(S3Exception $e) {
      $error = $e->getMessage()."\n";
      error_log($error);
   }
} else {
   $s3Client = S3Client::factory(array(
      'region' => $config->aws->s3region,
      'version' => '2006-03-01'
   ));
   $cmd = $s3Client->getCommand('GetObject', [
      'Bucket' => $config->aws->bucketName,
      'Key'    => 'contests/'.$contestFolder.'/contest_'.$contestID.'_sols.html'
   ]);
   $request = $s3Client->createPresignedRequest($cmd, '+10 minutes');
   $solutionsUrl = (string) $request->getUri();
}

echo json_encode(array('success' => !$error, 'solutions' => $solutions, 'solutionsUrl' => $solutionsUrl, 'error' => $error));
