﻿<?php
//namespace XoopsModules\Quizmaker;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * QuizMaker module for xoops
 *
 * @copyright     2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        quizmaker
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Jean-Jacques Delalandre - Email:<jjdelalandre@orange.fr> - Website:<http://xmodules.jubile.fr>
 */

use XoopsModules\Quizmaker;
include_once QUIZMAKER_PATH . "/class/Type_question.php";

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Answers
 */
class slide_listboxIntruders2 extends XoopsModules\Quizmaker\Type_question
{
     
	/**
	 * Constructor 
	 *
	 */
	public function __construct()
	{
        parent::__construct("listboxIntruders2");
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

/* **********************************************************
*
* *********************************************************** */
 	public function getFormOptions($caption, $name, $value = "")
 	{    
      
      $input = new XoopsFormRadio($caption, $name, $value, '<br>');
      $input->addOption("", _AM_QUIZMAKER_REPARTITION_ALEATOIRE1);            
      $input->addOption("M", _AM_QUIZMAKER_REPARTITION_ALEATOIRE2);            
      //$input->setDescription ('Oui');      
            
      return $input;
    }


/* *************************************************
*
* ************************************************** */
 	public function getForm($questId)
 	{
        global $utility, $answersHandler;

        $answers = $answersHandler->getListByParent($questId);
        $this->initFormForQuestion();
        //-------------------------------------------------_AM_QUIZMAKER_PROPOSITIONS
        $trayAllAns = new XoopsFormElementTray  ('', $delimeter = '<br>');
        
        //element definissant un objet ou un ensemble
        $i=0;
        if(isset($answers[$i])){
          $tPropos   = explode(",", $answers[$i]->getVar('answer_proposition'));
          $tPoints   = explode(",", $answers[$i]->getVar('answer_points'));
          $tCaptions = explode("|", $answers[$i]->getVar('answer_caption'));
        }else{
            $tPropos   = array();
            $tPoints   = array();
            $tCaptions = array();
        }
        //--------------------------------------------------- 
                           
        $trayCaption = new XoopsFormElementTray ('', $delimeter = '<br>');   
        $inpCaption1 = new \XoopsFormText(_AM_QUIZMAKER_SLIDE_CAPTION1, $this->getName(0, 'caption'), $this->lgMot1, $this->lgMot2, isset($tCaptions[0])  ? $tCaptions[0] : 'Bonne réponses');
        $inpCaption2 = new \XoopsFormText(_AM_QUIZMAKER_SLIDE_CAPTION2, $this->getName(1, 'caption'), $this->lgMot1, $this->lgMot2, isset($tCaptions[1])  ? $tCaptions[1] : 'Mauvaises réponses');
        
        $trayCaption->addElement($inpCaption1);
        $trayCaption->addElement($inpCaption2);
        $trayAllAns->addElement($trayCaption);
        $trayAllAns->addElement(new \XoopsFormLabel('', '<hr>'));
            
        //---------------------------------------------------                    
        for ($h = 0; $h < $this->maxPropositions; $h++){
            $trayAns = new XoopsFormElementTray  ('', $delimeter = ' ');  
            
            $propos = (isset($tPropos[$h]))  ? $tPropos[$h] : '';
            $points = (isset($tPoints[$h]))  ? $tPoints[$h] : 0;
            
            $inpLab  = new XoopsFormLabel("", $h+1 . " : ");
            $trayAns->addElement($inpLab);
            
            $name = $this->getName($h, 'proposition');
            $inpPropos = new \XoopsFormText(_AM_QUIZMAKER_SLIDE_MOT, $name, $this->lgMot1, $this->lgMot2, $propos);
            $trayAns->addElement($inpPropos);
            
            $name = $this->getName($h, 'points');
            $inpPoints = new \XoopsFormNumber(_AM_QUIZMAKER_SLIDE_POINTS,  $name, $this->lgPoints, $this->lgPoints, $points);
            $inpPoints->setMinMax(-30, 30);
            $trayAns->addElement($inpPoints);
            
            $trayAllAns->addElement($trayAns);
        }
        $this->trayGlobal->addElement($trayAllAns);
        
        //----------------------------------------------------------
		return $this->trayGlobal;
	}
    
/* ********************************************
*
*********************************************** */
 	public function saveAnswers($questId, $answers)
 	{
        global $utility, $answersHandler, $type_questionHandler;
        //$this->echoAns ($answers, $questId, $bExit = true);    
        $answersHandler->deleteAnswersByQuestId($questId); 
        //--------------------------------------------------------        
//echoArray($answers);
        $propos = array();
        $points = array();
        $captions = array();
        foreach ($answers as $key=>$value){
            if ($value['proposition'] != ''){
                $propos[] = trim($value['proposition']);
                $points[] = intval(trim($value['points']));
                $captions[] = trim($value['caption']);
            }
        }
    
    	$ansObj = $answersHandler->create();
    	$ansObj->setVar('answer_quest_id', $questId);
    	$ansObj->setVar('answer_proposition', implode(',', $propos));
    	$ansObj->setVar('answer_points', implode(',', $points));
    	$ansObj->setVar('answer_weight', 10);
        
    	$ansObj->setVar('answer_caption', implode('|', $captions));
    	//$ansObj->setVar('answer_caption', $value['caption1'] . "|" . $value['caption2']);
    	$ansObj->setVar('answer_inputs', 0);
        
    	$ret = $answersHandler->insert($ansObj);
 //       exit;
        }

/* ********************************************
*
*********************************************** */
  public function getSolutions($questId){
  global $answersHandler;

    $tpl = "<tr><td><span style='color:%5\$s;'>%1\$s</span></td>" 
             . "<td><span style='color:%5\$s;'>%2\$s</span></td>" 
             . "<td style='text-align:right;padding-right:5px;'><span style='color:%5\$s;'>%3\$s</span></td>"
             . "<td><span style='color:%5\$s;'>%4\$s</span></td></tr>";

    $answersAll = $answersHandler->getListByParent($questId);
    $ans = $answersAll[0]->getValuesAnswers();
    $tp = $this->combineAndSorAnswer($ans);    
    
    $html = array();
    $html[] = "<table class='quizTbl'>";
//    echoArray($answersAll);
    $ret = array();
    $scoreMax = 0;
    $scoreMin = 0;

	foreach($tp as $key=>$item) {
        $points = intval($item['points']);
        if ($points > 0) {
            $scoreMax += $points;
            $color = QUIZMAKER_POINTS_POSITIF;
        }elseif ($points < 0) {
            $scoreMin += $points;
          $color = QUIZMAKER_POINTS_NEGATIF;
        }else{
           $color = QUIZMAKER_POINTS_NULL;
        }
        $html[] = sprintf($tpl, $item['exp'], '&nbsp;===>&nbsp;', $points, _CO_QUIZMAKER_POINTS, $color);

	}
    $html[] = "</table>";
 
    $ret['answers'] = implode("\n", $html);
    $ret['scoreMax'] = $scoreMax;
    $ret['scoreMin'] = $scoreMin;
    //echoArray($ret);
    return $ret;
     }

} // fin de la classe




