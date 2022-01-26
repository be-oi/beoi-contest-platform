<?php

$config->db->use = 'mysql'; // or dynamoDB
$config->db->dynamoSessions = true;
$config->teacherInterface->generationMode = 'aws';
$config->teacherInterface->sAssetsStaticPath = 'https://manage-static.be-oi.be/contestAssets';
$config->teacherInterface->sAbsoluteStaticPath = 'https://manage-static.be-oi.be';
$config->teacherInterface->countryCode = 'BE';
$config->timezone = 'Europe/Brussels';
$config->email->bSendMailForReal = true;
$config->email->sEmailInsriptionBCC = null;
$config->email->smtpHost = 'email-smtp.eu-west-1.amazonaws.com';
$config->email->smtpPort = '587';
$config->email->smtpSecurity = 'tls'; // to fill PHPMailer->SMTPSecure, "tls" or "ssl"
$config->email->smtpUsername = $_ENV['SMTP_USERNAME'];
$config->email->smtpPassword = $_ENV['SMTP_PASSWORD'];
$config->email->sInfoAddress = 'inscription@be-oi.be';
$config->teacherInterface->forceOfficialEmailDomain = false; // not forcing email, but checking it manually with the email.

$config->enableAwardTab = false;
$config->contestInterface->sessionLength = 36000;
$config->certificates->confIndexForThisPlatform = 0; // index of the conf in certificates/ (you shouldn't need to change it)
$config->certificates->allow = true;
$config->certificates->background = 'images/certificate.png';
$config->certificates->logo = 'images/logo-beoi-white.png';
$config->certificates->yearBackground = 'images/certificate.png';
$config->certificates->partnerLogos = [];
$config->certificates->titleFontSize = 20;
$config->certificates->url = "http://www.be-oi.be";
$config->certificates->mainColor = "black";
$config->certificates->showYear = true;
$config->certificates->nbContestants = '{"CAD": 280, "JUN": 380, "SEN": 512}';
