﻿

 /*******************************************************************
  *                     _radioMultiple2
  * *****************************************************************/

class radioMultiple2 extends quizPrototype{
name = "radioMultiple2";  
  
 constructor(question, chrono) {
    super(question, chrono);
  }
  
/* ***************************************
*
* *** */
build (){
    var currentQuestion = this.question;
    var id = this.getId(0);
    var name = this.getName();

      const html = [];
      html.push(`<div id="${this.getName()}">`);
        var newAns = shuffleArray(currentQuestion.ans2) ;     
        if (this.data.sens == "V"){
            html.push(this.build_vertical (newAns, this.getName())) ;
        }else{
            html.push(this.build_horizontal (newAns, this.getName())) ;
        }
    
      html.push(`</div>`);
      return html.join("\n");

 }


 /*******************************************************************
  *                     build_multiRadioH
  * *****************************************************************/

 build_horizontal (answers, tblId){
    var currentQuestion = this.question;
    var id = this.getId(0);
    var name = this.getName();

      const html = [];

      html.push(`<table class="question">`);

     for(var k in answers){
      html.push(`<tr>`);

        //var tWords = answers[k].proposition.split(",");
        //answers[k].words = duplicateArray(tWords);
        var tWords = duplicateArray(answers[k].words);
        
        this.shuffleArray(tWords);


        html.push(`<td>`);

        for (var i = 0; i < tWords.length; i++){
          html.push(
            `<td style='text-align:left;'><label>
              <input type="radio" name="${name}-${k}" value="${tWords[i]}" ${this.data.attributeSens}>
              ${tWords[i]}
            </label></td>`
          );
        }
       // html.push(`</td>`);
      html.push(`</tr>`);

     }

      html.push(`</table>`);


//alert(answers);
      return html.join("\n");
}

 /*******************************************************************
  *                     build_multiRadioV
  * *****************************************************************/
build_vertical (answers, tblId){
    var currentQuestion = this.question;
    var id = this.getId(0);
    var name = this.getName();

      const html = [];

      html.push(`<table class="question">`);

     for(var k in answers){

//         var tWords = answers[k].proposition.split(",");
//         answers[k].words = duplicateArray(tWords);
        var tWords = duplicateArray(answers[k].words);
        this.shuffleArray(tWords);
        
        html.push(`<tr>`);



        for (var i = 0; i < tWords.length; i++){
          html.push(
            `<td style='text-align:left;'><label>
              <input type="radio" name="${name}-${k}" value="${tWords[i]}" ${this.data.attributeSens}>
              ${tWords[i]}
            </label></td>`
          );
        }
        html.push(`</tr>`);

     }

      html.push(`</table>`);


//alert(answers);
      return html.join("\n");
}
//---------------------------------------------------
prepareData(){
    var currentQuestion = this.question;

    var tOpt = currentQuestion.options.split(",");
    this.data.sens = (tOpt[0].toUpperCase() == "H") ? "V" : "H";
    this.data.attributeSens = `${this.getName()}="${this.data.sens}"` ;
    

    var currentQuestion = this.question;
    this.transposeArray(currentQuestion);
}

/* *************************************
*
* ******** */
 transposeArray(){
    var currentQuestion = this.question;
var ans2 = [];

    for (var k in currentQuestion.answers){
        var tWords = currentQuestion.answers[k].proposition.split(",");
        currentQuestion.answers[k].words = tWords;
    }
    //------------------------------------------------------------
    for (var w in currentQuestion.answers[0].words){
        var tw = [];
        for (var k in currentQuestion.answers){
            tw.push(currentQuestion.answers[k].words[w]);
        }
        ans2.push({id   :this.getId(currentQuestion,w), 
                  name  :this.getName(currentQuestion) ,
                  words :tw});
    }

// verif

/*

    for (var k in ans2){
        // console.log("---------------------");
        // console.log(ans2[k].id + " | " + ans2[k].name);
        // console.log(ans2[k].words.join("-"));
        
    }
*/

    currentQuestion.ans2 = ans2;
} 
//---------------------------------------------------
computeScoresMinMax(){
    var currentQuestion = this.question;
var maxPoints = 0;
var minPoints = 99999;

    for  (var k in currentQuestion.answers){
        if (maxPoints < currentQuestion.answers[k].points*1){
            maxPoints = currentQuestion.answers[k].points*1;
        }
        if (minPoints > currentQuestion.answers[k].points*1){
            minPoints = currentQuestion.answers[k].points*1;
        }
    }


     this.scoreMaxi = maxPoints ;
     this.scoreMini = minPoints;
 
      return true;
}


