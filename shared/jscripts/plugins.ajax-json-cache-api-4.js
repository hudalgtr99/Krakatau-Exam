function backdrop(bd,dis){
	var bdDiv = document.querySelector(".backdrop");
	if(bd==="1" || bd==="100"){bdDiv.style.display = "block"}else{bdDiv.style.display = "none"}
	if(dis==="1"){bdDiv.style.pointerEvents = "none"}else{bdDiv.style.pointerEvents = "all"}
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
function menuOpen(){scrolLayer.setAttribute("class","slide-in-header");backdrop("1")}
function menuClose(){var slideInHeader = document.querySelector(".slide-in-header");if(slideInHeader){scrolLayer.setAttribute("class","slide-out-header");backdrop("-1")}}

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
	// alert(a);
	if(infolinkCont.style.display==="block"){
		infolinkCont.removeAttribute("style");
		iconsettings.removeAttribute("style");
		// scrollTo(0,0);
	}else{
		iconsettings.style.color = "var(--col-3)";
		iconsettings.style.background = "var(--col-12)";
		infolinkCont.style.display = "block";
		/* infolinkCont.style.top = a.offsetTop+30+"px";
		infolinkCont.style.left = a.offsetLeft+20+"px"; */
		// scrollTo(0,0);
		/* var btnClose = document.createElement("DIV");
		btnClose.innerHTML = "&times;";
		btnClose.className = "close-btn";
		btnClose.setAttribute("onclick","this.parentNode.removeAttribute('style')"); */
		infolinkCont.style.opacity = "0.95";
		infolinkCont.style.zIndex = "1";
		infolinkCont.style.transition = "opacity 0.2s ease-in-out 0s";
		// infolinkCont.appendChild(btnClose);
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
if(!fTestForm){document.getElementById("utilTop").style.display = "none"}
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
		for(var i = 0; i < unsure.length;){
			if(unsure[i] === index){
				unsure.splice(i, 1);
			}else{
				i++;
			}
		}
		localStorage.setItem('unsure', JSON.stringify(unsure));
	}
}

function setUnsureLiBg(a){
	document.querySelectorAll("ol.qlist li")[a].firstElementChild.style.setProperty("background-image","linear-gradient(45deg, transparent 2.5em, #ffcc00 2.5em)","important");
}
function resetUnsureLiBg(a){
	document.querySelectorAll("ol.qlist li")[a].firstElementChild.removeAttribute("style");
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
var utilTop = document.getElementById("utilTop");
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
var hidePass = document.getElementById("hidePass");
var xuser_password = document.getElementById("xuser_password");
if(showPass){
	showPass.addEventListener("click", function() {
		showPass.style.display = "none";	
		hidePass.style.display = "block";
		xuser_password.setAttribute("type","text");		
	})
}
if(hidePass){
	hidePass.addEventListener("click", function() {
		showPass.style.display = "block";	
		hidePass.style.display = "none";
		xuser_password.setAttribute("type","password");		
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
	// alert(n);
	for (var e = 0, el = form.elements.length; e < el; e++) {
		n = form.elements[e];
		// alert(n);
		c = false;
		// alert(n.id);
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
						// console.log(n.id);
						// console.log(c);
						// console.log(n.checked+" _ "+n.defaultChecked);
						// console.log(n.defaultChecked);
						break;
					default:
						// standard values
						c = (n.value != n.defaultValue);
						// console.log(c);
						break;				
				}
				break;
		}
		// console.log(Array.isArray(changed));
		if (c) changed.push(n);
	}
	// alert(n);
	// localStorage.setItem("answer_change","1");
	// localStorage.setItem("answ_changed_from_script","0");
	return changed;
}
// show changed messages
function DetectChanges(formId) {
	var f = FormChanges(formId)
	return(f.length);
}

//load js if question type 3 (free text answer)
// var qtype3 = document.getElementById("question-type-3");
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
	/* else{
		$("#btn_uploadFileCont").show();
		alert("zzz");
		$("#answertext").wysibb();
	} */
}

