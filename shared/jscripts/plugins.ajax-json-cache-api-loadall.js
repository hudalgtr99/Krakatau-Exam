// Avoid `console` errors in browsers that lack a console.
(function() {
  var method;
  var noop = function () {};
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});

  while (length--) {
    method = methods[length];

    // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop;
    }
  }
}());

// Place any jQuery/helper plugins in here.


if(document.getElementById("fprintmsg")){
	let wrap = document.getElementById("fprintmsg");
	let tipe = document.getElementById("msg_type");
	let title = document.getElementById("msg_title");
	
	document.getElementById("fprintmsg").setAttribute("class",tipe.textContent+" jc-c");
	document.getElementById("msg_title").setAttribute("style","font-weight:bold");
	
	title.innerHTML = title.innerHTML+"&nbsp;:&nbsp;";
	
	wrap.innerHTML = wrap.innerHTML + "<span onclick='this.parentNode.style.display = &quot;none&quot;' id='close_btn'>×</span>";
	
	document.getElementById("msg_type").style.display = "none";
}


function backdrop(bd,dis){
	var bdDiv = document.getElementById("backdrop");
	if(bd==="1" || bd==="100"){bdDiv.style.display = "block"}else{bdDiv.style.display = "none"}
	if(dis==="1"){document.body.style.pointerEvents = "none"}else{document.body.removeAttribute("style")}
	bdDiv.style.zIndex = bd;
}

var reloadCont = document.getElementById("reloadCont");
var noSoal = document.getElementById("nosoal");
var noSoalTop = document.getElementById("nosoalTop");
if(noSoal){noSoalTop.appendChild(noSoal);noSoal.style.display = "block"}

var qlistShow = document.getElementById("qlistShow");
var qlistTop = document.getElementById("qlistTop");
if(qlistShow){qlistTop.appendChild(qlistShow);qlistShow.style.display = "flex"}

var scrolLayer = document.getElementById("scrollayer");
function menuOpen(){scrolLayer.setAttribute("class","slide-in-header");backdrop("1",false)}
function menuClose(){var slideInHeader = document.querySelector(".slide-in-header");if(slideInHeader){scrolLayer.setAttribute("class","slide-out-header");backdrop("-1",false)}}

var qlistContID = document.getElementById("qlistContID");

function qlistOpen(){
	if(localStorage.getItem("darkMode")==="1"){var darkClass="darkCont"}else{darkClass=""}
	qlistContID.setAttribute("class","tcecontentbox qlistCont slide-in-qlist "+darkClass);backdrop("1")
}
function qlistHide(){
	if(localStorage.getItem("darkMode")==="1"){var darkClass="darkCont"}else{darkClass=""}
	var slideInQlist = document.querySelector(".slide-in-qlist");if(slideInQlist){qlistContID.setAttribute("class","tcecontentbox qlistCont slide-out-qlist "+darkClass);backdrop("-1")}}

var langSelID = document.getElementById("langSelID");
function langSelOpen(){langSelID.setAttribute("class","qlistCont slide-in-langsel");backdrop("1")}
function langSelHide(){var slideInLangsel = document.querySelector(".slide-in-langsel");if(slideInLangsel){langSelID.setAttribute("class","qlistCont slide-out-langsel");backdrop("-1")}}

var userInfoID = document.getElementById("userInfoID");
function userInfoOpen(){userInfoID.setAttribute("class","qlistCont slide-in-userIID");backdrop("1")}
function userInfoHide(){var slideInUserIID = document.querySelector(".slide-in-userIID");if(slideInUserIID){userInfoID.setAttribute("class","qlistCont slide-out-userIID");backdrop("-1")}}

var testComment = document.querySelector(".testcomment");
function commentOpen(){testComment.setAttribute("class","testcomment slide-in-comment");backdrop("1")}
function commentHide(){var slideInComment = document.querySelector(".slide-in-comment");if(slideInComment){testComment.setAttribute("class","testcomment slide-out-comment");backdrop("-1")}}

var h1_testpage = document.getElementById("h1_testpage");
var infolinkCont = document.getElementById("infolinkCont");
var nosoalCont = document.getElementById("nosoalCont");
var iconsettings = document.getElementById("iconsettings");
function qSettingToggle(a){
	if(infolinkCont.style.display==="block"){
		infolinkCont.removeAttribute("style");
		iconsettings.removeAttribute("style");
	}else{
		iconsettings.style.color = "var(--col-3)";
		iconsettings.style.background = "var(--col-12)";
		infolinkCont.style.display = "block";
		infolinkCont.style.opacity = "0.95";
		infolinkCont.style.zIndex = "1";
		infolinkCont.style.transition = "opacity 0.2s ease-in-out 0s";
	}
}

var imgProblem = document.getElementById("imgProblem");
if(imgProblem){
	imgProblem.addEventListener("click", function() {
		imgProblem.setAttribute("class","hidden");
	})
}

var btn_uploadFile = document.getElementById("btn_uploadFile");
if(btn_uploadFile){
	btn_uploadFile.addEventListener("click", function() {
		imgProblem.removeAttribute("class");
	})
}

function qNumUnsureStyle(){
	noSoal.style.color = "#343a40";
	noSoal.style.background = "#ffcc00";
	noSoal.style.textShadow = "none";
}

var fTestForm = document.getElementById("testform");
var utilTop = document.getElementById("utilTop");

if(!fTestForm){utilTop.style.display = "none"}

function addUnsure(){
	if(fTestForm){
		let unsure;		
		if(localStorage.getItem('unsure') === null){
			unsure = [];
		}else{
			unsure = JSON.parse(localStorage.getItem('unsure'));
		}
		unsure.push(window.noSoalIndex);
		localStorage.setItem('unsure', JSON.stringify(unsure));
	}
}

function removeUnsure(){
	if(fTestForm){
		var index = window.noSoalIndex;
		let unsure;
		if(localStorage.getItem('unsure') === null){
			unsure = [];
		}else{
			unsure = JSON.parse(localStorage.getItem('unsure'));
		}
		var i;
		for(i = 0; i < unsure.length;){
			if(unsure[i] === index){
				unsure.splice(i, 1);
			}else{
				i++;
			}
		}
		localStorage.setItem('unsure', JSON.stringify(unsure));
	}
}

var qlistArr = document.querySelectorAll("ol.qlist li");
function setUnsureLiBg(a){
	qlistArr[a].firstElementChild.style.setProperty("background-image","linear-gradient(45deg, transparent 2.1em, #ffcc00 2.1em)","important");
}
function resetUnsureLiBg(a){
	qlistArr[a].firstElementChild.removeAttribute("style");
}

