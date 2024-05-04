<?php

namespace XoopsModules\Quizmaker;

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

use XoopsModules\Quizmaker;
use JJD;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Quiz
 */
class Quiz extends \XoopsObject
{
	/**
	 * Constructor 
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('quiz_id', XOBJ_DTYPE_INT);
		$this->initVar('quiz_flag', XOBJ_DTYPE_INT);
		$this->initVar('quiz_cat_id', XOBJ_DTYPE_INT);
		$this->initVar('quiz_name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_author', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_folderJS', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_description', XOBJ_DTYPE_OTHER);
		$this->initVar('quiz_weight', XOBJ_DTYPE_INT);
		$this->initVar('quiz_creation', XOBJ_DTYPE_OTHER); //XOBJ_DTYPE_DATETIME
		$this->initVar('quiz_update', XOBJ_DTYPE_OTHER); //XOBJ_DTYPE_DATETIME
		$this->initVar('quiz_dateBegin', XOBJ_DTYPE_OTHER); //XOBJ_DTYPE_DATETIME
		$this->initVar('quiz_dateEnd', XOBJ_DTYPE_OTHER); //XOBJ_DTYPE_DATETIME
		$this->initVar('quiz_publishQuiz', XOBJ_DTYPE_INT);
		$this->initVar('quiz_publishResults', XOBJ_DTYPE_INT);
		$this->initVar('quiz_publishAnswers', XOBJ_DTYPE_INT);
		$this->initVar('quiz_theme', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_libBegin', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_libEnd', XOBJ_DTYPE_TXTBOX);
		$this->initVar('quiz_questPosComment1', XOBJ_DTYPE_INT);
		$this->initVar('quiz_minusOnShowGoodAnswers', XOBJ_DTYPE_INT);
		$this->initVar('quiz_legend', XOBJ_DTYPE_OTHER);
		$this->initVar('quiz_build', XOBJ_DTYPE_INT);
		$this->initVar('quiz_optionsIhm', XOBJ_DTYPE_INT);
		$this->initVar('quiz_optionsDev', XOBJ_DTYPE_INT);
		$this->initVar('quiz_actif', XOBJ_DTYPE_INT);
		$this->initVar('quiz_showConsigne', XOBJ_DTYPE_INT);
		$this->initVar('quiz_dateBeginOk', XOBJ_DTYPE_INT);
		$this->initVar('quiz_dateEndOk', XOBJ_DTYPE_INT);
        
	}
        
	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
	}

	/**
	 * The new inserted $Id
	 * @return inserted id
	 */
	public function getNewInsertedIdQuiz()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormQuiz($action = false)
	{global $utility, $categoriesHandler, $quizUtility;
		$quizmakerHelper = \XoopsModules\Quizmaker\Helper::getInstance();
		if (false === $action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        $quiId = $this->getVar('quiz_id');
        
		// Permissions for uploader
		$grouppermHandler = xoops_getHandler('groupperm');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$permissionUpload = $grouppermHandler->checkRight('upload_groups', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
		// Title
		$title = $this->isNew() ? sprintf(_AM_QUIZMAKER_QUIZ_ADD) : sprintf(_AM_QUIZMAKER_QUIZ_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title . " (#{$quiId})", 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Quiz Handler
		$quizHandler = $quizmakerHelper->getHandler('Quiz');
        $form->addElement(new \XoopsFormHidden('quiz_id', $quiId));
		
        // Form Select quizCat_id
		$quizCat_idSelect = new \XoopsFormSelect( _AM_QUIZMAKER_CATEGORY, 'quiz_cat_id', $this->getVar('quiz_cat_id'));
		$quizCat_idSelect->addOptionArray($categoriesHandler->getListKeyName());
		$form->addElement($quizCat_idSelect, true);
        
		
        // Form Text quizName
		$form->addElement(new \XoopsFormText( _AM_QUIZMAKER_QUIZ_NAME, 'quiz_name', 50, 255, $this->getVar('quiz_name') ), true);
        
        // Form Text quiz_author
		$form->addElement(new \XoopsFormText( _AM_QUIZMAKER_QUIZ_AUTHOR, 'quiz_author', 50, 255, $this->getVar('quiz_author') ), false);

        //----------------------------------------------------------
        $fileNameTray = new \XoopsFormElementTray(_AM_QUIZMAKER_FILE_NAME_JS, ' ');        
		// Form Text quiz_folderJS
        $inpFileName = new \XoopsFormText('' , 'quiz_folderJS', 50, 255, $this->getVar('quiz_folderJS'));
        $inpFileName->setDescription(_AM_QUIZMAKER_FILE_NAME_JS_DESC);
		$fileNameTray->addElement($inpFileName, true);
        
		// Form number quiz_build
		$build = $this->isNew() ? 0 : $this->getVar('quiz_build');
        $inpBuild = new \XoopsFormNumber(_AM_QUIZMAKER_QUIZ_BUILD, 'quiz_build', 5, 5, $build);
        $inpBuild->setMinMax(0, 500);
		$fileNameTray->addElement($inpBuild);
        
		$form->addElement($fileNameTray);
        
        // Form Text quiz_weight
		$form->addElement(new \XoopsFormText( _AM_QUIZMAKER_WEIGHT, 'quiz_weight', 50, 255, $this->getVar('quiz_weight') ), false);
        //----------------------------------------------------------
		// Form Editor DhtmlTextArea quizDescription
        /* champ a supprimer fait double emploi avec les champs du premier slide "page_info/intro"
        $editDescription = $quizUtility->getEditor2(_AM_QUIZMAKER_DESCRIPTION, 'quiz_description', $this->getVar('quiz_description', 'e'),  _AM_QUIZMAKER_DESCRIPTION_DESC, null, $quizmakerHelper);
		$form->addElement($editDescription, true);
        */
            
            
        
		// Form Check Box quiz_actif
		$quizActif = $this->isNew() ? 1 : $this->getVar('quiz_actif');
		$inpActif = new \XoopsFormRadioYN( _AM_QUIZMAKER_ACTIF, 'quiz_actif', $quizActif);
		$form->addElement($inpActif);
        

		// Form Check Box quizDateBegin
        $quizDateBegin = \JJD\xoopsformDateOkTray(_AM_QUIZMAKER_DATEBEGIN, 'quiz_dateBeginOk', $this->getVar('quiz_dateBeginOk'), 'quiz_dateBegin', $this->getVar('quiz_dateBegin'));
		$form->addElement($quizDateBegin);
        
		// Form Check Box quizDateEnd
        $quizDateEnd = \JJD\xoopsformDateOkTray(_AM_QUIZMAKER_DATEEND, 'quiz_dateEndOk', $this->getVar('quiz_dateEndOk'), 'quiz_dateEnd', $this->getVar('quiz_dateEnd'));
		$form->addElement($quizDateEnd);
        
		// Form Check Box quiz_publishQuiz
		$quizExecution = $this->isNew() ? 0 : $this->getVar('quiz_publishQuiz');
		$inpExecution = new \XoopsFormRadio( _CO_QUIZMAKER_PUBLISH_QUIZ, 'quiz_publishQuiz', $quizExecution);
        $inpExecution->setDescription(_AM_QUIZMAKER_PUBLISH_QUIZ_DESC);
		$inpExecution->addOption(0, _CO_QUIZMAKER_PUBLISH_NONE);
		$inpExecution->addOption(1, _CO_QUIZMAKER_PUBLISH_INLINE);
		$inpExecution->addOption(2, _CO_QUIZMAKER_PUBLISH_OUTLINE);
		$form->addElement($inpExecution);

        $publishArr = array(1=>_YES, 0=>_NO, 2=>_AM_QUIZMAKER_AUTO);
        $inpPublishResults = new \XoopsFormRadio(_AM_QUIZMAKER_PUBLISH_RESULTS , 'quiz_publishResults', $this->getVar('quiz_publishResults'));
        $inpPublishResults->addOptionArray($publishArr);
        $inpPublishResults->setDescription(_AM_QUIZMAKER_PUBLISH_AUTO_DESC);
		$form->addElement($inpPublishResults);
        
        $inpPublishAnswers = new \XoopsFormRadio(_AM_QUIZMAKER_PUBLISH_ANSWERS , 'quiz_publishAnswers', $this->getVar('quiz_publishAnswers'));
        $inpPublishAnswers->addOptionArray($publishArr);
        $inpPublishAnswers->setDescription(_AM_QUIZMAKER_PUBLISH_AUTO_DESC);
		$form->addElement($inpPublishAnswers);

        /* JJDai - Pas vraiment utile, mais je garde des fois que �a puisse servir a autre chose
        oui : ce bouton est activer sur le dernier slide
        non :  ce bouton esst d�sactiver sur le dernier slide (utilisation en dehors du site a verifier)
        */
        
        //========================================================
        $form->insertBreak('<center><div style="background:black;color:white;">' . _AM_QUIZMAKER_OPTIONS_FOR_QUIZ . '</div></center>');
        //========================================================
     
        $inpTheme = new \XoopsFormSelect(_AM_QUIZMAKER_THEME, 'quiz_theme', $this->getVar('quiz_theme'));
		$inpTheme->setDescription(_AM_QUIZMAKER_THEME_DESC);
        //$inpTheme->addOptionArray($quizUtility::get_css_color(true));
        $inpTheme->addOptionArray( \JJD\get_css_color());
		$form->addElement($inpTheme, false);

        // Form Text quiz_libBegin
        $libBegin = ($this->getVar('quiz_libBegin')) ? $this->getVar('quiz_libBegin') :  _CO_QUIZMAKER_LIB_BEGIN_DEFAULT;
        $inpLibBegin = new \XoopsFormText(_CO_QUIZMAKER_LIB_BEGIN , 'quiz_libBegin', 120, 120, $libBegin);  
        $inpLibBegin->setDescription(_CO_QUIZMAKER_LIB_BEGIN_DESC);  
		$form->addElement($inpLibBegin, false);
        
        // Form Text quiz_libEnd
        $libEnd = ($this->getVar('quiz_libEnd')) ? $this->getVar('quiz_libEnd') :  _CO_QUIZMAKER_LIB_END_DEFAULT;
        $inpLibEnd = new \XoopsFormText(_CO_QUIZMAKER_LIB_END , 'quiz_libEnd', 120, 120, $libEnd);  
        $inpLibEnd->setDescription(_CO_QUIZMAKER_LIB_END_DESC);  
		$form->addElement($inpLibEnd, false);
        
		// Form Check Box quiz_questPosComment1
		$inpPosComment = new \XoopsFormRadio(_AM_QUIZMAKER_POS_COMMENT, 'quiz_questPosComment1', $this->getVar('quiz_questPosComment1'));
        $inpPosComment->addOptionArray(['1'=>_AM_QUIZMAKER_POS_COMMENT_1, '2'=>_AM_QUIZMAKER_POS_COMMENT_2 , '3'=>_AM_QUIZMAKER_POS_COMMENT_3]);
        $inpPosComment->setDescription(_AM_QUIZMAKER_POS_COMMENT_DESC);
        $form->addElement($inpPosComment);

		// Form Check Box quiz_showConsigne
		/*
        $quizShowConsigne = $this->isNew() ? 0 : $this->getVar('quiz_showConsigne');
		$inpShowConsigne = new \XoopsFormRadioYN( _AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE, 'quiz_showConsigne', $quizShowConsigne);
		$inpShowConsigne->setDescription(_AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE_DESC);
		$form->addElement($inpShowConsigne);
        */
		$quizShowConsigne = $this->isNew() ? 0 : $this->getVar('quiz_showConsigne');
		$inpShowConsigne = new \XoopsFormSelect( _AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE, 'quiz_showConsigne', $quizShowConsigne);
		$inpShowConsigne->setDescription(_AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE_DESC);
        $inpShowConsigne->addOption(0, _AM_QUIZMAKER_POSITION_NONE);
        $inpShowConsigne->addOption(1, _AM_QUIZMAKER_POSITION_TL);
        $inpShowConsigne->addOption(2, _AM_QUIZMAKER_POSITION_TR);
        $inpShowConsigne->addOption(3, _AM_QUIZMAKER_POSITION_BR);
        $inpShowConsigne->addOption(4, _AM_QUIZMAKER_POSITION_BL);
		$form->addElement($inpShowConsigne);
/*
        // Form Editor DhtmlTextArea quizLegend
        $editLegend = \JJD\getformTextarea(_AM_QUIZMAKER_LEGEND, 'quiz_legend', $this->getVar('quiz_legend', 'e'), _AM_QUIZMAKER_LEGEND_DESC);
		$form->addElement($editLegend, false);
*/		
        
		// Form CheckBoxBin quiz_optionsIhm
        $inpOptionsIhm = new \xoopsFormCheckboxBin(_AM_QUIZMAKER_QUIZ_OPTIONS_IHM . "[{$this->getVar('quiz_optionsIhm')}]", 'quiz_optionsIhm', $this->getVar('quiz_optionsIhm'),1,true);
        $inpOptionsIhm->setDescription(_AM_QUIZMAKER_QUIZ_OPTIONS_IHM_DESC);
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_SHOWSCOREMINMAX,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOW_SCORE_MIN_MAX, _AM_QUIZMAKER_QUIZ_SHOW_SCORE_MIN_MAX_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_SHOWALLSOLUTIONS,sprintf("%s (%s)", _AM_QUIZMAKER_VIEW_ALL_SOLUTIONS, _AM_QUIZMAKER_SHOW_ALL_SOLUTIONS_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_ANSWERBEFORENEXT,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_ANSWERBEFORENEXT, _AM_QUIZMAKER_QUIZ_ANSWERBEFORENEXT_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_ALLOWEDPREVIOUS,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_ALLOWEDPREVIOUS, _AM_QUIZMAKER_QUIZ_ALLOWEDPREVIOUS_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_USETIMER,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_USE_TIMER, _AM_QUIZMAKER_QUIZ_USE_TIMER_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_SHUFFLEQUESTIONS,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHUFFLE_QUESTION, _AM_QUIZMAKER_QUIZ_SHUFFLE_QUESTION_DESC) ) ;
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_SHOWRESULTPOPUP,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_RESULT_POPUP, _AM_QUIZMAKER_QUIZ_RESULT_POPUP_DESC) ) ;
		$form->addElement($inpOptionsIhm);
        $inpOptionsIhm->addOption(QUIZMAKER_BIT_MINUSONSHOWGOODANSWERS,sprintf("%s (%s)", _AM_QUIZMAKER_MINUSONSHOWGOODANSWERS, _AM_QUIZMAKER_MINUSONSHOWGOODANSWERS_DESC) ) ;
        
        //========================================================
        $form->insertBreak('<center><div style="background:black;color:white;">' . _AM_QUIZMAKER_OPTIONS_FOR_DEV . '</div></center>');
        //========================================================
		// Form CheckBoxBin quiz_optionsDev
        $inpOptionsDev = new \xoopsFormCheckboxBin(_AM_QUIZMAKER_QUIZ_OPTIONS_DEV . "[{$this->getVar('quiz_optionsDev')}]", 'quiz_optionsDev', $this->getVar('quiz_optionsDev'),1,true);
        $inpOptionsDev->setDescription(_AM_QUIZMAKER_QUIZ_OPTIONS_DEV_DESC);
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWTYPEQUESTION,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOW_TYPE_QUESTION, _AM_QUIZMAKER_QUIZ_SHOW_TYPE_QUESTION_DESC) ) ;
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWRELOADANSWERS,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOW_BTN_RELOAD_ANSWERS, _AM_QUIZMAKER_QUIZ_SHOW_BTN_RELOAD_ANSWERS_DESC) );
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWGOTOSLIDE, sprintf("%s (%s)", _AM_QUIZMAKER_SHOW_BTN_GOTO_SLIDE, _AM_QUIZMAKER_SHOW_BTN_GOTO_SLIDE_DESC));
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWGOODANSWERS,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOW_GOOD_ANSWERS, _AM_QUIZMAKER_QUIZ_SHOW_GOOD_ANSWERS_DESC) );
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWBADANSWERS,sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOW_BAD_ANSWERS, _AM_QUIZMAKER_QUIZ_SHOW_BAD_ANSWERS_DESC) );
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWLOG, sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOWLOG, _AM_QUIZMAKER_QUIZ_SHOWLOG_DESC));
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWRESULTALLWAYS, sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOWRESULTALLWAYS, _AM_QUIZMAKER_QUIZ_SHOWRESULTALLWAYS_DESC) );
        $inpOptionsDev->addOption(QUIZMAKER_BIT_SHOWREPONSESBOTTOM, sprintf("%s (%s)", _AM_QUIZMAKER_QUIZ_SHOWREPONSES_BOTTOM, _AM_QUIZMAKER_QUIZ_SHOWREPONSES_BOTTOM_DESC));
		$form->addElement($inpOptionsDev);


        //========================================================
        $form->insertBreak('<center><div style="background:black;color:white;">' . _AM_QUIZMAKER_PERMISSIONS . '</div></center>');
        //========================================================
        
		// Permissions si  'perm_by_quiz') est d�fini sur oui
        if ($quizmakerHelper->getConfig('perm_by_quiz')){
    		$memberHandler = xoops_getHandler('member');
    		$groupList = $memberHandler->getGroupList();
    		$grouppermHandler = xoops_getHandler('groupperm');
    		$fullList[] = array_keys($groupList);
    		if (!$this->isNew()) {
    			$groupsIdsApprove = $grouppermHandler->getGroupIds('quizmaker_approve_quiz', $this->getVar('quiz_id'), $GLOBALS['xoopsModule']->getVar('mid'));
    			$groupsIdsApprove[] = array_values($groupsIdsApprove);
    			$groupsCanApproveCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_APPROVE, 'groups_approve_quiz[]', $groupsIdsApprove);
    			$groupsIdsSubmit = $grouppermHandler->getGroupIds('quizmaker_submit_quiz', $this->getVar('quiz_id'), $GLOBALS['xoopsModule']->getVar('mid'));
    			$groupsIdsSubmit[] = array_values($groupsIdsSubmit);
    			$groupsCanSubmitCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_SUBMIT, 'groups_submit_quiz[]', $groupsIdsSubmit);
    			$groupsIdsView = $grouppermHandler->getGroupIds('quizmaker_view_quiz', $this->getVar('quiz_id'), $GLOBALS['xoopsModule']->getVar('mid'));
    			$groupsIdsView[] = array_values($groupsIdsView);
    			$groupsCanViewCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_VIEW, 'groups_view_quiz[]', $groupsIdsView);
    		} else {
    			$groupsCanApproveCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_APPROVE, 'groups_approve_quiz[]', $fullList);
    			$groupsCanSubmitCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_SUBMIT, 'groups_submit_quiz[]', $fullList);
    			$groupsCanViewCheckbox = new \XoopsFormCheckBox( _AM_QUIZMAKER_PERMISSIONS_VIEW, 'groups_view_quiz[]', $fullList);
    		}
    		// To Approve
    		$groupsCanApproveCheckbox->addOptionArray($groupList);
    		$form->addElement($groupsCanApproveCheckbox);
    		// To Submit
    		$groupsCanSubmitCheckbox->addOptionArray($groupList);
    		$form->addElement($groupsCanSubmitCheckbox);
    		// To View
    		$groupsCanViewCheckbox->addOptionArray($groupList);
    		$form->addElement($groupsCanViewCheckbox);
        }     
                      
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

	/**
	 * Get Values
	 * @param null $keys 
	 * @param null $format 
	 * @param null$maxDepth 
	 * @return array
	 */
	public function getValuesQuiz($keys = null, $format = null, $maxDepth = null)
	{
        global $quizUtility, $categoriesHandler;
		$quizmakerHelper  = \XoopsModules\Quizmaker\Helper::getInstance();
		$utility = new \XoopsModules\Quizmaker\Utility();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']                = $this->getVar('quiz_id');
		$ret['cat_id']            = $this->getVar('quiz_cat_id');
		$ret['name']              = $this->getVar('quiz_name');
		$ret['author']            = $this->getVar('quiz_author');
		$ret['folderJS']          = $this->getVar('quiz_folderJS');
		$ret['description']       = $this->getVar('quiz_description', 'e');
		$ret['weight']            = $this->getVar('quiz_weight');
		$editorMaxchar = $quizmakerHelper->getConfig('editor_maxchar');
		$ret['description_short'] = $utility::truncateHtml($ret['description'], $editorMaxchar);
		$ret['creation']          = \JJD\getDateSql2Str($this->getVar('quiz_creation'));
		$ret['update']            = \JJD\getDateSql2Str($this->getVar('quiz_update'));

// 		$ret['dateBegin']         = formatTimeStamp($this->getVar('quiz_dateBegin'), 'm');
// 		$ret['dateEnd']           = formatTimeStamp($this->getVar('quiz_dateEnd'), 'm');
        
		$ret['dateBegin']          = \JJD\getDateSql2Str($this->getVar('quiz_dateBegin'));
		$ret['dateEnd']            = \JJD\getDateSql2Str($this->getVar('quiz_dateEnd'));
		$ret['periodeOK']          = \JJD\isDateBetween($this->getVar('quiz_dateBegin'), $this->getVar('quiz_dateEnd'), $this->getVar('quiz_dateBeginOk'), $this->getVar('quiz_dateEndOk'));
         
		$ret['publishQuiz']         = $this->getVar('quiz_publishQuiz');
		$ret['publishQuiz_lib']     = Array(_CO_QUIZMAKER_PUBLISH_NONE,_CO_QUIZMAKER_PUBLISH_INLINE,_CO_QUIZMAKER_PUBLISH_OUTLINE)[$ret['publishQuiz']];
		
        
        $ret['publishResults']      = $this->getVar('quiz_publishResults');
        $ret['publishResultsOk']    = (($ret['periodeOK']==0 && $ret['publishQuiz']>0 && $ret['publishResults']==2) || $ret['publishResults']==1) ? 1 : 0;

		$ret['publishAnswers']      = $this->getVar('quiz_publishAnswers');
        $ret['publishAnswersOk']    = (($ret['periodeOK']==0 && $ret['publishQuiz']>0 && $ret['publishAnswers']==2) || $ret['publishAnswers']==1) ? 1 : 0;

        
		$ret['theme']             = $this->getVar('quiz_theme');
		$ret['libBegin']          = $this->getVar('quiz_libBegin');
		$ret['libEnd']            = $this->getVar('quiz_libEnd');
        $ret['theme_ok'] = ($ret['theme'] == '') ? $categoriesHandler->getValue($ret['cat_id'],'cat_theme','default') : $ret['theme'];
		$ret['questPosComment1']  = $this->getVar('quiz_questPosComment1');
		$ret['minusOnShowGoodAnswers'] = $this->getVar('quiz_minusOnShowGoodAnswers');
		$ret['legend']            = $this->getVar('quiz_legend', 'e');
		$ret['legend_short']      = $utility::truncateHtml($ret['legend'], $editorMaxchar);
		$ret['dateBeginOk']       = $this->getVar('quiz_dateBeginOk');
		$ret['dateEndOk']         = $this->getVar('quiz_dateEndOk');
		$ret['build']             = $this->getVar('quiz_build');
		$ret['optionsIhm']        = $this->getVar('quiz_optionsIhm');
		$ret['optionsDev']        = $this->getVar('quiz_optionsDev');
		$ret['actif']             = $this->getVar('quiz_actif');
		$ret['showConsigne']      = $this->getVar('quiz_showConsigne');

        //verifie que le quiz a �t� g�n�r�
        $quiz_html = QUIZMAKER_PATH_UPLOAD_QUIZ . "/{$ret['folderJS']}/index.html"; 
        $ret['quiz_html'] = (file_exists($quiz_html)) ?  QUIZMAKER_URL_UPLOAD_QUIZ . "/{$ret['folderJS']}/index.html" : '';
        $ret['quiz_html_path'] = (file_exists($quiz_html)) ?  $quiz_html : '';
        
        $quiz_tpl = QUIZMAKER_PATH_UPLOAD_QUIZ . "/{$ret['folderJS']}/index.tpl"; 
        $ret['quiz_tpl'] = (file_exists($quiz_tpl)) ?  QUIZMAKER_URL_UPLOAD_QUIZ . "/{$ret['folderJS']}/index.tpl" : '';
        $ret['quiz_tpl_path'] = (file_exists($quiz_tpl)) ?  $quiz_tpl : '';
        $ret['flags'] = $this->getFlags($ret);



        
        $ret['countQuestions'] = $this->countQuestions();
        
		return $ret;
	}
	
    public function getFlags(&$ret){
        $flags = array();
        $flags['actif']             = quizFlagAscii($ret['actif'], "A");
        $flags['showConsigne']      = quizFlagAscii($ret['showConsigne'], "?");
        $flags['publishResults']    = quizFlagAscii($ret['publishResults'], "R");
        $flags['publishAnswers']    = quizFlagAscii($ret['publishAnswers'], "S");
               
        //$flags['onClickSimple']     = quizFlagAlpha($ret['onClickSimple'], "Dk|Sk"); //bascul� dans les options du slide
        
        $optionsIhm = $ret['optionsIhm'];
        $flags['allowedSubmit']   = quizFlagAscii(isBitOk(QUIZMAKER_BIT__ALLOWEDSUBMIT, $optionsIhm), "Sb"); 
        $flags['showScoreMinMax']   = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWSCOREMINMAX, $optionsIhm), "Smm"); 
        $flags['showAllSolutions']  = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWALLSOLUTIONS, $optionsIhm), "Vas"); 
        $flags['answerBeforeNext']  = quizFlagAlpha(isBitOk(QUIZMAKER_BIT_ANSWERBEFORENEXT, $optionsIhm), "Ro|Ro");
        $flags['allowedPrevious']   = quizFlagAscii(isBitOk(QUIZMAKER_BIT_ALLOWEDPREVIOUS, $optionsIhm), "Pr"); 
        $flags['useTimer']          = quizFlagAscii(isBitOk(QUIZMAKER_BIT_USETIMER, $optionsIhm), "T");        
        $flags['shuffleQuestions']  = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHUFFLEQUESTIONS, $optionsIhm), "M"); 
        $flags['showResultPopup']   = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWRESULTPOPUP, $optionsIhm), "Popup");
        $flags['minusOnShowGoodAnswers'] = quizFlagAscii(isBitOk(QUIZMAKER_BIT_MINUSONSHOWGOODANSWERS, $optionsIhm), "Minus");

        $optionsDev = $ret['optionsDev'];
        $flags['showTypeQuestion']  = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWTYPEQUESTION, $optionsDev), "TQ");
        $flags['showReloadAnswers'] = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWRELOADANSWERS, $optionsDev), "Rl");
        $flags['showGoToSlide']     = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWGOTOSLIDE, $optionsDev), "Go");
        $flags['showGoodAnswers']   = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWGOODANSWERS, $optionsDev), "Ga"); 
        $flags['showBadAnswers']    = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWBADANSWERS, $optionsDev), "Ba"); 
        $flags['showLog']           = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWLOG, $optionsDev), "Log"); 
        $flags['showResultAllways'] = quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWRESULTALLWAYS, $optionsDev), "Ra"); 
        $flags['showReponsesBottom']= quizFlagAscii(isBitOk(QUIZMAKER_BIT_SHOWREPONSESBOTTOM, $optionsDev), "Rb"); 
        
        return $flags;
}                                      

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayQuiz()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach(array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
    
/* ******************************
 * renvoie l'id parent pour l'idEnfant
 * *********************** */
    public function getParentId($quizId)

    {
        $ob = $this->get('quest_id', $questId);
        return $ob->GetVar('quest_quiz_id');
    }
    
/* ******************************
 * renvoie l'id parent pour l'idEnfant
 * *********************** */
    public function countQuestions()

    {
    global $questionsHandler;
    
    $criteria = new \CriteriaCompo();
    $criteria->add( new \Criteria("quest_quiz_id",  $this->getVar('quiz_id'), "="));
    $criteria->add( new \Criteria("quest_type_question",  'pageBegin', "<>"));
    $criteria->add( new \Criteria("quest_type_question",  'pageEnd', "<>"));
    $criteria->add( new \Criteria("quest_type_question",  'pageGroup', "<>"));
    $count = $questionsHandler->getCount($criteria);
    return $count;
    }
    
/* ******************************
 * renvoie l'id parent pour l'idEnfant
 * *********************** */
    public function countGroups()

    {
    global $questionsHandler;
    
    $criteria = new \CriteriaCompo();
    $criteria->add( new \Criteria("quest_quiz_id",  $this->getVar('quiz_id'), "="));
    $criteria->add( new \Criteria("quest_type_question",  'pageGroup', "="));
    $count = $questionsHandler->getCount($criteria);
    return $count;
    }
}