// var fTestForm = document.getElementById("testform");
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
			c.style.display = "none";
			//alert(lastQuestion.value);
			//alert(b.value);
			//c.setAttribute("onclick","saveAnswerAjax(0,this)");
			// c.id = "nextbtn-disabled";
		}else{
			c.removeAttribute("style");
		}
		if(lastQuestion.value===b.value){
			nextBtn.setAttribute("onclick","saveAnswerAjax(0,this)")
		}else{
			nextBtn.setAttribute("onclick","saveAnswerAjax(1,this)")
			// nextBtn.setAttribute("onclick","if(navigator.onLine){saveAnswerAjax(1,this)}else{pageOffline()}")
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
		let closeBtn = document.getElementById("close_btn");
		if(closeBtn){
			closeBtn.click();
		}
		var loginStatus = JSON.parse(this.responseText);
		/* if(loginStatus.type==="0"){var status=loginStatus.desc;var mdlType="warning"}
		if(loginStatus.type==="1"){var status="Password salah";var type="warning"}
		if(loginStatus.type==="10"){var status="Login berhasil";var type="message";location.reload()} */
      document.body.insertAdjacentHTML("afterbegin", "<div class='"+loginStatus[0]+"'><span>"+loginStatus[1]+"</span><span onclick='this.parentNode.style.display = \"none\"' id='close_btn'>×</span></div>");
	  if(loginStatus[0]==="message"){
		  location.reload()
	  }
	  // var res[0] = this.responseText[0];
	  
	  
	  // resArray.push(this.responseText);
	  // console.log(resArray);
      // document.body.insertAdjacentHTML("afterbegin", resArray[0]+"-"+resArray[1]+"-"+resArray[2]);
    }
  };
  xhttp.open("POST", "index.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("logaction=login&xuser_name="+usernameField.value+"&xuser_password="+passwordField.value);
}	

