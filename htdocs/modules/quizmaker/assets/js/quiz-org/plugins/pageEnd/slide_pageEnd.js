
 /*******************************************************************
  *                     _End
  * *****************************************************************/

class pageEnd extends quizPrototype{
name = "pageEnd";

//---------------------------------------------------
build (){
    var currentQuestion = this.question;
    return this.getInnerHTML() ;
 }
  
/* ***************************************
*
* *** */
getInnerHTML (){

var currentQuestion=this.question;
var name = this.getName();

      const answers = [];
      
    if(currentQuestion.image){
        var imageMain = `<div><img src="${ quiz_config.urlQuizImg}/${currentQuestion.image}" alt="" title="" height="${currentQuestion.options.imgHeight}px"></div>`;
        answers.push(imageMain);
    }

      for(var k in currentQuestion.answers){
        var id = this.getId(k);
        if(currentQuestion.answers[k].proposition == '') continue;
            console.log("IDS ===>" + currentQuestion.questId + "-" + currentQuestion.parentId);
            var exp = replaceBalisesByValues(currentQuestion.answers[k].proposition, 0);
            answers.push(
                `<div id="${id}" name="${name}" class="quiz-shadowbox "  style='width:90%;' disabled>${exp}</div>
                `);
          
      }
      //answers.push(`<br><button id="quiz_btn_endQuiz"  name="quiz_btn_endQuiz" class="${quiz_css.buttons}" style="font-size:1.8em;visibility: visible; display: inline-block;">${quiz_messages.btnEndQuiz}</button>`);      
      //if(this.typeForm == 3){
          answers.push(this.buildFormSubmitAnswers());
      //}
//alert(answers);
      return answers.join("\n");

  }

//---------------------------------------------------
buildFormSubmitAnswers(){
    var tNamesId = ['quiz_id', 'uid', 'answers_total', 'answers_achieved', 
                    'score_achieved', 'score_max', 'score_min', 'duration', 'isAnonymous', 'pseudo'];
                 
    var tHtml = [];
    
    tHtml.push(`<form name="form_submit_quizmaker" id="form_submit_quizmaker" action="/modules/quizmaker/results_submit.php?op=submit_answers" method="post">`);
    
    for (var h = 0; h < tNamesId.length; h++){
        tHtml.push(`<input type="hidden" name="${tNamesId[h]}" id="${tNamesId[h]}" value="0" />`);
    }
    tHtml.push(`</form>`);
    
    
    return "\n" + tHtml.join("\n") + "\n";
}  
//---------------------------------------------------
submitAnswers(){
console.log("submitAnswers begin");
    //---------------------------------------------
    //alert('submitAnswers in pageinfo - typeForm = ' + this.typeForm);
    document.form_submit_quizmaker.quiz_id.value = quiz.quizId;
    document.form_submit_quizmaker.uid.value = 0;// quiz.uid;
    document.form_submit_quizmaker.answers_total.value = statsTotal.quiz_questions;
    
    document.form_submit_quizmaker.answers_achieved.value = statsTotal.cumul_questions;
    document.form_submit_quizmaker.score_achieved.value = statsTotal.cumul_score;
    document.form_submit_quizmaker.score_max.value = statsTotal.quiz_score_max;
    document.form_submit_quizmaker.score_min.value = statsTotal.quiz_score_min;
    document.form_submit_quizmaker.duration.value = statsTotal.cumul_timer;
    
    document.form_submit_quizmaker.isAnonymous.value = quiz_rgp.isAnonymous;
    document.form_submit_quizmaker.pseudo.value = quiz_rgp.uname;

    //---------------------------------
    document.form_submit_quizmaker.submit();
alert("submitAnswers end");
}

//---------------------------------------------------
isQuestion (){
              
    return false;         
}

//---------------------------------------------------
  getScoreByProposition (answerContainer){
    return 0;
  }
  
//---------------------------------------------------
  isInputOk(currentQuestion, answerContainer,chrono){
    return false;
  }
  
//---------------------------------------------------
  getAllReponses  (currentQuestion){
      return "";
  }
  
//---------------------------------------------------
  getGoodReponses (currentQuestion){
      return '';
  }
  
  
 
//---------------------------------------------------
  update(nameId, chrono) {
  }

} // ----- fin de la classe ------
