<?php
  include(__DIR__.'/config.php');
  include(__DIR__.'/i18n.php');
  header('Content-type: text/html');
?><!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="<?= $config->faviconfile ?>" />
<title data-i18n="general_page_title"></title>
<?php stylesheet_tag('/style.css'); ?>
</head><body>
<div id="divHeader">
    <div style="z-index: 10; position: absolute; right: 0; top: 0; font-variant: small-caps;">
      <a href="https://concours.be-oi.be">fr</a>
      - <a href="https://wedstrijd.be-oi.be">nl</a>
      - <a href="https://wettbewerb.be-oi.be">de</a>
    </div>
   <div id="leftTitle" data-i18n="[html]left_title"></div>
   <div id="headerGroup">
      <h1 id="headerH1" data-i18n="general_title"></h1>
      <h2 id="headerH2" data-i18n="general_subtitle"></h2>
      <p id="login_link_to_home" data-i18n="[html]general_instructions"></p>
   </div>
</div>
<form id="mainContent" autocomplete="off">

  <div id="browserAlert" data-i18n="[html]browser_support"></div>


  <nav id="mainNav">
    <ul>
      <li id="button-school" class="selected" onclick="selectMainTab('school');return false;" data-i18n="general_nav_start_contest"></li>
      <li id="button-home" onclick="selectMainTab('home');return false;" data-i18n="general_nav_public_contests"></li>
      <li id="button-continue" onclick="selectMainTab('continue');return false;" data-i18n="general_nav_continue_contest"></li>
  <!--
    <li id="button-results" onclick="selectMainTab('results');return false;" data-i18n="general_nav_view_results"></li>
      <li id="button-contests" onclick="selectMainTab('contests');return false;" data-i18n="general_nav_view_other_contests"></li>
  -->
    </ul>
  </nav>
  <div id="divCheckGroup" class="dialog">
  <div id="tab-home" style="display:none" class="tabContent">
    <div class="tabTitle" data-i18n="general_public_contests"></div>
      <!-- Display the first div during the contest week -->
      <div id="warningPublicGroups" style="display:none;background:#F33;width:650px;text-align:center;padding:5px;margin:10px">
         <p><b data-i18n="tab_home_warning_not_contest"></b></p>
         <button type="button" onclick="selectMainTab('school');return false;" data-i18n="[html]tab_home_button_wrong_choice"></button>
         <button type="button" onclick="confirmPublicGroup();return false;" data-i18n="[html]tab_home_button_confirm_choice"></button>
      </div>
      <div id="publicGroups" style="display:block">
         <span id="loadPublicGroups" style="color:red" data-i18n="tab_public_loading"></span>
         <div id="contentPublicGroups" style="display:none;width:800px">
            <p><b data-i18n="[html]tab_public_contests_info"></b></p>
            <!--<p data-i18n="[html]tab_public_contests_score_explanation"></p>-->
            <div id="listPublicGroups">
            </div>
            <p data-i18n="[html]tab_public_contests_organization"></p>
         </div>
      </div>
  </div>

  <div id="tab-school" class="tabContent">
    <div class="tabTitle" data-i18n="general_start_contest"></div>
      <!--
      <p>Pour <b>voir votre score détaillé</b> si vous avez participé au concours 2012, cliquez sur "Continuer le concours" et saisissez votre code personnel fourni au début de l'épreuve. Vous aurez aussi accès aux réponses et à une <b>correction détaillée</b> en dessous de chaque question.</p>
      <h3>Vous démarrez un concours en classe, pour la première fois ?</h3>
      -->
      <p data-i18n="[html]tab_start_contest_enter_code"><br />
         <div class="divInput">
            <input id="groupCode" type="text"/>
               &nbsp;&nbsp;&nbsp;<button type="button" id="buttonCheckGroup" onclick="checkGroup()" data-i18n="tab_start_contest_start_button"></button>
               <br /><span id="CheckGroupResult" style="color:red"></span>
         </div>
      </p>
      <div id="recoverGroup" style="display:none;">
         <p data-i18n="[html]group_session_expired_recover"></p>
         <input id="recoverGroupPass" type="password"/>
         &nbsp;&nbsp;&nbsp;<button type="button" id="buttonRecoverGroup" onclick="recoverGroup()" data-i18n="submitPass"></button>
         <br><span id="recoverGroupResult" style="color:red"></span>
         <p data-i8n="[html]others_retry"></p>
      </div>
	  <div id="selectLanguage" style="display:none">
		 <p>
			Quel langage souhaitez-vous utiliser pour ce concours ?
		 </p>
		 <br/>
		 <p>
			 <button type="button" id="buttonBlockly" onclick="checkGroup('blockly')">Blockly</button> <b>Ce que nous vous conseillons pour ce concours.</b>
		 </p>
		 <br/>
		 <p>
			 <button type="button" id="buttonBlockly" onclick="checkGroup('scratch')">Scratch</button> Si vous avez l'habitude de Scratch.<br/>
          Attention : ne fonctionne bien qu'avec les navigateurs Google Chrome ou Mozilla Firefox récents.
		 </p>
		 <br/>
		 <p>
			 <button type="button" id="buttonPython" onclick="checkGroup('python')">Python</button> Si vous maîtrisez bien ce langage.<br/>
          Attention : ne fonctionne bien qu'avec les navigateurs Google Chrome ou Mozilla Firefox récents.
		 </p>
	  </div>
  </div>

  <div id="tab-continue" style="display:none" class="tabContent">
    <div class="tabTitle" data-i18n="general_continue_contest"></div>
      <p><span data-i18n="tab_view_results_access_code"></span>
         <div class="divInput">
            <input id="interruptedPassword" type="password">
            &nbsp;&nbsp;&nbsp;<button type="button" id="buttonInterrupted" onclick="checkPasswordInterrupted()" data-i18n="tab_view_results_view_results_button"></button>
            <br/><span id="InterruptedResult" style="color:red"></span>
          </div>
      </p>
      <p data-i18n="tab_view_results_info_1"></p>
      <p><b data-i18n="tab_view_results_info_2"></b></p>
      <!--<p>Si vous ne disposez pas de mot de passe mais que vous êtes en classe, alors entrez le code de groupe fourni par votre enseignant.</p>-->
      <p data-i18n="tab_view_results_info_3"></p>
      <p data-i18n="tab_view_results_info_4"></p>
      <div id="divRelogin" style="display:none">
         <p data-i18n="tab_view_select_team_in_list"></p>
         <p><select id="selectTeam"><option value='0' data-i18n="tab_view_select_team"></option></select></p>
         <p data-i18n="tab_view_ask_password_to_teacher"></p>
         <p>
            <div class="divInput">
                   <input id="groupPassword" type="password">
                   &nbsp;&nbsp;&nbsp;<button type="button" id="buttonRelogin" onclick="relogin()" data-i18n="tab_view_restart_contest"></button>
                   <br/><span id="ReloginResult" style="color:red"></span>
             </div>
         </p>
      </div>
  </div>

  <div id="tab-results" style="display:none" class="tabContent">
    <div class="tabTitle" data-i18n="general_view_results"></div>
    <p data-i18n="tab_view_results_access_code"></p>
    <div class="divInput">
      <input id="interruptedPassword" type="password">&nbsp;&nbsp;&nbsp;<button type="button" id="buttonInterrupted" onclick="checkPasswordInterrupted()" data-i18n="tab_view_results_view_results_button"></button>
      <br/><span id="InterruptedResult" style="color:red"></span>
    </div>
    <p data-i18n="tab_view_results_info_1"></p>
    <p><b data-i18n="tab_view_results_info_2"></b></p>
    <!--<p>Si vous ne disposez pas de mot de passe mais que vous êtes en classe, alors entrez le code de groupe fourni par votre enseignant.</p>-->
    <p data-i18n="tab_view_results_info_3"></p>
    <p data-i18n="tab_view_results_info_4"></p>
    <div id="divRelogin" style="display:none">
      <p data-i18n="tab_view_select_team_in_list"></p>
      <select id="selectTeam"><option value='0' data-i18n="tab_view_select_team"></option></select>
      <p data-i18n="tab_view_ask_password_to_teacher"></p>
      <div class="divInput">
        <input id="groupPassword" type="password">&nbsp;&nbsp;&nbsp;<button type="button" id="buttonRelogin" onclick="relogin()" data-i18n="tab_view_restart_contest"></button>
        <br/><span id="ReloginResult" style="color:red"></span>
      </div>
    </div>
  </div>

  <div id="tab-contests" style="display:none" class="tabContent">
    <div class="tabTitle" data-i18n="general_view_other_contests"></div>
    <div data-i18n="[html]tab_view_other_contests"></div>
  </div>