function saveAnswerAjax(a,b){
	// alert(b.id);
	// checkQuestionUpdate(b.id);
	// alert(document.getElementById("testlogid").value);
	// checkQuestionUpdate(f);
	// console.log(checkFormState());
	if(document.getElementById("close_btn_offline")){document.getElementById("page-offline").remove()}
	// alert(noSoalLbl);
	// var prevTestLogID = document.querySelectorAll("ol.qlist li")[noSoalLbl].firstChild.id-1;
	var prevTestLogID = document.querySelectorAll("ol.qlist li")[noSoalLbl-1].firstChild.id;
	// alert(prevTestLogID);
	var answertext = document.querySelector(".wysibb-texarea");
	if(answertext){$("#answertext").sync()}
	
	var form = document.getElementById('testform');
	var data = new FormData(form);
	data.append('question-block','1');
	data.append('save-answer','1');
	// data.append('ls-answdatas','xxx');
	// var formChanged = DetectChanges("testform");
	// var formChanged = DetectChanges("zzz");
	var formChanged = checkFormState();
	var btnLbl = b.innerHTML;
	// formChanged = 1;
	if(formChanged>0){
		// start - some array of selected / filled question and save to localStorage
		var testlogid = document.getElementById("testlogid").value;
		var qtype = document.getElementById("qtype").value;
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
			// if(fcTestF[i].checked && qtype==="1"){
			if(qtype==="1"){
				for(var i = 0; i < AllCbQType1.length; i++){
					if(AllCbQType1[i].checked){
						// qtype2data.push(AllCbQType2[i].id.replace(/\D/g,''));
						answdata[2] = AllCbQType1[i].id.replace(/\D/g,'');	
					}
				}
				// answdata[2] = fcTestF[i].id.replace(/\D/g,'');
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
		localStorage.setItem('answdatas', JSON.stringify(answdatas));
		//alert(localStorage.getItem('answdatas'));
		
		data.append('ls-answdatas',localStorage.getItem('answdatas'));
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
				if(a===1000){
					// document.getElementById(b.id).innerHTML = "<div class='anim-pulsate'><span class='icon-spinner11'></span></div>";
					document.getElementById(prevTestLogID).innerHTML = "<div class='anim-pulsate'><span class='icon-upload'></span></div>";
				}else{
					// document.getElementById(b.id).innerHTML = "<div class='anim-pulsate'>"+btnLbl+"</div>";
					document.getElementById(b.id).innerHTML = "<div class='anim-pulsate'><span class='icon-upload'></span></div>";
				}
			}
			if (this.readyState == 4 && this.status == 200){
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
			}
		};
		xhttp.open("POST", "tce_test_execute.php", true);
		xhttp.send(data);
		// console.log(
			// data.forEach(x=>console.log(x))
		// );
		
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

function pageOffline(){
	/* if(document.getElementById("close_btn_offline")){document.getElementById("page-offline").remove()}
	document.body.insertAdjacentHTML("afterbegin", "<div id='page-offline' class='error' style='z-index:100'><span>Can't continue. Offline? Please, check your network connection</span><span onclick='this.parentNode.style.display = &quot;none&quot;' id='close_btn_offline'>×</span></div>"); */
	console.log("page offline");
}

function getTidArr(){
	var tidArr = [];
	var qlistLi = document.querySelectorAll("ol.qlist li");
	for(var i=0; i<qlistLi.length; i++){
		tidArr[i] = document.querySelectorAll("ol.qlist li")[noSoalIndex+i].firstChild.id;
	}
	return tidArr;
}

// async function getCachedData(url) {
   // caches.open('qBlockCache').then(cache => {
	  // cache.match(url).then(res => {
		// res is the Response Object
		// console.log(res);
	  // })
	// })
// }

// getCachedData("../../"+document.getElementById("testlogid").value+".json")

/* async function q2Cache(url){
	if ('caches' in window) {
	  const qblockCache = await caches.open('qblockCache');
	  qblockCache.add(url);
	}
} */

// Try to get data from the cache, but fall back to fetching it live.
async function getData(tid,bid) {
   const cacheVersion = 1;
   const cacheName    = 'qBlockCache';
   const url          = "../../qblock/"+tid+".json"
   
   var zhttp = new XMLHttpRequest();
	zhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 404){
			renewQuestion(tid);
			document.getElementById("relbtn").click();
			/* if(bid===undefined){
				document.getElementById("relbtn").click();
			}
			else{
				document.getElementById("relbtn").click();
			} */
			// alert(tid);
			// alert("tekan clear");
		}
	};
			
	zhttp.open("HEAD", url, true);
	zhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	zhttp.send();
		
		
   let cachedData     = await getCachedData( cacheName, url );

   if ( cachedData ) {
      // console.log( 'Retrieved cached data' );
      return cachedData;
   }

   // console.log( 'Fetching fresh data' );

   const cacheStorage = await caches.open( cacheName );
   // console.log(await cacheStorage.add( url ));
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

