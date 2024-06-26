<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Quizmaker module for xoops
 *
 * @copyright     2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        quizmaker
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Jean-Jacques Delalandre - Email:<jjdelalandre@orange.fr> - Website:<http://xmodules.jubile.fr>
 */

use Xmf\Request;
use XoopsModules\Quizmaker;
use XoopsModules\Quizmaker\Constants;
//use JJD;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request type_id
$typeId = Request::getInt('type_id');



$sender  = Request::getString('sender', '');
$catId   = Request::getInt('cat_id', 0);
$catTypeQuestion   = Request::getString('catTypeQuestion', QUIZMAKER_ALL);

$catArray = $categoriesHandler->getListKeyName();  
if ($sender == 'cat_id'){
    $quizId = $quizHandler->getFirstIdOfParent($catId);
}else{
    $quizId  = Request::getInt('quiz_id', 0);
}

//    $gp = array_merge($_GET, $_POST);
//    echo "<hr>_GET/_POST<pre>" . print_r($gp, true) . "</pre><hr>";





switch($op) {
	case 'list':
	default:
        $GLOBALS['xoopsTpl']->assign('buttons', '');
        // Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet( $style, null );
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $quizmakerHelper->getConfig('adminpager'));
		$templateMain = 'quizmaker_admin_type_question.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('type_question.php'));    
        
		$type_questionAll = $type_questionHandler->getAll($catTypeQuestion);
		$type_questionCount = count($type_questionAll);
//echo "<hr>type_questions<pre>" . print_r($type_questionAll, true) . "</pre><hr>";        
		$GLOBALS['xoopsTpl']->assign('type_question_count', $type_questionCount);
		$GLOBALS['xoopsTpl']->assign('quizmaker_url', QUIZMAKER_URL_MODULE);
		$GLOBALS['xoopsTpl']->assign('quizmaker_upload_url', QUIZMAKER_URL_UPLOAD);
        
        // ----- Listes de selection pour filtrage des type de questions par categorie-----  
        //if ($catId == 0) $catId = $quiz->getVar('quiz_cat_id');
        //$cat = $categoriesHandler->getListKeyName(null, false, false);
        $inpCatTQ = new \XoopsFormSelect(_AM_QUIZMAKER_CATEGORIES, 'catTypeQuestion', $catTypeQuestion);
        $inpCatTQ->addOptionArray($type_questionHandler->getCategories(true));
        $inpCatTQ->setExtra('onchange="document.quizmaker_select_filter.sender.value=this.name;document.quizmaker_select_filter.submit();"' . " style='background:#FFCCCC'");
  	    $GLOBALS['xoopsTpl']->assign('inpCatTQ', $inpCatTQ->render());
        
		$GLOBALS['xoopsTpl']->assign('type_question_list', $type_questionAll);
                        
\JJD\include_highslide();
	break;

	case 'view':
    
/*
<a href='' onclick="javascript:openWithSelfMain('<{$smarty.const._MED_URL}>/diapo.php?idMedia=<{$media.idMedia}>','',900,600);return false;"
http://127.0.0.16/modules/quizmaker/plugins/alphaSimple/language/french/help.html
 
<a href='' onclick="javascript:openWithSelfMain('<{$smarty.const.XOOPS_URL}>//modules/quizmaker/plugins/alphaSimple/language/french/help.html>','',900,600);return false;"
http://127.0.0.16/modules/quizmaker/plugins/alphaSimple/language/french/help.html
    public function 
		$type_questionAll = $type_questionHandler->getAll($catTypeQuestion);    
*/    
      $templateMain = 'quizmaker_admin_type_question_help.tpl';
      $plugin = Request::getString('plugin', '');
      //echo "<hr>plugin : {$plugin}<hr>";
      $clsTypeQuestion = $type_questionHandler->getTypeQuestion($plugin);
      $GLOBALS['xoopsTpl']->assign('viewHelpTypeQuestion', $clsTypeQuestion->getViewType_question());

        
        break;


}
require __DIR__ . '/footer.php';