var lblUnsure = document.getElementById("lblUnsure");
function unsureToggler(a){
	if(localStorage.getItem('unsure') && fTestForm){
		const unsures = JSON.parse(localStorage.getItem('unsure'));
		unsures.forEach(el => {
		  setUnsureLiBg(el);
		});
		
		if(unsures.indexOf(a) !== -1){
			qNumUnsureStyle();
			cbUnsure.setAttribute("checked","checked");
		}else{
			noSoal.setAttribute("style","display:block");
			cbUnsure.removeAttribute("checked");
		}
		cbUnsure.removeAttribute("style");
	}
}
		
function markUnsure(a){
	if(a.checked){
		qNumUnsureStyle();
		addUnsure();
		setUnsureLiBg(window.noSoalIndex);
	}else{
		noSoal.setAttribute("style","display:block");
		removeUnsure();
		resetUnsureLiBg(window.noSoalIndex);
	}
}

var h_fileAction = document.getElementById("h_fileAction");
var c_fileAction = document.getElementById("c_fileAction");
if(h_fileAction){
	h_fileAction.addEventListener("click", function() {
		if(c_fileAction.style.display==="block"){	
			c_fileAction.style.display = "none";
		}else{
			c_fileAction.style.display = "block";
		}
	})
}

function clearUnsure(){
	localStorage.setItem('unsure', '[]');
}

if(fTestForm){
	if(!localStorage.getItem("darkMode")){
		localStorage.setItem("darkMode","0")
	}
}

var h1_testpageLink = document.querySelector("#h1_testpage a");
var questionBlock = document.querySelector(".question-block");
var navLink = document.querySelector(".navlink");
var header = document.querySelector(".header");
var lightModeBtn = document.getElementById("lightModeBtn");
var darkModeBtn = document.getElementById("darkModeBtn");
var forceterminateCont = document.getElementById("forceterminateCont");

function darkMode(){
	if(fTestForm){
		fTestForm.style.setProperty("background","var(--col-11)","important");
		document.body.style.background = "var(--col-11)";
		questionBlock.style.color = "var(--col-7)";
		questionBlock.style.background = "var(--col-6)";
		header.style.background = "var(--col-11)";
		navLink.style.background = "var(--col-11)";
		utilTop.style.background = "var(--col-6)";
		h1_testpageLink.className = "darkCont";
		infolinkCont.className = "darkCont";
		utilTop.style.color = "var(--col-7)";
		forceterminateCont.style.background = "var(--col-11)";
		darkModeBtn.style.display = "none";
		lightModeBtn.style.display = "flex";
		localStorage.setItem("darkMode","1")
		
	}
}

function lightMode(){
	if(fTestForm){
		document.body.removeAttribute("style");
		questionBlock.removeAttribute("style");
		header.removeAttribute("style");
		navLink.removeAttribute("style");
		fTestForm.removeAttribute("style");
		h1_testpageLink.removeAttribute("class");
		infolinkCont.removeAttribute("class");
		utilTop.removeAttribute("style");
		forceterminateCont.removeAttribute("style");
		darkModeBtn.style.display = "flex";
		lightModeBtn.style.display = "none";
		localStorage.setItem("darkMode","0")
	}
}

if(fTestForm){
	var lsDarkMode = localStorage.getItem("darkMode");
	if(lsDarkMode){
		if(lsDarkMode==="1"){
			document.getElementById("darkModeBtn").style.display = "none";
			document.getElementById("lightModeBtn").style.display = "block";
			darkMode()
		}else{
			document.getElementById("darkModeBtn").style.display = "block";
			document.getElementById("lightModeBtn").style.display = "none";
			lightMode()
		}
	}
}

if(fTestForm){
	var lsFontSize = localStorage.getItem("fontSize");
	if(lsFontSize){
		document.querySelector(".tcecontentbox").style.fontSize =lsFontSize+'px';
		if(document.querySelector(".answer")){
			document.querySelector(".answer").style.fontSize =lsFontSize+'px';
		}
	}
}

function zoomintext(){
	if(fTestForm){
		var fs=parseFloat(window.getComputedStyle(document.querySelector(".tcecontentbox")).fontSize);
		newfontSize=fs*(1.1);
		document.querySelector(".tcecontentbox").style.fontSize =newfontSize+'px';
		if(document.querySelector(".answer")){
			document.querySelector(".answer").style.fontSize =newfontSize+'px';
		}
		fontSize=newfontSize;
		localStorage.setItem("fontSize", fontSize);
	}
}
function zoomouttext(){
	if(fTestForm){
		var fs=parseFloat(window.getComputedStyle(document.querySelector(".tcecontentbox")).fontSize);
		newfontSize=fs/(1.1);
		document.querySelector(".tcecontentbox").style.fontSize =newfontSize+'px';
		if(document.querySelector(".answer")){
			document.querySelector(".answer").style.fontSize =newfontSize+'px';
		}
		fontSize=newfontSize;
		localStorage.setItem("fontSize", fontSize);
	}	
}

var showPass = document.getElementById("showPass");
var showPass_new = document.getElementById("showPass_new");
var showPass_repeat = document.getElementById("showPass_repeat");
var hidePass = document.getElementById("hidePass");
var hidePass_new = document.getElementById("hidePass_new");
var hidePass_repeat = document.getElementById("hidePass_repeat");
var xuser_password = document.getElementById("xuser_password") || document.getElementById("xtest_password") || document.getElementById("currentpassword");
var xuser_password_new = document.getElementById("newpassword");
var xuser_password_repeat = document.getElementById("newpassword_repeat");
if(showPass){
	showPass.addEventListener("click", function() {
		// alert("xxx");
		showPass.style.display = "none";	
		hidePass.style.display = "block";
		xuser_password.setAttribute("type","text");		
	})
}
if(showPass_new){
	showPass_new.addEventListener("click", function() {
		// alert("xxx");
		showPass_new.style.display = "none";	
		hidePass_new.style.display = "block";
		xuser_password_new.setAttribute("type","text");		
	})
}
if(showPass_repeat){
	showPass_repeat.addEventListener("click", function() {
		// alert("xxx");
		showPass_repeat.style.display = "none";	
		hidePass_repeat.style.display = "block";
		xuser_password_repeat.setAttribute("type","text");		
	})
}
if(hidePass){
	hidePass.addEventListener("click", function() {
		showPass.style.display = "block";	
		hidePass.style.display = "none";
		xuser_password.setAttribute("type","password");		
	})
}
if(hidePass_new){
	hidePass_new.addEventListener("click", function() {
		showPass_new.style.display = "block";	
		hidePass_new.style.display = "none";
		xuser_password_new.setAttribute("type","password");		
	})
}
if(hidePass_repeat){
	hidePass_repeat.addEventListener("click", function() {
		showPass_repeat.style.display = "block";	
		hidePass_repeat.style.display = "none";
		xuser_password_repeat.setAttribute("type","password");		
	})
}

