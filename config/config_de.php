<?php

$config->defaultLanguage = 'de';
$config->contestPresentationURL = 'http://beoi.be-oi.be/fr/';

$config->contestOfficialURL = 'https://wettbewerb.be-oi.be';

$config->contestInterface->baseUrl = 'https://wettbewerb.be-oi.be';
$config->contestInterface->sAbsoluteStaticPathNoS3 = 'https://wettbewerb.be-oi.be';
$config->contestInterface->sAssetsStaticPathNoS3 = 'https://wettbewerb.be-oi.be';

$config->teacherInterface->baseUrl = 'https://gestion.be-oi.be';
$config->teacherInterface->sCoordinatorFolder = 'https://gestion.be-oi.be';
$config->teacherInterface->sAbsoluteStaticPathOldIE = 'https://gestion.be-oi.be';

$config->validationMailBody = "Bonjour,\r\n\r\nPour valider votre inscription en tant que coordinateur pour le concours Castor, ouvrez le lien suivant dans votre navigateur  : \r\n\r\n%s\r\n\r\nN'hésitez pas à nous contacter si vous rencontrez des difficultés.\r\n\r\nCordialement,\r\n-- \r\nL'équipe du Castor Informatique";
$config->validationMailTitle = "Éliminatoires beOI : Confirmation d'inscription";