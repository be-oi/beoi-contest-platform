<?php
  include('./config.php');
  header('Content-type: text/html');
?><!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
<title data-i18n="page_title"></title>
<link href="https://fonts.googleapis.com/css?family=Lato|Sorts+Mill+Goudy|Varela+Round" rel="stylesheet">
<!-- Varela Round needed for Alkindi -->
<?php
function imageToBase64($path) {
   return 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' .
          base64_encode(file_get_contents($path));
}

script_tag('/bower_components/pdfmake/build/pdfmake.js');
script_tag('/bower_components/jquery/jquery.min.js');
script_tag('/bower_components/jquery-ui/jquery-ui.min.js'); // for $.datepicker.formatDate
script_tag('/bower_components/i18next/i18next.min.js');
script_tag('/printCertificatesPdf.js');

?>

<script type="text/javascript">

 window.i18nconfig = <?= json_encode([
   'lng' => $config->defaultLanguage,
   'fallbackLng' => [$config->defaultLanguage],
   'fallbackNS' => 'translation',
   'ns' => [
    'namespaces' => $config->customStringsName ? [$config->customStringsName, 'translation'] : ['translation'],
    'defaultNs' => $config->customStringsName ? $config->customStringsName : 'translation',
   ],
   'getAsync' => true,
   'resGetPath' => static_asset('/i18n/__lng__/__ns__.json')
 ]); ?>;



var allImages = {
   background: "<?= imageToBase64($config->certificates->background) ?>",
   logo: "<?= imageToBase64($config->certificates->logo) ?>",
   yearBackground: "<?= imageToBase64($config->certificates->yearBackground) ?>"
}
<?php

$partnerImagesInfos = array();
$maxLogoHeight = 0;
$finalWidth = 100;
$logoStartX = 650 - (count($config->certificates->partnerLogos) * 80 - 10) / 2;
foreach ($config->certificates->partnerLogos as $fileName) {
   $imageInfo = getimagesize($fileName);
   $width = intVal($imageInfo[0]);
   $height = intVal($imageInfo[1]) * $finalWidth / $width;
   if ($height > $maxLogoHeight) {
      $maxLogoHeight = $height;
   }
   $partnerImagesInfos[] = array($fileName, $height);
}
$strJS = "var partnerLogos = [\n";
foreach ($partnerImagesInfos as $iLogo => $logoInfo) {
   $strJS .= "{ stack:[{image: '" . imageToBase64($logoInfo[0]) .
              "', width:70}], absolutePosition: {x:" . ($logoStartX + ($iLogo * 80)) . ", y:" .
              (535 + ($maxLogoHeight - $logoInfo[1]) / 2) . " } },\n";
}
$strJS .= "];";

echo $strJS;

?>
var contestName = '<?=$config->certificates->title?>';
var qualificationText = '<?=$config->certificates->qualificationText?>';
var contestUrl = '<?=$config->certificates->url?>';
var mainColor = '<?=$config->certificates->mainColor?>';
var accentColor = '<?=$config->certificates->accentColor?>';
var showYear = <?=$config->certificates->showYear?>;
var nbContestants = <?=$config->certificates->nbContestants?>;
</script>
<style>
   /*
font-family: 'Sorts Mill Goudy', serif;
font-family: 'Varela Round', sans-serif;
   */
   body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      color: #4A5785;
      line-height: 1;
   }
   .bigmessage {
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      margin-top: 30px;
   }
</style>
</head>
<body>
<div style="text-align: center">
   <p class="bigmessage" data-i18n="certificates_genpage_title"></p>

   <div id="preload">
      <p data-i18n="certificates_genpage_preload1"></p>
      <p data-i18n="certificates_genpage_preload2"></p>
   </div>

   <div id="loaded" style="display:none;text-align:center">
      <div style="width:600px;background:#EEE;border:solid black 1px;margin:auto" data-i18n="[html]certificates_genpage_explanation"> </div>
      <br/>
      <div style="border:solid black 1px;margin:auto;padding:5px;text-align:left;width:600px;">
         <p data-i18n="certificates_genpage_options"></p>
         <p><input type="checkbox" id="qualifiedOnly" onchange="updateNbDiplomas()"></input><span data-i18n="certificates_genpage_qualified"></span></p>
         <!-- <p><input type="checkbox" id="topRankedOnly" onchange="updateNbDiplomas()"></input><span data-i18n="certificates_genpage_perc_part1"></span> <input type="number" id="minRankPercentile" style="width:40px;text-align:center" value="50" onchange="updateNbDiplomas()"/></input>% <span data-i18n="certificates_genpage_perc_part2"></span> </p> -->
         <p><span data-i18n="certificates_genpage_to_print"></span> <span id="printedCertificates"></span> <span data-i18n="certificates_genpage_on"></span> <span id="totalCertificates"></span>
      </div>
      <br/>
      <p><span data-i18n="certificates_genpage_genpdf"></span> <input type="number" id="diplomasPerPart" value="100" style="width:40px" onchange="updateNbDiplomas()"></input> <span data-i18n="certificates_genpage_certificate"></span>.<br/>(<span data-i18n="certificates_genpage_cert_number_expl"></span>)</p>
      <div id="buttons">
      </div>
   </div>

</div>
<?php
   global $config;
   $language = $config->defaultLanguage;
   $countryCode = $config->teacherInterface->countryCode;
   $domainCountryCode = $config->teacherInterface->domainCountryCode;
   script_tag('/bower_components/i18next/i18next.min.js');
   script_tag('/regions/' . strtoupper($countryCode) . '/regions.js');
?>
<script type="text/javascript">
   window.config = <?= json_encode([
      'defaultLanguage' => $language,
      'maintenanceUntil' => $config->maintenanceUntil,
      'countryCode' => $countryCode,
      'domainCountryCode' => $domainCountryCode,
      'infoEmail' => $config->email->sInfoAddress,
      'forceOfficialEmailDomain' => $config->teacherInterface->forceOfficialEmailDomain,
      'contestPresentationURL' => $config->contestPresentationURL,
      'contestURL' => $config->contestInterface->baseUrl,
      'i18nResourcePath' => static_asset('/i18n/__lng__/__ns__.json'),
      'customStringsName' => $config->customStringsName,
      'allowCertificates' => $config->certificates->allow,
      'useAlgoreaCodes' => $config->teacherInterface->useAlgoreaCodes,
   ]) ?>;  
   i18n.init({
      lng: config.defaultLanguage,
      fallbackLng: [config.defaultLanguage],
      getAsync: true,
      resGetPath: config.i18nResourcePath,
      fallbackNS: 'translation',
      ns: {
         namespaces: config.customStringsName ? [config.customStringsName, 'translation', 'country' + config.countryCode] : ['translation', 'country' + config.countryCode],
         defaultNs: config.customStringsName ? config.customStringsName : 'translation',
      },
      useDataAttrOptions: true
   }, function () {
      $("title").i18n();
      $("body").i18n();
   });
</script>
</body>
</html>