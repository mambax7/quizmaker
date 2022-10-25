<?php

namespace XoopsModules\Quizmaker;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  quizmaker
 *
 * @package      \module\quizmaker\class
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <owners@zyspec.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since        
 */

use XoopsModules\Quizmaker;
use Xmf\Request;
use JJD;
//include_once XOOPS_ROOT_PATH . "/modules/quizmaker/class/Utility.php";
                            
//$utility = new \XoopsModules\Quizmaker\Utility();

/**
 * Class Utility
 */
class QuizUtility extends Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits
    use Common\ServerStats; // getServerStats Trait
    use Common\FilesManagement; // Files Management Trait


/* ************************************************
*
* ************************************************* */
public static function build_quiz($quizId){
global $quizHandler, $questionsHandler, $answersHandler;
///quiz-questions.js
    
    //Au cas ou cela aurait �t� oubli�
    $questionsHandler->incrementeWeight($quizId);
    
    // --- Dossier de destination
    $quiz = $quizHandler->get($quizId);
//echo "<hr>quiz<pre>" . print_r($quiz, true) . "</pre><hr>";
//exit;    
    $name = $quiz->getVar('quiz_fileName');    
    $path = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$name}";
    if (!is_dir($path))
        mkdir($path, 0777, true);
    $url = QUIZMAKER_UPLOAD_URL . "/{$name}";
        
    // --- G�n�ration du fichier d'option ---
    self::export_options2Jason($quiz, $path);
        
    // --- G�n�ration du fichier de questions ---
    self::export_questions2Jason($quizId, $path);
    // --- G�n�ration du fichier d'HTML ---
    self::build_quizinline($quiz, QUIZMAKER_UPLOAD_QUIZ_PATH, $name);

    // incrementer la version => quiz_build   
    $quiz->setVar('quiz_build', $quiz->getVar('quiz_build') + 1);
    $quizHandler->insert($quiz);
}

/* ************************************************
*
* ************************************************* */
public static function build_quizinline($quiz, $path, $name){
global $utility, $xoopsConfig;    

    include_once XOOPS_ROOT_PATH.'/class/template.php';
    $tpl = new \xoopsTpl();
    $rootApp = QUIZMAKER_QUIZ_JS_PATH ;
    $urlApp  = QUIZMAKER_QUIZ_JS_URL  ;
    //----------------------------------------------
    //insertion des CSS
    $tCss = \JJD\FSO\getFilePrefixedBy($rootApp.'/css', array('css'), '', false, false,false);
//echo "<hr><pre>CSS : " . print_r($tCss, true) . "</pre><hr>";
    $urlCss = QUIZMAKER_QUIZ_JS_URL. "/css";
    $tpl->assign('urlCss', $urlCss);
    $tpl->assign('allCss', $tCss);
    
    //----------------------------------------------
    //insertion du prototype des tpl
    $urlApp = QUIZMAKER_QUIZ_JS_URL. "";    
    $tpl->assign('prototype', 'slide__prototype.js');
    
    
    //----------------------------------------------
    //insertion des tpl js
    $tTpljs = \JJD\FSO\getFilePrefixedBy($rootApp.'/js/tpl', array('js'), '', false, false,false);
//echo "<hr><pre>TPL-JS <br>: {$rootApp}/js/tpl" . print_r($tTpljs, true) . "</pre><hr>";
    $tpl->assign('allTpljs', $tTpljs);

    //----------------------------------------------
    //insertion du fichier de langue
    $language = $xoopsConfig['language'];
    $langFile = $rootApp . "/js/language/quiz-" . $language . ".js";
    if (!file_exists($langFile)) { //JJDai : peut-etre forcer overwrite
        self::buildJsLanguage($langFile);
        //$language = english;
    }
    $tpl->assign('urlApp', $urlApp);
    $tpl->assign('language', $language);
    

    //----------------------------------------------
    $quizUrl = QUIZMAKER_UPLOAD_QUIZ_URL . "/{$name}";
    $tpl->assign('quizUrl', $quizUrl);
    $tpl->assign('questions', 'quiz-questions');
    $tpl->assign('options', 'quiz-options');
 

    $tpl->assign('quiz_functions', 'quiz-functions');
    $tpl->assign('quiz_events', 'quiz-events');
    $tpl->assign('quiz_main', 'quiz-main');

    //-------------------------------------------------
    $tpl->assign('outline', true);
    $content = $tpl->fetch('db:quizmaker_admin_quiz_inline.tpl' );    
    $fileName =  "{$path}/{$name}.html";
    \JJD\FSO\saveTexte2File($fileName, $content);   
    
    //-------------------------------------------------
    $tpl->assign('outline', false);
    $content = $tpl->fetch('db:quizmaker_admin_quiz_inline.tpl' );    
    $fileName =  "{$path}/{$name}.tpl";
    \JJD\FSO\saveTexte2File($fileName, $content);   
     
//exit;        
}

