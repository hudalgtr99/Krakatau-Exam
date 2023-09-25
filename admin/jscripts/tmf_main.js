$("span#mmCloseBtn").click(function(){
	$("div#scrollayer").toggle();
});
$("a.white").parent().css({"visibility":"hidden","height":"0"});

$("span.active").parents().eq(1).show();

$("ul.menu li a").click(function(){
	$(this).next("ul").slideToggle();
	$("ul.menu li a").not(this).next("ul").slideUp();
});

$("div.pagehelp").prepend("<i class='fas fa-info info-icon'></i>");

// $('#user_groups,#form_testeditor #subject_id[multiple]').selectize({
	// plugins: ['remove_button']
// });


$("#showPass").click(function(){
	$(this).toggle();
	$("#hidePass").toggle();
	$("#xuser_password").attr("type","text");
});

$("#hidePass").click(function(){
	$(this).toggle();
	$("#showPass").toggle();
	$("#xuser_password").attr("type","password");
});

$(".warning").click(function(){$(this).hide()})
$(".error").click(function(){$(this).hide()})
$(".message").click(function(){$(this).hide()})

if(document.getElementById("test_id")){
	var f_testName = document.getElementById("test_id")[document.getElementById("test_id").selectedIndex].textContent;
	if(f_testName.length<4){
		f_testName = 'All Test';
	}
}

var f_groupLbl = document.querySelector("label[for=group_id]").textContent;
var f_userLbl = document.querySelector("label[for=user_id]").textContent;

var f_userName = '';
if(document.getElementById("user_id")){
	f_userName = document.getElementById("user_id")[document.getElementById("user_id").selectedIndex].textContent;
}
if(f_userName.length<4){
	f_userName = 'All Users';
}

var f_groupName = '';
if(document.getElementById("group_id")){
	f_groupName = document.getElementById("group_id")[document.getElementById("group_id").selectedIndex].textContent;
}

if(f_groupName.length<4){
	f_groupName = 'All Groups';
}

var f_insName = document.getElementById("insName").textContent;
var f_pageName = document.querySelector(".page-title-heading div:last-child").textContent;
var addr1 = K_ADDRESS_LINE1.replace(/ /g, '%20');
var addr2 = K_ADDRESS_LINE2.replace(/ /g, '%20');
var addr3 = K_ADDRESS_LINE3.replace(/ /g, '%20');