function qBlockRender(a,b,c,d,e,f,g,h){
	// var f = document.getElementById("testlogid");
	// alert(b.id);
	reloadCont.style.display = "none";
	// var btnLbl = b.innerHTML;
	// alert(b.innerHTML)
	if(b!==0){
		document.getElementById(b.id).innerHTML = d;
	}
	if(a===1000){
		document.getElementById(b.id).innerHTML = d;
		e.removeAttribute("style");
		b.removeAttribute("style");
		btnDis(b.id,0);
	}
	// alert(c.length);
	// alert(g);
	if(c.length>0){
		// alert(c.content);
		if(g!=="cached"){
			var questionBlockData = JSON.parse(c);
			// alert(questionBlockData.content);
			document.getElementById("question-area").innerHTML = questionBlockData.content+"<input type='hidden' name='qtype' id='qtype' value='"+questionBlockData.qtype+"' />";	
			// document.getElementById("relbtn").click();
			// console.log(questionBlockData.qtype);
			
		}else{
			document.getElementById("question-area").innerHTML = c+"<input type='hidden' name='qtype' id='qtype' value='"+h+"' />";
			// document.getElementById("relbtn").click();
			// console.log(h);
		}
	}else{
		document.getElementById("question-area").innerHTML = "No Test Data Found, <a href='index.php'><u>click here to back home</u> or reload this page by clicking <a onclick='location.reload()'>here</a>";
	}
					
	if(a!==1000){
		dynNoSoal(a);
	}else{
		dynNoSoal(a,b);
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
	window.noSoalIndex = document.getElementById("nosoal").textContent.replace(/\D/g,'')-1;
	unsureToggler(noSoalIndex);
	// console.log(wysibb());
	if(window.jQuery && $("#answertext").wysibb()){$("#answertext").wysibb();$("#btn_uploadFileCont").show()}else{console.log("no bb editor")}
	if(!localStorage.getItem("json_"+f)){
		localStorage.setItem("json_"+f,"1");
	}
	restoreAnsMark();
	// checkQuestionUpdate(f);
}


/* function checkQuestionUpdate(tid){
	// alert(tid)
	if(localStorage.getItem("json_"+tid)){
		var yhttp = new XMLHttpRequest();
		yhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404){
				renewQuestion(tid);
			}
		};
				
		yhttp.open("HEAD", "../../qblock/"+tid+".json", true);
		yhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		yhttp.send();
	}
} */

function restoreAnsMark(){
	var lsAnswDatas = localStorage.getItem("answdatas");
	// var testlogid = document.getElementById("testlogid").value;
	// alert(typeof(testlogid.value));
	// alert(testlogid.value);
	
	if(lsAnswDatas){
		if(JSON.parse(lsAnswDatas)[noSoalIndex]){
			var tidMatch = false;
			// alert(typeof(JSON.parse(lsAnswDatas)[noSoalIndex][0]));
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
			// for(var i = 0; i < ansData.length; i++){
				// var x = i+1;
				document.getElementById("answpos_"+ansData).setAttribute("checked","checked");
				// alert("zzz");
			// }
		}
		
		if(lsQType==="2" && tidMatch===true){
			for(var i = 0; i < ansData.length; i++){
				// var x = i+1;
				// alert(JSON.parse(ansData));
				document.getElementById("answpos_"+ansData[i]).setAttribute("checked","checked");
			}
		}
		
		if(lsQType==="3" && tidMatch===true){
			// for(var i = 0; i < ansData.length; i++){
				// var x = i+1;
				// alert(ansData);
				if(document.querySelector(".wysibb-body")){
					// alert("zzz");
					document.querySelector(".wysibb-body").textContent = ansData;
					// $("#answertext").sync();
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
	// console.log(DetectChanges("testform"));
	
}
// document.querySelector(".testform_class").setAttribute("id","testform");

function checkFormState(){
	var lsAnswDatas = localStorage.getItem("answdatas");
	if(lsAnswDatas){
		if(JSON.parse(lsAnswDatas)[noSoalIndex]){
			var tidMatch = false;
			// alert(typeof(JSON.parse(lsAnswDatas)[noSoalIndex][0]));
			if (testlogid.value===JSON.parse(lsAnswDatas)[noSoalIndex][0]){
				var tidMatch = true;
			}
			if(tidMatch === true){
			// console.log(JSON.parse(lsAnswDatas)[noSoalIndex]);
				var lsQType = JSON.parse(lsAnswDatas)[noSoalIndex][1];
				var ansData = JSON.parse(lsAnswDatas)[noSoalIndex][2];
			}else{
				return DetectChanges("testform");
			}
			
			// console.log(ansData);
			
		}else{
			var tidMatch = false;
			var lsQType = "0";
			var ansData = "0";
			// console.log("undefined");
			return DetectChanges("testform");
		}
		
		if(lsQType==="1" && tidMatch===true){
			var curState = document.querySelectorAll(".rowl .answer input");
			for(var i=0; i<curState.length; i++){
				if(curState[i].checked){
					if(ansData===curState[i].id.replace(/\D/g,'')){
						return 0;
					}else{
						return 1;
					}
				}
			}
		}
		if(lsQType==="2" && tidMatch===true){
			// console.log(ansData.toString());
			var curState = document.querySelectorAll(".rowl .answer input");
			var curStateArr = [];
			for(var i=0; i<curState.length; i++){
				// console.log(curState[i]);
				if(curState[i].checked){
					// if(ansData===curState[i].id.replace(/\D/g,'')){
						// return 0;
						curStateArr.push(i+1);
					// }
					// res += i;
					// console.log(res);
				}
			}
			// console.log(curStateArr.toString());
			if(ansData.toString()===curStateArr.toString()){
				// console.log("sama")
				return 0;
			}else{
				// console.log("beda")
				return 1;
			}
		}
		
		if(lsQType==="3" && tidMatch===true){
			var curState = document.getElementById("answertext").value;
			if(curState===ansData){
				return 0;
			}else{
				return 1;
			}
			// console.log(curState);
			// console.log(ansData);
		}
		
		if(lsQType==="4" && tidMatch===true){
			// ansData.toString()
			
			var curState = document.querySelectorAll(".rowl .answer select");
			var curStateArr = [];
			for(var i=0; i<curState.length; i++){
				// console.log(curState[i].value);
				curStateArr.push(curState[i].value);
			}
			// console.log(curStateArr.toString());
			if(ansData.toString()===curStateArr.toString()){
				// console.log("sama")
				return 0;
			}else{
				// console.log("beda")
				return 1;
			}
		}
		
		
	}else{
		return DetectChanges("testform");
	}
}

function loadQuestion(a,b){
	// alert(b.id);
	var testlogid = document.getElementById("testlogid").value;
	//checkQuestionUpdate(testlogid);
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
		var targetIndex = document.querySelectorAll("ol.qlist li")[noSoalLbl-1+a];
		if(targetIndex){
			document.getElementById("testlogid").value = targetIndex.firstChild.id;
		}
	}else{
		document.getElementById("testlogid").value = b.id;
	}
		
	var testlogid = document.getElementById("testlogid").value;
	
	if(localStorage.getItem("json_"+testlogid) && window.location.protocol==="https:"){
	// checkQuestionUpdate(testlogid);
	// console.log("xxx");	
	// if(localStorage.getItem("json_"+testlogid)){
	// if(false){
		// alert("zzz");
		try {
		   // getData("../../qblock/"+testlogid+".json");
		   // getData yang atas awalnya dipakai
		   // const data = getData("../../qblock/"+testlogid+".json");
		   // const data = getData("../../qblock/"+testlogid+".json");
		   const data = getData(testlogid,b.id);
		   //console.log(data);
			{ 
				data.then(function(value){
					// console.log(value);
					// alert(value.content)
					// console.log(value.content);
					// console.log(value.content.length);
					// checkQuestionUpdate(testlogid);
					qBlockRender(a,b,value.content,btnLbl,questionList,testlogid,"cached",value.qtype);
					
				}) 
		   };
		} catch ( error ) {
		   console.error({error});
		   // checkQuestionUpdate(testlogid);
		}
	}else{
		// var testlogid = document.getElementById("testlogid").value;
		//alert(testlogid); 
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404){
				xhttp.open("POST", "tce_test_execute.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("question-block&testid="+testid+"&testlogid="+testlogid+"&testuser_id="+testuser_id+"&examtime="+examtime+"&prevquestionid="+prevquestionid+"&nextquestionid="+nextquestionid+"&autonext="+autonext+"&finish="+finish+"&display_time="+display_time+"&reaction_time="+reaction_time+"&csrf_token="+csrf_token);
			}
			if (this.readyState == 1){
				if(b!==0){
					document.getElementById(b.id).innerHTML = "<div class='anim-rotate'><span class='icon-spinner11'></span></div>";
					btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
				}
				if(a==1000){
					document.getElementById(b.id).innerHTML = "<div class='anim-rotate'><span class='icon-spinner11'></span></div>";
					b.style.setProperty("color","currentColor");
					questionList.style.pointerEvents = "none";
					btnDis(b.id,1);btnDis("relbtn",1);btnDis("prevbtn",1);btnDis("nextbtn",1);btnDis("savebtn",1);
					reloadCont.style.display = "block";
					backdrop("100","1");
				}else{
					reloadCont.style.display = "block";
					backdrop("1","1");
				}
			}
			if (this.readyState == 4 && this.status == 200){
				// alert(b.id)
				// alert(this.responseText);
				qBlockRender(a,b,this.responseText,btnLbl,questionList,testlogid,"fresh","0");
			}
		};
		
	  xhttp.open("GET", "../../qblock/"+testlogid+".json", true);
	  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhttp.send();
	}
}

function loadAnswData(){
	var testuser_id = document.getElementById("testuser_id").value;
	var lhttp = new XMLHttpRequest();
	lhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 404){
				console.log("fresh question / never answered");
			}
			if (this.readyState == 1){
				
			}
			if (this.readyState == 4 && this.status == 200){
				// store answdata to localStorage
				localStorage.setItem("answdatas",this.responseText)
			}
		};
		
	lhttp.open("GET", "../../answdata/"+testuser_id+"_answdata.txt?"+Math.floor(Math.random() * 100000) + 1, true);
	lhttp.send();
}