</div>

<div id="divCheckNbContestants" style="display:none" class="dialog">
  <p data-i18n="nb_contestants_question"></p>
  <div class="divInput">
    <button type="button" onclick="setNbContestants(1)" data-i18n="nb_contestants_one"></button>
    &nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="setNbContestants(2)" data-i18n="nb_contestants_two"></button>
  </div>
</div>
<div id="divLogin" style="display:none" class="dialog">
   <p id="login-input-firstName-1"> <span data-i18n="[html]login_input_firstname"></span> <input id="firstName1" type="text" autocomplete="off" /></p>
   <p id="login-input-lasttName-1"> <span data-i18n="[html]login_input_lastname"></span> <input id="lastName1" type="text" autocomplete="off" /></p>
   <p id="login-input-email-1"> <span data-i18n="[html]login_input_email"></span> <input id="email1" type="text" autocomplete="off" /></p>
   <p id="login-input-zipCode-1"> <span data-i18n="[html]login_input_zipCode"></span> <input id="zipCode1" type="text" autocomplete="off" /></p>
   <div id="login-input-genre-1"> <span data-i18n="login_ask_gender"></span> <br/>
         <div class="divInput">
            <input type="radio" id="genre1_female" name="genre1" value="1" autocomplete="off"><label for="genre1_female" data-i18n="login_female"></label>
            <br><input type="radio" id="genre1_male" name="genre1" value="2" autocomplete="off"><label for="genre1_male" data-i18n="login_male"></label>
         </div>
   </div>
   <p id="login-input-grade-1"> <span data-i18n="grade_question"></span> <select id="grade1">
       <option value="" data-i18n="grade_select" selected></option>
       <option value="-1" data-i18n="grade_-1"></option>
       <option value="4" data-i18n="grade_4"></option>
       <option value="5" data-i18n="grade_5"></option>
       <option value="6" data-i18n="grade_6"></option>
       <option value="7" data-i18n="grade_7"></option>
       <option value="8" data-i18n="grade_8"></option>
       <option value="9" data-i18n="grade_9"></option>
       <option value="10" data-i18n="grade_10"></option>
       <option value="11" data-i18n="grade_11"></option>
       <option value="12" data-i18n="grade_12"></option>
       <option value="15" data-i18n="grade_13_pro"></option>
       <option value="-4" data-i18n="grade_-4"></option>
   </select> </p>
   <p id="login-input-studentId-1"> <span data-i18n="[html]login_input_studentId"></span> <input id="studentId1" type="text" autocomplete="off" /></p>
   <div id="contestant2" style="display:none">
      <p><b data-i18n="login_teammate"></b></p>
      <p id="login-input-firstName-2"><span data-i18n="[html]login_input_firstname"></span> <input id="firstName2" type="text" autocomplete="off" /></p>
      <p id="login-input-lasttName-2"><span data-i18n="[html]login_input_lastname"></span> <input id="lastName2" type="text" autocomplete="off" /></p>
      <p id="login-input-email-2"><span data-i18n="[html]login_input_email"></span> <input id="email2" type="text" autocomplete="off" /></p>
      <p id="login-input-zipCode-2"><span data-i18n="[html]login_input_zipCode"></span> <input id="zipCode2" type="text" autocomplete="off" /></p>
      <div id="login-input-genre-2"><span data-i18n="login_ask_gender"></span> <br/>
         <div class="divInput">
         <input type="radio" id="genre2_female" name="genre2" value="1" autocomplete="off"/><label for="genre2_female" data-i18n="login_female"></label><br>
         <input type="radio" id="genre2_male" name="genre2" value="2" autocomplete="off"/><label for="genre2_male" data-i18n="login_male"></label>
         </div>
      </div>
      <p id="login-input-grade-2"> <span data-i18n="grade_question"></span> <select id="grade2">
       <option value="" data-i18n="grade_select" selected></option>
       <option value="-1" data-i18n="grade_-1"></option>
       <option value="4" data-i18n="grade_4"></option>
       <option value="5" data-i18n="grade_5"></option>
       <option value="6" data-i18n="grade_6"></option>
       <option value="7" data-i18n="grade_7"></option>
       <option value="8" data-i18n="grade_8"></option>
       <option value="9" data-i18n="grade_9"></option>
       <option value="10" data-i18n="grade_10"></option>
       <option value="11" data-i18n="grade_11"></option>
       <option value="12" data-i18n="grade_12"></option>
       <option value="15" data-i18n="grade_13_pro"></option>
       <option value="-4" data-i18n="grade_-4"></option>
      </select> </p>
      <p id="login-input-studentId-2"><span data-i18n="[html]login_input_studentId"></span> <input id="studentId2" type="text" autocomplete="off" /></p>
   </div>
   <p><button type="button" id="buttonLogin" onclick="validateLoginForm()" data-i18n="login_start_contest"></button><span id="LoginResult" style="color:red"></span></p>