/* 
 * FormChanges(string FormID | DOMelement FormNode)
 * Returns an array of changed form elements.
 * An empty array indicates no changes have been made.
 * NULL indicates that the form does not exist.
 *
 * By Craig Buckler,		http://twitter.com/craigbuckler
 * of OptimalWorks.net		http://optimalworks.net/
 * for SitePoint.com		http://sitepoint.com/
 * 
 * Refer to http://blogs.sitepoint.com/javascript-form-change-checker/
 *
 * This code can be used without restriction. 
 */
function FormChanges(form) {
	// get form
	if (typeof form == "string") form = document.getElementById(form);
	if (!form || !form.nodeName || form.nodeName.toLowerCase() != "form") return null;
	
	// find changed elements
	var changed = [], n, c, def, o, ol, opt;
	for (var e = 0, el = form.elements.length; e < el; e++) {
		n = form.elements[e];
		c = false;
		if(n.id!=="cbUnsure")
		switch (n.nodeName.toLowerCase()) {
			// select boxes
			case "select":
				def = 0;
				for (o = 0, ol = n.options.length; o < ol; o++) {
					opt = n.options[o];
					c = c || (opt.selected != opt.defaultSelected);
					if (opt.defaultSelected) def = o;
				}
				if (c && !n.multiple) c = (def != n.selectedIndex);
				break;
			
			// input / textarea
			case "textarea":
			case "input":
				switch (n.type.toLowerCase()) {
					case "checkbox":
					case "radio":
						// checkbox / radio
						c = (n.checked != n.defaultChecked);
						break;
					default:
						// standard values
						c = (n.value != n.defaultValue);
						break;				
				}
				break;
		}
		if (c) changed.push(n);
	}
	return changed;
}
// show changed messages
function DetectChanges(formId) {
	var f = FormChanges(formId)
	return(f.length);
}

//load js if question type 3 (free text answer)
function loadWYSIBB(){
	var imported3 = document.createElement("link");
	var wysibbStyle = document.getElementById("wysibb-style");
	if(!wysibbStyle){
		imported3.id = "wysibb-style";
		imported3.rel = "stylesheet";
		imported3.href = "../../shared/jscripts/vendor/wysibb/theme/default/wbbtheme.css";
		document.head.appendChild(imported3);
	}
	
	if(!window.jQuery){
		var imported = document.createElement("script");
		imported.defer = "defer";
		imported.id = "jquery";
		imported.src = "../../shared/jscripts/vendor/wysibb/jquery-1.11.0.min.js";
		imported.onload = function(){
			var imported2 = document.createElement("script");
			imported2.defer = "defer";
			imported2.id = "wysibb";						
			imported2.src = "../../shared/jscripts/vendor/wysibb/jquery.wysibb.min.js";
			imported2.onload = function(){
				//run wysibb
				var answerText = $("#answertext");
				$("#answertext").wysibb();
				$("#btn_uploadFileCont").show();
			}
			document.head.appendChild(imported2);
		};
		document.head.appendChild(imported);
	}
}

var firstQuestion = document.getElementById("first_question");
var lastQuestion = document.getElementById("last_question");
var testLogId = document.getElementById("testlogid");
var prevBtn = document.getElementById("prevbtn");
var nextBtn = document.getElementById("nextbtn");
if(fTestForm){
	var noSoalLbl = parseInt(noSoal.textContent);
}

var fLogin = document.getElementById("form_login");
var usernameField = document.getElementById("xuser_name");
var usernameLbl = document.getElementById("xuser_nameLbl");
var passwordField = document.getElementById("xuser_password");
var passwordLbl = document.getElementById("xuser_passwordLbl");

function btnVis(a,b,c){
	if(fTestForm){
		if(a.value===b.value){
			c.style.display = "none";
		}else{
			c.removeAttribute("style");
		}
		if(lastQuestion.value===b.value){
			nextBtn.setAttribute("onclick","saveAnswerAjax(0,this)")
		}else{
			nextBtn.setAttribute("onclick","saveAnswerAjax(1,this)")
		}
	}
}

btnVis(firstQuestion,testLogId,prevBtn);

function dynNoSoal(a,b){
	if(fTestForm){
		if(b){
			noSoalLbl = parseInt(b.value);
			noSoal.textContent = noSoalLbl;
		}else{
			noSoalLbl = noSoalLbl+a;
			noSoal.textContent = noSoalLbl;
		}
		markLiSelected();
	}
}


function loadDoc() {
	if((document.getElementById("xuser_name").value).length>0 && (document.getElementById("xuser_password").value).length>0){
		var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 1){
				reloadCont.style.display = "block";
				backdrop("1","1");	
			}
			if (this.readyState == 4 && this.status == 200) {
				let closeBtn = document.getElementById("close_btn");
				if(closeBtn){
					closeBtn.click();
				}
				var loginStatus = JSON.parse(this.responseText);
				if(loginStatus[0]=="userdisabled"){
					document.querySelector("button#login").removeAttribute("onclick");
					document.querySelector("#xuser_name").setAttribute("readonly","readonly");
					document.querySelector("#xuser_name").value = "";
					document.querySelector("#xuser_password").setAttribute("readonly","readonly");
					document.querySelector("#xuser_password").value = "";
				}
			  document.body.insertAdjacentHTML("afterbegin", "<div class='"+loginStatus[0]+"'><span>"+loginStatus[1]+"</span><span onclick='this.parentNode.style.display = \"none\"' id='close_btn'>×</span></div>");
			  if(loginStatus[0]==="message"){
				  location.reload()
			  }
			  reloadCont.style.display = "none";
			  backdrop("-1","-1");			  
			}
		  };
		  xhttp.open("POST", "index.php", true);
		  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  xhttp.send("logaction=login&xuser_name="+usernameField.value+"&xuser_password="+passwordField.value);
	}
}	

function getAllTestLogID(){
	var testlogid_arr = [];
	let i;
	for(i=0; i < qlistArr.length; i++){
		testlogid_arr[i] = qlistArr[i].firstChild.id;
	}
	return testlogid_arr;
}

function findLocalItems (query) {
  var i, results = [];
  for (i in localStorage) {
    if (localStorage.hasOwnProperty(i)) {
      if (i.match(query) || (!query && typeof i === 'string')) {
		results.push(i.replace(/\D/g,''));
      }
    }
  }
  return results;
}

function checkTestuserID(){
	let aconttinue_arr = document.querySelectorAll(".continue");
	let testlogid_arr = [];
	let i;
	for(i=0; i < aconttinue_arr.length; i++){
		testlogid_arr[i] = aconttinue_arr[i].id;
	}
	return testlogid_arr;
}

