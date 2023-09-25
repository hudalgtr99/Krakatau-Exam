<?php
//============================================================+
// File name   : tce_page_footer.php
// Begin       : 2001-09-02
// Last Update : 2009-09-30
//
// Description : Outputs default XHTML page footer.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//
// License:
//    Copyright (C) 2004-2010  Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Outputs default XHTML page footer.
 * @package com.tecnick.tcexam.public
 * @author Nicola Asuni
 * @since 2001-09-02
 */

/**
 */

echo K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div ContainerWrapper
echo '</div>'.K_NEWLINE; //close div.body
echo '<div id="footer">'.K_NEWLINE;
include('../../shared/code/tce_page_userbar.php'); // display user bar
echo '</div>'.K_NEWLINE; //close div#footer
echo '<!-- '.base64_decode(K_KEY_SECURITY).' -->'.K_NEWLINE;


//echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'main.js"></script>'.K_NEWLINE;
echo '<script src="'.K_PATH_SHARED_JSCRIPTS.'plugins.js"></script>'.K_NEWLINE;
?>
<script>
var fTestForm = document.getElementById("testform");
var firstQuestion = document.getElementById("first_question");
var lastQuestion = document.getElementById("last_question");
var testLogId = document.getElementById("testlogid");
var prevBtn = document.getElementById("prevbtn");
var nextBtn = document.getElementById("nextbtn");
if(fTestForm){
	var noSoalLbl = document.getElementById("nosoal").textContent.replace(/\D/g,'');
}

var fLogin = document.getElementById("form_login");
var usernameField = document.getElementById("xuser_name");
var usernameLbl = document.getElementById("xuser_nameLbl");
var passwordField = document.getElementById("xuser_password");
var passwordLbl = document.getElementById("xuser_passwordLbl");

function btnVis(a,b,c){
	if(fTestForm){
		if(a.value===b.value){
			c.style.visibility = "hidden";
		}else{
			c.removeAttribute("style");
		}
	}
}

btnVis(firstQuestion,testLogId,prevBtn);

function dynNoSoal(a,b){
	if(fTestForm){
		if(b){
			noSoalLbl = parseInt(b.value);
			document.getElementById("nosoal").textContent = "#"+noSoalLbl;
		}else{
			noSoalLbl = parseInt(noSoalLbl)+a;
			document.getElementById("nosoal").textContent = "#"+noSoalLbl;
		}
		markLiSelected();
	}
}


function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		if(this.responseText==="0"){var status="Akun tidak ditemukan";var type="warning"}
		if(this.responseText==="1"){var status="Password salah";var type="warning"}
		if(this.responseText==="10"){var status="Login berhasil";var type="message";location.reload()}
      document.body.insertAdjacentHTML("afterbegin", "<div class='"+type+"'><span>"+status+"</span><span onclick='this.parentNode.style.display = \"none\"' id='close_btn'>×</span></div>");
    }
  };
  xhttp.open("POST", "index.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("logaction=login&xuser_name="+usernameField.value+"&xuser_password="+passwordField.value);
}	

function getSelAns(){
	var answposArr = [];
	var checkboxes = document.getElementById("testform").querySelectorAll('ol.answer li input[type=checkbox]');	
	for (var i = 0; i < checkboxes.length; i++) {
		var checkbox = checkboxes[i];
		
		if(checkbox.checked){
			if(checkboxes[i].value !== "0"){
				answposArr[i] = "1";	
			}else{
				answposArr[i] = "0";
			}
			
		}else{
			answposArr[i] = "0";
		}
	}
	return answposArr;
}

function saveAnswer(a,b){
	// var xxx="1";	
	if(localStorage.getItem("answer_change")==="1"){
	// if(xxx==="1"){
	// var form = document.getElementById('testform');
	// var data = new FormData(form);

	// data.forEach(el => {
		//var currNo = document.getElementById("qNum").textContent-1;
		// console.log(el);
		// alert(el);
	// });
	
	var prevIndex = noSoalLbl;
	var prevAns = localStorage.getItem("prev_ansrad_val");
	var testid = document.getElementById("testid").value;
	var testlogid = document.getElementById("testlogid").value;
	var testuser_id = document.getElementById("testuser_id").value;
	var examtime = document.getElementById("examtime").value;
	var prevquestionid;
	var nextquestionid;
	var autonext;
	
	var finish = document.getElementById("finish").value;
	var display_time = document.getElementById("display_time").value;
	var reaction_time = document.getElementById("reaction_time").value;
	if(document.getElementById("testform").answpos){
		var answpos = document.getElementById("testform").answpos.value;
	}
	var csrf_token = document.getElementById("csrf_token").value;
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if (this.readyState == 1){
			document.getElementById(b.id).disabled = "disabled";
			if(a===1000){
				document.getElementById(b.id).innerHTML = "&hellip;";
			}else{
				document.getElementById(b.id).innerHTML = "saving &hellip;";
			}
		}
		if (this.readyState == 4 && this.status == 200){
			document.getElementById(b.id).innerHTML = b.title;
			document.getElementById(b.id).removeAttribute("disabled");
			if(a!==999){
				loadQuestion(a,b);
			}
			markLiAnswered(prevIndex,prevAns);
			localStorage.setItem("answer_change","0");
			btnVis(lastQuestion,testLogId,nextBtn);
			btnVis(firstQuestion,testLogId,prevBtn);
		}
	};
// alert(getSelAns());	
  xhttp.open("POST", "tce_test_execute.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("question-block&save-answer&answpos="+answpos+"&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
  // xhttp.send("question-block&save-answer&answpos="+answpos+"&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
  // xhttp.send("question-block&save-answer&"+data);
	}else{
		if(a!==999){
			loadQuestion(a,b);
		}
	}
}

