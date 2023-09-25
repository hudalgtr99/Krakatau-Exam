//============================================================+
// File name   : timer.js
// Begin       : 2004-04-29
// Last Update : 2023-02-05
//
// Description : display clock and countdown timer
//
// Author: Nicola Asuni
// Co-author : Maman Sulaeman
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//
// License:
//    Copyright (C) 2004-2010 Nicola Asuni - Tecnick.com LTD
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//    Additionally, you can't remove, move or hide the original TCExam logo,
//    copyrights statements and links to Tecnick.com and TCExam websites.
//
//    See LICENSE.TXT file for more information.
//============================================================+

// global variables

var enable_countdown = false;
var remaining_time = 0; // countdown duration
var msg_endtime = ''; // message to display at the end of time
var start_time = 0; // client computer datetime in milliseconds
var displayendtime = true; // display popup message indicating the end of the time
var timeout_logout = false; // if true logout user at the end of available time
var time_diff = 0; // time difference between server and client in milliseconds
var almostend1 = true;
var almostend2 = true;
/* var almostend1_time = -7200;
var almostend1_msg = 'aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa';
var almostend1_bg = '#ffecb3';
var almostend1_col = '#333333';
var almostend2 = true;
var almostend2_time = -6600;
var almostend2_msg = 'bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb bbb';
var almostend2_bg = '#ffcdd2';
var almostend2_col = '#333333'; */
/**
 * Display current server date-time and remaining time (countdown)
 * on a input text form field (timerform.timer)
 */
 
 