/* ************************************************
*
* ************************************************* */
public static function export_options2Jason($quiz, $path){
global $categoriesHandler, $quizHandler, $questionsHandler, $answersHandler, $utility;
    $quizValues = $quiz->getValuesQuiz();
    
    if($quizValues['theme'] == ''){
        $theme = $categoriesHandler->getValue($quizValues['cat_id'], 'cat_theme', 'default');
    }else{
        $theme = $quizValues['theme'];
    }
    
    $optionsArr = array();

    $optionsArr['quizId'] = $quizValues['id'];
    $optionsArr['name'] = $quizValues['name']; 
    $optionsArr['description'] = $quizValues['description']; 
    $optionsArr['legend'] = $quizValues['legend'];//"{allType}"
    $optionsArr['theme'] = $theme;
    $optionsArr['onClickSimple'] = $quizValues['onClickSimple'];
    $optionsArr['answerBeforeNext'] = $quizValues['answerBeforeNext'];
    $optionsArr['allowedPrevious'] = $quizValues['allowedPrevious'];
    $optionsArr['shuffleQuestions'] = $quizValues['shuffleQuestions'];
    $optionsArr['useTimer'] = $quizValues['quiz_useTimer'];
    $optionsArr['showGoodAnswers'] = $quizValues['showGoodAnswers'];
    $optionsArr['showBadAnswers'] = $quizValues['showBadAnswers'];
    $optionsArr['minusOnShowGoodAnswers'] = $quizValues['minusOnShowGoodAnswers'];
    $optionsArr['showReloadAnswers'] = $quizValues['showReloadAnswers'];
    $optionsArr['allowedSubmit'] = $quizValues['allowedSubmit'];
    $optionsArr['showReponsesBottom'] = $quizValues['showReponsesBottom'];
    $optionsArr['showResultPopup'] = $quizValues['showResultPopup'];  
    $optionsArr['showResultAllways'] = $quizValues['showResultAllways'];
    $optionsArr['showLog'] = $quizValues['quiz_showLog'];
          
    //Utiliser pour le dev pas utile de mettre ces infos en base
    $optionsArr['showTypeQuestion'] = $quizValues['showTypeQuestion'];
    $optionsArr['mode'] = 0;

    //---------------------------------------------------------
//echo "<hr><pre>optionsArr : " . print_r($optionsArr, true) . "</pre><hr>";
//echo json_encode($optionsArr);
 
    $exp ="var quiz = JSON.parse(`" .  json_encode($optionsArr) . "`);";
    $exp = str_replace('"', '\"', $exp);
//     $exp = str_replace("\n", '<br>', $exp);
    
    $br = '<br>' ;     //
    $exp = str_replace('\r\n', $br, $exp);
    $exp = str_replace('\n', $br, $exp);
    $exp = str_replace('\r', $br, $exp);
    $exp = utf8_encode($exp);
    
    $exp = utf8_encode($exp);
    $fileName = $path . "/quiz-options.js";
    
//    echo "Export ===>{$path}<br>";
//    echo "{$exp}";
    \JJD\FSO\saveTexte2File($fileName, $exp);

//exit;

}
/* ************************************************
*
* ************************************************* */
public static function export_questions2Jason($quizId, $path){
global $quizHandler, $questionsHandler, $answersHandler, $utility;
    
    $questionsArr = array();
    $criteria = new \CriteriaCompo(new \Criteria('quest_quiz_id', $quizId, '='));
    $criteria->add(new \Criteria('quest_visible', 1, '='));
    $criteria->add(new \Criteria('quest_actif', 1, '='));
    $criteria->setsort("quest_weight");
    $criteria->setOrder("ASC");
    $questions = $questionsHandler->getObjects($criteria);
    foreach (array_keys($questions) as $i) {
        $values=$questions[$i]->getValuesQuestions();
        $tQuest = array();
        $tQuest['quizId']         = $quizId;
        $tQuest['questId']        = $values['quest_id'];
        $tQuest['type']           = $values['type_question'];
        $tQuest['typeQuestion']   = $values['type_question'];
        $tQuest['typeForm']       = $values['typeForm'];
        $tQuest['question']       = self::sanitise($values['quest_question']);
        $tQuest['options']        = self::sanitise($values['quest_options']);
        //$tQuest['options']        = $values['quest_options'];
        $tQuest['comment1']       = self::sanitise($values['quest_comment1']);
        $tQuest['explanation']    = self::sanitise($values['quest_explanation']);
        $tQuest['learn_more']     = self::sanitise($values['quest_learn_more']);
        $tQuest['see_also']       = self::sanitise($values['quest_see_also']);
        $tQuest['minReponse']     = $values['minReponse'];
        $tQuest['numbering']      = $values['numbering'];
        $tQuest['shuffleAnswers'] = $values['shuffleAnswers'];
        $tQuest['isQuestion']     = $values['isQuestion'];
        $tQuest['timer']          = $values['timer'];
        $tQuest['timestamp']      = date("H:i:s");
    
        $tQuest['answers']        = self::exportAnswers2Jason($values['id']);
        $questionsArr[] = $tQuest;
   
    }

    $exp ="var myQuestions = JSON.parse(`" .  json_encode($questionsArr) . "`);";
     $exp = str_replace('"', '\"', $exp);
//     $exp = str_replace("\n", '<br>', $exp);
    
    $br = '<br>' ;     //
    $exp = str_replace('\r\n', $br, $exp);
    $exp = str_replace('\n', $br, $exp);
    $exp = str_replace('\r', $br, $exp);
    
    $exp = utf8_encode($exp);
    //$exp ="var myQuestions = JSON.parse('" .  json_encode($questionsArr) . "');";
    //$path = QUIZMAKER_UPLOAD_PATH . "/quiz-questions-01.js";
    //$path = QUIZMAKER_QUIZ_JS_PATH . "/quiz-js/data/quiz-questions-01.js";
//    $path = QUIZMAKER_UPLOAD_PATH . "/quiz-js/togodo/quiz-questions.js";
    $fileName = $path . "/quiz-questions.js";
    
//    echo "Export ===>{$path}<br>";
//    echo "{$exp}";
    \JJD\FSO\saveTexte2File($fileName, $exp);
//    exit;
//json_encode
}

