<?php

require_once("../shared/common.php");
require_once("commonAdmin.php");
require_once("i18n.php");

if (!isset($_SESSION["userID"])) {
   echo i18n()["session_expired"];
   exit;
}

if (function_exists('getNextContestData')) {
  	$data = getNextContestData();
  	echo json_encode(['success' => true, 'data' => $data]);
} else {
	echo json_encode(['success' => false]);
}