function FJ_timer() {
	if (enable_countdown) { // --- COUNTDOWN MODE ---
		// get local time
		var today = new Date();
		// elapsed time in seconds
		var diff_seconds = remaining_time + ((today.getTime() - start_time) / 1000);
		//get sign
		var sign = '-';
		// submit form for the last time to save user input on textbox (if any)

		var allowsubmittime_min = (allowsubmittime/60)*(-1);
 
		
		if(document.getElementById("termbtn")){
			if((diff_seconds < allowsubmittime)){
				document.getElementById("termbtn").setAttribute("onclick","alert('Anda belum diperkenankan untuk menghentikan ujian, silakan tunggu hingga waktu ujian tersisa "+allowsubmittime_min+" menit')");
			}else{
				document.getElementById("termbtn").setAttribute("onclick","saveAnswerAjax(0,this)");
			}
		}
		
		
		
		if ((diff_seconds >= almostend1_time) && almostend1) {
			document.getElementById("almostend").innerHTML = "<p style='margin:0.5em 0 0 0;padding:0.5em;border-radius:0.5em;background:"+almostend1_bg+";color:"+almostend1_col+"'>"+almostend1_msg+((parseInt(diff_seconds/60)-1)*-1)+" "+K_MINUTES+"</p>";
			document.getElementById("timer").style.background = almostend1_bg;
			document.getElementById("timer").style.color = almostend1_col;
			document.getElementById("timerdiv").style.background = almostend1_bg;
			document.getElementById("timerdiv").style.color = almostend1_col;
			document.getElementById("timerdiv").style.border = '1px solid rgba(0,0,0,0.1)';
		}
		if ((diff_seconds >= almostend2_time) && almostend2) {
			document.getElementById("almostend").innerHTML = "<p style='margin:0.5em 0 0 0;padding:0.5em;border-radius:0.5em;background:"+almostend2_bg+";color:"+almostend2_col+"'>"+almostend2_msg+((parseInt(diff_seconds/60)-1)*-1)+" "+K_MINUTES+"</p>";
			document.getElementById("timer").style.background = almostend2_bg;
			document.getElementById("timer").style.color = almostend2_col;
			document.getElementById("timerdiv").style.background = almostend2_bg;
			document.getElementById("timerdiv").style.color = almostend2_col;
		}
		if (diff_seconds >= -11){
			document.getElementById("almostend").innerHTML = "<p style='margin:0.5em 0 0 0;padding:0.5em;border-radius:0.5em;background:"+lastsec_bg+";color:"+lastsec_col+"'>"+lastsec_msg+parseInt(diff_seconds*-1)+"</strong></p>";
			document.getElementById("timer").style.background = almostend2_bg;
			document.getElementById("timer").style.color = almostend2_col;
			document.getElementById("timerdiv").style.background = almostend2_bg;
			document.getElementById("timerdiv").style.color = almostend2_col;
		}
		
		if (diff_seconds >= 0){
			document.getElementById("almostend").innerHTML = "<p style='margin:0.5em 0 0 0;padding:0.5em;border-radius:0.5em;background:"+almostend2_bg+";color:"+almostend2_col+"'>Waktu mengerjakan ujian <strong>"+document.getElementById("h1_testpage").textContent+"</strong> telah usai</p>";
			document.getElementById("timer").style.background = almostend2_bg;
			document.getElementById("timer").style.color = almostend2_col;
			document.getElementById("timerdiv").style.background = almostend2_bg;
			document.getElementById("timerdiv").style.color = almostend2_col;
		}
		
		if(document.getElementById('testform')){
			if ((diff_seconds >= -2) && (document.getElementById('testform').finish.value == 0)) {
				document.getElementById('testform').finish.value = 1;
				document.getElementById('relbtn').click();
			}
		}
		if(document.getElementById('terminationform')){
			if ((diff_seconds >= -2) && (document.getElementById('terminationform').value == 1)) {
				document.getElementById('terminationform').value = 0;
			}
		}
		
		if (diff_seconds >= 0) {
			sign = '+';
			if (displayendtime && (msg_endtime.length > 1)) {
				displayendtime = false;
				alert(msg_endtime);
				// clearStorage();
				if(QBLOCK_JSON){delAllMatchLsCache(document.getElementById("testuser_id").value)};
				if (timeout_logout) {
					// logout
					window.location.replace('tce_logout.php');
				} else {
					// redirect user to index page
					if(K_ENDTEST_PAGE.length>0){
						window.location.replace(K_ENDTEST_PAGE+"?testid="+document.getElementById("testid").value);
					}else{
						window.location.replace('index.php');
					}
				}
			}
		}
		diff_seconds = Math.abs(diff_seconds); // get absolute value
		// split seconds in HH:mm:ss
		var diff_hours = Math.floor(diff_seconds / 3600);
		diff_seconds  = diff_seconds % 3600;
		var diff_minutes = Math.floor(diff_seconds / 60);
		diff_seconds  = Math.floor(diff_seconds % 60);
		if(diff_hours < 10) {
			diff_hours = "0" + diff_hours;
		}
		if(diff_minutes < 10) {
			diff_minutes = "0" + diff_minutes;
		}
		if(diff_seconds < 10) {
			diff_seconds = "0" + diff_seconds;
		}
		// display countdown string on form field

		document.getElementById('timerform').timer.value = ''+diff_hours+':'+diff_minutes+':'+diff_seconds+' ';
	} else { // --- CLOCK MODE ---
		var localtime = new Date();
		var today = new Date((localtime.getTime() + time_diff));
		var year = ''+today.getFullYear();
		var month = ''+(1 + today.getMonth());
		if(month.length < 2) {
			month = '0'+month;
		}
		var day = ''+today.getDate();
		if(day.length < 2) {
			day = '0'+day;
		}
		var hour = ''+today.getHours();
		if(hour.length < 2) {
			hour = '0'+hour;
		}
		var minute = ''+today.getMinutes();
		if(minute.length < 2) {
			minute = '0'+minute;
		}
		var second = ''+today.getSeconds();
		if(second.length < 2) {
			second = '0'+second;
		}
		// display clock string on form field
		document.getElementById('timerform').timer.value = ''+year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
	}
	return;
}

/**
 * Starts the timer
 * @param boolean countdown if true enable countdown
 * @param int remaining remaining test time in seconds
 * @param string msg  message to display at the end of countdown
 * @param boolean logout if true logout user at the end of available time
 * @param int servertime the server time in milliseconds
 */
function FJ_start_timer(countdown, remaining, msg, logout, servertime) {
	var startdate = new Date();
	start_time = startdate.getTime();
	time_diff = servertime - start_time + 60;
	enable_countdown = countdown;
	remaining_time = remaining;
	msg_endtime = msg;
	timeout_logout = logout;
	// update clock
	setInterval('FJ_timer()', 500);
}

// --------------------------------------------------------------------------
//  END OF SCRIPT
// --------------------------------------------------------------------------