function arrayDiff(){
	return findLocalItems("testlog").filter(x => !checkTestuserID().includes(x));
}

function delAllMatchLsCache(a){
	var tuidArr = a;
	if(!Array.isArray(a)){
		var tuidArr = [];
		tuidArr = [a];
	}
	for(i=0; i < tuidArr.length; i++){
		let testlogid_arr = JSON.parse(localStorage.getItem(tuidArr[i]+'_testlogid'));
		for(let i=0; i < testlogid_arr.length; i++){
			localStorage.removeItem('json_'+testlogid_arr[i]);
			caches.open('qBlockCache').then(cache => {
				cache.delete('../../qblock/'+testlogid_arr[i]+'.json');
			});		
		}
		delStaticServFile(tuidArr[i]);
		localStorage.removeItem(tuidArr[i]+'_testlogid');
		localStorage.removeItem('answdatas');
		localStorage.removeItem('unsure');
	}
}

function delStaticServFile(x){
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
		  }
	  };
	  xhttp.open("POST", "tmf_del_json_user.php", true);
	  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhttp.send("tuid="+x+"&data="+localStorage.getItem(x+"_testlogid"));
}

if(document.querySelector(".testlist") && QBLOCK_JSON){
	delAllMatchLsCache(arrayDiff());
}

function getCurTestLogID(){
	let curtestlogid = qlistArr[noSoalIndex].firstChild.id;
	return curtestlogid;
}