 /*******************************************************************
  *                     
  * *****************************************************************/
   getScore (answerContainer){
    var currentQuestion = this.question;
      // find selected answer
      //const answerContainer = answerContainers[questionNumber];
var bolOk = true;
var points = 0;
var score;
var selector = ``;
var ansFound = -1;
var nbExp2Found = 0 ; 

    //console.clear();
    //// console.log(questionNumber + " : " + currentQuestion.question);

    var id = this.getName(currentQuestion);
     
//     selector = "input[type=radio]:checked";
//     var obs = answerContainer.querySelectorAll(selector);
//    var obs = getObjectsByName('', 'input', 'radio', 'checked');
    var obs = getObjectsByName(``, 'input', 'radio', `[${this.data.attributeSens}]:checked`);
            
    // console.log (obs.length + " / " + currentQuestion.answers[0].words.length);
    if(obs.length != currentQuestion.answers[0].words.length) return 0;
    
    //------------------------------------------------------------
    
    for  (var k in currentQuestion.answers){
        var tWords = currentQuestion.answers[k].words;
        nbExp2Found = tWords.length;
        var j = 0;
        for (var h=0; h < obs.length; h++){
            let exp = obs[h].value;
            // console.log(h + " - exp : " + exp);
            if (tWords.indexOf(exp) >= 0) j++;
        }
        if (j == nbExp2Found) ansFound = k;
//            // console.log('jjjjjjjjjjjjj ===> J = ' + j + ' dans ' + ansFound);            
    }
    if (ansFound < 0) return 0;



     if (ansFound < 0) return 0;
    
//    // console.log (`trouvé dans ${currentQuestion.answers[ansFound].proposition} `) ;

      return  currentQuestion.answers[ansFound].points*1;
 }


//---------------------------------------------------
isInputOk (currentQuestion, answerContainer,questionNumber){
var selector = ``;

    var currentQuestion = this.question;


    //console.clear();
    //// console.log(questionNumber + " : " + currentQuestion.question);

//    var id = this.getName(currentQuestion);
     
//     selector = "input[type=radio]:checked";
//     var obs = answerContainer.querySelectorAll(selector);
    //var obs = getObjectsByName(``, 'input', 'radio', `${this.getName()} checked`);
    var obs = getObjectsByName(``, 'input', 'radio', `[${this.data.attributeSens}]:checked`);
                                                          
    if (obs){
    return (obs.length == currentQuestion.answers[0].words.length) ? 1 :  0;
    }

 }


//---------------------------------------------------
getAllReponses (flag = 0){
    var currentQuestion = this.question;
   // var tReponses = [];
var tRep = [];

var tReponses = [];
    for  (var k in currentQuestion.answers){
        //ne mettre ques les combinaisons qui donnent un nombre de points != 0
        //les combinaisons égalent à 0 peuvent nombreuses et sont inutile pour le résultats
        if ([currentQuestion.answers[k].points*1] > 0){
            if(currentQuestion.answers[k].caption){
                tReponses.push([[currentQuestion.answers[k].caption], [currentQuestion.answers[k].proposition], [currentQuestion.answers[k].points*1]])
                tReponses = sortArrayArray(tReponses, 2, "DESC");
            }else{
                tReponses.push([[currentQuestion.answers[k].proposition], [currentQuestion.answers[k].points*1]])
                tReponses = sortArrayArray(tReponses, 1, "DESC");
            }
        }
    }
    return formatArray0(tReponses, "=>");

}


//---------------------------------------------------
  update(nameId, questionNumber) {
}

//---------------------------------------------------
 incremente_question(nbQuestions)
  {
    return nbQuestions+1;
  } 
 
  
/* *************************************
*
* ******** */

  reloadQuestion(answerContainer)
  {
    var currentQuestion = this.question;


    var obDiv = document.getElementById(this.getName());
        var newAns = shuffleArray(currentQuestion.ans2) ;    
      
        if (this.data.sens == "V"){
            obDiv.innerHTML = this.build_vertical (newAns, this.getName());
        }else{
            obDiv.innerHtml = this.build_horizontal (newAns, this.getName());
        }
    
  }
 
 
/* *************************************
*
* ******** */
  showGoodAnswers()//
  {
    var currentQuestion = this.question;
var maxPoints = 0;
var ansFound = -1;

    for  (var k in currentQuestion.answers){
        if (maxPoints < currentQuestion.answers[k].points){
            maxPoints = currentQuestion.answers[k].points;
            ansFound = k;
        }
    }
    var tWords = currentQuestion.answers[ansFound].words;
    
    var obs = getObjectsByName(``, 'input', 'radio', `[${this.data.attributeSens}]`);
     
    obs.forEach((obInput, index) => {
        let exp = obInput.value;
        if (tWords.indexOf(exp) >= 0)  obInput.checked = true;
    });
  } 
 
/* *************************************
*
* ******** */
  showBadAnswers()//
  {
    var currentQuestion = this.question;
var maxPoints = 999;
var ansFound = -1;

    for  (var k in currentQuestion.answers){
        if (maxPoints > currentQuestion.answers[k].points){
            maxPoints = currentQuestion.answers[k].points;
            ansFound = k;
        }
    }
    var tWords = currentQuestion.answers[ansFound].words;
    
    var obs = getObjectsByName(``, 'input', 'radio', `[${this.data.attributeSens}]`);
     
    obs.forEach((obInput, index) => {
        let exp = obInput.value;
        if (tWords.indexOf(exp) >= 0)  obInput.checked = true;
    });
  } 
  
} // ----- fin de la classe ------