/* ************************************************
*
* ************************************************* */
public static function exportAnswers2Jason($questId){
global $quizHandler, $questionsHandler, $answersHandler;

    $answersArr = array();
    $criteria = new \CriteriaCompo(new \Criteria('answer_quest_id', $questId, '='));
    $criteria->setsort("answer_weight");
    $criteria->setOrder("ASC");
    $answers = $answersHandler->getObjects($criteria);
    foreach (array_keys($answers) as $i) {
        $values = $answers[$i]->getValuesAnswers();
        $tVals = array();
        
        $tVals['answerId']      = $values['answer_id'];
        $tVals['proposition']   = self::sanitise($values['proposition']);
        //$tVals['reponse']       = 0;//$values[''];
        $tVals['inputs']        = $values['inputs'];
        $tVals['points']        = $values['points'];
        $tVals['caption']       = ($values['caption']) ? $values['caption'] : "";
        
        $answersArr[] = $tVals;
   
    }
    return $answersArr;    
}

/* ************************************************
*
* ************************************************* */
public static function buildJsLanguage($fileName){

global $messagesHandler;    
    $messagesAll = $messagesHandler->getAll();
    $tDef = array();
    $tDef[] = "const quiz_messages = {";
    
	foreach(array_keys($messagesAll) as $i) {
		$key = $messagesAll[$i]->getVar('msg_code');
        $value = constant('_JS_QUIZMAKER_' . $messagesAll[$i]->getVar('msg_constant')) ;
        //$value = $messagesAll[$i]->getVar('msg_constant') ;
        $tDef[] = "{$key} : \"{$value}\"";      
	}
    $tDef[] = "}";
    $content = implode(",\n", $tDef);
    
    \JJD\FSO\saveTexte2File($fileName, $content);
}

/* ************************************************
*
* ************************************************* */
public static function sanitise($exp){
    //$exp = str_replace("'","_",$exp);
    return $exp;
}

/**********************************************
 *
 **********************************************/
public static function  get_css_color($addEmpty = false){
global $quizmakerHelper;
    return \JJD\get_css_color(QUIZMAKER_QUIZ_JS_PATH . "/css/style-item-color.css", $addEmpty);
    
}
///////////////////////////////////////////////////////////