function saveAnswerAjax(a,b){
	var questionList = document.getElementById("question-list");
	if(document.getElementById("close_btn_offline")){document.getElementById("page-offline").remove()}
	var prevTestLogID = qlistArr[noSoalLbl-1].firstChild.id;
	var answertext = document.querySelector(".wysibb-texarea");
	if(answertext){$("#answertext").sync()}
	
	var form = document.getElementById('testform');
	var data = new FormData(form);
	data.append('question-block','1');
	data.append('save-answer','1');
	var formChanged = checkFormState();
	var btnLbl = b.innerHTML;
	if(formChanged>0){
		var submittime=new Date();document.getElementById('reaction_time').value=submittime.getTime()-document.getElementById('display_time').value;
		data.set('display_time',document.getElementById('display_time').value);
		data.set('reaction_time',document.getElementById('reaction_time').value);
		var testlogid = document.getElementById("testlogid").value;
		var qtype = document.getElementById("qtype").value;
		
		if(QBLOCK_JSON){
			if(localStorage.getItem('answdatas') === null){
				var answdatas = [];
			}else{
				var answdatas = JSON.parse(localStorage.getItem('answdatas'));
			}		
		
			var answdata = [];
			answdata[0] = testlogid;
			answdata[1] = qtype;
			
			var fcTestF = FormChanges("testform");
			var AllCbQType1 = document.querySelectorAll(".rowl .answer li input");
			var AllCbQType2 = document.querySelectorAll(".rowl .answer li input");
			var AllSelQType4 = document.querySelectorAll(".rowl .answer li select");
			
			var qtype2data = [];
			var qtype4data = [];
			for(var i = 0; i < fcTestF.length; i++){
				if(qtype==="1"){
					for(var i = 0; i < AllCbQType1.length; i++){
						if(AllCbQType1[i].checked){
							answdata[2] = AllCbQType1[i].id.replace(/\D/g,'');	
						}
					}
				}
				if(qtype==="2"){
					for(var i = 0; i < AllCbQType2.length; i++){
						if(AllCbQType2[i].checked){
							qtype2data.push(AllCbQType2[i].id.replace(/\D/g,''));
							answdata[2] = qtype2data;	
						}
					}
				}
				if(qtype==="3"){
					answdata[2] = fcTestF[0].value;
				}
				if(qtype==="4"){
					for(var i = 1; i < AllSelQType4.length+1; i++){
						qtype4data.push(document.getElementById("answpos_"+i).options.selectedIndex);
						answdata[2] = qtype4data;
					}
				}
			}
			answdatas[noSoalIndex] = answdata;			
			data.append('ls-answdatas',JSON.stringify(answdatas));
		}
		data.append('ls-unsure',localStorage.getItem('unsure'));
		// end - some array of selected / filled question and save to localStorage
		
		
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

		var csrf_token = document.getElementById("csrf_token").value;
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function(){
			if (this.readyState == 1){
				document.getElementById(b.id).disabled = "disabled";
				reloadCont.style.display = "block";
				backdrop("100","1");
				document.body.style.pointerEvents = "none";
				if(a===1000){
					document.getElementById(prevTestLogID).innerHTML = "<div class='anim-pulsate'><span class='icon-upload'></span></div>";
				}else{
					document.getElementById(b.id).innerHTML = "<div class='anim-pulsate'><span class='icon-upload'></span></div>";
				}
			}
			
			if (this.readyState == 4 && this.status == 200){
				if(QBLOCK_JSON){localStorage.setItem('answdatas', JSON.stringify(answdatas))};
				if(a===1000){
					document.getElementById(prevTestLogID).innerHTML = prevIndex;
				}else{
					document.getElementById(b.id).innerHTML = btnLbl;
				}
				document.getElementById(b.id).removeAttribute("disabled");
				if(a!==999){
					loadQuestion(a,b);
				}
				markLiAnswered(prevIndex,prevAns);
				localStorage.setItem("answer_change","0");
				btnVis(lastQuestion,testLogId,nextBtn);
				btnVis(firstQuestion,testLogId,prevBtn);
				//uncomment below to always load answdata from server
				//loadDataFromServer(1);
				if(b.id==="termbtn"){
					document.getElementById("terminatetest").click();
				}
			}
		};
		xhttp.open("POST", "tce_test_execute.php", true);
		xhttp.timeout = 10000;
		xhttp.ontimeout = function (e) {			
			if(b!==0){
					document.getElementById(b.id).innerHTML = btnLbl;
				}
			if(a===1000){
					document.getElementById(b.id).innerHTML = btnLbl;
					questionList.removeAttribute("style");
					b.removeAttribute("style");
			}
			
			btnDis(b.id,0);
			document.getElementById(b.id).click();
			
		};
		xhttp.send(data);
		xhttp.onerror = function(e){
			reloadCont.style.display = "block";
			if(!document.getElementById("offline-msg")){
				reloadCont.insertAdjacentHTML("beforebegin", "<h5 id='offline-msg' class='p-1em' style='border-radius:5px;margin:0.5em;text-align:justify;color:#fff;background:rgba(255,0,0,0.5);border: 3px solid #8c1212;'></h5>");
			}
			document.getElementById("offline-msg").innerHTML = 'Offline! Perangkat Anda tidak terhubung ke jaringan.<br/>Mohon lakukan perbaikan terhadap hal tersebut.<br/>Apabila sudah, silakan tekan tombol <u>RELOAD</u> di bawah ini.';
			
			setTimeout(function(){
				if(b!==0){
						document.getElementById(b.id).innerHTML = btnLbl;
					}
				if(a===1000){
						document.getElementById(b.id).innerHTML = btnLbl;
						questionList.removeAttribute("style");
						b.removeAttribute("style");
				}
				
				btnDis(b.id,0);
				document.getElementById(b.id).click();
			},3000);
			
		};
	}else{
		if(a!==999){
			loadQuestion(a,b);
		}
		if(b.id==="termbtn"){
			document.getElementById("terminatetest").click();
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

let xLi;
let qlistLen = qlistArr.length;
function markLiSelected(){
	for (xLi=0; xLi < qlistLen; xLi++){
		qlistArr[xLi].className = "";
	}
	liIndex = noSoalLbl-1;
	qlistArr[liIndex].className += "terpilih";
	
	var qListBtn = qlistArr[liIndex].firstChild;	
	var clBtn = qListBtn.classList.contains("q_displayed");
		
	if(!clBtn){
		qListBtn.className += " q_displayed";
	}
	backdrop("-1","0");
}

function markLiAnswered(a,b){
	prevIndex = a-1;
	var qListBtn = qlistArr[prevIndex].firstChild;	
	var clBtnAns = qListBtn.classList.contains("q_answered");	
	var clBtnNAns = qListBtn.classList.contains("q_notanswered");
	if(clBtnNAns){
		qListBtn.classList.replace("q_notanswered","q_answered");
	}
	if(clBtnAns && b==="0"){
		qListBtn.classList.replace("q_answered","q_notanswered");
	}
}

function pageOffline(){
	console.log("page offline");
}

function getTidArr(){
	var tidArr = [];
	let i;
	for(i=0; i<qlistArr.length; i++){
		tidArr[i] = qlistArr[noSoalIndex+i].firstChild.id;
	}
	return tidArr;
}

// Try to get data from the cache, but fall back to fetching it live.
async function getData(tid,bid) {
   const cacheVersion = 1;
   const cacheName    = 'qBlockCache';
   const url          = "../../qblock/"+tid+".json"
   
   var zhttp = new XMLHttpRequest();
	zhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 404){
			caches.open('qBlockCache').then(cache => {
				cache.delete(url);
			});
			localStorage.removeItem("json_"+tid);
			if(bid===undefined){
				var h = document.getElementById("question-area");
				h.insertAdjacentHTML("afterbegin", "<p class='p-1em' style='border-radius:5px;text-align:justify;color:var(--col-7);background:var(--col-10)'>Soal pada halaman ini telah direvisi. Apabila semua berjalan normal, maka sebentar lagi halaman soal akan berganti ke soal baru. Namun, apabila halaman tidak menampilkan soal apapun dan pesan ini tidak menghilang silakan tekan link reload di bawah ini.<br/><br/><a class='brad100 box-bd-2 bd-gray5' style='color:var(--col-7)' onclick='location.reload()'><span class='icon-spinner11'></span>&nbsp;RELOAD</a></p>");
				
				setTimeout(function(){saveAnswerAjax(0,document.getElementById("relbtn"))},3000);
			}
			else{
				console.log("LLL");
				document.getElementById(tid).click();
			}
		}
	};
			
	zhttp.open("HEAD", url, true);
	zhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	zhttp.send();
		
		
   let cachedData     = await getCachedData( cacheName, url );

   if ( cachedData ) {
      return cachedData;
   }

   // console.log( 'Fetching fresh data' );

   const cacheStorage = await caches.open( cacheName );
   await cacheStorage.add( url );
   cachedData = await getCachedData( cacheName, url );
   await deleteOldCaches( cacheName );

   return cachedData;
}

// Get data from the cache.
async function getCachedData( cacheName, url ) {
	const options = {
	  ignoreSearch: true,
	  ignoreMethod: true,
	  ignoreVary: true
	};

   const cacheStorage   = await caches.open( cacheName );
   const cachedResponse = await cacheStorage.match( url, options );

   if ( ! cachedResponse || ! cachedResponse.ok ) {
      return false;
   }
   return await cachedResponse.json();
}

// Delete any old caches to respect user's disk space.
async function deleteOldCaches( currentCache ) {
   const keys = await caches.keys();

   for ( const key of keys ) {
      const isOurCache = 'myapp-' === key.substr( 0, 6 );

      if ( currentCache === key || ! isOurCache ) {
         continue;
      }

      caches.delete( key );
   }
}

function testJSON(text){
    if (typeof text!=="string"){
        return false;
    }
    try{
        JSON.parse(text);
        return true;
    }
    catch (error){
        return false;
    }
}

function qBlockRender(a,b,c,d,e,f,g,h){
	if(document.getElementById("offline-msg")){
		document.getElementById("backdrop").removeChild(document.getElementById("offline-msg"));
	}
	if(b.value>1){
		document.getElementById('question-list').scrollTop = document.getElementById(b.id).offsetTop-250;
	}	
	var loadtime=new Date();
    document.getElementById('display_time').value=loadtime.getTime();
	reloadCont.style.display = "none";

	if(b!==0){
		document.getElementById(b.id).innerHTML = d;
	}
	if(a===1000){
		document.getElementById(b.id).innerHTML = d;
		e.removeAttribute("style");
		b.removeAttribute("style");
		btnDis(b.id,0);
	}
	if(c.length>0){
		if(QBLOCK_JSON){
			if(testJSON(c)){
				if(g!=="cached"){
					var questionBlockData = JSON.parse(c);
					document.getElementById("question-area").innerHTML = questionBlockData.content+"<input type='hidden' name='qtype' id='qtype' value='"+questionBlockData.qtype+"' />";						
				}else{
					document.getElementById("question-area").innerHTML = c+"<input type='hidden' name='qtype' id='qtype' value='"+h+"' />";
				}
			}else{
				document.getElementById("question-area").innerHTML = "Oops! Sepertinya ada masalah pada halaman ini. Kemungkinan disebabkan karena:<ol><li>Waktu mengerjakan telah selesai, namun halaman tidak teralihkan ke beranda dengan benar,</li><li>Terjadi perubahan soal pada server,</li><li>Konfigurasi server yang berhubungan dengan <i>URL Rewriting</i> tidak bekerja dengan baik.</li></ol>Silakan mencoba untuk me-reload halaman dengan cara <a href='#' onclick='location.reload()'><u>klik disini</u></a>";
			}
		}else{
			document.getElementById("question-area").innerHTML = c+"<input type='hidden' name='qtype' id='qtype' value='"+h+"' />";
		}
	}else{
		document.getElementById("question-area").innerHTML = "Data ujian tidak ditemukan, <a href='index.php'><u>Silakan klik disini untuk kembali ke Beranda</u> atau reload halaman ini melalui <a onclick='location.reload()'>klik disini</a>";
	}
					
	if(a!==1000){
		dynNoSoal(a);
	}else{
		dynNoSoal(a,b);
		qlistHide();
	}
	btnVis(firstQuestion,testLogId,prevBtn);btnVis(lastQuestion,testLogId,nextBtn);
	btnDis("relbtn",0);btnDis("prevbtn",0);btnDis("nextbtn",0);btnDis("savebtn",0);
	
	var hiddenAnswerText = document.getElementById("hiddenAnswerText");
	if(hiddenAnswerText){
		hiddenAnswerText = hiddenAnswerText.innerHTML;
	}

	var answertext = document.getElementById("answertext");
	if(answertext){answertext.value = hiddenAnswerText}
	
	//unsure
	var unsureBtnCont = document.getElementById("unsureCbCont");
	var cbUnsure = document.getElementById("cbUnsure");
	unsureBtnCont.innerHTML = '<input type="checkbox" id="cbUnsure" style="display:none" onchange="markUnsure(this)" />';
	window.noSoalIndex = noSoalLbl-1;
	unsureToggler(noSoalIndex);

	if(window.jQuery && $("#answertext").wysibb()){$("#answertext").wysibb();$("#btn_uploadFileCont").show()}else{console.log("no bb editor")}
	if(!localStorage.getItem("json_"+f) && QBLOCK_JSON===true){
		localStorage.setItem("json_"+f,"1");
	}
	if(QBLOCK_JSON===true){restoreAnsMark()};

	var testuser_id = document.getElementById("testuser_id").value;
	if(!localStorage.getItem(testuser_id+'_testlogid') && QBLOCK_JSON){
		localStorage.setItem(testuser_id+'_testlogid',JSON.stringify(getAllTestLogID()));
	}

	if(K_SHOW_TERMINATE_WHEN_ALL_ANSWERED){
		if(document.querySelectorAll(".q_answered").length===getAllTestLogID().length || document.getElementById("last_question").value===testlogid.value){
			document.getElementById("termbtn").style.display = "block";
		}else{
			document.getElementById("termbtn").style.display = "none";
		}
	}
	
	document.body.removeAttribute("style");
	window.scrollTo(0,0);
	
	if(document.getElementById("tmfmatchsub")){
		document.getElementById("tmfmatchsub").style.display = 'none';
		subselopt();
	}
}

function restoreAnsMark(){
	var lsAnswDatas = localStorage.getItem("answdatas");
	
	if(lsAnswDatas){
		if(JSON.parse(lsAnswDatas)[noSoalIndex]){
			var tidMatch = false;
			if (testlogid.value===JSON.parse(lsAnswDatas)[noSoalIndex][0]){
				var tidMatch = true;
			}
			var lsQType = JSON.parse(lsAnswDatas)[noSoalIndex][1];
			var ansData = JSON.parse(lsAnswDatas)[noSoalIndex][2];
		}else{
			var lsQType = "0";
			var ansData = "0";
			var tidMatch = false;
		}
		
		if(lsQType==="1" && tidMatch===true){
				document.getElementById("answpos_"+ansData).setAttribute("checked","checked");
		}
		
		if(ansData && lsQType==="2" && tidMatch===true){
			for(var i = 0; i < ansData.length; i++){
				document.getElementById("answpos_"+ansData[i]).setAttribute("checked","checked");
			}
		}
		
		if(lsQType==="3" && tidMatch===true){
				if(document.querySelector(".wysibb-body")){
					document.querySelector(".wysibb-body").textContent = ansData;
				}else{
					document.getElementById("answertext").value = ansData;
				}
				
			// }
		}
		
		if(lsQType==="4" && tidMatch===true){
			for(var i = 0; i < ansData.length; i++){
				var x = i+1;
				document.getElementById("answpos_"+x).options.selectedIndex = ansData[i];
			}
		}
	}
	
}

function checkFormState(){
	if(QBLOCK_JSON){
		var lsAnswDatas = localStorage.getItem("answdatas");
		if(lsAnswDatas){
			if(JSON.parse(lsAnswDatas)[noSoalIndex]){
				var tidMatch = false;
				if (testlogid.value===JSON.parse(lsAnswDatas)[noSoalIndex][0]){
					var tidMatch = true;
				}
				if(tidMatch === true){
					var lsQType = JSON.parse(lsAnswDatas)[noSoalIndex][1];
					var ansData = JSON.parse(lsAnswDatas)[noSoalIndex][2];
				}else{
					return DetectChanges("testform");
				}				
			}else{
				var tidMatch = false;
				var lsQType = "0";
				var ansData = "0";
				return DetectChanges("testform");
			}
			
			if(lsQType==="1" && tidMatch===true){
				var curState = document.querySelectorAll(".rowl .answer input");
				for(var i=0; i<curState.length; i++){
					if(curState[i].checked){
						if(ansData===curState[i].id.replace(/\D/g,'') && document.forms.testform.cbUnsure.defaultChecked===document.forms.testform.cbUnsure.checked){
							return 0;
						}else{
							return 1;
						}
					}
				}
			}
			if(lsQType==="2" && tidMatch===true){
				var curState = document.querySelectorAll(".rowl .answer input");
				var curStateArr = [];
				for(var i=0; i<curState.length; i++){
					if(curState[i].checked){
							curStateArr.push(i+1);
					}
				}

				if(ansData && ansData.toString()===curStateArr.toString() && document.forms.testform.cbUnsure.defaultChecked===document.forms.testform.cbUnsure.checked){
					return 0;
				}else{
					if(ansData===undefined){
						var ansData=0;
					}				
					if(ansData===curStateArr.length && document.forms.testform.cbUnsure.defaultChecked===document.forms.testform.cbUnsure.checked){
						return 0;
					}else{
						return 1;
					}
				}
			}
			
			if(lsQType==="3" && tidMatch===true){
				var curState = document.getElementById("answertext").value;
				if(curState===ansData && document.forms.testform.cbUnsure.defaultChecked===document.forms.testform.cbUnsure.checked){
					return 0;
				}else{
					return 1;
				}
			}
			
			if(lsQType==="4" && tidMatch===true){				
				var curState = document.querySelectorAll(".rowl .answer select");
				var curStateArr = [];
				for(var i=0; i<curState.length; i++){
					curStateArr.push(curState[i].value);
				}
				if(ansData.toString()===curStateArr.toString() && document.forms.testform.cbUnsure.defaultChecked===document.forms.testform.cbUnsure.checked){
					return 0;
				}else{
					return 1;
				}
			}		
		}	
	}else{
		return DetectChanges("testform");
	}
}

function touchWaitTestLogID(a,c){
	var b = getAllTestLogID()[c];
	let testid = document.getElementById("testid").value;
	let testuser_id = document.getElementById("testuser_id").value;
	let examtime = document.getElementById("examtime").value;
	let prevquestionid;
	let nextquestionid;
	let autonext;
	let finish = document.getElementById("finish").value;
	let display_time = document.getElementById("display_time").value;
	let reaction_time = document.getElementById("reaction_time").value;
	let csrf_token = document.getElementById("csrf_token").value;
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 404){
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					localStorage.setItem("json_"+b,"1");
					caches.open('qBlockCache').then(cache => {
						cache.add('../../qblock/'+b+'.json');
					});
				}
			}
			
			xhttp.open("POST", "tce_test_execute.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("question-block&testid="+testid+"&testlogid="+b+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
		}
		
		if(this.readyState == 4 && this.status == 200){
			if(!localStorage.getItem("json_"+b)){
				localStorage.setItem("json_"+b,"1");
				caches.open('qBlockCache').then(cache => {
					cache.add('../../qblock/'+b+'.json');
				});
			}
		}
	};
	xhttp.onloadend = function(){
		if(c===getAllTestLogID().length-1){
			console.log("stop");
		}else{
			// console.log("yoo");
			if(!localStorage.getItem('json_'+getAllTestLogID()[c+1])){
				setTimeout(function(){touchWaitTestLogID(1000,c+1)},300);
			}
		}
	}
	if(b){
		xhttp.open("HEAD", "../../qblock/"+b+".json", true);
		xhttp.send();
	}
	
}

