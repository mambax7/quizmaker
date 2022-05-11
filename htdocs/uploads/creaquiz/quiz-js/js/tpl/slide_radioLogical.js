﻿

 /*******************************************************************
  *                     _radioLogical
  * *****************************************************************/

class radioLogical extends quizPrototype{
name = "radioLogical";  
  
 constructor(question, chrono) {
    super();
    this.question = question;
    this.typeName = question.type;
    this.name = question.type;
    this.chrono = chrono;
console.log("dans la classe ---> " + question.type)
    
    this.prepareData();
    this.computeScoresMinMax();

  }
  
/* ***************************************
*
* *** */
build (){
    var currentQuestion = this.question;
    var id = this.getId(0);
    var name = this.getName();

    
    const answers = [];

    var obListText = getHtmlSpan(name, this.data.words, -1, quiz.numerotation);
    answers.push(`<table width="500px" class="question"><tr><td id="${name}-famille">${obListText}`);
    
    var obListRadio = getHtmlRadio(name, this.data.reponses, -1, quiz.numerotation, this.data.words.length);
    answers.push(`</td><td id="${name}-cartes">${obListRadio}</td></tr></table>`);

    return answers.join("\n");

}
//---------------------------------------------------
prepareData(){
    var currentQuestion = this.question;
    this.data.words =  currentQuestion.answers[0].proposition.split(",");   
    this.data.reponses =  currentQuestion.answers[1].proposition.split(",");   
    this.data.points =  currentQuestion.answers[1].points.split(",");   
    this.data.keyPoints = conbineArrayKeys(this.data.reponses, this.data.points);
}
//---------------------------------------------------
computeScoresMinMax(){
     var currentQuestion = this.question;
     var score = {min:0, max:0};


     var tPropos = this.data.reponses;
     var tPoints = padArray(this.data.points, tPropos.length);

      for (var i = 0; i < tPropos.length; i++) {
          if (tPoints[i]>0) this.scoreMaxi += parseInt(tPoints[i])*1;
          if (tPoints[i]<0) this.scoreMini += parseInt(tPoints[i])*1;
      }

     return score;
}

//---------------------------------------------

//calcul le nombre de points obtenus d'une question/slide
//---------------------------------------------------
getScore (answerContainer){
    var currentQuestion = this.question;
var points = 0;

    var keyPoints = this.data.keyPoints;
    var obs = getObjectsByName(this.getName(), "input", "radio", "checked");
    if (obs.length > 0){

        points += keyPoints[obs[0].getAttribute('caption')]*1;
    }   
    return points*1;
}

//---------------------------------------------------
  isInputOk (myQuestions, answerContainer,questionNumber){
    var obs = getObjectsByName(this.getName(), "input", "radio", "checked");
    return (obs.length > 0) ? true : false ;
 }

//---------------------------------------------------
getAllReponses2 (){
    var currentQuestion = this.question;
     var tPropos = this.data.reponses;
     var tPoints = this.data.points;

    var tReponses = [];
     for (var i = 0; i < tPropos.length; i++) {
        tReponses.push (`${tPropos[i]} ===> ${tPoints[i]} points`) ;
     }

    return tReponses.join("<br>");
}
//-------------------------------------------------------
getAllReponses (flag = 0){
     var currentQuestion = this.question;
     var tPropos = this.data.reponses;
     var tPoints = this.data.points;
     var tpl1;
     var tReponses = [];
     

     for (var i = 0; i < tPropos.length; i++) {
        tReponses.push ([[tPropos[i]], [tPoints[i]]]) ;
     }


    return formatArray0(sortArrayArray(tReponses, 1, "DESC"), "=>");
}


//---------------------------------------------------
incremente_question(nbQuestions)
  {
    return nbQuestions+1;
  } 
 
/* ***************************************
*
* *** */
 reloadQuestion()
  {
    var currentQuestion = this.question;

    var id = this.getId(0);
    var name = this.getName();
    
    var obTd = document.getElementById(`${name}-famille`);
    var tWords = shuffleArray(this.data.words);
    obTd.innerHTML = getHtmlSpan(name, tWords,  quiz.numerotation);

    var obTd = document.getElementById(`${name}-cartes`);
    var tReponses = shuffleArray(this.data.reponses);
    obTd.innerHTML = getHtmlRadio(name, tReponses, -1,  quiz.numerotation, tWords.length);
  }                  







/* ***************************************
*
* *** */

 showAntiSeche()
  {
    var currentQuestion = this.question;
    var keyPoints = this.data.keyPoints;
  
    var obs = getObjectsByName(this.getName(), "input", "radio");
    obs.forEach((obInput, index) => {
        obInput.checked = (keyPoints[obInput.getAttribute('caption')]*1 > 0) ? true : false;
    });
  } 

 
} // ----- fin de la classe ------
