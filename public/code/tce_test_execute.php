<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_PUBLIC_TEST_EXECUTE;
$thispage_title = $l['t_test_execute'];
$thispage_title_icon = '';
$thispage_description = $l['hp_test_execute'];
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_test.php');

$formname = 'testform';

$test_id = 0;
$testlog_id = 0;
$testuser_id = 0;
$answpos = array();
$answer_text = '';
$test_comment = '';
$reaction_time = 0;

/* echo '<pre>';
var_dump($_REQUEST);
echo '</pre>'; */
if (isset($_REQUEST['testid']) and ($_REQUEST['testid'] > 0)) {
    $test_id = intval($_REQUEST['testid']);
    // check for test password
    $tph = F_getTestPassword($test_id);
    if (!empty($tph) and !checkPassword($tph.$test_id.$_SESSION['session_user_id'].$_SESSION['session_user_ip'], $_SESSION['session_test_login'])) {
        // display login page
        require_once('../code/tce_page_header.php');
        echo F_testLoginForm($_SERVER['SCRIPT_NAME'], 'form_test_login', 'post', 'multipart/form-data', $test_id);
        require_once('../code/tce_page_footer.php');
        exit(); //break page here
    }
    if (isset($_REQUEST['repeat']) and ($_REQUEST['repeat'] == 1)) {
        // mark previous test attempts as repeated
        F_repeatTest($test_id);
    }
	if (isset($_REQUEST['starttest']) and ($_REQUEST['starttest'] == 1)) {
        // mark previous test attempts as repeated
        F_startTest($test_id);
    }
	
    if (F_executeTest($test_id)) {
		if (!empty($_REQUEST['testuser_id'])) {
            $testuser_id = intval($_REQUEST['testuser_id']);
        }
		if (!empty($_REQUEST['ls-answdatas'])) {
            $ls_answdatas = $_REQUEST['ls-answdatas'];
        }
		if (!empty($_REQUEST['ls-unsure'])) {
            $ls_unsure = $_REQUEST['ls-unsure'];
        }
        if (!empty($_REQUEST['testlogid'])) {
            $testlog_id = intval($_REQUEST['testlogid']);
        }
        if (!empty($_REQUEST['answpos'])) {
            if (is_numeric($_REQUEST['answpos'])) {
                $answpos = array($_REQUEST['answpos'] => 1);
            } else {
                $answpos = (array) $_REQUEST['answpos'];
            }
        }
		
		// var_dump($_REQUEST);
		
        if (!empty($_REQUEST['answertext'])) {
            $answer_text = $_REQUEST['answertext'];
        }
        if (!empty($_REQUEST['reaction_time'])) {
            $reaction_time = intval($_REQUEST['reaction_time']);
        }

        if (!empty($_REQUEST['forceterminate']) && F_isRightTestlogUser($test_id, $testlog_id)) {
            if ($_REQUEST['forceterminate'] == 'lasttimedquestion') {
                // update last question
                F_updateQuestionLog($test_id, $testlog_id, $answpos, $answer_text, $reaction_time);
            }
            // terminate the test (lock the test to status=4)
            F_terminateUserTest($test_id);
            // redirect the user to the index page
			if(strlen(K_ENDTEST_PAGE)>0){
				$testend_page = K_ENDTEST_PAGE.'?testid='.$test_id;
			}else{
				$testend_page = 'index.php';
			}
            header('Location: '.$testend_page);
            echo '<'.'?xml version="1.0" encoding="'.$l['a_meta_charset'].'"?'.'>'.K_NEWLINE;
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.K_NEWLINE;
            echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$l['a_meta_language'].'" lang="'.$l['a_meta_language'].'" dir="'.$l['a_meta_dir'].'">'.K_NEWLINE;
            echo '<head>'.K_NEWLINE;
            echo '<title>REDIRECT</title>'.K_NEWLINE;
            echo '<meta http-equiv="refresh" content="0;url='.$testend_page.'" />'.K_NEWLINE; //reload page
            echo '</head>'.K_NEWLINE;
            echo '<body>'.K_NEWLINE;
            echo '<a href="'.$testend_page.'">INDEX...</a>'.K_NEWLINE;
            echo '</body>'.K_NEWLINE;
            echo '</html>'.K_NEWLINE;
            exit;
        }

        // Kunci layar penuh
        echo '<script>';
        echo 'document.addEventListener("keydown", function (e) {';
        echo 'if (e.key === "F11" || (e.ctrlKey && e.key === "Tab")) {';
        echo 'e.preventDefault();';
        echo '}';
        echo '});';
        echo '</script>';

        // Deteksi pergantian tab
        echo '<script>';
        echo 'let isWindowFocused = true;';
        echo 'window.onblur = function () {';
        echo 'isWindowFocused = false;';
        echo '};';
        echo 'window.onfocus = function () {';
        echo 'isWindowFocused = true;';
        echo '};';
        echo 'setInterval(function () {';
        echo 'if (!isWindowFocused) {';
        echo 'alert("Anda tidak diperkenankan untuk mengganti tab selama ujian berlangsung.");';
        echo '}';
        echo '}, 1000);';
        echo '</script>';

        // the user is authorized to execute the selected test
		$test_name = F_getTestName($test_id);
        $thispage_title .= ': '.F_getTestName($test_id);
		
		

        require_once('../code/tce_page_header.php');
		
		$persen = K_ALLOW_SUBMIT_AFTER;
		$persen = $persen/100;
		$tglexamtime = date('d-M-Y H:i:s',$examtime);
		$durasi_ujian_detik = F_getTestDuration($test_id);
		$durasi_ujian_detik_persen = $persen * $durasi_ujian_detik;
		$durasi_ujian_detik_persen_sisa = $durasi_ujian_detik - $durasi_ujian_detik_persen;
		$allowsubmittime = date('Y-m-d H:i:s', strtotime($tglexamtime. '-'.$durasi_ujian_detik_persen_sisa.' seconds'));
		$menit_sisa = $durasi_ujian_detik_persen_sisa / 60;
		
		echo K_NEWLINE;
		echo '<script>const allowsubmittime = -'.$durasi_ujian_detik_persen_sisa.';</script>'.K_NEWLINE;
		
		if(!isset($_POST['question-block'])){
			echo '<div class="container">'.K_NEWLINE;
		}
        

        if (!isset($_REQUEST['terminationform'])){
            if (F_isRightTestlogUser($test_id, $testlog_id)) {				
                // the form has been submitted, update testlogid data
				if(!isset($_POST['question-block']) or isset($_POST['save-answer'])){
					// echo $_REQUEST;
					if(F_updateQuestionLog($test_id, $testlog_id, $answpos, $answer_text, $reaction_time)){
						if(isset($ls_answdatas)){
							$fp = fopen(K_PATH_ANSWDATA.$testuser_id.'_answdata.txt', 'w');
							fwrite($fp, stripslashes($ls_answdatas));
							fclose($fp);
						}
						if(isset($ls_unsure)){
							$fpu = fopen(K_PATH_ANSWDATA.$testuser_id.'_unsure.txt', 'w');
							fwrite($fpu, stripslashes($ls_unsure));
							fclose($fpu);
						}	
					}
					
					
				}
                // update user's test comment
                if (isset($_REQUEST['testcomment']) and (!empty($_REQUEST['testcomment']))) {
                    $test_comment = $_REQUEST['testcomment'];
                    F_updateTestComment($test_id, $test_comment);
                }
                if ((isset($_REQUEST['nextquestion']) or (isset($_REQUEST['autonext']) and ($_REQUEST['autonext'] == 1))) and ($_REQUEST['nextquestionid'] > 0)) {
                    // go to next question
                    $testlog_id = 0 + intval($_REQUEST['nextquestionid']);
                } elseif (isset($_REQUEST['prevquestion']) and ($_REQUEST['prevquestionid'] > 0)) {
                    // go to previous question
                    $testlog_id = intval($_REQUEST['prevquestionid']);
                } else {
                    // go to selected question
                    foreach ($_POST as $key => $value) {
                        if (preg_match('/jumpquestion_([0-9]+)/', $key, $matches) > 0) {
                            $testlog_id = intval($matches[1]);
                            break;
                        }
                    }
                }
            }
        }
        // confirmation form to terminate the test
		$omitted_msg = '';
        if (isset($_REQUEST['terminatetest']) and (!empty($_REQUEST['terminatetest']))) {
            // check if some questions were omitted (undisplayed or unanswered).
			if(K_REALTIME_GRADING){
				$num_omitted_questions = F_getNumOmittedQuestions($test_id);
				
				$forceTerminate=1;
				if ($num_omitted_questions > 0) {
					if(K_FORCE_ANSWER_ALL==false){
						$forceTerminate=1;
						$addMsg='';
					}else{
						$forceTerminate=0;
						$addMsg=$l['m_addMsg'];
					}
					$omitted_msg = '<span style="color:#990000;font-size:120%">[ '.$l['h_questions_unanswered'].': '.$num_omitted_questions.' ] '.$addMsg.'</span>';
				}
			
			
			if(time()>strtotime($allowsubmittime)){
				F_print_error('WARNING', $l['m_confirm_test_termination'].' '.$omitted_msg);
				$hidden_confirm = 0;
			}else{
				F_print_error('ERROR', 'Anda belum diijinkan untuk menyelesaikan ujian, tunggu hingga waktu ujian tersisa '.$menit_sisa.' menit');
				$hidden_confirm = 1;
			}
            
			}
            ?>
            <div class="confirmbox">
            <form onsubmit="reloadCont.style.display='block';backdrop('1','1')" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" id="form_test_terminate">
            <div>
            <input type="hidden" name="testid" id="testid" value="<?php echo $test_id; ?>" />
            <input type="hidden" name="testuserid" id="testuser_id" value="<?php echo $testuser_id; ?>" />
            <input type="hidden" name="testlogid" id="testlogid" value="<?php echo $testlog_id; ?>" />
            <input type="hidden" name="terminationform" id="terminationform" value="1" />
            <input type="hidden" name="display_time" id="display_time" value="" />
            <input type="hidden" name="reaction_time" id="reaction_time" value="" />
            <?php
			
			if(K_REALTIME_GRADING){
				if($forceTerminate==1){
					if($hidden_confirm==0){
						echo '<button type="button" id="forceterminatebtn" onclick="document.getElementById(\'forceterminate\').click();delAllMatchLsCache(document.getElementById(\'testuser_id\').value)">'.$l['w_terminate'].'</button>';
						F_submit_button('forceterminate', $l['w_terminate'].'" class="hidden"', $l['w_terminate_exam']);
					}
				}
			}else{
				if(time()>strtotime($allowsubmittime)){
					F_print_error('WARNING', $l['m_confirm_test_termination'].' '.$omitted_msg);
					$hidden_confirm = 0;
				}else{
					F_print_error('ERROR', 'Anda belum diijinkan untuk menyelesaikan ujian, tunggu hingga waktu ujian tersisa '.$menit_sisa.' menit');
					$hidden_confirm = 1;
				}
			
				if($hidden_confirm==0){
					echo '<button type="button" id="forceterminatebtn" onclick="document.getElementById(\'forceterminate\').click();delAllMatchLsCache(document.getElementById(\'testuser_id\').value)">'.$l['w_terminate'].'</button>';
						F_submit_button('forceterminate', $l['w_terminate'].'" class="hidden"', $l['w_terminate_exam']);
				}
			}
			
            F_submit_button('cancel', $l['w_back'], $l['w_back']);
            echo F_getCSRFTokenField().K_NEWLINE;
            ?>
            </div>
            </form>
            </div>
            <?php
        } else {
			if(!isset($_POST['question-block'])){
				echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="'.$formname.'"';
				echo '>'.K_NEWLINE;
				echo '<div>'.K_NEWLINE;
			}

            // display questions + navigation menu
			// if(isset($_GET['question-block'])){
				echo F_questionForm($test_id, $testlog_id, $formname);
				// echo $test_id;
				// echo $testuser_id;
				
			/* if(!isset($_POST['question-block'])){
				echo '<div class="d-flex jc-sb p-1em">';
				echo '<button id="prevbtn" onclick="saveAnswerAjax(-1,this)" type="button" title="&#10094;">&#10094;</button>';
				echo '<button id="relbtn" onclick="saveAnswerAjax(0,this)" type="button" title="Reload">Reload</button>';
				echo '<button id="savebtn" onclick="saveAnswerAjax(999,this)" type="button" title="Save">Save</button>';
				echo '<button id="nextbtn" onclick="saveAnswerAjax(1,this)" type="button" title="&#10095;">&#10095;</button>';
				echo '</div>';
			} */
			// }
			// echo '<input type="hidden" name="question-block" id="question-block" value="1" />';

            // the $finish variable is used to check if the form has been automatically submitted
            // at the end of the time.
			if(!isset($_POST['question-block'])){
            if (isset($_REQUEST['finish']) and ($_REQUEST['finish'] > 0)) {
                $finish = 1;
            } else {
                $finish = 0;
            }
			}
			if(!isset($_POST['question-block'])){
            echo '<input type="hidden" name="finish" id="finish" value="'.$finish.'" />'.K_NEWLINE;
            echo '<input type="hidden" name="display_time" id="display_time" value="" />'.K_NEWLINE;
            echo '<input type="hidden" name="reaction_time" id="reaction_time" value="" />'.K_NEWLINE;
			}
            // textarea field for user's comment
			if(!isset($_POST['question-block'])){
            echo F_testComment($test_id).K_NEWLINE;
			}
            // test termination button
			if(!isset($_POST['question-block'])){
			echo '<div id="forceterminateCont">'.K_NEWLINE;
            F_submit_button('terminatetest', $l['w_terminate_exam'], $l['w_terminate_exam']);
			echo '</div>'.K_NEWLINE;
			}
			if(!isset($_POST['question-block'])){
            echo K_NEWLINE;
            echo '</div>'.K_NEWLINE;
            echo F_getCSRFTokenField().K_NEWLINE;
            echo '</form>'.K_NEWLINE;
			}
        }

        // start the countdown if disabled
        if (isset($examtime)) {
			if(!isset($_POST['question-block'])){
				// echo date('Y:m:d H:i:s',$examtime).'<br/>';
				// echo strtotime('2022-03-26 11:00:00').'<br/>';
				// echo strtotime('2021-03-26 11:50:00').'<br/>';
			
			// echo ($examtime-strtotime('2021-03-26 11:50:00')).'<br/>';
			
			// if($examtime>strtotime('2021-03-26 11:50:00')){
				// echo 'Examtime melebihi waktu selesai jadwal test';
			// }else{
				// echo 'Examtime masih kurang dari waktu selesai jadwal test';
			// }
			
            // if (isset($timeout_logout) and ($timeout_logout)) {
                // $timeout_logout = 'true';
            // } else {
                // $timeout_logout = 'false';
            // }
            echo '<script type="text/javascript">'.K_NEWLINE;
            echo '//<![CDATA['.K_NEWLINE;
            echo 'var TL = false;'.K_NEWLINE;
			echo 'if(document.getElementById("timeout_logout").value==="1"){TL=true}else{TL=false}'.K_NEWLINE;
            // echo 'alert(TL);'.K_NEWLINE;
            echo 'if(!enable_countdown) {'.K_NEWLINE;
			
			$testendtime = strtotime(F_getTestEndTime($test_id));
			// echo date('d-M-Y H:i:s', $examtime);
			if(($examtime-$testendtime)>0){
				echo '	FJ_start_timer(\'true\', '.(time() - $testendtime).', \''.addslashes($l['m_exam_end_time']).'\', TL);'.K_NEWLINE;
			}else{
				echo '	FJ_start_timer(\'true\', '.(time() - $examtime).', \''.addslashes($l['m_exam_end_time']).'\', TL);'.K_NEWLINE;
			}
			
			
            echo '}'.K_NEWLINE;
            // echo 'var loadtime=new Date();'.K_NEWLINE;
            // echo 'document.getElementById(\'display_time\').value=loadtime.getTime();'.K_NEWLINE;
            echo '//]]>'.K_NEWLINE;
            echo '</script>'.K_NEWLINE;
			
			// echo date('d-M-Y H:i:s', $examtime);
			// echo '<br/>'.date('d-M-Y H:i:s', $testendtime);
			// echo '<br/>'.($examtime-$testendtime);
			
			//batasi waktu hentikan
			$persen = 50;
			$persen = $persen/100;
			$tglexamtime = date('d-M-Y H:i:s',$examtime);
			$durasi_ujian_detik = F_getTestDuration($test_id);
			$durasi_ujian_detik_persen = $persen * $durasi_ujian_detik;
			$durasi_ujian_detik_persen_sisa = $durasi_ujian_detik - $durasi_ujian_detik_persen;
			$allowsubmittime = date('Y-m-d H:i:s', strtotime($tglexamtime. '-'.$durasi_ujian_detik_persen_sisa.' seconds'));			
			}
        }
    } else {
        // redirect the user to the index page
		if(isset($_POST['question-block'])){
			echo 'Oops, Anda tidak diperkenankan meneruskan Ujian. Hal ini bisa disebabkan karena beberapa hal antara lain yaitu:';
			echo '<ol>';
			echo '<li>Waktu / jadwal ujian telah berakhir / kadaluarsa;</li>';
			echo '<li>Anda tidak memiliki hak akses terhadap ujian;</li>';
			echo '<li>Pengaturan waktu ujian telah berubah;</li>';
			echo '<li>Jadwal ujian belum tersedia.</li>';
			echo '</ol>';
			echo '<p>Anda bisa <a href="index.php">klik disini</a> untuk kembali ke beranda dan melihat jadwal ujian yang ada.</p>';
			echo '<a onclick="reloadCont.style.display=\'block\';backdrop(\'1\',\'1\');window.location.replace(\'tce_test_execute.php?testid=3&amp;repeat=1\');" title="jalankan test" class="xmlbutton"><span class="icon-home-outline"></span> KEMBALI KE BERANDA</a>';
			die();
		}
        header('Location: index.php');
        echo '<'.'?xml version="1.0" encoding="'.$l['a_meta_charset'].'"?'.'>'.K_NEWLINE;
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.K_NEWLINE;
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$l['a_meta_language'].'" lang="'.$l['a_meta_language'].'" dir="'.$l['a_meta_dir'].'">'.K_NEWLINE;
        echo '<head>'.K_NEWLINE;
        echo '<title>REDIRECT</title>'.K_NEWLINE;
        echo '<meta http-equiv="refresh" content="0;url=index.php" />'.K_NEWLINE; //reload page
        echo '</head>'.K_NEWLINE;
        echo '<body>'.K_NEWLINE;
        echo '<a href="index.php">INDEX...</a>'.K_NEWLINE;
        echo '</body>'.K_NEWLINE;
        echo '</html>'.K_NEWLINE;
        exit;
    }
} else {
    require_once('../code/tce_page_header.php');
    echo '<div class="container">'.K_NEWLINE;
	echo '<div id="broken_testpage">'.K_NEWLINE;
	echo '<p>'.$l['p_testpage_broken'].'</p>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	echo '</div">';
}
if(!isset($_POST['question-block'])){
	echo '<div class="pagehelp">'.$l['hp_test_execute'].'</div>'.K_NEWLINE;

// echo $testuser_id;
// echo $test_id;
echo '</div>'.K_NEWLINE; // container
require_once('../code/tce_page_footer.php');
}
//============================================================+
// END OF FILE
//============================================================+