function touchOneTestLogIDLoop(){
	for (let i=1; i <= getAllTestLogID().length-1; i++) { 
	   task(i);	   
	} 
	  
	function task(i) { 
	  setTimeout(function() { 
		  touchOneTestLogID(500,getAllTestLogID()[i]);
	  }, 500 * i); 
	}
}

function touchOneTestLogID(a,b){
	let testid = document.getElementById("testid").value;
	let testuser_id = document.getElementById("testuser_id").value;
	let examtime = document.getElementById("examtime").value;
	let prevquestionid;
	let nextquestionid;
	let autonext;
	let finish = document.getElementById("finish").value;
	let display_time = document.getElementById("display_time").value;
	let reaction_time = document.getElementById("reaction_time").value;
	let csrf_token = document.getElementById("csrf_token").value;
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 404){
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					localStorage.setItem("json_"+b,"1");
					caches.open('qBlockCache').then(cache => {
						cache.add('../../qblock/'+b+'.json');
					});
				}
			}
			
			xhttp.open("POST", "tce_test_execute.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("question-block&testid="+testid+"&testlogid="+b+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
		}
		
		if(this.readyState == 4 && this.status == 200){
			if(!localStorage.getItem("json_"+b)){
				localStorage.setItem("json_"+b,"1");
				caches.open('qBlockCache').then(cache => {
					cache.add('../../qblock/'+b+'.json');
				});
			}
		}
	};
	xhttp.onloadend = console.log("okey");
	xhttp.open("HEAD", "../../qblock/"+b+".json", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function touchAllTestLogID(a){
	let testid = document.getElementById("testid").value;
	let testuser_id = document.getElementById("testuser_id").value;
	let examtime = document.getElementById("examtime").value;
	let prevquestionid;
	let nextquestionid;
	let autonext;
	let finish = document.getElementById("finish").value;
	let display_time = document.getElementById("display_time").value;
	let reaction_time = document.getElementById("reaction_time").value;
	let csrf_token = document.getElementById("csrf_token").value;
	let elLi = document.querySelectorAll("ol.qlist li");
	const matchoptions = {
	  ignoreSearch: true,
	  ignoreMethod: true,
	  ignoreVary: true
	};
	for(let i=0; i < elLi.length; i++){
		let testlogid = document.querySelectorAll("ol.qlist li")[i].firstChild.id;
		
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404){
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						localStorage.setItem("json_"+testlogid,"1");
						caches.open('qBlockCache').then(cache => {
							cache.add('../../qblock/'+testlogid+'.json');
						});
					}
				}
				
				xhttp.open("POST", "tce_test_execute.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("question-block&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
			}
			
			if(this.readyState == 4 && this.status == 200){
				if(!localStorage.getItem("json_"+testlogid)){
					localStorage.setItem("json_"+testlogid,"1");
					caches.open('qBlockCache').then(cache => {
						cache.add('../../qblock/'+testlogid+'.json');
					});
				}
								
			}
		};
		xhttp.open("HEAD", "../../qblock/"+testlogid+".json", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();
	}
}