/* ***********************

************************** */
public static function getNewBtn($caption, $op, $img,  $title ){
/*
<div class="xo-buttons">
<a class="ui-corner-all tooltip" href="questions.php?op=new" title="Add New Questions"><img src="http://xmodules.jubile.fr/Frameworks/moduleclasses/icons/32/add.png" title="" alt="">Add New Questions</a>
&nbsp;</div>
*/

$html = <<<__HTML__
<a class="ui-corner-all tooltip" title="{$title}" onclick="document.quizmaker_select_filter.op.value='{$op}';document.quizmaker_select_filter.submit();">
<img src="{$img}" title="" alt="">{$caption}</a>
&nbsp;
__HTML__;

    return $html;

}




/**************************************************************
 * 
 * ************************************************************/
// function saveData($quizId)
// {
//     global $xoopsConfig, $quizHandler, $xoopsDB;
//     
//     // --- Dossier de destination
//     $quiz = $quizHandler->get($quizId);
// //echo "<hr>quiz<pre>" . print_r($quiz, true) . "</pre><hr>";
// //exit;    
//     $name = $quiz->getVar('quiz_fileName');    
//     $path = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$name}/export/";
//     if (!is_dir($path))
//         mkdir($path, 0777, true);
//     //----------------------------------------------------
//     $tbl = 'quizmaker_quiz';
//     $sql = "UPDATE " . $xoopsDB->prefix($tbl) . " SET quiz_flag = quiz_id";
//     $xoopsDB->query($sql);
//     
//     $criteria = new \CriteriaCompo(new \Criteria('quiz_id',$quizId,'='));
//     \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $tbl . '.yml', $criteria, array('quiz_id'));
//     
//     //--------------------------------------------
//     $tbl = 'quizmaker_questions';
//     $sql = "UPDATE " . $xoopsDB->prefix($tbl) . " SET quest_flag = quest_id";
//     $xoopsDB->query($sql);
//     
//     $criteria = new \CriteriaCompo(new \Criteria('quest_quiz_id',$quizId,'='));
//     \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $tbl . '.yml', $criteria, array('quest_id'));
//     
//     //--------------------------------------------
//        $questIdList = $quizHandler->getChildrenIds($quizId);
// echo "<hr>{$questIdList}";
//     $tbl = 'quizmaker_answers';
//     $sql = "UPDATE " . $xoopsDB->prefix($tbl) . " SET answer_flag = answer_id";
//     $xoopsDB->query($sql);
// 
//     $criteria = new \CriteriaCompo(new \Criteria('answer_quest_id',"({$questIdList})",'in'));
//     \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $tbl . '.yml', $criteria, array('answer_id'));
//     
//}

public static function exportQuiz($quizId){
global $quizHandler;
        $quiz = $quizHandler->get($quizId);
        $folder = $quiz->getVar('quiz_fileName');    
        $name = $folder . '_' . date("Y-m-d_H-m-s");    
        self::saveDataKeepId($quizId);
        
        $sourcePath = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$folder}/export/";
        $outZipPath = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$folder}/{$name}.zip";
        $outZipUrl = QUIZMAKER_UPLOAD_QUIZ_URL . "/{$folder}/{$name}.zip";
        
        \JJD\zipSimpleDir($sourcePath, $outZipPath);   


		$GLOBALS['xoopsTpl']->assign('download', 1);        
		$GLOBALS['xoopsTpl']->assign('href', $outZipUrl);        
		$GLOBALS['xoopsTpl']->assign('delai', 2000);        
		$GLOBALS['xoopsTpl']->assign('name', $name);        
//exit;
}

/**************************************************************
 * 
 * ************************************************************/
public static function saveDataKeepId($quizId)
{
    global $xoopsConfig, $quizHandler, $xoopsDB;
    
    // --- Dossier de destination
    $quiz = $quizHandler->get($quizId);
//echo "<hr>quiz<pre>" . print_r($quiz, true) . "</pre><hr>";
//exit;    
    $name = $quiz->getVar('quiz_fileName');    
    $path = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$name}/export/";
    if (!is_dir($path))
        mkdir($path, 0777, true);
    //----------------------------------------------------
    $criteria = new \CriteriaCompo(new \Criteria('quiz_id',$quizId,'='));
    $shortName = 'quiz';
    $tbl = 'quizmaker_' . $shortName;
    \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $shortName . '.yml', $criteria);
    
    //-----------------------------------------------------    
    $criteria = new \CriteriaCompo(new \Criteria('quest_quiz_id',$quizId,'='));
    $shortName = 'questions';
    $tbl = 'quizmaker_' . $shortName;
    \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $shortName . '.yml', $criteria);
    
    //--------------------------------------------
    $questIdList = $quizHandler->getChildrenIds($quizId);