function btnDis(a,b){
	if(b===1){
		document.getElementById(a).setAttribute("disabled","disabled");
	}else{
		document.getElementById(a).removeAttribute("disabled");
	}
}

function markLiSelected(){
	for (var i=0; i < document.querySelectorAll("ol.qlist li").length; i++){
		document.querySelectorAll("ol.qlist li")[i].className = "";
	}
	liIndex = noSoalLbl-1;
	document.querySelectorAll("ol.qlist li")[liIndex].className += "terpilih";
	
	var qListBtn = document.querySelectorAll("ol.qlist li")[liIndex].firstChild;	
	var clBtn = qListBtn.classList.contains("q_displayed");
		
	if(!clBtn){
		qListBtn.className += " q_displayed";
	}
	backdrop("-1","0");
}

function markLiAnswered(a,b){
	prevIndex = a-1;
	var qListBtn = document.querySelectorAll("ol.qlist li")[prevIndex].firstChild;	
	var clBtnAns = qListBtn.classList.contains("q_answered");	
	var clBtnNAns = qListBtn.classList.contains("q_notanswered");
	if(clBtnNAns){
		qListBtn.classList.replace("q_notanswered","q_answered");
	}
	if(clBtnAns && b==="0"){
		qListBtn.classList.replace("q_answered","q_notanswered");
	}
}

function loadQuestion(a,b){
	if(fTestForm){
		localStorage.setItem("answer_change","0");
		var testid = document.getElementById("testid").value;
		if(a!==1000){
			document.getElementById("testlogid").value = parseInt(document.getElementById("testlogid").value)+a;
		}else{
			document.getElementById("testlogid").value = b.id;
		}
		var testlogid = document.getElementById("testlogid").value;
		var testuser_id = document.getElementById("testuser_id").value;
		var examtime = document.getElementById("examtime").value;
		var prevquestionid;
		var nextquestionid;
		var autonext;
		var finish = document.getElementById("finish").value;
		var display_time = document.getElementById("display_time").value;
		var reaction_time = document.getElementById("reaction_time").value;
		var csrf_token = document.getElementById("csrf_token").value;
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function(){
			if (this.readyState == 1){
				if(b!==0){
					document.getElementById(b.id).innerHTML = "loading &hellip;";
					btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
				}
				if(a==1000){
					document.getElementById(b.id).innerHTML = "&hellip;";
					btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
					backdrop("100","1");
				}else{
					backdrop("1","1");
				}
			}
			if (this.readyState == 4 && this.status == 200){
				if(b!==0){
					document.getElementById(b.id).innerHTML = b.title;
				}
				if(a===1000){
					document.getElementById(b.id).innerHTML = b.value;
				}
				
				if(this.responseText.length>0){
					document.getElementById("question-area").innerHTML = this.responseText;
				}else{
					document.getElementById("question-area").innerHTML = "No Test Data Found, <a href='index.php'><u>click here to back home</u> or reload this page by clicking <a onclick='location.reload()'>here</a>";
				}
				
				var ansrad = document.getElementById("testform").answpos;	
				if(ansrad){
					for (var i = 0; i < ansrad.length; i++) {
						ansrad[i].addEventListener('change', function() {				
							localStorage.setItem("answer_change","1");
							localStorage.setItem("prev_ansrad_val",ansrad.value);
						});
					}
				}						
				
				if(a!==1000){
					dynNoSoal(a);
				}else{
					dynNoSoal(a,b);
				}
				btnVis(firstQuestion,testLogId,prevBtn);btnVis(lastQuestion,testLogId,nextBtn);
				btnDis("relbtn",0);btnDis("prevbtn",0);btnDis("nextbtn",0);btnDis("savebtn",0);
			}
		};
		
	  xhttp.open("POST", "tce_test_execute.php", true);
	  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhttp.send("question-block&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
	}
}
loadQuestion(0,0);
function floatingLabel(a,b){
	if(fLogin){
		if(a.value.length>0){
			b.style.transition = "all 0.05s ease-in-out";
			b.style.opacity = "1";
		}
		a.addEventListener("keyup", function() {
			if(a.value.length>0){
				b.style.color = "#343a40";
				b.style.fontSize = "0.85em";
				b.style.top = "-15px";
				b.style.left = "0px";
				b.style.transition = "all 0.15s ease-in-out";
			}else{				
				b.style.color = "#999";
				b.style.fontSize = "0.98em";
				b.style.top = "7px";
				b.style.left = "8px";
				b.style.transition = "all 0.15s ease-in-out";
			}
		})
	}
}

floatingLabel(usernameField,usernameLbl);
floatingLabel(passwordField,passwordLbl);

</script>
<?php
echo '</body>'.K_NEWLINE;
echo '</html>';

//============================================================+
// END OF FILE
//============================================================+