function exportTableToExcel(tableID){
	var f_groupLbl = document.querySelector("label[for=group_id]").textContent;
	if(document.querySelector("label[for=user_id]")==null){
		var f_userLbl = '';
	}else{
		var f_userLbl = document.querySelector("label[for=user_id]").textContent;
	}
	
	var f_userName = '';
	if(document.getElementById("user_id")){
		f_userName = document.getElementById("user_id")[document.getElementById("user_id").selectedIndex].textContent;
	}
	if(f_userName.length<4){
		f_userName = 'Semua Peserta';
	}

	var f_groupName = '';
	if(document.getElementById("group_id")){
		f_groupName = document.getElementById("group_id")[document.getElementById("group_id").selectedIndex].textContent;
	}

	if(f_groupName.length<4){
		f_groupName = 'Semua grup';
	}

	var f_insName = document.getElementById("insName").textContent;
	var f_pageName = document.querySelector(".page-title-heading div:last-child").textContent;
	var addr1 = K_ADDRESS_LINE1.replace(/ /g, '%20');
	var addr2 = K_ADDRESS_LINE2.replace(/ /g, '%20');
	var addr3 = K_ADDRESS_LINE3.replace(/ /g, '%20');

	setTimeout(function(){
		let eltd = document.querySelectorAll("#test_result_users td:first-child");
		let tdlength = eltd.length;

		for(let i = 0; i < tdlength; i++){
			eltd[i].firstChild.remove();
		}
	},1000)
	setTimeout(function(){
		var downloadLink;
		var dataType = 'application/vnd.ms-excel';
		var tableSelect = document.getElementById(tableID);
		var tableHTML = '<h4>'+f_insName.replace(/ /g, '%20')+'<br/>'+addr1+'<br/>'+addr2+'<br/>'+addr3+'</h4><h5>'+f_pageName.replace(/ /g, '%20')+'%20:%20'+f_testName.replace(/ /g, '%20')+'<br/>Grup%20:%20'+f_groupName.replace(/ /g, '%20')+'<br/>Peserta %20:%20'+f_userName.replace(/ /g, '%20')+'</h5>'+tableSelect.outerHTML.replace(/ /g, '%20').replace(/#/g, '%23').replace(/checkbox/g, 'hidden').replace(/href/g, 'href-data').replace(/table/g, 'table%20border=1');
		
		// Specify file name
		var filename = f_insName+' - '+f_pageName+' - '+f_testName+' - '+f_groupName;
		filename = filename?filename+'.xls':'excel_data.xls';
		
		// Create download link element
		downloadLink = document.createElement("a");
		
		document.body.appendChild(downloadLink);
		
		if(navigator.msSaveOrOpenBlob){
			var blob = new Blob(['\ufeff', tableHTML], {
				type: dataType
			});
			navigator.msSaveOrOpenBlob( blob, filename);
		}else{
			// Create a link to the file
			downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
		
			// Setting the file name
			downloadLink.download = filename;
			
			//triggering the function
			downloadLink.click();
			
			window.location.reload()
		}
	},1000)
	// setTimeout(function(){window.location.reload()},500)
}



function toggleIsRight(a,b,c){
	
$.ajax({
		'url': 'tmf_toggle_answer.php?answer_isright='+a+'&answer_question_id='+b+'&answer_id='+c,
		'type': 'GET',
		'success': function(result){
			if(result==="1"){
				if(a===0){
					alert("kunci jawaban berhasil dihapus");
				}else{
					alert("kunci jawaban berhasil ditambahkan");
				}
			}
			location.reload()
		}		
});


}

//eg: #form_resultallusers td input[type=checkbox]
function checkAll(a){
	var cbArr = document.querySelectorAll(a);
	for(let i=0; i < cbArr.length; i++){
		if(!cbArr[i].checked){
			cbArr[i].click()
		}
	}
}

function downloadAll(a){
	if(confirm("Timpa apabila telah ada lembar soal offline di cache/offline-sheets?")){
		var add = "&timpa=1";
	}else{
		var add = "";
	}
	
	var h = document.getElementById("footer");
	
	var cbArr = document.querySelectorAll(a);
	for(let i=0; i < cbArr.length; i++){
		h.insertAdjacentHTML('afterend', '<iframe id="dl-all'+i+'" style="width:0;height:0;border:none"></iframe>');
		document.getElementById('dl-all'+i).setAttribute('src', cbArr[i].href+add+"&ext=html");
	}
}

$(function() {
    window.ajax_loading = false;
    $.hasAjaxRunning = function() {
        return window.ajax_loading;
    };
    $(document).ajaxStart(function() {
        window.ajax_loading = true;
    });
    $(document).ajaxStop(function() {
        window.ajax_loading = false;
    });
});  

function generateAll(a,b,c){
	var refreshIntervalId = setInterval(function(){
		var ftype = "archive";
		if(b=="html"){
			ftype = "code";
		}
		var btnLbl = "<i class='fas fa-file-"+ftype+"'></i> Generate All Offline Sheets ("+b+")"; 
		if(window.ajax_loading===false){
			if(!lanjut){
				alert("Selesai melakukan Generate All Offline Sheet. Semua lembar soal offline dapat dilihat pada folder cache/offline-sheets dalam bentuk file "+b);
				clearInterval(refreshIntervalId);
				$("#"+c).html(btnLbl); 
			}
		}
	}, 3000);
	
	if(confirm("Timpa apabila telah ada lembar soal offline di cache/offline-sheets?")){
		var add = "&timpa=1";
	}else{
		var add = "";
	}
	
	if(b=="zip"){
		if(confirm("Proses ini juga akan menghapus file HTML yang ada di cache/offline-sheets. Lanjut?")){
			$("#"+c).text("Harap menunggu...");
			var cbArr = document.querySelectorAll(a);
			let i;
			for(i=0; i < cbArr.length; i++){
				$.ajax({
					'type': 'HEAD',
					'url': cbArr[i].href+add+'&ext='+b
				});
			}
		}else{
			var lanjut = true;
		}	
	}
	
	if(b=="html"){
		$("#"+c).text("Harap menunggu...");
		var cbArr = document.querySelectorAll(a);
		let i;
		for(i=0; i < cbArr.length; i++){
			$.ajax({
				'type': 'HEAD',
				'url': cbArr[i].href+add+'&ext='+b
			});
		}
	}
}

function setAwalTahun(){
	var tanggal = new Date();
	var newTanggal = tanggal.getFullYear()+'-01-01 00:00:00';
	document.getElementById('startdate').value = newTanggal;
}

var h = document.getElementById("startdate_date_trigger");
h.insertAdjacentHTML('afterend', '&nbsp;<button title="Ke awal waktu" onclick="event.preventDefault();document.getElementById(\'startdate\').value = \'0001-01-01 00:00:00\'; document.getElementById(\'form_resultallusers\').submit()"><i class="fas fa-history"></i></button>&nbsp;<button title="Ke awal tahun" onclick="event.preventDefault();setAwalTahun();document.getElementById(\'form_resultallusers\').submit()"><i class="fas fa-calendar-alt"></i></button>');


//uncheck all
function unCheckAll(a){
	var cbArr = document.querySelectorAll(a);
	for(let i=0; i < cbArr.length; i++){
		if(cbArr[i].checked){
			cbArr[i].click()
		}
	}	
}

/* $('#test_id').select2();
$('select#testuser_id').select2();
$('#group_id').select2();
$('#user_id').select2();
$('#display_mode').select2();
$('#module_id').select2();
$('#subject_module_id').select2();
$('#form_subjecteditor #subject_id').select2();
$('#question_subject_id').select2();
$('#question_id').select2();
$('#answer_question_id').select2();
$('#answer_id').select2(); */

if(document.getElementById("checkall1")){
	document.getElementById("checkall1").parentNode.setAttribute("class","ltrdir");
}


function toggleAnswer(){
	let a;
	let hideAns = document.getElementById("hide_answers").checked;
	// alert(hideAns);
	if(hideAns===false){a = "unset"}else{a = "none"}
	// alert(a);
	let olans = document.querySelectorAll("ol.answer");
	let i;
	for(i=0; i<olans.length; i++){
		olans[i].style.display = a;
	}
}

function checkRight(){
	let aw = $("#answer_weight").val();
	// alert(aw);
	if(aw >= 100){
		$("#answer_isright").prop("checked",true);
		$("#answer_isright").prop("readonly","readonly");
		$("#answer_isright").prop("disabled","disabled");
	}else{
		$("#answer_isright").prop("checked",false);
		$("#answer_isright").prop("readonly",false);
		$("#answer_isright").prop("disabled",false);
	}
}	