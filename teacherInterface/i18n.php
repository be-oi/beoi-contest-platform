<?php

function i18n() {
   global $config;

   $base = __DIR__.'/i18n/'.$config->defaultLanguage."/translation.json";
   $countryOverride = __DIR__.'/i18n/'.$config->defaultLanguage."/".strtolower($config->teacherInterface->domainCountryCode).".json";

   if (is_readable($base)) {
   	  $strings = json_decode(file_get_contents($base), true);

   	  if (is_readable($countryOverride)) {
   	  	$countryStrings = json_decode(file_get_contents($countryOverride), true);
   	  	$strings = $countryStrings + $strings;
   	  }

   	  return $strings;
   }
   else {
      return array();
   }
}

$i18n = i18n();
global $i18n;