//echo "<hr>{$questIdList}";
    $shortName = 'answers';
    $tbl = 'quizmaker_' . $shortName;

    $criteria = new \CriteriaCompo(new \Criteria('answer_quest_id',"({$questIdList})",'in'));
    \Xmf\Database\TableLoad::saveTableToYamlFile($tbl, $path . $shortName . '.yml', $criteria);
    
}
/**************************************************************
 * 
 * ************************************************************/
public static function loadAsNewData($path, $catId = 1)
{
    global $xoopsConfig, $quizHandler, $questionsHandler, $answersHandler, $xoopsDB;
    // --- Nouvel id pour ce qyuz
    // --- ce n'est pas la bonne m�thode il faudrait utiliser la m�thode de xoopsObjectHandler
    $newQuizId  = $quizHandler->getMax('quiz_id')+1;
//echo "<hr>quiz<pre>" . print_r($quiz, true) . "</pre><hr>";
//exit;    
//    $name = $quiz->getVar('quiz_fileName');    
//    $path = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$name}/export/";



    
    // --- Dossier de destination
//     if (!is_dir($path))
//         mkdir($path, 0777, true);
    //--------------------------------------------------------
    // chargement de la table quiz et affectation du nouvel ID
    //--------------------------------------------------------
    $shortName = "quiz";
    $table     = 'quizmaker_' . $shortName;
    $quizHandler->updateAll('quiz_flag',0);
    
    //lecture du fichier et chargement dans un tableau
    $tabledata = \Xmf\Yaml::readWrapped($path . "/". $shortName . '.yml');
//     echo "path import : <hr>{$path}<hr>";
//     echoArray($tabledata);
    //Mise � jour des champs avant importation
    foreach ($tabledata as $index => $row) {
        //affectation du nouvel ID
        $tabledata[$index]['quiz_id'] = $newQuizId;
        // stockage de l'ancien ID dans le champs flag pour permettre la mise � jour des enfants   
        $tabledata[$index]['quiz_flag'] = $tabledata[$index]['quiz_id'];    
        //modification du nom du fichier et dossier du quiz pour ne pas surcharger l'original si il existe
        //cette modification consiste juste � ajouter un nombre al�atoir a la fin du nom original
        //il pourra �tre modifier une fois l'importation termin�
        $tabledata[$index]['quiz_fileName'] = $tabledata[$index]['quiz_fileName'] . "-" . rand(1000, 9999);
        //affectation de la nouvelle cat�gorie pour ce quiz    
        $tabledata[$index]['quiz_cat_id'] = $catId;    
        //unset($tabledata[$index]['quiz_id']);    
    }
    \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
   
//     $criteria = new \criteriaCompo(new \Criteria('quiz_flag', $quizId, "="));
//     $ids = $quizHandler->getIds($criteria);
//     $newQuizId = $ids[0];    
//echo "<hr>" . implode('-', $ids) . "<br>New newQuizId = {$newQuizId}<hr>";    

    //--------------------------------------------------------
    // chargement de la table questions
    //--------------------------------------------------------
    $questShortName = 'questions';
    $tblQuest     = 'quizmaker_' . $questShortName;

    //Mise a zero du flag pour tous les enregistrement de la table
    $questionsHandler->updateAll('quest_flag',0);
    
//     $criteria = new \CriteriaCompo(new \Criteria('quest_quiz_id',$quizId,'='));
//     $questionsHandler->deleteAll($criteria);

    //lecture du fichier et chargement dans un tableau
    $tabledata = \Xmf\Yaml::readWrapped($path . "/". $questShortName . '.yml');
    //modificaion des champs
    foreach ($tabledata as $index => $row) {
        //recupe de l'ancien ID dans la champ FLAG
        //il sera utile pour les enfaant de la table answers
        //et pour reconstituer les groupe des pagesinfo si ils existent    
        $tabledata[$index]['quest_flag'] = $tabledata[$index]['quest_id'];    
        unset($tabledata[$index]['quest_id']);    
    }
    //Chargement de la table questions
    \Xmf\Database\TableLoad::loadTableFromArray($tblQuest, $tabledata);
    //affectation du nouvelle quiz_id
    $criteria = new \criteriaCompo(new \Criteria('quest_flag', 0 , '<>'));
    $questionsHandler->updateAll('quest_quiz_id', $newQuizId, $criteria);
    
    //--------------------------------------------------------------
    //mise � jour du champ parent_id pour recreer les groupes (pageinfo)
    //--------------------------------------------------------------
    $criteria = new \criteriaCompo(new \Criteria('quest_quiz_id',  $newQuizId, '='));
    $criteria->add(new \Criteria('quest_parent_id',  0, '='));
    $questionsAll = $questionsHandler->getAll($criteria);
    
	foreach(array_keys($questionsAll) as $i) {
	   $newQuestId = $questionsAll[$i]->getVar('quest_id');
	   $oldQuestId = $questionsAll[$i]->getVar('quest_flag');
       
        $criteria = new \criteriaCompo(new \Criteria('quest_parent_id', $oldQuestId , '='));       
        $criteria->add(new \Criteria('quest_quiz_id', $newQuizId , '='));       
        $questionsHandler->updateAll('quest_parent_id', $newQuestId, $criteria);       
    }




//     $tblQuestPrefixe = $xoopsDB->prefix($tblQuest);    
// $sql =  <<<___IMG___
// UPDATE $tblQuestPrefixe tChild
//     LEFT JOIN {$tblQuestPrefixe} tParent 
//       ON tChild.quest_parent_id = tParent.quest_flag 
//     SET tChild.quest_parent_id = tParent.quest_id
//     WHERE tChild.quest_parent_id = tParent.quest_id 
//       AND tChild.quest_quiz_id={$newQuizId} 
//       AND tChild.quest_parent_id > 0;
// ___IMG___;  
//     $sql = "UPDATE " . $tblQuest  . " tChild"
//          . " LEFT JOIN " . $xoopsDB->prefix($tblQuest) . " tParent"
//          . " ON tChild.quest_parent_id = tParent.quest_flag"
//          . " SET tChild.quest_parent_id = tParent.quest_id"
//          . " WHERE tChild.quest_parent_id = tParent.quest_id AND tChild.qust_quiz_id={$newQuizId} AND tChild.quest_parent_id > 0;";
// echo "<hr>{$sql}<hr>";
//     $ret = $xoopsDB->query($sql);
//exit;
//echo "<hr>question<pre>" . print_r($tabledata, true) . "</pre><hr>";
    //--------------------------------------------------------
    // chargement de la table answers
    //--------------------------------------------------------
    $ansShortName = "answers";
    $table     = 'quizmaker_' . $ansShortName;
    //Mise a zero du flag pour tous les enregistrement de la table
    $answersHandler->updateAll('answer_flag',0);
    
//     $criteria = new \CriteriaCompo(new \Criteria('answer_quest_id',"({$questIdList})",'in'));
//     $answersHandler->deleteAll($criteria);
    //lecture du fichier dans un tableau
    $tabledata = \Xmf\Yaml::readWrapped($path . "/". $ansShortName . '.yml');
    foreach ($tabledata as $index => $row) {
        $tabledata[$index]['answer_flag'] = $tabledata[$index]['answer_quest_id'];    
        unset($tabledata[$index]['answer_id']);    
    }
    //chargement du tableau dans la table
    \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
//     $sql = "UPDATE " . $xoopsDB->prefix($table)  
//          . " SET ta.answer_quest_id = tq.quest_id"
//          . " FROM " . $xoopsDB->prefix($table) . " ta"
//          . " LEFT JOIN " . $xoopsDB->prefix('quizmaker_questions') . " tq"
//          . " ON ta.flag = tq.flag"
    
    //mise � jour du cham answer_quest_id pour recreer le lien avec la table question
    $tblAns = $xoopsDB->prefix($table);  
    $sql = "UPDATE " . $tblAns  . " ta"
         . " LEFT JOIN " . $xoopsDB->prefix('quizmaker_questions') . " tq"
         . " ON ta.answer_flag = tq.quest_flag"
         . " SET ta.answer_quest_id = tq.quest_id"
         . " WHERE ta.answer_flag > 0;";
    $ret = $xoopsDB->query($sql);

    //exit;
    return $newQuizId;
/*
*/    
   
}
/**************************************************************
 * 
 * ************************************************************/