</div>
<div id="divPassword" style="display:none" class="dialog">
   <p data-i18n="[html]password_warning">
   </p>
   <p>
      <span data-i18n="[html]password_access_code"></span>
      <span id="teamPassword" class="selectable" style="font-size:2em"></span>
   </p>
         <div class="divInput">
            <button type="button" data-i18n="password_confirm" id="buttonConfirmTeamPassword" onclick="confirmTeamPassword()"></button>
         </div>
</div>
</form>
<div id="divImagesLoading" style="display:none" class="dialog">
  <span id="nbImagesLoaded">0</span> <span data-i18n="images_preloaded"></span>
</div>

<div id="divQuestions" style="display:none" autocomplete="off">
   <div class="oldInterface">
      <div class="questionListHeader">
         <table class="chrono" width="95%">
            <tr><td class="fullFeedback">Temps&nbsp;: </td><td><span class='minutes'></span>:<span class='seconds'></span></td></tr>
            <tr><td class="fullFeedback">Score&nbsp;:</td><td><span class='scoreTotalFullFeedback'></span></td></tr>
         </table>
         <p></p>
         <div class="scoreBonus" style="display:none"><b data-i18n="questions_bonus"></b><br/></div>
         <div class="rank" width="95%"></div>
      </div>
      <div class='questionList'>
         <span style="color:red" data-i18n="questions_loading"></span>
      </div>
      <p></p>
      <div style="text-align:center;width:180px;">
         <button type="button" id="buttonClose" class="buttonClose" style="display:none;" data-i18n="questions_finish_early" onclick='tryCloseContest()'></button>
      </div>
      <table class="questionsTable">
         <tr><td>
            <div id="divQuestionParams">
               <table style="width:100%"><tr>
                  <td style="width:10%" data-i18n="[html]top_image"></td>
                  <td><div class="questionTitle"></div></td>
                  <td style="width:25%"><div id="questionPoints"></div></td>
               </tr></table>
            </div>
         </td></tr>
      </table>
   </div>
   <div class="newInterface" style="padding-bottom:1em">
      <div class="header">
         <table class="header_table">
            <tr>
               <td class="header_logo" data-i18n="[html]top_image_new"></td>
               <td class="header_score"><span data-i18n="[html]score"></span><br/><b><span class='scoreTotalFullFeedback'></span></b></td>
               <td class="header_time" id="header_time"><span data-i18n="[html]time_remaining_3"></span><br/><b><span class='minutes'></span>:<span class='seconds'></span></b></td>
               <td class="header_rank" style="display:none"><span data-i18n="[html]rank"></span><br/><b><span class="rank" width="95%"></span></b></td>
               <td class="header_button">
                 <input class="button_return_list" type="button" value="<?php echo i18n()["back_to_task_list"] ?>" onclick="backToList()" />
               </td>
            </tr>
         </table>
      </div>
      <div class="header_sep_top"></div>
      <div class="layout_table_wrapper">
         <div class="questionListIntro" style="text-align:left;line-height:170%" id="questionListIntro">
            <ul data-i18n="[html]question_list_intro">
            </ul>
         </div>
         <div class="questionList task_icons">
            <span style="color:red" data-i18n="questions_loading"></span>
         </div>
      </div>
   </div>
   <span id="divQuestionsContent" style="display:none">
   </span>
   <span id="divSolutionsContent" style="display:none">
   </span>
   <span id="divGradersContent" style="display:none">
   </span>
