<?php

$config->db->use = 'mysql'; // or dynamoDB
$config->db->dynamoSessions = false;
$config->db->mysql->extra_session_options = "sql_mode = \"NO_ENGINE_SUBSTITUTION\"";
$config->teacherInterface->generationMode = 'local';
$config->teacherInterface->sAssetsStaticPath = 'http://127.0.0.1/contestInterface';
$config->teacherInterface->sAbsoluteStaticPath = 'http://127.0.0.1/contestInterface';
$config->teacherInterface->countryCode = 'BE';
$config->timezone = 'Europe/Brussels';
$config->email->bSendMailForReal = true;
$config->email->sEmailInsriptionBCC = null;
$config->email->smtpHost = 'email-smtp.eu-west-1.amazonaws.com';
$config->email->smtpPort = '587';
$config->email->smtpSecurity = 'tls'; // to fill PHPMailer->SMTPSecure, "tls" or "ssl"
$config->email->smtpUsername = $_ENV['SMTP_USERNAME'];
$config->email->smtpPassword = $_ENV['SMTP_PASSWORD'];
$config->email->sInfoAddress = 'info@be-oi.be';
$config->teacherInterface->forceOfficialEmailDomain = false;

$config->enableAwardTab = false;
$config->contestInterface->sessionLength = 36000;

$config->defaultLanguage = 'fr';
$config->contestPresentationURL = 'http://127.0.0.1/';

$config->contestOfficialURL = "http://127.0.0.1";

$config->contestInterface->baseUrl = 'http://127.0.0.1/contestInterface';
$config->contestInterface->sAbsoluteStaticPathNoS3 = 'http://127.0.0.1/contestInterface';
$config->contestInterface->sAssetsStaticPathNoS3 = 'http://127.0.0.1/contestInterface';

$config->teacherInterface->baseUrl = 'http://127.0.0.1/teacherInterface';
$config->teacherInterface->sCoordinatorFolder = 'http://127.0.0.1/teacherInterface';
$config->teacherInterface->sAbsoluteStaticPathOldIE = 'http://127.0.0.1/teacherInterface';