function loadQuestion(a,b){
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
	var questionList = document.getElementById("question-list");
	var btnLbl = b.innerHTML;
	
	localStorage.setItem("answer_change","0");
	var testid = document.getElementById("testid").value;
	if(a!==1000){
		var targetIndex = qlistArr[noSoalLbl-1+a];
		if(targetIndex){
			document.getElementById("testlogid").value = targetIndex.firstChild.id;
		}
	}else{
		document.getElementById("testlogid").value = b.id;
	}
		
	var testlogid = document.getElementById("testlogid").value;
	
	if(localStorage.getItem("json_"+testlogid) && window.location.protocol==="https:" && localStorage.getItem("cacheEnable")==="1" && QBLOCK_JSON===true){
		try {
		   const data = getData(testlogid,b.id);
			{ 
				data.then(function(value){
					qBlockRender(a,b,value.content,btnLbl,questionList,testlogid,"cached",value.qtype);					
				}) 
		   };
		} catch ( error ) {
		   console.error({error});
		}
	}else{
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404 && QBLOCK_JSON===true){
				xhttp.open("POST", "tce_test_execute.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("question-block&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
			}
			if (this.readyState == 1){
				if(b!==0){
					// alert("aaa");
					document.getElementById(b.id).innerHTML = "<div class='anim-rotate'><span class='icon-spinner11'></span></div>";
					btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
				}
				if(a==1000){
					// alert("bbb");
					document.getElementById(b.id).innerHTML = "<div class='anim-rotate'><span class='icon-spinner11'></span></div>";
					b.style.setProperty("color","currentColor");
					// questionList.style.pointerEvents = "none";
					document.body.style.pointerEvents = "none";
					btnDis(b.id,1);btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
					reloadCont.style.display = "block";
					backdrop("100","1");
				}else{
					// alert("cccc");
					reloadCont.style.display = "block";
					backdrop("1","1");
				}
				// alert("ddd");
			}
			if (this.readyState == 4 && this.status == 200){
				qBlockRender(a,b,this.responseText,btnLbl,questionList,testlogid,"fresh","0");
			}
		};
		
		xhttp.timeout = 10000;
		xhttp.ontimeout = function (e) {
			
			if(b!==0){
					document.getElementById(b.id).innerHTML = btnLbl;
				}
			if(a===1000){
					document.getElementById(b.id).innerHTML = btnLbl;
					questionList.removeAttribute("style");
					b.removeAttribute("style");
			}
			
			btnDis(b.id,0);
			document.getElementById(b.id).click();
			
		};
		
		xhttp.onerror = function(e){
			reloadCont.style.display = "block";
			backdrop("100","1");
			if(!document.getElementById("offline-msg")){
				reloadCont.insertAdjacentHTML("beforebegin", "<h5 id='offline-msg' class='p-1em' style='border-radius:5px;margin:0.5em;text-align:justify;color:#fff;background:rgba(255,0,0,0.5);border: 3px solid #8c1212;'></h5>");
			}
			document.getElementById("offline-msg").innerHTML = 'Offline! Perangkat Anda tidak terhubung ke jaringan.<br/>Mohon lakukan perbaikan terhadap hal tersebut.<br/>Apabila sudah, silakan tekan tombol <u>RELOAD</u> di bawah ini.';
			
			setTimeout(function(){
				if(b!==0){
						document.getElementById(b.id).innerHTML = btnLbl;
					}
				if(a===1000){
						document.getElementById(b.id).innerHTML = btnLbl;
						questionList.removeAttribute("style");
						b.removeAttribute("style");
				}
				
				btnDis(b.id,0);
				document.getElementById(b.id).click();
			},3000);
		};
		
		if(QBLOCK_JSON===true){		
		  xhttp.open("GET", "../../qblock/"+testlogid+".json", true);
		  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  xhttp.send();
		}else{
			xhttp.open("POST", "tce_test_execute.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("question-block&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
		}
	}
}

