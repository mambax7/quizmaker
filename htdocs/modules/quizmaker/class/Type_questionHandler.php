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


/**
 * Class Object Handler Type_question
 */
class Type_questionHandler 
{
    var $dirname = QUIZMAKER_PATH_MODULE . "/quiz/quiz-php/class";
    var $name = '';
    var $description= '';
    var $allPlugins = null;
        
	/**
	 * Constructor 
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct()
	{
      $this->allPlugins = $this->getAllPluginsPath();    
      //echoArray($this->allPlugins );
	}


	/**
	 * Get Count Type_question in the database
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return int
	 */
	public function getCount()
	{
		return Count($this->getListKeyName());
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
	 * Get Count Quiz in the database
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return int
	 */
	public function getCountQuiz()
	{
        
		return count($this->getListKeyName());
	}


// /* *****************************************
// 
// ******************************************** */    
// private function build_sorter($key) {
//     return function ($a, $b) use ($key) {
//         if($a->weight == $b->weight) return 0;
//         return ($a[$key] > $b[$key]) ? 1 : -1;
//     };
// }

/* ***********************

************************** */
// public function getFileListTypeQuestion(){
// global $utility;
//     $dirname = QUIZMAKER_PATH_ANSWERS_CLASS; 
//     $extensions = array("php");
//     $prefix = "slide_";
//     return \JJD\FSO\getFilePrefixedBy($dirname, $extensions, $prefix, false, true);     
// }
/* ***********************

************************** */
public function getListKeyName($category = null, $boolCode = false){
        $listTQ = $this->getAll($category);
        $ret = array();

        
        foreach ($listTQ as $key=>$arr){
              $ret[$arr['type']] = (($boolCode) ? $arr['type'] . ' : ' : '') . $arr['name'];  
        }

       //tri sur le poids poids 
       ksort ($ret);
       return $ret;

}

/* ************************

************************** */
public function getListByGroup($boolCode = false, $addPagesBeginEnd = false){
    $allTQ = $this->getAll(null, true);
    $list = array();

    foreach($allTQ as $key => $arr) {
       if($arr['obsolette']) continue;
       if (!$addPagesBeginEnd && ($key == "pageBegin" || $key == "pageEnd")) continue;
       if(!isset($list[$arr['category']])) $list[$arr['category']] = $arr['category'];
       
       $key = $arr['category'] .'-' . $arr['type'];
       $list[$key] = $arr['type'];
       
    }
    ksort($list);
    //echoArray($list);

    //--------------------------------------------------------
    $ret = array();
    $prefix = '--- ';
    
    foreach($list as $key => $v) {
        if ($key == $v){
            $ret['>' . $v] = constant(QUIZMAKER_PREFIX_CAT .  strToUpper($v));
        }else{
            $lib = $allTQ[$v]['name'];
            $ret[$v] = $prefix . $lib . (($boolCode) ? " [{$v}]"  : '') ;
        }
    }
    
    //echoArray($ret);
    return $ret;    
}
/* ***********************

************************** */
public function getCategories($addAll = false){
    $allTQ = $this->getAll(null, true);
    $cat = array();    
    if($addAll) $cat[QUIZMAKER_ALL] = '(*)';
    foreach($allTQ as $key => $arr) {
        if(!array_key_exists($arr['category'], $cat))
            $cat[$arr['category']] = $arr['category'] . " - " . constant(QUIZMAKER_PREFIX_CAT . strToUpper($arr['category']));
            $cat[$arr['category']] = constant(QUIZMAKER_PREFIX_CAT . strToUpper($arr['category'])) . " [{$arr['category']}]";
    }
    return $cat;    
}

/****************************************************************************
 * 
 ****************************************************************************/

public function getClassTypeQuestion($typeQuestion){
    $clsName = "slide_" . $typeQuestion;   
    $f = QUIZMAKER_PATH_PLUGINS_PHP . "/{$typeQuestion}/slide_" . $typeQuestion . ".php";  
//    echo "<hr>getClassTypeQuestion : {$f}<hr>";
    include_once($f);    
    $cls = new $clsName; 
    return $cls;

}


public function getTypeQuestion(&$typeQuestion)
  {
    // pour permettre une correction sans aceder à la base apres un changement de nom
    // A virer dès que les noms seront stabilisés
    // $typeQuestion est passé par référence pour remonter le transfert
    $this->getNewTypeQuestion($typeQuestion);

      //if(!isset($typeQuestion[$typeQuestion])) echo "<hr>===> {$typeQuestion}<br>";
      if(isset($this->allPlugins))
        $f = $this->allPlugins[$typeQuestion]['php_path'];  
      else
        $f = QUIZMAKER_PATH_PLUGINS_PHP . "/{$typeQuestion}/slide_" . $typeQuestion . ".php";  
      
      $clsName = "slide_" . $typeQuestion;   
// echo "<hr>{$f}<br>{$typeQuestion}<br>{$clsName}<hr>";
      //----------------------------------------------
      if (class_exists($clsName) ){
          $cls = new $clsName; 
          return $cls;
      }else if (file_exists($f) && !class_exists($clsName) ){
          include_once($f);    
          $cls = new $clsName; 
          return $cls;
      }
      else{
        return null;
      }
  }
  /* *****
  * transfert de classes obsolettes
  * pour permettre une correction sans aceder à la base apres un changement de nom
  * A virer dès que les noms seront stabilisés
  * $typeQuestion est passé par référence pour remonter le transfert
  * ****** */
public function getNewTypeQuestion(&$typeQuestion){

    switch($typeQuestion){
        case 'checkboxLogical' :
            $typeQuestion = 'checkboxSimple'; 
        case 'radioLogical' :
            $typeQuestion = 'radioSimple'; 
            break;
        case 'listboxIntruders1' : 
        case 'listboxIntruders2' : 
        case 'listboxIntruders' : 
            $typeQuestion = 'listboxClassItems';   
            break;
        case 'sortCombobox' :
        case 'comboboxSortList' :
            $typeQuestion = 'comboboxSortItems'; 
            break;
        case 'imagesSortItems' :
            $typeQuestion = 'imagesDaDSortItems'; 
            break;
        case 'ulSortList' :
            $typeQuestion = 'ulDaDSortList'; 
            break;
        case 'imagesDaDBasket' :
            $typeQuestion = 'imagesDaDGroups'; 
            break;
        case 'matchItems' :
            $typeQuestion = 'comboboxMatchItems'; 
            break;
        case 'textarea' :
            $typeQuestion = 'textareaSimple'; 
            break;
        case 'radioMultiple2' :
            $typeQuestion = 'radioMultiple'; 
            break;
        case 'multiTextbox' :
            $typeQuestion = 'textboxMultiple'; 
            break;
        case 'imagesDaDLogical' :
            $typeQuestion = 'imagesDaDMatchItems'; 
            break;
        case 'imagesDaDSortItemsIns' :
            $typeQuestion = 'imagesDaDSortItems'; 
            break;
  }
}
/* ////////////////////////////////////////////////////////////////////// */

/* ****************************************************

******************************************************* */
public function getAllPluginsName(){
    return XoopsLists::getDirListAsArray(QUIZMAKER_PATH_PLUGINS_PHP);     
}
/* ****************************************************

******************************************************* */
public function getAllPlugins($category=null, $bolKeyType = false){
    if (!$category) $category=QUIZMAKER_ALL;
    
    $allPluginsName =  \XoopsLists::getDirListAsArray(QUIZMAKER_PATH_PLUGINS_PHP);
//echoArray($allPluginsName, QUIZMAKER_PATH_PLUGINS_PHP);    
    $ret = array();    
    foreach($allPluginsName as $key=>$typeQuestion){    
//        if(substr($typeQuestion,0,strlen($category)) == $category || $category == QUIZMAKER_ALL) {
//           $f = QUIZMAKER_PATH_PLUGINS_PHP . "/{$key}/slide_" . $key . ".php";  
//           include_once($f);
//           $clsName = "slide_" . $key;    
//           $cls = new $clsName; 
          
          
          $cls = $this->getTypeQuestion($typeQuestion);
          if($cls->category == $category || $category == QUIZMAKER_ALL) {
          
          
          if($bolKeyType)
            $ret[$cls->type] = $cls->getValuesType_question();
          else
            $ret[] = $cls->getValuesType_question();
        }
    }
//echoArray($ret, 'getPluginPath');   
    return $ret;     
}

    
	/**
	 * Get All Type_question in the database
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return array
	 */
	public function getAll($category=null, $bolKeyType = false)
	{
        return  $this->getAllPlugins($category, $bolKeyType);
	}

/* ****************************************************

******************************************************* */
public function getAllPluginsPath(){

    $allPluginsName =  \XoopsLists::getDirListAsArray(QUIZMAKER_PATH_PLUGINS_PHP);
    $ret = array();    
    
    foreach($allPluginsName as $key=>$typeQuestion){   
        $ret[$typeQuestion] = $this->getPluginPath($typeQuestion); 
    }
//echoArray($ret, 'getPluginPath');   
    return $ret;     
}
/* ****************************************************

******************************************************* */
public function getPluginPath($typeQuestion, $includefiles = false )
  {  
    $language = empty( $GLOBALS['xoopsConfig']['language'] ) ? 'english' : $GLOBALS['xoopsConfig']['language'];
                      
    $pArr = array();
    $pArr['name'] = $typeQuestion;
    $pArr['path'] = QUIZMAKER_PATH_PLUGINS_PHP . '/' . $typeQuestion;
    $pArr['url']  = QUIZMAKER_URL_PLUGINS_PHP  . '/' . $typeQuestion;
    
    $pArr['php_path'] = $pArr['path'] . "/slide_{$typeQuestion}.php";    
    $pArr['js_path']  = $pArr['path'] . "/slide_{$typeQuestion}.js";
    $pArr['constants_path'] = $pArr['path'] . "/language/{$language}/constants.php";    
    $pArr['help_path'] = $pArr['path'] . "/language/{$language}/help.html";    
    $pArr['consigne_path'] = $pArr['path'] . "/language/{$language}/consigne.html";    
    $pArr['img'] = $pArr['path'] . '/img';    
    
    $fldSnapShoot = '/snapshoot';    
    //=====================================================================    
    //remplacer les path par un tableau

    //=====================================================================    
    
    $pArr['js_url']  = $pArr['url'] . "/{$typeQuestion}.js";
    $pArr['img_url'] = $pArr['url'] . '/img';    
   
    
//--------------------------------------------------------------------
    $filesList =  \XoopsLists::getFileListByExtension($pArr['path'].$fldSnapShoot, array('jpg'));    
    $pArr['snapshoot_path'] = array();    
    $pArr['snapshoot_url']  = array();    
//echo "<hr>{$pArr['zpath']['snapshoot']}<hr>";    
//echoArray($filesList);
    foreach($filesList AS $key=>$f){
        $pArr['snapshoot_path'][$key] = $pArr['path'] . $fldSnapShoot .'/' . $f;    
        $pArr['snapshoot_url'][$key]  = $pArr['url']  . $fldSnapShoot .'/' . $f;    
    }  
    include_once( $pArr['constants_path']);
    include_once( $pArr['php_path']);

    return $pArr;  
  }
    



} //Fin de la class
