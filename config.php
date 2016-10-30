<?php

// Do not modify this file, but override the configuration
// in a config_local.php file based on config_local_template.php

global $config;
$config = (object) array();

$config->maintenanceUntil = null; // maintenance end time (null if no maintenance)

$config->faviconfile = 'favicon.png';

$config->db = (object) array();
$config->db->use = 'mysql';
$config->db->dynamoSessions = false;
$config->db->dynamoDBPrefix = ''; // prefix for team and team_question
$config->db->testMode = false;

// MySQL
$config->db->mysql = (object) array();
$config->db->mysql->host = $_ENV['DATABASE_HOST']?:'localhost';
$config->db->mysql->database = $_ENV['DATABASE_NAME']?:'unknowndb';
$config->db->mysql->password = $_ENV['DATABASE_PASSWORD']?:'';
$config->db->mysql->user = $_ENV['DATABASE_USER']?:'unknownuser';
$config->db->mysql->logged = false;

// Emails
$config->email = (object) array();
$config->email->sFileStoringSentMails = 'logs/mails.txt';
$config->email->bSendMailForReal = false;
$config->email->sEmailSender = 'info@be-oi.be';
$config->email->sEmailInsriptionBCC = null;
$config->email->smtpHost = '';
$config->email->smtpPort = '';
$config->email->smtpSecurity = ''; // to fill PHPMailer->SMTPSecure, "tls" or "ssl"
$config->email->smtpUsername = '';
$config->email->smtpPassword = 'PASSWORD';
$config->email->sInfoAddress = 'info@be-oi.be';

$config->aws = (object) array();
$config->aws->region = $_ENV['AWS_REGION'];
$config->aws->bucketName = $_ENV['AWS_BUCKET'];
$config->aws->s3region = $_ENV['AWS_REGION'];

$config->contestInterface = (object) array();
// Point contestInterface->baseUrl to an URL serving the contestInterface directory.
$config->contestInterface->baseUrl = '';
$config->contestInterface->sAbsoluteStaticPathNoS3 = '';
$config->contestInterface->sAssetsStaticPathNoS3 = '';
$config->contestInterface->sessionLength = 3600;

$config->teacherInterface = (object) array();
$config->teacherInterface->sHotlineNumber = '';
$config->teacherInterface->sCoordinatorFolder = '';
$config->teacherInterface->sAssetsStaticPath = '';
$config->teacherInterface->sAbsoluteStaticPath = '';
$config->teacherInterface->genericPasswordMd5 = '';
$config->teacherInterface->countryCode = 'BE';
$config->teacherInterface->domainCountryCode = 'BE';
$config->teacherInterface->generationMode = 'local';
$config->teacherInterface->sAbsoluteStaticPathOldIE = '';
$config->teacherInterface->sContestGenerationPath = '/../contestInterface/contests/'; // *MUST* be relative!
$config->teacherInterface->forceOfficialEmailDomain = false;
$config->teacherInterface->useAlgoreaCodes = false; // change if your award is an acess code for another contest
// Point teacherInterface->baseUrl to an URL serving the teacherInterface directory.
$config->teacherInterface->baseUrl = '';
$config->teacherInterface->teacherPersonalCodeContestID = 0;

$config->certificates = (object) array();
$config->certificates->webServiceUrl = 'http://castor-informatique.fr.localhost/certificates/';
$config->certificates->allow = false;
$config->certificates->confIndexForThisPlatform = 0; // index of the conf in certificates/ (you shouldn't need to change it)

$config->timezone = ini_get('date.timezone');
$config->defaultLanguage = 'fr';
$config->contestPresentationURL = '';
$config->contestOfficialURL = '';
$config->contestBackupURL = '';
$config->customStringsName = null; // see README

$config->validationMailBody = "";
$config->validationMailTitle = "";

if (is_readable(__DIR__.'/config_local.php')) {
   include_once __DIR__.'/config_local.php';
}

/* Subsite configs */

$lang_mapping = [
  'contest-fr.be-oi.be' => 'fr',
  'concours.be-oi.be' => 'fr',
  'gestion.be-oi.be' => 'fr',
  'contest-fr.be-oi.be' => 'nl',
  'wedstrijd.be-oi.be' => 'nl',
  'beheer.be-oi.be' => 'nl',
];

$lang = 'fr';
foreach ($lang_mapping as $domain => $l) {
    if (strpos($_SERVER['HTTP_HOST'], $domain) !== FALSE) {
        $lang = $l;
    }
}

require_once __DIR__.'/config/config_'.$lang.'.php';

/* end subsite */

date_default_timezone_set($config->timezone);

// for dbv...
$config->db->host = $config->db->mysql->host;
$config->db->database = $config->db->mysql->database;
$config->db->password = $config->db->mysql->password;
$config->db->user = $config->db->mysql->user;