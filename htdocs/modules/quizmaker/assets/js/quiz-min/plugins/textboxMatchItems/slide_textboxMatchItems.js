 

 /*******************************************************************
  *                     _textboxMatchItems
  * *****************************************************************/
class textboxMatchItems extends quizPrototype{
name = 'textboxMatchItems';  

//---------------------------------------------------
build (){
    var currentQuestion = this.question;
    return this.getInnerHTML() ;
 }
//-----------------------------------------------------------
getInnerHTML (){
const htmlArr = [];

    var currentQuestion = this.question;
    var id = currentQuestion.answers[0].id;
    var name = this.getName();
    
    var newKeys = this.shuffleArray(this.data.keys);
    var inpName = `${name}-input`;
    var textName = `${name}-text`;
console.log(currentQuestion.options.disposition);
    if(currentQuestion.options.disposition == 'disposition-02'){
        var tpl=`<td><span>{numbering}</span></td>
                 <td right><input type="text"  id="{inptId}" name="{inpName}" right tabindex="{tabindex}" value="" ></td>
                 <td left><input type="text" id="{textId}"  name="${textName}" left value="{mot1}" disabled></td>`;       
    }else{
        var tpl=`<td><span>{numbering}</span></td>
                 <td right><input type="text" id="{textId}"  name="${textName}" right value="{mot1}" disabled></td>       
                 <td left><input type="text" left id="{inptId}" name="{inpName}" left tabindex="{tabindex}" value="" ></td>`;
    }
 
    htmlArr.push(`<table class="question">`);
    for(var k = 0; k< newKeys.length; k++){
        var key = newKeys[k];
        var textId = textName + "-" + k;
        var inptId = inpName + "-" + k;
        //alert(key + "-" + tKeyWords[key].match);

        htmlArr.push(`<tr>`);
        var htmlTD = tpl.replace("{numbering}", getNumAlpha(k,currentQuestion.numbering))
                        .replace("{textId}", textId)
                        .replace("{textName}", textName)
                        .replace("{mot1}", newKeys[k])
                        .replace("{tabindex}", k+1)
                        .replace("{inpName}", inpName)
                        .replace("{inptId}", inptId);
        
        
        //alert(key + "-" + tKeyWords[key].match);

        htmlArr.push(htmlTD);
        htmlArr.push(`</tr>`);

    }
    htmlArr.push(`</table>`);
    this.focusId = inpName + "-" + "0";
   
    //return "en construction";
    return htmlArr.join("\n");

    
 }

//---------------------------------------------------
prepareData(){
    var currentQuestion = this.question;
    
    var tWords = [];
    var tKeyWords = [];
    var tKeys = [];

    for(var k=0; k < currentQuestion.answers.length; k++){
        var tCouple = currentQuestion.answers[k].proposition.split(","); 
        if(currentQuestion.options.disposition == 'disposition-02') {tCouple.reverse()};
        var tRep = tCouple[0].toLowerCase().split(",");
        for(var i=0 ; i < tRep.length; i++) tRep[i] = tRep[i].trim();
        //alert(t[0] + " = " + t[1]);
        tKeyWords[tCouple[1]] = {key : tCouple[1], match : tCouple[0], rep : tRep, points : currentQuestion.answers[k].points};

        tWords.push(tCouple[0]);
        tKeys.push(tCouple[1])
    }
    
    this.data.words = tWords;
    this.data.kitems = tKeyWords;
    this.data.keys = tKeys;
    
}
//---------------------------------------------------
prepareDatazzz(){
    var currentQuestion = this.question;
    
    var tWords = [];
    var tKeyWords = [];
    var tKeys = [];

    for(var k=0; k < currentQuestion.answers.length; k++){
        var tCouple = currentQuestion.answers[k].proposition.split(","); 
        if(currentQuestion.options.disposition == 'disposition-01') {tCouple.reverse()};
        var tRep = tCouple[1].toLowerCase().split(",");
        for(var i=0 ; i < tRep.length; i++) tRep[i] = tRep[i].trim();
        //alert(t[0] + " = " + t[1]);
        tKeyWords[tCouple[0]] = {key : tCouple[0], match : tCouple[1], rep : tRep, points : currentQuestion.answers[k].points};

        tWords.push(tCouple[1]);
        tKeys.push(tCouple[0])
    }
    
    this.data.words = tWords;
    this.data.kitems = tKeyWords;
    this.data.keys = tKeys;
    
}

//---------------------------------------------------
computeScoresMinMaxByProposition(){
    var currentQuestion = this.question;
     
    var newKeys = this.data.keys;     
    var tKeyWords = this.data.kitems;     
     
    for(var k = 0; k< newKeys.length; k++){
        var key = newKeys[k];
        this.scoreMaxiBP += tKeyWords[key].points*1;
     }
     return true;
}

/* ************************************
*
* **** */
getScoreByProposition (answerContainer){
//alert("getScore");
var points = 0;
var key ='';
var match = '';

    var currentQuestion = this.question;
    var newKeys = this.data.keys;
    var name = this.getName();
    var inpName = `${name}-input`;    
    var textName = `${name}-text`;
    var obTexts = this.getQuerySelector("input", textName, "text");
    var obInps = this.getQuerySelector("input", inpName, "text");
//alert(inpName)    ;
    var tKeyWords = this.data.kitems;
    
    obTexts.forEach((obInput, index) => {
        key = obInput.value;
        match = obInps[index].value.toLowerCase();
        
        switch (currentQuestion.options *1 ){
        case 1: 
            if(this.compareAvecAccent(match, tKeyWords[key].rep, ','))
                points +=  tKeyWords[key].points*1;
            break;
        case 2: 
            if(this.compareAvecAccentSouple(match, tKeyWords[key].rep, ','))
                points +=  tKeyWords[key].points*1;
            break;
        case 0: 
        default: 
            if ( tKeyWords[key].rep.indexOf(match.toLowerCase()) >= 0)
                points +=  tKeyWords[key].points*1;
            break;
        }
                
    
    });

    return points;

  }

/* ************************************
*
* **** */
compareAvecAccent(exp, tRep, sep=','){
var bolOk = false;
    var newExp = sanityseTextForComparaison(exp);
    for (var i = 0; i < tRep.length; i++){
        if(newExp == sanityseTextForComparaison(tRep[i])){
            //alert(newExp + "===" + sanityseTextForComparaison(tRep[i]));
            bolOk = true;
            break;
        }
    }
    return bolOk;
}

/* ************************************
*
* **** */
compareAvecAccentSouple(exp, tRep, sep=','){
var bolOk = false;
 
    var tExp = exp.split(" ");
    
    for (var i = 0; i < tRep.length; i++){
        for (var k = 0; k < tExp.length; k++){
            var mot = sanityseTextForComparaison(tExp[k]);
                //alert(mot + "===" + sanityseTextForComparaison(tRep[i]));
            if(mot == sanityseTextForComparaison(tRep[i])){
                bolOk = true;
                break;
            }
            if (bolOk) break;
        }
        
        //alert(newExp + "===" + sanityseTextForComparaison(tRep[i]));
    }
    return bolOk;
}
/* ************************************
*
* **** */
compareAvecAccentSouple_pas_bon(exp, tRep, sep=','){
var bolOk = false;
    var newExp = sanityseTextForComparaison(exp);
    for (var i = 0; i < tRep.length; i++){
        //alert(newExp + "===" + sanityseTextForComparaison(tRep[i]));
        if(sanityseTextForComparaison(tRep[i]).indexOf(newExp) >= 0){
            //alert(newExp + "===" + sanityseTextForComparaison(tRep[i]));
            bolOk = true;
            break;
        }
    }
    return bolOk;
}
/* ************************************
*
* **** */
isInputOk (answerContainer){
var rep = 0;
    var currentQuestion = this.question;
    var name = this.getName();
    var inpName = `${name}-input`;
        
    var selector = `select[name=${inpName}]`;
    var obLists = document.querySelectorAll(selector);
    
    obLists.forEach((obList, index) => {
        
        if (obList.value != "") rep++; 
    
    });

    var bolOk = (rep >= currentQuestion.options.minReponses);
    return bolOk;
 }



// //---------------------------------------------------
getAllReponses (flag = 0){
    var currentQuestion = this.question;
     var tReponses = [];

    var newKeys = this.data.keys;     
    var tKeyWords = this.data.kitems;     
     
    for(var k = 0; k< newKeys.length; k++){
        var key = newKeys[k];
//        alert([tKeyWords[key].match]);
        tReponses.push([[tKeyWords[key].key], [tKeyWords[key].match], [tKeyWords[key].points]]);
     }

    return formatArray0(tReponses, "=>");
 }


/* ************************************
*
* **** */
showGoodAnswers(quizDivAllSlides) {
    var currentQuestion = this.question;
    var newKeys = this.shuffleArrayKeys(this.data.keys);
    var name = this.getName();
    var inpName = `${name}-input`;
    var textName = `${name}-text`;
    
    var obTexts = this.getQuerySelector("input", textName, "text");
    var obInps = this.getQuerySelector("input", inpName, "text");
    
    var tKeyWords = this.data.kitems;
   
    
    obTexts.forEach((obInput, index) => {
        var key = obInput.value;
        // Pick a remaining element...
        var rnd = getRandomIntInclusive(0, tKeyWords[key].rep.length-1);
    // this.blob("showAntiSeche : " + obInput.value);
        obInps[index].value = tKeyWords[key].rep[rnd]; 

    });
  } 
  
/* ************************************
*
* **** */
showBadAnswers(quizDivAllSlides) {
    var currentQuestion = this.question;
    var newKeys = this.shuffleArrayKeys(this.data.keys);
    var name = this.getName();
    var inpName = `${name}-input`;
    var textName = `${name}-text`;
    
    var obTexts = this.getQuerySelector("input", textName, "text");
    var obInps = this.getQuerySelector("input", inpName, "text");
    
    var tKeyWords = this.data.kitems;
    var tItems1 = this.data.words;
    var tKeys = shuffleArray(Object.keys(this.data.kitems));

    var tIntrus = splitAllSep("lune,soleil,pied,J°J°D");
    for(var $h = 0; $h < tIntrus.length; $h++){
        tItems1.push(tIntrus[$h]);
    }

   
    
    obTexts.forEach((obInput, index) => {
        var exp = tItems1[rnd(0,tItems1.length-1)];
        obInps[index].value = exp;        
        
        
//         var key = obInput.value;
//         // Pick a remaining element...
//         var rnd = getRandomIntInclusive(0, tKeyWords[key].rep.length-1);
//     // this.blob("showAntiSeche : " + obInput.value);
//         obInps[index].value = tKeyWords[key].rep[rnd].split("").reverse().join(""); 

    });
  } 
  
/* ************************************
*
* **** */
showBadAnswerszzzzzzzz(quizDivAllSlides) {
    var currentQuestion = this.question;
    var name = this.getName();
    var listName = `${name}-list`;
    
    var obLists = this.getQuerySelector("select", listName, "");
    
    var tKeyWords = this.data.kitems;
    
    
   
    obLists.forEach((obInput, index) => {
        var exp = tItems1[rnd(0,tItems1.length-1)];
        obLists[index].value = exp; 
        //console.log(index + "===>" + exp); 
    });
  } 


} // ----- fin de la classe ------
