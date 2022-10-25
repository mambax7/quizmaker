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

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'quizmaker_quiz.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $quizmakerHelper->getConfig('userpager'));
$quizId = Request::getInt('quiz_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet( $style, null );

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('quizmaker_url', QUIZMAKER_URL);

$keywords = [];

$permEdit = $permissionsHandler->getPermGlobalSubmit();
$GLOBALS['xoopsTpl']->assign('permEdit', $permEdit);
$GLOBALS['xoopsTpl']->assign('showItem', $quizId > 0);
 	
switch($op) {
	case 'show':
	case 'list':
	default:
		$crQuiz = new \CriteriaCompo();
		if ($quizId > 0) {
			$crQuiz->add( new \Criteria( 'quiz_id', $quizId ) );
		}
		$quizCount = $quizHandler->getCount($crQuiz);
		$GLOBALS['xoopsTpl']->assign('quizCount', $quizCount);
		$crQuiz->setStart( $start );
		$crQuiz->setLimit( $limit );
		$quizAll = $quizHandler->getAll($crQuiz);
		if ($quizCount > 0) {
			$quiz = [];
			// Get All Quiz
			foreach(array_keys($quizAll) as $i) {
				$quiz[$i] = $quizAll[$i]->getValuesQuiz();
				$keywords[$i] = $quizAll[$i]->getVar('quiz_cat_id');
			}
			$GLOBALS['xoopsTpl']->assign('quiz', $quiz);
			unset($quiz);
			// Display Navigation
			if ($quizCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($quizCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('type', $quizmakerHelper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $quizmakerHelper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $quizmakerHelper->getConfig('numb_col'));
		}
	break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			redirect_header('quiz.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			redirect_header('quiz.php?op=list', 3, _NOPERM);
		}
		if ($quizId > 0) {
			$quizObj = $quizHandler->get($quizId);
		} else {
			$quizObj = $quizHandler->create();
		}
		$quizObj->setVar('quiz_cat_id', Request::getInt('quiz_cat_id', 0));
		$quizObj->setVar('quiz_name', Request::getString('quiz_name', ''));
		$quizObj->setVar('quiz_author', Request::getString('quiz_author', ''));
		$quizObj->setVar('quiz_fileName', Request::getString('quiz_fileName', ''));
		$quizObj->setVar('quiz_description', Request::getText('quiz_description', ''));
		$quizObj->setVar('quiz_weight', Request::getInt('quiz_weight', 0));
		$QuizCreationArr = Request::getArray('quiz_creation');
		$QuizCreation = strtotime($QuizCreationArr['date']) + (int)$QuizCreationArr['time'];
		$quizObj->setVar('quiz_creation', $QuizCreation);
		$QuizUpdateArr = Request::getArray('quiz_update');
		$QuizUpdate = strtotime($QuizUpdateArr['date']) + (int)$QuizUpdateArr['time'];
		$quizObj->setVar('quiz_update', $QuizUpdate);
		$QuizDateBeginArr = Request::getArray('quiz_dateBegin');
		$QuizDateBegin = strtotime($QuizDateBeginArr['date']) + (int)$QuizDateBeginArr['time'];
		$quizObj->setVar('quiz_dateBegin', $QuizDateBegin);
		$QuizDateEndArr = Request::getArray('quiz_dateEnd');
		$QuizDateEnd = strtotime($QuizDateEndArr['date']) + (int)$QuizDateEndArr['time'];
		$quizObj->setVar('quiz_dateEnd', $QuizDateEnd);
		$quizObj->setVar('quiz_publishResults', Request::getInt('quiz_publishResults', 0));
		$quizObj->setVar('quiz_publishAnswers', Request::getInt('quiz_publishAnswers', 0));
		$quizObj->setVar('quiz_viewAllSolutions', Request::getInt('quiz_viewAllSolutions', 0));
		$quizObj->setVar('quiz_publishQuiz', Request::getInt('quiz_publishQuiz', 0));
		$quizObj->setVar('quiz_onClickSimple', Request::getInt('quiz_onClickSimple', 0));
		$quizObj->setVar('quiz_theme', Request::getString('quiz_theme', 'default'));
		$quizObj->setVar('quiz_answerBeforeNext', Request::getInt('quiz_answerBeforeNext', 0));
		$quizObj->setVar('quiz_allowedPrevious', Request::getInt('quiz_allowedPrevious', 0));
		$quizObj->setVar('quiz_allowedSubmit', Request::getInt('quiz_allowedSubmit', 0));
		$quizObj->setVar('quiz_shuffleQuestions', Request::getInt('quiz_shuffleQuestions', 0));
		$quizObj->setVar('quiz_showGoodAnswers', Request::getInt('quiz_showGoodAnswers', 0));
		$quizObj->setVar('quiz_showBadAnswers', Request::getInt('quiz_showBadAnswers', 0));
		$quizObj->setVar('quiz_showReloadAnswers', Request::getInt('quiz_showReloadAnswers', 0));
		$quizObj->setVar('quiz_minusOnShowGoodAnswers', Request::getInt('quiz_minusOnShowGoodAnswers', 0));
		$quizObj->setVar('quiz_useTimer', Request::getInt('quiz_useTimer', 0));
		$quizObj->setVar('quiz_showResultAllways', Request::getInt('quiz_showResultAllways', 0));
		$quizObj->setVar('quiz_showReponsesBottom', Request::getInt('quiz_showReponsesBottom', 0));
		$quizObj->setVar('quiz_showResultPopup', Request::getInt('quiz_showResultPopup', 0));
		$quizObj->setVar('quiz_showTypeQuestion', Request::getInt('quiz_showTypeQuestion', 0));
		$quizObj->setVar('quiz_showLog', Request::getInt('quiz_showLog', 0));
		$quizObj->setVar('quiz_legend', Request::getText('quiz_legend', ''));
		$quizObj->setVar('quiz_dateBeginOk', Request::getInt('quiz_dateBeginOk', 0));
		$quizObj->setVar('quiz_dateEndOk', Request::getInt('quiz_dateEndOk', 0));
		$quizObj->setVar('quiz_build', Request::getInt('quiz_build', 0));
		$quizObj->setVar('quiz_actif', Request::getInt('quiz_actif', 1));
		// Insert Data
		if ($quizHandler->insert($quizObj)) {
			$newQuizId = $quizId > 0 ? $quizId : $quizObj->getNewInsertedIdQuiz();
			$grouppermHandler = xoops_getHandler('groupperm');
			$mid = $GLOBALS['xoopsModule']->getVar('mid');
			// Permission to view_quiz
			$grouppermHandler->deleteByModule($mid, 'quizmaker_view_quiz', $newQuizId);
			if (isset($_POST['groups_view_quiz'])) {
				foreach($_POST['groups_view_quiz'] as $onegroupId) {
					$grouppermHandler->addRight('quizmaker_view_quiz', $newQuizId, $onegroupId, $mid);
				}
			}
			// Permission to submit_quiz
			$grouppermHandler->deleteByModule($mid, 'quizmaker_submit_quiz', $newQuizId);
			if (isset($_POST['groups_submit_quiz'])) {
				foreach($_POST['groups_submit_quiz'] as $onegroupId) {
					$grouppermHandler->addRight('quizmaker_submit_quiz', $newQuizId, $onegroupId, $mid);
				}
			}
			// Permission to approve_quiz
			$grouppermHandler->deleteByModule($mid, 'quizmaker_approve_quiz', $newQuizId);
			if (isset($_POST['groups_approve_quiz'])) {
				foreach($_POST['groups_approve_quiz'] as $onegroupId) {
					$grouppermHandler->addRight('quizmaker_approve_quiz', $newQuizId, $onegroupId, $mid);
				}
			}
			// Handle notification
			$quizCat_id = $quizObj->getVar('quiz_cat_id');
			$tags = [];
			$tags['ITEM_NAME'] = $quizCat_id;
			$tags['ITEM_URL']  = XOOPS_URL . '/modules/quizmaker/quiz.php?op=show&quiz_id=' . $quizId;
			$notificationHandler = xoops_getHandler('notification');
			if ($quizId > 0) {
				// Event modify notification
				$notificationHandler->triggerEvent('global', 0, 'global_modify', $tags);
				$notificationHandler->triggerEvent('quiz', $newQuizId, 'Quiz_modify', $tags);
			} else {
				// Event new notification
				$notificationHandler->triggerEvent('global', 0, 'global_new', $tags);
			}
			// redirect after insert
			if ('' !== $uploaderErrors) {
				redirect_header('quiz.php?op=edit&quiz_id=' . $newQuizId, 5, $uploaderErrors);
			} else {
				redirect_header('quiz.php?op=list', 2, _MA_QUIZMAKER_FORM_OK);
			}
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $quizObj->getHtmlErrors());
		$form = $quizObj->getFormQuiz();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
	case 'new':
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			redirect_header('quiz.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$quizObj = $quizHandler->create();
		$form = $quizObj->getFormQuiz();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
	case 'edit':
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			redirect_header('quiz.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $quizId) {
			redirect_header('quiz.php?op=list', 3, _MA_QUIZMAKER_INVALID_PARAM);
		}
		// Get Form
		$quizObj = $quizHandler->get($quizId);
		$form = $quizObj->getFormQuiz();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
	case 'delete':
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			redirect_header('quiz.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $quizId) {
			redirect_header('quiz.php?op=list', 3, _MA_QUIZMAKER_INVALID_PARAM);
		}
		$quizObj = $quizHandler->get($quizId);
		$quizCat_id = $quizObj->getVar('quiz_cat_id');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				redirect_header('quiz.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($quizHandler->delete($quizObj)) {
				// Event delete notification
				$tags = [];
				$tags['ITEM_NAME'] = $quizCat_id;
				$notificationHandler = xoops_getHandler('notification');
				$notificationHandler->triggerEvent('global', 0, 'global_delete', $tags);
				$notificationHandler->triggerEvent('quiz', $quizId, 'Quiz_delete', $tags);
				redirect_header('quiz.php', 3, _MA_QUIZMAKER_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $quizObj->getHtmlErrors());
			}
		} else {
			xoops_confirm(['ok' => 1, 'quiz_id' => $quizId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], sprintf(_MA_QUIZMAKER_FORM_SURE_DELETE, $quizObj->getVar('quiz_cat_id')));
		}
	break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_QUIZMAKER_QUIZ];

// Keywords
quizmakerMetaKeywords($quizmakerHelper->getConfig('keywords').', '. implode(',', $keywords));
unset($keywords);

// Description
quizmakerMetaDescription(_MA_QUIZMAKER_QUIZ_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUIZMAKER_URL.'/quiz.php');
$GLOBALS['xoopsTpl']->assign('quizmaker_upload_url', QUIZMAKER_UPLOAD_URL);

// View comments
require_once XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
