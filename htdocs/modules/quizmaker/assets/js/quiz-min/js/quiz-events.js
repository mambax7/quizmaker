﻿ function testClick2(exp){var a=555;alert("testClick:exp="+exp+" | a="+a);}function computeAllScoreEvent(){document.getElementById('quiz_div_all_slides').click();}function quiz_textareaInput_event(eventName,id,name,chrono){clQuestion=quizard[chrono];var obExp=document.getElementById(id);var exp=clQuestion.data.text;var obs=getObjectsByName("input",name);switch(eventName){case "update":obs.forEach((obInput,index)=>{if(obInput.value!=""){exp=exp.replaceAll("{"+(index+1)+"}",obInput.value);}});obExp.innerHTML=exp;break;case "reload":break;}}function quiz_textareaListbox_event(e,action,idText,idParentList,chrono){clQuestion=quizard[chrono];var obExp=document.getElementById(idText);var exp=clQuestion.data.text;var obLists=document.querySelectorAll(`#${idParentList}`+' select');switch(action){case "update":obLists.forEach((obInput,index)=>{if(obInput.value!=""){exp=exp.replaceAll("{"+(index*1+1)+"}",obInput.value);}});obExp.innerHTML=exp;break;case "reload":break;}e.stopPropagation();return false;}function quiz_deleteValue(id){var ob=document.getElementById(id);index=ob.selectedIndex;if(ob.selectedIndex==-1){return true;}else{ob.options.remove(index)}return true;}function quiz_basculeValue(idLeft,idRight){var obLeft=document.getElementById(idLeft);var obRight=document.getElementById(idRight);var index=obLeft.selectedIndex;if(obLeft.selectedIndex==-1){return true;}else{obRight.options.add(obLeft.options[index]);}return true;}function quiz_MoveItemTo(idObj,where,arround=false){var listObj=document.getElementById(idObj);var options=listObj.getElementsByTagName("OPTION");for(var i=options.length-1;i >=0;i--){if(options[i].selected){var obSelected=options[i];var oldPos=i;listObj.removeChild(options[i]);continue;}}switch(where){case 'top':listObj.insertBefore(obSelected,options[0]);break;case 'bottom':listObj.insertBefore(obSelected,null);break;case 'up':if((oldPos-1)>=0)listObj.insertBefore(obSelected,options[oldPos-1]);else if(arround)listObj.insertBefore(obSelected,null);elselistObj.insertBefore(obSelected,options[0]);break;case 'down':if((oldPos+1)<=options.length)listObj.insertBefore(obSelected,options[oldPos+1]);else if(arround)listObj.insertBefore(obSelected,options[0]);elselistObj.insertBefore(obSelected,null);break;}};function permuteImg_event(idFrom,idTo,chrono){var obImgFrom=document.getElementById(idFrom);var obImgTo=document.getElementById(idTo);var tmp=obImgTo.getAttribute("src");obImgTo.setAttribute("src",obImgFrom.getAttribute("src"));obImgFrom.setAttribute("src",tmp);}function setImgFromImg_event(idFrom,idTo,chrono){var obImgFrom=document.getElementById(idFrom);var obImgTo=document.getElementById(idTo);obImgTo.setAttribute("src",obImgFrom.getAttribute("src"));}function dad_start(e,isDiv=false){console.log("===> dad=> "+"dad_start");e.dataTransfer.effectAllowed="move";if(isDiv){e.dataTransfer.setData("text",e.target.parentNode.getAttribute("id"));}else{e.dataTransfer.setData("text",e.target.getAttribute("id"));}blob("dad_start:"+e.target.getAttribute("id")+" | "+e.target.getAttribute("src"));}function dad_over(e){console.log("===> dad=> "+"dad_over");if(e.currentTarget.getAttribute("id")==e.dataTransfer.getData("text"))return false;e.currentTarget.parentNode.classList.remove('quiz_dad1');e.currentTarget.parentNode.classList.add('quiz_dad2');return false;}function dad_drop(e,mode=0){console.log("===> dad=> "+"dad_drop");idFrom=e.dataTransfer.getData("text");e.currentTarget.classList.remove('quiz_dad2');e.currentTarget.classList.add('quiz_dad1');var obDest=document.getElementById(e.currentTarget.getAttribute("id"));var obSource=document.getElementById(idFrom);alert(obSource.id);switch(mode){case quiz_config.dad_shift_img:shiftImg(obSource,obDest);break;case quiz_config.dad_move_img:alert('move');e.currentTarget.appendChild(document.getElementById(idFrom));break;case quiz_config.dad_move_div:replaceDiv(obSource,obDest);break;case quiz_config.dad_flip_img:default:replaceImg(obSource,obDest);break;}computeAllScoreEvent();e.stopPropagation();return false;}function dad_leave(e){console.log("===> dad=> "+"dad_leave");e.currentTarget.parentNode.classList.remove('quiz_dad2');e.currentTarget.parentNode.classList.add('quiz_dad1');}function replaceImg(obSource,obDest,deleteSource=false){var srcTmp=obDest.getAttribute("src");obDest.setAttribute("src",obSource.getAttribute("src"));if(deleteSource){obSource.parentNode.removeChild(obSource);}else{obSource.setAttribute("src",srcTmp);}}function replaceDiv(obSource,obDest){var obNext=obSource.nextSibling;var obPrevious=obSource.previousSibling;obSource.parentNode.insertBefore(obSource,obDest);if(obNext){obSource.parentNode.insertBefore(obDest,obNext);}else if(obPrevious){obSource.parentNode.insertAfter(obDest);}else{obSource.parentNode.appendChild(obDest);}return false;}function shiftImg(obSource,obDest){obSource.parentNode.insertBefore(obSource,obDest);}function testMouseOver(e){blob("testMouseOver:"+e.currentTarget.getAttribute("src"));}function testOnClick(e){var obSource=document.getElementById(e.currentTarget.getAttribute("id"));var obs=document.querySelectorAll(`#${obSource.parentNode.id}`+' img');for(var i=0;i < obs.length;i++){blob("===> "+i+':'+obs[i].getAttribute("src"))}}function event_hide_popup_result(){var divDisabledAll=document.getElementById('quiz_div_disabled_all');divDisabledAll.style.visibility="hidden";document.getElementById('quiz_div_popup_answers').innerHTML="";document.getElementById('quiz_div_popup_quest').innerHTML="";document.getElementById('quiz_div_popup_points').innerHTML="";return true;}