function loadDataFromServer(a){
	if(a===1){
		var lsItem = "answdatas";
		var reqFile = "answdata";
	}else{
		var lsItem = "unsure";
		var reqFile = "unsure";
	}
	var testuser_id = document.getElementById("testuser_id").value;
	var lhttp = new XMLHttpRequest();
	lhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404){
				console.log("fresh question / never answered");
			}
			if (this.readyState == 4 && this.status == 200){
				// store answdata to localStorage
				localStorage.setItem(lsItem,this.responseText);
			}
		};
		
	lhttp.open("GET", "../../answdata/"+testuser_id+"_"+reqFile+".txt?"+Math.floor(Math.random() * 100000) + 1, true);
	lhttp.send();
}

function clearStorage(){
	// clearUnsure();
	caches.delete("qBlockCache");
	localStorage.clear();
}

if(fTestForm){
	if(QBLOCK_JSON===true){
		loadDataFromServer(1);
	}
	loadDataFromServer(2);
	loadQuestion(0,0);
	if(!localStorage.getItem('unsure')){
		localStorage.setItem('unsure','[]');
	}
	for(let i=0; i<getAllTestLogID().length;i++){
		if(!localStorage.getItem('json_'+getAllTestLogID()[i])){
			var startNum = i;
			break;		
		}
	}

	if(LOAD_ALL_JSON){
		touchWaitTestLogID(1000,startNum);
	}
}

// Change style of top container on scroll
window.onscroll = function(){if(fTestForm){qInfoBar()}};
function qInfoBar() {
	infolinkCont.style.position = "absolute";
  if (document.body.scrollTop > 47 || document.documentElement.scrollTop > 47) {
    utilTop.className = "d-flex utilTopTest jc-sb fwrap scrolledFloat";
    document.getElementById("question-area").style.paddingTop = "6.5em";
	infolinkCont.style.position = "fixed";
  } else {
    utilTop.className = "d-flex utilTopTest jc-sb fwrap";
    document.getElementById("question-area").style.paddingTop = "1em";	
  }
}

/* Get the documentElement (<html>) to display the page in fullscreen */
var elem = document.documentElement;

/* View in fullscreen */
function openFullScr() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
	document.getElementById("resScBtn").removeAttribute("style");
	document.getElementById("fullScBtn").setAttribute("style","display:none")
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
	document.getElementById("resScBtn").removeAttribute("style");
	document.getElementById("fullScBtn").setAttribute("style","display:none")
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
	document.getElementById("resScBtn").removeAttribute("style");
	document.getElementById("fullScBtn").setAttribute("style","display:none")
  }
}

/* Close fullscreen */
function closeFullScr() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
	document.getElementById("fullScBtn").removeAttribute("style");
	document.getElementById("resScBtn").setAttribute("style","display:none")
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
	document.getElementById("fullScBtn").removeAttribute("style");
	document.getElementById("resScBtn").setAttribute("style","display:none")
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
	document.getElementById("fullScBtn").removeAttribute("style");
	document.getElementById("resScBtn").setAttribute("style","display:none")
  }
}

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
				b.style.left = "10px";
				b.style.transition = "all 0.15s ease-in-out";
			}
		})
	}
}

if(!localStorage.getItem("cacheEnable") && QBLOCK_JSON===true && CACHE_FEATURE===true){
	localStorage.setItem("cacheEnable",1);
}else{
	if(localStorage.getItem("cacheEnable")==="1"){
		if(document.getElementById("cacheBtn")){
			document.getElementById("cacheBtn").setAttribute("style","background:var(--col-3);color:var(--col-7)")
		}
	}
	if(QBLOCK_JSON===false || CACHE_FEATURE===false){
		localStorage.removeItem("cacheEnable");
	}
}



function cacheToggle(){
	if(localStorage.getItem("cacheEnable")==="1"){
		if(confirm("Apakah Anda yakin ingin mematikan Fitur Cache?")){
			if(confirm("Lanjutkan?")){
				document.getElementById("cacheBtn").removeAttribute("style");
				localStorage.setItem("cacheEnable",0);
				caches.delete("qBlockCache");
			}
		}
	}else{
		document.getElementById("cacheBtn").setAttribute("style","background:var(--col-3);color:var(--col-7)")
		localStorage.setItem("cacheEnable",1);
	}
}

function subselopt(){
	let i;
	let a;
	let tms = document.querySelectorAll("#tmfmatchsub ol li");
	let tmsarr = [];
	let selopt = [];
	for(i=0; i<tms.length; i++){
		tmsarr[i] = tms[i].textContent;
		a = i+1;
		selopt[i] = document.querySelectorAll("ol.answer li select option[value='"+a+"']");
	}

	let b;
	for(b=0; b<selopt.length; b++){
		let c;
		for(c=0; c<selopt.length; c++){
			selopt[b][c].textContent = tmsarr[b]
		}
	}
}

floatingLabel(usernameField,usernameLbl);
floatingLabel(passwordField,passwordLbl);

function drawerClose(){menuClose();qlistHide();langSelHide();userInfoHide();commentHide()}