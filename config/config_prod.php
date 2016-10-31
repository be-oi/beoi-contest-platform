<?php

$config->db->use = 'mysql'; // or dynamoDB
$config->db->dynamoSessions = true;
$config->teacherInterface->generationMode = 'aws+local';
$config->teacherInterface->sAssetsStaticPath = 'https://manage-static.be-oi.be/contestAssets';
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