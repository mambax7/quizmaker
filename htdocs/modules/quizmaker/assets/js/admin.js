
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


function reloadImgModeles(divId, imgWidth=80){
    //alert('reloadImgModeles : ' + divId);
    var obDivImg = document.getElementById(divId);
    var obInpTypeQuestion = document.getElementById('quest_type_question');
    var tOptions = obInpTypeQuestion.options;
    //alert(tOptions + '===>' + tOptions.length);
    var typeQuestion = obInpTypeQuestion.options[obInpTypeQuestion.selectedIndex].value;
    obDivImg.innerHTML = "";
    //alert('reloadImgModeles : ' + divId + " / " + typeQuestion); //obInpTypeQuestion.value
    
    var tImg = [];
    for(var i=0; i<3; i++){
        var url = `../assets/images/modeles/slide_${typeQuestion}-0${i}.jpg`;
        tImg.push(`<a href='${url}' class='highslide' onclick='return hs.expand(this);' >
                  <img src="${url}" alt="" style="max-width:${imgWidth}px" />
               </a>`)
    }
    obDivImg.innerHTML = tImg.join("\n");
}