</div>

<div id="question-iframe-container" autocomplete="off">
   <div class="newInterface" style="width:770px;margin:auto;text-align:left;padding: 10px 0 10px">
      <span class="questionTitle" style="padding-right: 20px"></span><span id="questionStars"></span>
   </div>
   <iframe src="about:blank" id="question-iframe" scrolling="no"></iframe>
</div>
<div id="divFooter" style="display:none;text-align:center" autocomplete="off">
   <div class="header_sep_bottom"></div>
   <button type="button" id="buttonCloseNew" class="buttonClose" data-i18n="questions_finish_early" onclick='tryCloseContest()'></button>
</div>

<div id="divClosed" style="display:none" class="dialog" autocomplete="off">
   <h3 id="divClosedMessage">
   </h3>
   <div id="divClosedPleaseWait" style="display:none">
      <p style='margin:200px 0 200px 0' data-i18n="[html]closed_please_wait">
      </p>
   </div>
   <div id="divClosedEncodedAnswers" style="display:none">
      <p data-i18n="[html]closed_connexion_error">
      </p>
      <textarea cols=60 rows=20 id="encodedAnswers"></textarea>
   </div>
   <div id="divClosedRemindPassword" style="display:none">
      <p>
         <b data-i18n="closed_remind_password"></b>
      </p>
      <p>
         <span data-i18n="closed_your_password"></span> <span class='selectable' id="remindTeamPassword"></span>
      </p>
   </div>