public static function loadData($quizId)
{
    global $xoopsConfig, $quizHandler, $questionsHandler, $answersHandler, $xoopsDB;
    
    // --- Dossier de destination
    $quiz = $quizHandler->get($quizId);
//echo "<hr>quiz<pre>" . print_r($quiz, true) . "</pre><hr>";
//exit;    
    $name = $quiz->getVar('quiz_fileName');    
    $path = QUIZMAKER_UPLOAD_QUIZ_PATH . "/{$name}/export/";
    if (!is_dir($path))
        mkdir($path, 0777, true);
    //--------------------------------------------------------
    $questIdList = $quizHandler->getChildrenIds($quizId);    
    //--------------------------------------------------------
       
    $criteria = new \CriteriaCompo(new \Criteria('quiz_id',$quizId,'='));
    $quizHandler->deleteAll($criteria);
    $table     = 'quizmaker_quiz';
    $tabledata = \Xmf\Yaml::readWrapped($path . $table . '.yml');
    \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
    //--------------------------------------------------------
    $criteria = new \CriteriaCompo(new \Criteria('quest_quiz_id',$quizId,'='));
    $questionsHandler->deleteAll($criteria);
    $table     = 'quizmaker_questions';
    $tabledata = \Xmf\Yaml::readWrapped($path . $table . '.yml');
    \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
//echo "<hr>question<pre>" . print_r($tabledata, true) . "</pre><hr>";
    //--------------------------------------------------------
    $criteria = new \CriteriaCompo(new \Criteria('answer_quest_id',"({$questIdList})",'in'));
    $answersHandler->deleteAll($criteria);
    $table     = 'quizmaker_answers';
    $tabledata = \Xmf\Yaml::readWrapped($path . $table . '.yml');
    \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
   
}

