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
if (count($xoBreadcrumbs) > 1) {
	$GLOBALS['xoopsTpl']->assign('xoBreadcrumbs', $xoBreadcrumbs);
}
$GLOBALS['xoopsTpl']->assign('adv', $quizmakerHelper->getConfig('advertise'));
// 
$GLOBALS['xoopsTpl']->assign('bookmarks', $quizmakerHelper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $quizmakerHelper->getConfig('fbcomments'));
// 
$GLOBALS['xoopsTpl']->assign('admin', QUIZMAKER_URL_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);
// 
include_once XOOPS_ROOT_PATH . '/footer.php';
