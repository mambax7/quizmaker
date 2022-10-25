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
include_once QUIZMAKER_PATH . "/class/Type_question.php";

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Answers
 */
class slide_radioMultiple2 extends XoopsModules\Quizmaker\Type_question
{
     
	/**
	 * Constructor 
	 *
	 */
	public function __construct()
	{
        parent::__construct("radioMultiple2", 0, 220);
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
 	public function getFormOptions($caption, $name, $value = "H")
 	{    
      if (!$value) $value = "H";
      $input = new XoopsFormRadio($caption, $name, $value, '<br>');
      $input->addOption("H", _AM_QUIZMAKER_Orientation_HBR);            
      $input->addOption("V", _AM_QUIZMAKER_Orientation_VBR);            
            
      //$input->setDescription ('Oui');      
            
      return $input;
    }
    
/* *************************************************
*
* ************************************************** */
 	public function getForm($questId)
 	{
        global $utility, $answersHandler, $xoopsConfig;

        $answers = $answersHandler->getListByParent($questId);
        $this->initFormForQuestion();
        $this->maxPropositions = 8;
        $maxMots = 5;
        //---------------------------------------------------------

        
        $trayAllAns = new XoopsFormElementTray  ('', $delimeter = '<br>');  
        for($i = 0; $i < $this->maxPropositions; $i++){        
            $trayAns = new XoopsFormElementTray  (chr($i+65), $delimeter = '<br>');  
            if (isset($answers[$i])){
                $mots = explode(',', $answers[$i]->getVar('answer_proposition'));
                $points = $answers[$i]->getVar('answer_points');
        
            }else{
                $mots = array();
                $points = 0;
            }
           $trayWords = new XoopsFormElementTray  ('' . " : ", $delimeter = ' => ');
            for($k = 0; $k < $maxMots; $k++){        
                $mot = (isset($mots[$k])) ? $mots[$k] : '';
                $name = $this->getName($i, 'mots', $k);
                $inpMot = new \XoopsFormText(" " . ($k+1), $name, $this->lgMot1, $this->lgMot2, $mot);
                $trayWords->addElement($inpMot);
            }
            
                      
           $inpPoints = new \XoopsFormNumber(_AM_QUIZMAKER_SLIDE_POINTS . " : ", $this->getName($i,'points'), $this->lgPoints, $this->lgPoints, $points);
           $inpPoints->setMinMax(-30,30);
           $trayWords->addElement($inpPoints); 
           
           $trayAns->addElement($trayWords);
           
            //ajouter les points ici
           //$trayAns->addElement($inpPoints);
           $trayAllAns->addElement($trayAns);        
         }
        
        //----------------------------------------------------------
        $this->trayGlobal->addElement($trayAllAns);
		return $this->trayGlobal;
	}


/* *************************************************
*
* ************************************************** */
 	public function saveAnswers($questId, $answers)
 	{
        global $utility, $answersHandler, $type_questionHandler;

        $answersHandler->deleteAnswersByQuestId($questId); 
        //--------------------------------------------------------   
        $propos = array();
        $weight = 10;     
   
        foreach ($answers as $keyAns=>$valueAns){
//echo "<hr>Question questId = {$questId}<pre>" . print_r($valueAns, true) . "</pre><hr>";
            
            $tMots = array(); 
            foreach ($valueAns['mots'] as $keyMot=>$mot){
                $mot = trim($mot);
                if ($mot != ''){
                    $tMots[] = $mot;
                }
                
            }
            if (count($tMots) > 0){
//echo "<hr>mots : " .  implode(',', $tMots);          
            	$ansObj = $answersHandler->create();
            	$ansObj->setVar('answer_quest_id', $questId);
            	$ansObj->setVar('answer_proposition', implode(',', $tMots));
            	$ansObj->setVar('answer_points', $valueAns['points']);
            	$ansObj->setVar('answer_weight', $weight += 10);
                
            	$ansObj->setVar('answer_caption', '');
            	$ansObj->setVar('answer_inputs', 0);
    	
                $ret = $answersHandler->insert($ansObj);
            }
            
            
            
            
        }
        
        
        //$this->echoAns ($answers, $questId, $bExit = true);    
        //exit;
        
        
        
        
             
    }
/* ********************************************
*
*********************************************** */
  public function getSolutions($questId, $boolAllSolutions = true){
  global $answersHandler;

    $tpl = "<tr><td><span style='color:%5\$s;'>%1\$s</span></td>" 
             . "<td><span style='color:%5\$s;'>%2\$s</span></td>" 
             . "<td style='text-align:right;padding-right:5px;'><span style='color:%5\$s;'>%3\$s</span></td>"
             . "<td><span style='color:%5\$s;'>%4\$s</span></td></tr>";

    $answersAll = $answersHandler->getListByParent($questId, 'answer_points DESC,answer_weight,answer_id');
    
    $html = array();
    $html[] = "<table class='quizTbl'>";
//    echoArray($answersAll);
    $ret = array();
    $scoreMax = 0;
    $scoreMin = 0;

	foreach(array_keys($answersAll) as $i) {
		$ans = $answersAll[$i]->getValuesAnswers();
        $exp = str_replace(',', ' - ', $ans['proposition']);
        $points = $ans['points'];

        if ($points > 0) {
            $scoreMax += $points;
            $color = QUIZMAKER_POINTS_POSITIF;
            $html[] = sprintf($tpl, $exp, '&nbsp;===>&nbsp;', $points, _CO_QUIZMAKER_POINTS, $color);
        }elseif ($points < 0) {
            $scoreMin += $points;
            $color = QUIZMAKER_POINTS_NEGATIF;
            $html[] = sprintf($tpl, $exp, '&nbsp;===>&nbsp;', $points, _CO_QUIZMAKER_POINTS, $color);
        }elseif($boolAllSolutions){
            $color = QUIZMAKER_POINTS_NULL;
            $html[] = sprintf($tpl, $exp, '&nbsp;===>&nbsp;', $points, _CO_QUIZMAKER_POINTS, $color);
        }

	}
    $html[] = "</table>";
 
    $ret['answers'] = implode("\n", $html);
    $ret['scoreMax'] = $scoreMax;
    $ret['scoreMin'] = $scoreMin;
    //echoArray($ret);
    return $ret;
     }

} // fin de la classe