/**************************************************************
 * 
 * ************************************************************/
public static function submitQuizVerif($quizId, $uid, $uname)
{
        $ip = \Xmf\IPAddress::fromRequest()->asReadable();
        $criteria = new \CriteriaCompo(new \criteria('result_ip', $ip, "="));
        $criteria->add(new \criteria('result_quiz_id', $quizId, "="));
        $resultsCount = $resultsHandler->getCount($criteria);
        $attempt_max = 3;
        if ($resultsCount >= $attempt_max){
			redirect_header("categories.php?op=list&quiz_id={$quizId}&sender=", 3, _MA_QUIZMAKER_STILL_ANSWER);
        }        
		

}

/* ******************************
 *  getTypeQuestion : renvoie la class du type de question
 * @return : classe h�rit�e du type de question
 * *********************** */
public static function getTypeQuestion($typeQuestion, $default='checkbox')
  {
      // recupe de la classe du type de question

      if ($typeQuestion == '') $typeQuestion = $default;
      $clsName = "slide_" . $typeQuestion;   
      $f = QUIZMAKER_ANSWERS_CLASS . "/slide_" . $typeQuestion . ".php";  
      if (file_exists($f)){
          include_once($f);    
          $cls = new $clsName; 
      }else{$cls = null;}
      return $cls;
  }
        
    


//   
// /**************************************************************
//  * 
//  * ************************************************************/
// public static function getSqlDate($dateVar = null)
// {//setlocale (LC_TIME, 'fr_FR.utf8','fra');
//     if (is_null($dateVar)){
//         $ret = date(QUIZMAKER_FORMAT_DATE_SQL);
//     }elseif (is_array($dateVar)){
// 		$dateVar = strtotime($dateVar['date']) + (int)$dateVar['time'];
//         $ret =  date(QUIZMAKER_FORMAT_DATE_SQL, $dateVar);
//     }else{
//         $ret =  date(QUIZMAKER_FORMAT_DATE_SQL, $dateVar);
//         //echo "<hr>{$dateVar}<br>{$ret}<hr>";
//         //exit;
//     }
//     return $ret;
//   }
// /**************************************************************
//  * 
//  * ************************************************************/
// public static function getDateSql2Str($dateSql)
// {
//     return date(QUIZMAKER_FORMAT_DATE, strtotime ($dateSql));
// }