</div>
<div id="divError" autocomplete="off">
   <b data-i18n="error_server"></b> <p style="float:right;"><a href="#" onclick="$('#divError').hide()">[<span data-i18n="error_close"></span>]</a></p><br/>
   <span id="contentError"></span>
</div>
<?php
  script_tag('/bower_components/jquery/jquery.min.js');
?>
<!--[if lte IE 9]>
  <?php
  // JSON3 shim for IE6-9 compatibility.
  script_tag('/bower_components/json3/lib/json3.min.js');
  // Ajax CORS support for IE9 and lower.
  script_tag('/bower_components/jQuery-ajaxTransport-XDomainRequest/jquery.xdomainrequest.min.js');
  ?>
<![endif]-->
<?php
  // jquery 1.9 is required for IE6+ compatibility.
  script_tag('/bower_components/jquery-ui/jquery-ui.min.js');
  script_tag('/bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js');
  script_tag('/bower_components/i18next/i18next.min.js');
  script_tag('/bower_components/utf8/utf8.js');
  script_tag('/bower_components/base64/base64.min.js');
  script_tag('/bower_components/pem-platform/task-pr.js');
  script_tag('/raphael-min.js');
  script_tag('/common.js');
  global $config;
?>
<script>
  function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
      return uri + separator + key + "=" + value;
    }
  }
  window.contestsRoot = <?= json_encode(upgrade_url($config->teacherInterface->sAbsoluteStaticPath.'/contests')) ?>;
  window.sAbsoluteStaticPath = <?= json_encode(upgrade_url($config->teacherInterface->sAbsoluteStaticPath.'/')) ?>;
  window.sAssetsStaticPath = <?= json_encode(upgrade_url($config->teacherInterface->sAssetsStaticPath.'/')) ?>;
  try {
    i18n.init(<?= json_encode([
      'lng' => $config->defaultLanguage,
      'fallbackLng' => [$config->defaultLanguage],
      'fallbackNS' => 'translation',
      'ns' => [
        'namespaces' => $config->customStringsName ? [$config->customStringsName, 'translation'] : ['translation'],
        'defaultNs' => $config->customStringsName ? $config->customStringsName : 'translation',
      ],
      'getAsync' => true,
      'resGetPath' => static_asset('/i18n/__lng__/__ns__.json')
    ]); ?>, function () {
      window.i18nLoaded = true;
      $("title").i18n();
      $("body").i18n();
    });
  } catch(e) {
    // assuming s3 was blocked, so add ?p=1 to url, see contestInterface/config.php
    var newLocation = updateQueryStringParameter(window.location.toString(), 'p', '1');
    if (newLocation != window.location.toString()) {
      window.location = newLocation;
    }
  }
  window.ieMode = false;

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-20319365-4', 'auto');
  ga('send', 'pageview');

</script>
<!--[if IE 6]>
<script>
window.sAbsoluteStaticPath = <?= json_encode(upgrade_url($config->teacherInterface->sAbsoluteStaticPathOldIE.'/')) ?>;
window.contestsRoot = <?= json_encode(upgrade_url($config->teacherInterface->sAbsoluteStaticPathOldIE.'/contests')) ?>;
</script>
<![endif]-->
<!--[if lte IE 9]>
<script>
window.ieMode = true;
</script>
<![endif]-->
<script type="text/javascript">
  var browser_support = true;
  if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    var ffversion=new Number(RegExp.$1);
    if (ffversion<3.6) var browser_support = false;
  }
  else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    var chversion=new Number(RegExp.$1);
    if (chversion<5) var browser_support = false;
  }
  else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    var sfversion=new Number(RegExp.$1);
    if (sfversion<3) var browser_support = false;
  }
  else if (navigator.userAgent.indexOf('MSIE') != -1) {
    var detectIEregexp = /MSIE (\d+\.\d+);/;
    if (detectIEregexp.test(navigator.userAgent)){
      var ieversion=new Number(RegExp.$1);
      if (ieversion<8) var browser_support = false;
    }
  }
  if (browser_support) {
    $('#browserAlert').hide();
  }
</script>
</body></html>
