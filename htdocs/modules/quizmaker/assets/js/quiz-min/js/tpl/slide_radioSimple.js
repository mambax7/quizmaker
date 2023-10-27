﻿class radioSimple extends quizPrototype{name='radioSimple';build(){var currentQuestion=this.question;var name=this.getName();if(currentQuestion.image){return this.getInnerHTML_img();}else{return this.getInnerHTML();}}getInnerHTML(){var currentQuestion=this.question;var name=this.getName();const answers=[];answers.push(`<div id="${name}-famille" style="text-align:left;padding-left:30px;margin-top:10px;">`);this.data.styleCSS=getMarginStyle(currentQuestion.answers.length);answers.push(getHtmlRadioKeys(name,this.shuffleArrayKeys(this.data.items),currentQuestion.numbering,0,this.data.styleCSS));answers.push(`</div>`);this.focusId=name+"-"+"0";return answers.join("\n");}getInnerHTML_img(){var currentQuestion=this.question;const answers=[];var imageMain=`<img src="${quiz_config.urlQuizImg}/${currentQuestion.image}" alt="" title="" height="${currentQuestion.options.imgHeight}px">`;return `<table><tr><td>${imageMain}</td><td>${this.getInnerHTML()}</td></tr></table>`;}prepareData(){var currentQuestion=this.question;var tWords=[];var tPoints=[];var tKeyPoints=[];var tItems=new Object;for(var k in currentQuestion.answers){var key="ans-"+k.padStart(3,'0');var tWP={'key':key,'word':currentQuestion.answers[k].proposition,'points':currentQuestion.answers[k].points*1};tItems[key]=tWP;}this.data.items=tItems;}computeScoresMinMaxByProposition(){var lMin=0;var lMax=0;var currentQuestion=this.question;for(var i in currentQuestion.answers){if(lMax < currentQuestion.answers[i].points*1)lMax=currentQuestion.answers[i].points;if(lMin > currentQuestion.answers[i].points*1)lMin=currentQuestion.answers[i].points;}this.scoreMaxiBP+=lMax*1;this.scoreMiniBP+=lMin*1;return true;}getScoreByProposition(answerContainer){var points=0;var currentQuestion=this.question;var userAnswer=getObjectsByName(this.getName(),"input","radio","checked");if(userAnswer.length>0){var caption=userAnswer[0].getAttribute('caption');var points=this.data.items[caption].points;}this.points=points;return points;}isInputOk(answerContainer){var bolOk=false;var currentQuestion=this.question;const selector=`input[name=${this.getName(currentQuestion)}]:checked`;const userAnswer=(document.querySelector(selector)||{}).value;if(userAnswer){bolOk=true;}return bolOk;}getAllReponses(flag=0){var currentQuestion=this.question;var tReponses=[];for(var k in currentQuestion.answers){var rep=currentQuestion.answers[k];tReponses.push([[rep.proposition],[rep.points]]);}tReponses=sortArrayArray(tReponses,1,"DESC");return formatArray0(tReponses,"=>");}update(nameId){}incremente_question(nbQuestions){return(nbQuestions*1)+1;}reloadQuestion(){var currentQuestion=this.question;var name=this.getName();var obFamille=document.getElementById(`${name}-famille`);obFamille.innerHTML=getHtmlRadioKeys(name,this.shuffleArrayKeys(this.data.items),currentQuestion.numbering,0,this.data.styleCSS);return true;}showGoodAnswers(){var currentQuestion=this.question;var bolOk=false;var points=0;var obs=getObjectsByName(this.getName(),'input','radio');obs.forEach((obInput,index)=>{var caption=obInput.getAttribute('caption');if(points < this.data.items[caption].points){points=this.data.items[caption].points;obInput.checked=true;}});return true;}showBadAnswers(){var currentQuestion=this.question;var bolOk=false;var points=999;var obs=getObjectsByName(this.getName(),'input','radio');obs.forEach((obInput,index)=>{var caption=obInput.getAttribute('caption');if(points > this.data.items[caption].points){points=this.data.items[caption].points;obInput.checked=true;}});return true;}}