// /**************************************************************
//  * 
//  * ************************************************************/
// public static function isDateBetween($dateBegin, $dateEnd, $dateBeginOk = true, $dateEndOk = true, $currentTime = null)
// {
//     if (is_null($currentTime)) $currentTime = time();
//     if (is_string($dateBegin))  $dateBegin = strtotime($dateBegin);
//     if (is_string($dateEnd))    $dateEnd   = strtotime($dateEnd);
//     
//     if ($dateBeginOk && $dateEndOk){
//         $ret =  (($currentTime >= $dateBegin) && ($currentTime <= $dateEnd));
//     }elseif ($dateBeginOk){
//         $ret =  ($currentTime >= $dateBegin);
//     }elseif($dateEndOk){
//         $ret =  ($currentTime <= $dateEnd);
//     }else{
//         $ret = true;
//     }
//     
//     
//     return ($ret) ? 1 : 0 ;
//}

    /**
     * @param \Xmf\Module\Helper $quizmakerHelper
     * @param array|null         $options
     * @return \XoopsFormDhtmlTextArea|\XoopsFormEditor
     */
//      Avertissement: Declaration of XoopsModules/Quizmaker/QuizUtility::
//      getEditor($caption, $name, $value, $description = '', $newOptions = NULL, $quizmakerHelper = NULL) 
//      should be compatible with XoopsModules/Quizmaker/Utility::getEditor($quizmakerHelper = NULL, $options = NULL)
//       dans le fichier /modules/quizmaker/class/QuizUtility.php ligne 
    public static function getEditor2($caption, $name, $value, $description = "", $newOptions = null, $quizmakerHelper = null)
    {
        if ($quizmakerHelper === null) $quizmakerHelper = \XoopsModules\Quizmaker\Helper::getInstance();
        $options           = [];
        $options['name']   = $name;
        $options['value']  = $value;
        $options['rows']   = 10;
        $options['cols']   = '100%';
        $options['width']  = '100%';
        $options['height'] = '300px';
        $options['editor'] = $quizmakerHelper->getConfig('editor_admin');
        
        if($newOptions !== null){
          $keys = array('rows','cols','width','height');
          for ($h=0; $h < count($keys); $h++){
                $key = $keys[$h];
                if (isset($newOptions[$key]) )  $options[$key] = $newOptions[$key];
          }
        }

        $isAdmin = $quizmakerHelper->isUserAdmin();

        if (class_exists('XoopsFormEditor')) {
            if ($isAdmin) {
                $descEditor = new \XoopsFormEditor($caption, $name, $options, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor($caption, $name, $options, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea($caption, $name, $options['value'], '100%', '100%');
        }

        //        $form->addElement($descEditor);
        if($description) $descEditor->setDescription($description);
        return $descEditor;
    }
    
/**********************************************************************
 * 
 **********************************************************************/
    public static function loadTextFile ($fullName){


  if (!is_readable($fullName)){return '';}
  
  $fp = fopen($fullName,'rb');
  $taille = filesize($fullName);
  $content = fread($fp, $taille);
  fclose($fp);
  
  return $content;

}

//     public static function getEditor($caption, $name, $value, $description = "", $newOptions = null, $quizmakerHelper = null)
//     {
//         $options           = [];
//         $options['name']   = $name;
//         $options['value']  = $value;
//         $options['rows']   = 10;
//         $options['cols']   = '100%';
//         $options['width']  = '100%';
//         $options['height'] = '400px';
//         
//         if($newOptions !== null){
//           $keys = array('rows','cols','width','height');
//           for ($h=0; $h < count($keys); $h++){
//                 $key = $keys[$h];
//                 if (isset($newOptions[$key]) )  $options[$key] = $newOptions[$key];
//           }
//         }
// 
//         if ($quizmakerHelper === null) $quizmakerHelper = \XoopsModules\Quizmaker\Helper::getInstance();
//         $isAdmin = $quizmakerHelper->isUserAdmin();
// 
//         if (class_exists('XoopsFormEditor')) {
//             if ($isAdmin) {
//                 $descEditor = new \XoopsFormEditor(ucfirst($options['name']), $quizmakerHelper->getConfig('editor_admin'), $options, $nohtml = false, $onfailure = 'textarea');
//             } else {
//                 $descEditor = new \XoopsFormEditor(ucfirst($options['name']), $quizmakerHelper->getConfig('editor_user'), $options, $nohtml = false, $onfailure = 'textarea');
//             }
//         } else {
//             $descEditor = new \XoopsFormDhtmlTextArea(ucfirst($options['name']), $options['name'], $options['value'], '100%', '100%');
//         }
// 
//         //        $form->addElement($descEditor);
//         if($description) $descEditor->setDescription($description);
//         return $descEditor;
//     }

}  //fin de la classe