function renewQuestion(a){
	// var xhttp = new XMLHttpRequest();
	// xhttp.onreadystatechange = function(){
		// if (this.readyState == 4 && this.status == 200){
			// if(this.responseText==="1"){
				// caches.delete("qBlockCache");
				caches.open('qBlockCache').then(cache => {
					cache.delete('/tmfajax1-2/qblock/'+a+'.json');
				});
				localStorage.removeItem("json_"+a);
				// document.getElementById("relbtn").click();
			// }
		// }
	// };
	// xhttp.open("GET", "tmf_del_json.php?jsonid="+a, true);
	// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// xhttp.send();
}

function clearStorage(){
	// clearUnsure();
	caches.delete("qBlockCache");
	localStorage.clear();
}

if(fTestForm){
	//localStorage.clear();
	// if(!localStorage.getItem("unsure")){}
	loadAnswData();
	loadQuestion(0,0);
	if(!localStorage.getItem('unsure')){
		localStorage.setItem('unsure','[]');
	}
}

// Change style of top container on scroll
window.onscroll = function(){if(fTestForm){qInfoBar()}};
function qInfoBar() {
	// console.log(document.documentElement.scrollTop)
	infolinkCont.style.position = "absolute";
  if (document.body.scrollTop > 47 || document.documentElement.scrollTop > 47) {
    // document.getElementById("utilTop").setAttribute("style","position:fixed;z-index:1;top:0;left:0;right:0");
    document.getElementById("utilTop").className = "d-flex utilTopTest jc-sb fwrap scrolledFloat";
    document.getElementById("question-area").style.paddingTop = "3.5em";
	infolinkCont.style.position = "fixed";
  } else {
    // document.getElementById("utilTop").setAttribute("style","position:relative");
    document.getElementById("utilTop").className = "d-flex utilTopTest jc-sb fwrap";
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
				b.style.left = "8px";
				b.style.transition = "all 0.15s ease-in-out";
			}
		})
	}
}

floatingLabel(usernameField,usernameLbl);
floatingLabel(passwordField,passwordLbl);

function drawerClose(){menuClose();qlistHide();langSelHide();userInfoHide();commentHide()}