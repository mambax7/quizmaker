﻿class pageGroup extends quizPrototype{name="pageGroup";build(){var currentQuestion=this.question;var name=this.getName();const answers=[];if(currentQuestion.image){if(currentQuestion.answers[0].proposition!=''){var imgHtml=get_highslide_a(quiz_config.urlQuizImg+'/'+currentQuestion.image,null,currentQuestion.options.imgHeight,null,true);currentQuestion.answers[0].proposition=imgHtml+currentQuestion.answers[0].proposition;}else{var imgHtml=get_highslide_a(quiz_config.urlQuizImg+'/'+currentQuestion.image,null,currentQuestion.options.imgHeight,null,false);answers.push(imgHtml);}}for(var k in currentQuestion.answers){var id=this.getId(k);if(currentQuestion.answers[k].proposition=='')continue;var exp=replaceBalisesByValues(currentQuestion.answers[k].proposition);answers.push(`<div id="${id}" name="${name}" class="quiz-shadowbox " style='width:90%;' disabled>${exp}</div>`);}answers.push('<br>');return answers.join("\n");}isQuestion(){return false;}getScoreByProposition(answerContainer){return 0;}isInputOk(currentQuestion,answerContainer,chrono){return false;}getAllReponses(currentQuestion){return "";}getGoodReponses(currentQuestion){return '';}update(nameId,chrono){}incremente_question(nbQuestions){return nbQuestions;}reloadQuestion(){var currentQuestion=this.question;for(var k in currentQuestion.answers){var id=this.getId(k);var obDiv=document.getElementById(id);if(!obDiv)continue;obDiv.innerHTML=replaceBalisesByValues(currentQuestion.answers[k].proposition);}}}