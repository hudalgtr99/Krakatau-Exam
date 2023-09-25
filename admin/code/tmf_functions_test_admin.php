<?php
function F_getUserTests()
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    require_once('../../shared/code/tce_functions_test_stats.php');
    global $db, $l;
    $user_id = intval($_SESSION['session_user_id']);

/*start maman modus siang/malam*/
	/*if(isset($_GET['modus'])){
		$_SESSION['modus']=$_GET['modus'];
	}else{
		$_SESSION['modus']=1;
	}

	if($_SESSION['modus']==1){
		$modus_link = '<a href="'.$_SERVER['SCRIPT_NAME'].'?modus=0">KE MODUS MALAM</a>';
	}else{
		$modus_link = '<a href="'.$_SERVER['SCRIPT_NAME'].'?modus=1">KE MODUS SIANG</a>';
	}*/
/*end maman modus siang/malam*/

	//if(empty($_SESSION['modus']) || $_SESSION['modus']==1){
	//	echo 'a href modus=0 untuk malam';
	//}else{
	//	echo 'a href modus=1 untuk siang';
	//}


//start maman session

	if(!K_CONFIRM_USER){
		$_SESSION['konfirmasi']=1;
		$konfirmasi=$_SESSION['konfirmasi'];
	}else{
		if(isset($_GET['konfirmasi'])){
			$_SESSION['konfirmasi']=$_GET['konfirmasi'];
			$konfirmasi=$_SESSION['konfirmasi'];
		}
	}

	if(empty($_SESSION['konfirmasi'])){
		//echo "<style>.tcecontentbox{background-color:unset;box-shadow: 0px 0px 19px -6px rgba(0,0,0,0.50);border-radius: 10px;</style>";
	    //$sql = 'SELECT * FROM '.K_TABLE_USERS.' WHERE user_name=\''.$_SESSION['session_user_name'].'\' AND user_password=\''.$_SESSION['session_user_name'].'\'';
	    $sql = 'SELECT * FROM '.K_TABLE_USERS.' WHERE user_name=\''.$_SESSION['session_user_name'].'\' AND user_password COLLATE UTF8_GENERAL_CI LIKE \'%'.$_SESSION['session_user_name'].'%\'';
            if ($r = F_db_query($sql, $db)) {
                if ($m = F_db_fetch_array($r)) {
			echo "<div class='d-block bg-white boxshd brad-5 px-20 py-5'>";
			echo "<p class='bg-fuchsia ft-white ft-bold py-10 px-20 txt-trans-up brad-5 d-block'><span class='glyphicon glyphicon-lock'></span> Password Error</p>";
			echo "<p>Anda belum diijinkan mengerjakan Ujian karena masih menggunakan <i>password</i> yang sama atau mirip dengan <i>username</i> Anda. Silakan ganti <i>password</i> Anda melalui tombol <b>Ubah Password</b> di bawah ini.</p>";
			echo "<a class='pwrap bg-biru ft-white ft-bold px-15 py-10 c-pointer brad-100 mb-15 no-underl' href='tce_user_change_password.php'>Ubah Password</a>";
			echo "</div>";
                    die();
                }else{
                    echo "";
                }
            }else{
                echo "";
            }
		echo '<div class="boxshd brad-10">';
		echo '<div class="loginboxtitle">Konfirmasi Data Peserta</div>';
		echo '<div class="bg-white ov-hidden">';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Kode NIK</p>';
		if($_SESSION['nik']===null){
			$_SESSION['nik']="-";
		}
		echo '<p class="konfirmasi_text">'.$_SESSION['nik'].'</p>';
		echo '</div>';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Nama Peserta</p>';
		$firstname = urldecode($_SESSION['session_user_firstname']);
		if($firstname===null){
			$firstname="-";
		}
		$_SESSION['print_firstname']=$firstname;
		echo '<p class="konfirmasi_text">'.$firstname.'</p>';
		echo '</div>';
		if($_SESSION['jurusan']===null){
			$_SESSION['jurusan']="-";
		}
		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Kompetensi Keahlian (Jurusan)</p>';
		echo '<p class="konfirmasi_text">'.$_SESSION['jurusan'].'</p>';
		echo '</div>';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Kelas</p>';
		if($_SESSION['kelas']===null){
			$_SESSION['kelas']="-";
		}
		echo '<p class="konfirmasi_text">'.$_SESSION['kelas'].'</p>';
		echo '</div>';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Tempat, Tanggal lahir</p>';
		if($_SESSION['user_birthdate']==="0000-00-00" || $_SESSION['user_birthdate']===null){
			$newDob = "-";
		}else{
			$tanggal=date("j", strtotime($_SESSION['user_birthdate']));
			$bulan=intval(date("n", strtotime($_SESSION['user_birthdate'])));
			
			if($bulan===1){
				$bulan="Januari";
			}elseif($bulan===2){
				$bulan="Februari";
			}elseif($bulan===3){
				$bulan="Maret";
			}elseif($bulan===4){
				$bulan="April";
			}elseif($bulan===5){
				$bulan="Mei";
			}elseif($bulan===6){
				$bulan="Juni";
			}elseif($bulan===7){
				$bulan="Juli";
			}elseif($bulan===8){
				$bulan="Agustus";
			}elseif($bulan===9){
				$bulan="September";
			}elseif($bulan===10){
				$bulan="Oktober";
			}elseif($bulan===11){
				$bulan="November";
			}elseif($bulan===12){
				$bulan="Desember";
			}else{
				$bulan="00";
			}
			$tahun=date("Y", strtotime($_SESSION['user_birthdate']));

			$newDob = $tanggal.' '.$bulan.' '.$tahun;
			if(strlen($newDob)<0){
				$newDob = '-';
			}
		}
		if(empty($_SESSION['user_birthplace'])){
			echo '<p class="konfirmasi_text">'.$newDob.'</p>';
		}elseif($_SESSION['user_birthplace']=="-"){
			echo '<p class="konfirmasi_text">'.$newDob.'</p>';
		}else{
			echo '<p class="konfirmasi_text">'.$_SESSION['user_birthplace'].', '.$newDob.'</p>';
		}
		echo '</div>';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm">';
		echo '<p class="ft-bold">Jenis Kelamin</p>';
		if($_SESSION['sex']==null){
			$_SESSION['sex']="-";
		}elseif($_SESSION['sex']=="-"){
			$_SESSION['sex']="-";
		}elseif($_SESSION['sex']==0){
			$_SESSION['sex']="Laki-laki";
		}elseif($_SESSION['sex']==1){
			$_SESSION['sex']="Perempuan";
		}
		echo '<p class="konfirmasi_text">'.$_SESSION['sex'].'</p>';
		echo '</div>';

		echo '<div class="bdb-gray1 py-5 px-20 ft-sm" style="border:none;background:#fff9c4">';
		echo '<p class="warn_konf"><b>PERINGATAN:</b> Jika informasi di atas tidak sesuai dengan data Anda silakan <span class="separator_warn"></span>klik tombol <b>LOGOUT</b>, jika sesuai klik tombol <b>MASUK</b>.</p>';
		echo '</div>';
		echo '</div>';
		echo '<div class="loginboxfooter">';
		echo '<span class="logout bg-grad-merah fl-l ft-bold c-pointer txt-trans-up"><a href="#" onclick="JSconfirm()" class="ft-white no-underl">logout</a></span>';
		echo '<span class="mulai bg-grad-hijau ft-bold c-pointer txt-trans-up"><a href="'.$_SERVER['SCRIPT_NAME'].'?konfirmasi=1" class="ft-white no-underl">MASUK</a></span>';
		echo '</div>';
		echo '</div>';
		echo '<script type="text/javascript" src="../../shared/jscripts/gocbt.min.js"></script>';
		exit;
	}
//end maman session
    $str = ''; // temp string
    $str .= '<div id="daftarUjian">'.K_NEWLINE;
    // get current date-time
    $current_time = date(K_TIMESTAMP_FORMAT);
    // select tests hiding old repeated tests
    $sql = 'SELECT * FROM '.K_TABLE_TESTS.' WHERE (test_id IN (SELECT tsubset_test_id FROM '.K_TABLE_TEST_SUBJSET.') AND (test_begin_time < \''.$current_time.'\')';
    if (K_HIDE_EXPIRED_TESTS) {
        $sql .= ' AND (test_end_time > \''.$current_time.'\')';
    }
    $sql .= ') ORDER BY test_begin_time DESC';
    if ($r = F_db_query($sql, $db)) {
	//$bgcolArray=array(1=>"bg-hijau", 2=>"bg-merah", 3=>"bg-biru", 4=>"bg-fuchsia");
	$bgcolArray=array(0=>"bg-hijau", 1=>"bg-yellow", 2=>"bg-yellow", 3=>"bg-biru", 4=>"bg-dark", 5=>"bg-biru", 6=>"bg-biru", 7=>"bg-biru", 8=>"bg-biru", 9=>"bg-fuchsia");
        while ($m = F_db_fetch_array($r)) { // for each active test
            $expired = false;
            // check user's authorization
            if (F_isValidTestUser($m['test_id'], $_SESSION['session_user_ip'], $m['test_ip_range'])) {
                // the user's IP is valid, check test status
                list ($test_status, $testuser_id) = F_checkTestStatus($user_id, $m['test_id'], $m['test_duration_time']);
                if (strtotime($current_time) >= strtotime($m['test_end_time'])) {
                    // the test is expired.
                    $expired = true;
                    //$datestyle = ' style="color:#666666;"';
			//$str .= "AAA";
                } else {
			//$str .= "BBB";
                    //$datestyle = '';
                }
                $str .= '<div class="testItemCont w-250 d-iblock boxshd-rb mb-20 brad-5">'.K_NEWLINE;
//                if (strlen($m['test_password']) > 0) {
//                    $str .= '<td>';
//                } else {
//                    $str .= '<td>';
//                }
                $str .= '<div class="brad-top-5 d-block py-15 px-20 '.$bgcolArray[$test_status].' txt-center boxshd-inset-rb pos-rel ov-hidden h-75" id="testTitle"><span class="infolink-list ft-lgr pos-abs l-0 top-0 py-15 px-20 z-99">'.F_testInfoLink($m['test_id'], $m['test_name']).'</span><span class="glyphicon ';
		switch($test_status){
			case 0:{$str .= 'glyphicon-file ';break;}
			case 1:{$str .= 'glyphicon-hourglass ';break;}
			case 2:{$str .= 'glyphicon-hourglass ';break;}
			case 3:{$str .= 'glyphicon-pushpin ';break;}
			case 4:{$str .= 'glyphicon-flag ';break;}
			case 9:{$str .= 'glyphicon-file ';break;}
		}
		$str .= 'pos-abs z-9 opa-01 ft-150 top--15"></span></div>'.K_NEWLINE;
		$str .= '<div class="bg-white brad-bot-5">'.K_NEWLINE;
                $str .= '<div class="txt-center py-5 ft-sm bdb-gray1-lt"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Ujian Mulai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="bg-hijau-pupus1 ft-white py-3 px-5 d-iblock brad-50"><span class="glyphicon glyphicon-time"></span>&nbsp;'.$m['test_begin_time'].'</span></div></div>'.K_NEWLINE;
                $str .= '<div class="txt-center py-5 ft-sm bdb-gray1-lt"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Ujian Selesai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="bg-tomat ft-white py-3 px-5 d-iblock brad-50"><span class="glyphicon glyphicon-time"></span>&nbsp;'.$m['test_end_time'].'</span></div></div>'.K_NEWLINE;
                $str .= '<div class="txt-center py-5 ft-sm bdb-gray1-lt"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Durasi Ujian</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="bg-tosca ft-white py-3 px-5 d-iblock brad-50 mr-5"><span class="glyphicon glyphicon-time"></span>&nbsp;'.$m['test_duration_time'].' menit</span><span class="bg-nila ft-white py-3 px-5 d-iblock brad-50"><!--span class="glyphicon glyphicon-th-large"></span-->&nbsp;'.$m['test_max_score'] / $m['test_score_right'].' soal&nbsp;</span></div></div>'.K_NEWLINE;
                $str .= '<div class="txt-center py-5 ft-sm bdb-gray1-lt"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Status Test</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="ft-white py-3 px-5 d-iblock brad-50 '.K_NEWLINE;
                //$str .= $m['test_end_time'].K_NEWLINE;
                // status
//                $str .= '<td';

		switch($test_status){
			case 0:{$str .= 'bg-hijau"><span class="glyphicon glyphicon-file"></span>&nbsp;Belum dikerjakan'.K_NEWLINE;break;}
			case 1:{$str .= 'bg-yellow"><span class="glyphicon glyphicon-hourglass"></span>&nbsp;Sedang dikerjakan'.K_NEWLINE;break;}
			case 2:{$str .= 'bg-yellow"><span class="glyphicon glyphicon-hourglass"></span>&nbsp;Sedang dikerjakan'.K_NEWLINE;break;}
			case 3:{$str .= 'bg-biru"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;Lengkap Terjawab'.K_NEWLINE;break;}
			case 4:{$str .= 'bg-dark"><span class="glyphicon glyphicon-flag"></span>&nbsp;Sudah dikerjakan'.K_NEWLINE;break;}
			case 9:{$str .= 'bg-hijau"><span class="glyphicon glyphicon-file"></span>&nbsp;Belum dikerjakan'.K_NEWLINE;break;}
		}

		$str .= '</span></div></div>'.K_NEWLINE;

                if (($test_status >= 4) and F_getBoolean($m['test_results_to_users'])) {
                    $usrtestdata = F_getUserTestStat($m['test_id'], $user_id, $testuser_id);
                    $passmsg = '';
                    if (isset($usrtestdata['user_score']) and isset($usrtestdata['test_score_threshold']) and ($usrtestdata['test_score_threshold'] > 0)) {
                        if ($usrtestdata['user_score'] >= $usrtestdata['test_score_threshold']) {
                            //$str .= ' style="background-color:#ddffdd;"';
                            $passmsg = '<span class="py-3 px-5 bg-hijau ft-white brad-50"><span class="glyphicon glyphicon-star"></span>&nbsp;Tuntas</span>';
                        } else {
                            //$str .= ' style="background-color:#ffdddd;"';
			    if($test_status == 9){
                            	$passmsg = '<span class="py-3 px-5 bg-hijau ft-white brad-50"><span class="glyphicon glyphicon-file"></span>&nbsp;Belum ditentukan</span>';
			    }else{
                            	$passmsg = '<span class="py-3 px-5 bg-merah ft-white brad-50"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Tidak Tuntas</span>';
			    }
                        }
                    }else{
                            $passmsg = '<span class="py-3 px-5 bg-dark ft-white brad-50"><b>?</b> Tidak ditentukan</span>';
		    }
                    //$str .= '>';
			//$str .= $passmsg;
                    if (isset($usrtestdata['user_score']) and (strlen(''.$usrtestdata['user_score']) > 0)) {
                        if ($usrtestdata['test_max_score'] > 0) {
			    if($test_status==9){
                            	$str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Nilai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="py-3 px-5 d-iblock brad-50 bg-biru-langit ft-white">Belum diproses</span></div></div>';
			    }else{
                            	$str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Nilai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="py-3 px-5 d-iblock brad-50 bg-biru-langit"><a class="fmono ft-white no-underl" href="tce_show_result_user.php?testuser_id='.$testuser_id.'&amp;test_id='.$m['test_id'].'" title="Hasil">'.round($usrtestdata['user_score'], 2).' / '.round($usrtestdata['test_max_score'], 2).' ('.round(100 * $usrtestdata['user_score'] / $usrtestdata['test_max_score']).'%)</a></span></div></div>';
			    }
                            $str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Status Nilai</span></div> <div id="contTlValue" class="d-iblock w-150">'.$passmsg.'</div></div>';
                        } else {
			    if($test_status==9){
	                            $str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Nilai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="py-3 px-5 d-iblock brad-50 bg-biru-langit ft-white">Belum diproses</span></div></div>';
			    }else{
	                            $str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Nilai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="py-3 px-5 d-iblock brad-50 bg-biru-langit"><a href="tce_show_result_user.php?testuser_id='.$testuser_id.'&amp;test_id='.$m['test_id'].'" title="Hasil">'.$usrtestdata['user_score'].$passmsg.'</a></span></div></div>';
			    }
                            $str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Status Nilai</span></div> <div id="contTlValue" class="d-iblock w-150">'.$passmsg.'</div></div>';

                        }
                    } else {
			$str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Status Nilai</span></div> <div id="contTlValue" class="d-iblock w-150">Tidak ditentukan</div></div>';
                    }
                } else {
		    $str .= '<div class="txt-center py-5 bdb-gray1-lt ft-sm"><div id="contTlLabel" class="d-iblock w-80"><span id="tlLabel" class="fl-r">Nilai</span></div> <div id="contTlValue" class="d-iblock w-150"><span class="ft-white py-3 px-5 d-iblock brad-50 bg-ungu"><span class="glyphicon glyphicon-eye-close"></span>&nbsp;Tidak ditampilkan</span></div></div>'.K_NEWLINE;
                    //$str .= 'yyy';
			/**if($test_status==0 and $test_status==1){
				$str .= $test_status.' Test Baru';
			}elseif($test_status==2 and $test_status==3){
				$str .= $test_status.' Sedang dikerjakan';
			}**/
                }
                //$str .= '</td>'.K_NEWLINE;
                // display various action links by status case
                $str .= '<div class="txt-center p-5">';
                if (!$expired) {
                    switch ($test_status) {
                        case 0: { // 0 = the test generation process is started but not completed
                            // print execute test link
                            $str .= '<a href="';
                            //if (K_DISPLAY_TEST_DESCRIPTION or !empty($m['test_password'])) {
                            if (K_DISPLAY_TEST_DESCRIPTION) {
                                // display test description before starting
                                $str .= 'tce_test_start.php';
                            } else {
                                // directly execute test
                                $str .= 'tce_test_execute.php';
                            }
                            $str .= '?testid='.$m['test_id'].'" title="Mulai Ujian" id="startbutton" class="d-block ft-white bg-hijau py-10 brad-5 txt-trans-up no-underl">Kerjakan <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
                            break;
                        }
                        case 1: // 1 = the test has been successfully created
                        case 2: // 2 = all questions have been displayed to the user
                        case 3: { // 3 = all questions have been answered
                            // continue test
                            $str .= '<a href="tce_test_execute.php?testid='.$m['test_id'].'" title="Lanjutkan Ujian" id="startbutton" class="d-block ft-white bg-yellow py-10 txt-trans-up brad-5 no-underl">Lanjutkan <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
                            break;
                        }
			case 9: {
				$str .= '<a href="tce_test_execute.php?starttest=1&testid='.$m['test_id'].'" title="Mulai test" id="startbutton" class="d-block bg-fuchsia py-10 txt-trans-up brad-5 ft-white no-underl">Kerjakan <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
				break;
			}
                        default: { // 4 or greater = test can be repeated
                            if (F_getBoolean($m['test_repeatable'])) {
                                // print execute test link
                                $str .= '<a href="';
                                if (K_DISPLAY_TEST_DESCRIPTION or !empty($m['test_password'])) {
                                    // display test description before starting
                                    $str .= 'tce_test_start.php';
                                } else {
                                    // directly execute test
                                    $str .= 'tce_test_execute.php';
                                }
                                $str .= '?testid='.$m['test_id'].'&amp;repeat=1" title="Ulangi Ujian" id="startbutton" class="d-block bg-biru ft-white py-10 brad-5 no-underl txt-trans-up">Ulangi <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
                            }else{
			    	$str .= '<span class="ft-dark py-10 d-block brad-5"><span class="glyphicon glyphicon-flag"></span> SELESAI</span>'.K_NEWLINE;
			    }
                            break;
                        }
                    }
                }else{
		    	$str .= '<span class="ft-merah py-10 d-block brad-5"><span class="glyphicon glyphicon-lock"></span> DIKUNCI</span>'.K_NEWLINE;
		}
                $str .= '</div>'.K_NEWLINE;
                $str .= '</div>'.K_NEWLINE;
                $str .= '</div>'.K_NEWLINE;
            }
        }
    } else {
        F_display_db_error();
    }
    $str .= '</div>'.K_NEWLINE;

//maman, jika ada pelanggaran
if (K_VIO_LOCK == true){
	$sqlcvl='SELECT * FROM '.K_TABLE_VIO_LOGS.' WHERE user_id=\''.$_SESSION['session_user_id'].'\' LIMIT 1';
	$runcvl = F_db_query($sqlcvl, $db);
	$vio=$runcvl->num_rows;
	//if (isset($_SESSION['session_violation'])){
}else{
	$vio=0;
}
if ($vio==1){
        $out = "<div class='py-10 px-20 bdl-merah-5 bg-white boxshd'>
<p class='ln-h-1-5'>
<span class='bdb-merah1 d-block py-1'>
<span class='glyphicon glyphicon-lock ft-merah'></span>
<span class='txt-trans-up ft-bold ft-merah'>laman ujian terkunci</span></span><br/>
<span class='ft-bold'>".$_SESSION['print_firstname']."</span><span>, Anda terdeteksi melakukan aktivitas ilegal pada saat Ujian berlangsung. Harap hubungi pengawas / proktor untuk melanjutkan Ujian.</span><br/>Apabila akses ke laman ujian sudah dibuka silakan klik tombol LANJUT di bawah ini.<br/><br/>
<a class='bg-hijau ft-bold ft-white brad-100 py-10 px-20 no-underl' href='../index.php'>LANJUT &#10095;</a></p></div>";
}else{
    if (strlen($str) > 32) {
        $out = $str;
    } else {
        $out = '<div id="notest" class="mt-25 brad-right-5 d-block bg-white boxshd-rb"><span class="py-10 px-15 bg-merah d-iblock ft-white ft-bold brad-left-5">&times;</span><span class="d-iblock px-20 txt-trans-up">Tidak ada jadwal Ujian</span></div>';
    }
}
    return $out;
}

/**
 * Start test that test page was generated from Admin.
 * @param $test_id (int) Test ID
 */
function F_startTest($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    $sql = 'SELECT * FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_status=\'9\' AND testuser_user_id='.$user_id.' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
			$sqlda = 'UPDATE '.K_TABLE_TEST_USER.' SET testuser_status=1 WHERE testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqlda, $db)) {
                        F_display_db_error();
            }
			$sqldb = 'UPDATE '.K_TABLE_TEST_USER.' SET testuser_creation_time=\''.date(K_TIMESTAMP_FORMAT).'\' WHERE testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqldb, $db)) {
                        F_display_db_error();
            }
			$sqldc = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET testlog_creation_time=\''.date(K_TIMESTAMP_FORMAT).'\' WHERE testlog_testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqldc, $db)) {
                        F_display_db_error();
            }
			/**
            $sqls = 'SELECT testuser_id FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_user_id='.$user_id.' AND testuser_status>3 ORDER BY testuser_status DESC';
            if ($rs = F_db_query($sqls, $db)) {
                while ($ms = F_db_fetch_array($rs)) {
                }
            } else {
                F_display_db_error();
            }**/
        }
    } else {
		die();
        F_display_db_error();
    }
}


function F_startOfflineTest($test_id, $user_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $sql = 'SELECT * FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_status=\'9\' AND testuser_user_id='.$user_id.' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
			$sqlda = 'UPDATE '.K_TABLE_TEST_USER.' SET testuser_status=3 WHERE testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqlda, $db)) {
                        F_display_db_error();
            }
			$sqldb = 'UPDATE '.K_TABLE_TEST_USER.' SET testuser_creation_time=\''.date(K_TIMESTAMP_FORMAT).'\' WHERE testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqldb, $db)) {
                        F_display_db_error();
            }
			$sqldc = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET testlog_creation_time=\''.date(K_TIMESTAMP_FORMAT).'\' WHERE testlog_testuser_id='.$m['testuser_id'].'';
                    if (!$rd = F_db_query($sqldc, $db)) {
                        F_display_db_error();
            }
			/**
            $sqls = 'SELECT testuser_id FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_user_id='.$user_id.' AND testuser_status>3 ORDER BY testuser_status DESC';
            if ($rs = F_db_query($sqls, $db)) {
                while ($ms = F_db_fetch_array($rs)) {
                }
            } else {
                F_display_db_error();
            }**/
        }
    } else {
		die();
        F_display_db_error();
    }
}


/**
 * Mark previous test attempts as repeated.
 * @param $test_id (int) Test ID
 */
function F_repeatTest($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    $sql = 'SELECT test_id FROM '.K_TABLE_TESTS.' WHERE test_id='.$test_id.' AND test_repeatable=\'1\' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $sqls = 'SELECT testuser_id FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_user_id='.$user_id.' AND testuser_status>3 ORDER BY testuser_status DESC';
            if ($rs = F_db_query($sqls, $db)) {
                while ($ms = F_db_fetch_array($rs)) {
                    $sqld = 'UPDATE '.K_TABLE_TEST_USER.' SET testuser_status=testuser_status+1 WHERE testuser_id='.$ms['testuser_id'].'';
                    if (!$rd = F_db_query($sqld, $db)) {
                        F_display_db_error();
                    }
                }
            } else {
                F_display_db_error();
            }
        }
    } else {
        F_display_db_error();
    }
}

/**
 * Check if user's IP is valid over test IP range
 * @param $user_ip (int) user's IP address in expanded IPv6 format.
 * @param $test_ips (int) comma separated list of valid test IP addresses. The '*' character may be used to indicate any number in IPv4 addresses. Intervals must be specified using the '-' character.
 * @return true if IP is valid, false otherwise
 */
function F_isValidIP($user_ip, $test_ips)
{
    if (empty($user_ip) or empty($test_ips)) {
        return false;
    }
    // convert user IP to number
    $usrip = getIpAsInt($user_ip);
    // build array of valid IP masks
    $test_ip = explode(',', $test_ips);
    // check user IP against test IP masks
    //while (list($key, $ipmask) = each($test_ip)) {
    foreach ($test_ip as $key => $ipmask) {
        if (strrpos($ipmask, '*') !== false) {
            // old range notation using IPv4 addresses and '*' character.
            $ipv4 = explode('.', $ipmask);
            $ipv4_start = array();
            $ipv4_end = array();
            foreach ($ipv4 as $num) {
                if ($num == '*') {
                    $ipv4_start[] = 0;
                    $ipv4_end[] = 255;
                } else {
                    $num = intval($num);
                    if (($num >= 0) and ($num <= 255)) {
                        $ipv4_start[] = $num;
                        $ipv4_end[] = $num;
                    } else {
                        $ipv4_start[] = 0;
                        $ipv4_end[] = 255;
                    }
                }
            }
            // convert to IPv6 address range
            $ipmask = getNormalizedIP(implode('.', $ipv4_start)).'-'.getNormalizedIP(implode('.', $ipv4_end));
        }
        if (strrpos($ipmask, '-') !== false) {
            // address range
            $ip_range = explode('-', $ipmask);
            if (count($ip_range) !== 2) {
                return false;
            }
            $ip_start = getIpAsInt($ip_range[0]);
            $ip_end = getIpAsInt($ip_range[1]);
            if (($usrip >= $ip_start) and ($usrip <= $ip_end)) {
                return true;
            }
        } elseif ($usrip == getIpAsInt($ipmask)) {
            // exact address comparison
            return true;
        }
    }
    return false;
}


/**
 * Check if user's IP is valid over test IP range
 * @param $test_id (int) Test ID
 * @return true if the client certifiate is valid, false otherwise
 */
function F_isValidSSLCert($test_id)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_authorization.php');
    global $db, $l;
    $test_id = intval($test_id);
    if (F_count_rows(K_TABLE_TEST_SSLCERTS, 'WHERE tstssl_test_id='.$test_id) == 0) {
        // no certificates were selected for this test
        return true;
    }
    // get the hash code for the client SSl certificate
    $client_ssl_hash = F_getSSLClientHash();
    // check if the client certificate is enabled for this test
    if (F_count_rows(
        K_TABLE_TEST_SSLCERTS.', '.K_TABLE_SSLCERTS,
        'WHERE tstssl_ssl_id=ssl_id
			AND tstssl_test_id='.$test_id.'
			AND ssl_hash=\''.$client_ssl_hash.'\'
			LIMIT 1'
    ) > 0) {
        return true;
    }
    return false;
}

/**
 * Check if user is authorized to execute the specified test
 * @param $test_id (int) ID of the selected test
 * @param $user_ip (int) user's IP address.
 * @param $test_ip (int) test IP valid addresses. Various IP addresses may be separated using comma character. The asterisk character may be used to indicate "any number".
 * @return true if is user is authorized, false otherwise
 */
function F_isValidTestUser($test_id, $user_ip, $test_ip)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    // check user's IP
    if (!F_isValidIP($user_ip, $test_ip)) {
        return false;
    }
    // check user's SSL certificate
    if (!F_isValidSSLCert($test_id)) {
        return false;
    }
    // check user's group
    if (F_count_rows(
        K_TABLE_USERGROUP.', '.K_TABLE_TEST_GROUPS,
        'WHERE usrgrp_group_id=tstgrp_group_id
			AND tstgrp_test_id='.$test_id.'
			AND usrgrp_user_id='.$user_id.'
			LIMIT 1'
    ) > 0) {
        return true;
    }
    return false;
}

/**
 * Terminate user's test<br>
 * @param $test_id (int) test ID
 * @since 4.0.000 (2006-09-27)
 */
function F_terminateUserTest($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    $sql = 'UPDATE '.K_TABLE_TEST_USER.'
		SET testuser_status=4
		WHERE testuser_test_id='.$test_id.'
			AND testuser_user_id='.$user_id.'
			AND testuser_status<4';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error();
    }
}

/**
 * Check and returns specific test status for the specified user.<br>
 * @param $user_id (int) user ID
 * @param $test_id (int) test ID
 * @param $duration (int) test duration in seconds
 * @return array of (test_status_code, testuser_id). test_status_code: <ul><li>0 = the test generation process is started but not completed;</li><li>1 = the test has been successfully created;</li><li>2 = all questions have been displayed to the user;</li><li>3 = all questions have been answered;</li><li>4 = test locked (for timeout);</li><li>5 or more = old version of repeated test;</li></ul>
 */
function F_checkTestStatus($user_id, $test_id, $duration)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    // get current date-time
    $current_time = date(K_TIMESTAMP_FORMAT);
    $test_status = 0;
    $user_id = intval($user_id);
    $test_id = intval($test_id);
    $duration = intval($duration);
    $testuser_id = 0;
    // get current test status for the selected user
    $sql = 'SELECT testuser_id, testuser_status, testuser_creation_time
		FROM '.K_TABLE_TEST_USER.'
		WHERE testuser_test_id='.$test_id.'
			AND testuser_user_id='.$user_id.'
		ORDER BY testuser_status
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $testuser_id = $m['testuser_id'];
            $test_status = $m['testuser_status'];
            $endtime = date(K_TIMESTAMP_FORMAT, strtotime($m['testuser_creation_time']) + ($duration * K_SECONDS_IN_MINUTE));
            if (($test_status > 0) and ($test_status < 4) and ($current_time > $endtime)) {
                // update test mode to 4 = test locked (for timeout)
                $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
					SET testuser_status=4
					WHERE testuser_id='.$testuser_id.'';
                if (!$ru = F_db_query($sqlu, $db)) {
                    F_display_db_error();
                } else {
                    // test locked
                    $test_status = 4;
                }
            } else {
                switch ($test_status) {
                    case 0: { // 0 = the test generation process is started but not completed
                        // delete incomplete test (also deletes test logs using database referential integrity)
                        $sqld = 'DELETE FROM '.K_TABLE_TEST_USER.'
							WHERE testuser_id='.$testuser_id.'';
                        if (!$rd = F_db_query($sqld, $db)) {
                            F_display_db_error();
                        }
                        break;
                    }
                    case 1: { // 1 = the test has been successfully created
                        // check if all questions were displayed
                        if (F_count_rows(K_TABLE_TESTS_LOGS, 'WHERE testlog_testuser_id='.$testuser_id.' AND testlog_display_time IS NULL') == 0) {
                            // update test status to 2 = all questions have been displayed to the user
                            $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
								SET testuser_status=2
								WHERE testuser_id='.$testuser_id.'';
                            if (!$ru = F_db_query($sqlu, $db)) {
                                F_display_db_error();
                            } else {
                                $test_status = 2;
                            }
                        }
                        break;
                    }
                    case 2: { // 2 = all questions have been displayed to the user
                        // check if test has been completed in time
                        if (F_count_rows(K_TABLE_TESTS_LOGS, 'WHERE testlog_testuser_id='.$testuser_id.' AND testlog_change_time IS NULL') == 0) {
                            // update test mode to 3 = all questions have been answered
                            $sqlu = 'UPDATE '.K_TABLE_TEST_USER.'
								SET testuser_status=3
								WHERE testuser_id='.$testuser_id.'';
                            if (!$ru = F_db_query($sqlu, $db)) {
                                F_display_db_error();
                            } else {
                                $test_status = 3;
                            }
                        }
                        break;
                    }
                } //end switch
            } //end else
        }
    } else {
        F_display_db_error();
    }
    return array($test_status, $testuser_id);
}

/**
 * Returns XHTML link to open test info popup.
 * @param $test_id (int) test ID
 * @param $link_name (string) link caption
 * return XHTML code
 */
function F_testInfoLink($test_id, $link_name = '')
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $str = '';
    $onclickinfo = 'infoTestWindow=window.open(\'tce_popup_test_info.php?testid='.$test_id.'\'';
    $onclickinfo .= ',\'infoTestWindow\',\'dependent';
    $onclickinfo .= ',height='.K_TEST_INFO_HEIGHT;
    $onclickinfo .= ',width='.K_TEST_INFO_WIDTH;
    $onclickinfo .= ',menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no\');';
    $onclickinfo .= 'return false;';
    //$str .= '<a href="tce_popup_test_info.php?testid='.$test_id.'" onclick="'.$onclickinfo.'" title="'.$l['m_new_window_link'].'">';
    $str .= '<a title="tce_popup_test_info.php?testid='.$test_id.'" title="Link ini akan membuka jendela browser baru">';
    if (strlen($link_name) > 0) {
        //$str .= $link_name;
        $str .= unhtmlentities(strip_tags($link_name));
    } else {
        $str .= 'Informasi';
    }
    $str .= '</a>';
    return $str;
}

/**
 * Returns an XHTML string containing specified test information.
 * @param $test_id (int) test ID
 * @param $showip (boolean) if true display enabled users' IP range
 * @return string containing an XHTML code
 */
function F_printTestInfo($test_id, $showip = false)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    $str = ''; //string to return
    $boolval = array('Tidak', 'Ya');
    //$sql = 'SELECT * FROM '.K_TABLE_TESTS.' WHERE test_id='.$test_id.'';
    $sql = 'SELECT * FROM '.K_TABLE_TESTS.' WHERE test_id='.$test_id.' LIMIT 1';	
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            if (!F_isValidTestUser($test_id, $_SESSION['session_user_ip'], $m['test_ip_range'])) {
                return '';
            }
            $str .= '</div>'.K_NEWLINE;
            $str .= '<div class="container">'.K_NEWLINE;
            $str .= '<div class="tcecontentbox boxshd brad-10 ov-hidden">'.K_NEWLINE;
            $str .= '<div class="loginboxtitle">Informasi Ujian</div>'.K_NEWLINE;
            $str .= '<div class="bg-white ov-hidden">'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Mata Pelajaran</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-fuchsia brad-50 ft-white p-3">'.htmlspecialchars($m['test_name'], ENT_NOQUOTES, 'UTF-8').'</p></div>'.K_NEWLINE;
            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Deskripsi Ujian</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-biru ft-white brad-5 p-3">'.F_decode_tcecode($m['test_description']).'</p></div>'.K_NEWLINE;
            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Durasi Ujian</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-tosca ft-white p-3 brad-50">'./*$l['w_test_time'].$l['h_test_time'].*/$m['test_duration_time'].' menit</p></div>'.K_NEWLINE;
            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Jumlah soal</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-nila ft-white brad-50 p-3">'.$m['test_max_score']/$m['test_score_right'].' butir</p></div>'.K_NEWLINE;

            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Nilai tiap butir soal</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-hijau ft-white brad-50 p-3">'./*$l['w_score_right'].$l['h_score_right'].*/str_replace('.000',',00',$m['test_score_right']).'</p></div>'.K_NEWLINE;

            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Nilai maksimal</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-ungu ft-white brad-50 p-3">'.str_replace('.000','',$m['test_max_score']).'</p></div>'.K_NEWLINE;

            $str .= '</div>'.K_NEWLINE;

            $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
            $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Nilai KKM</p></div><div style="display:table-cell;padding-left:17px"><p class="bg-dark ft-white brad-50 p-3">'./*$l['w_test_score_threshold'].$l['h_test_score_threshold'].*/str_replace('.000',',00',$m['test_score_threshold']).'</p></div>'.K_NEWLINE;

            $str .= '</div>'.K_NEWLINE;
            if ($showip) {
                $str .= F_twoColRow('IP yang berhak', 'Daftar IP yang berhak', $m['test_ip_range']);
            }
	    $str .= '<style>div#toggle-button{display:none}</style>'.K_NEWLINE;
        }
    } else {
        F_display_db_error();
    }
    return $str;
}

/**
 * Returns the test data.
 * @param $test_id (int) test ID.
 * @return array containing test data.
 */
function F_getTestData($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $td = array();
    $sql = 'SELECT *
		FROM '.K_TABLE_TESTS.'
		WHERE test_id='.$test_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        $td = F_db_fetch_assoc($r);
    } else {
        F_display_db_error();
    }
    return $td;
}

/**
 * Returns user data.
 * @param $user_id (int) User ID.
 * @return array containing test data.
 */
function F_getUserData($user_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $user_id = intval($user_id);
    $ud = array();
    $sql = 'SELECT *
		FROM '.K_TABLE_USERS.'
		WHERE user_id='.$user_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        $ud = F_db_fetch_assoc($r);
    } else {
        F_display_db_error();
    }
    return $ud;
}

/**
 * Returns the test password.
 * @param $test_id (int) test ID.
 * @return string test password or empty string in case of error.
 */
function F_getTestPassword($test_id)
{
    $test_id = intval($test_id);
    $td = F_getTestData($test_id);
    return $td['test_password'];
}

/**
 * Returns the test name.
 * @param $test_id (int) test ID.
 * @return string test name or empty string in case of error.
 */
function F_getTestName($test_id)
{
    $test_id = intval($test_id);
    $td = F_getTestData($test_id);
    return $td['test_name'];
}

/**
 * Returns the test duration time in seconds.
 * @param $test_id (int) test ID
 * @return int test duration time in seconds
 */
function F_getTestDuration($test_id)
{
    require_once('../config/tce_config.php');
    $test_id = intval($test_id);
    $td = F_getTestData($test_id);
    return ($td['test_duration_time'] * K_SECONDS_IN_MINUTE);
}

/**
 * Returns the user's test start time in seconds since UNIX epoch (1970-01-01 00:00:00).
 * @param $testuser_id (int) user's test ID
 * @return int start time in seconds
 */
function F_getTestStartTime($testuser_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testuser_id = intval($testuser_id);
    $starttime = 0;
    // select test control row (if any)
    $sql = 'SELECT testuser_creation_time
		FROM '.K_TABLE_TEST_USER.'
		WHERE testuser_id='.$testuser_id.'';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $starttime = strtotime($m['testuser_creation_time']);
        }
    } else {
        F_display_db_error();
    }
    return $starttime;
}

/**
 * Return a formatted XHTML row to display 2 columns data.<br>
 * See CSS classes:<ul>
 * <li>div.row span.label</li>
 * <li>div.row span.formw</li>
 * </ul>
 * @param $label (string) string to display on the left column
 * @param $description (string) string to display on the title attribute of the left column field
 * @param $value (string) string to display on the right column
 * @return string XHTML code
 */
function F_twoColRow($label = "", $description = "", $value = "")
{
    $str = '';
    $str .= '<div class="row">';
    $str .= '<span class="label">';
    $str .= '<span title="'.$description.'">';
    $str .= $label.': ';
    $str .= '</span>';
    $str .= '</span>';
    $str .= '<span class="value">';
    $str .= $value;
    $str .= '</span>';
    $str .= '</div>'.K_NEWLINE;
    return $str;
}

/**
 * Returns true if the current user is authorized to execute the selected test.<br>
 * Generates the test if it's not already generated.
 * @param $test_id (int) test ID.
 * @return true if user is authorized, false otherwise.
 */
function F_executeTest($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    // get current date-time
    $current_time = date(K_TIMESTAMP_FORMAT);
    $test_id = intval($test_id);
    // select the specified test checking if it's valid for the current time
    $sql = 'SELECT test_id, test_ip_range, test_duration_time, test_repeatable
		FROM '.K_TABLE_TESTS.'
		WHERE test_id='.$test_id.'
			AND test_begin_time < \''.$current_time.'\'
			AND test_end_time > \''.$current_time.'\'';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            // check user's authorization
            if (F_isValidTestUser($m['test_id'], $_SESSION['session_user_ip'], $m['test_ip_range'])) {
                // the user's IP is valid, check test status
                list ($test_status, $testuser_id) = F_checkTestStatus($_SESSION['session_user_id'], $m['test_id'], $m['test_duration_time']);
                if (($test_status > 4) and F_getBoolean($m['test_repeatable'])) {
                    // this test can be repeated - create new test session for the current user
                    return F_createTest($test_id, $_SESSION['session_user_id']);
                }
                switch ($test_status) {
                    case 0: { // 0 = test is not yet created
                        // create new test session for the current user
                        return F_createTest($test_id, $_SESSION['session_user_id']);
                        break;
                    }
                    case 1: // 1 = the test has been successfully created
                    case 2: // 2 = all questions have been displayed to the user
                    case 3: { // 3 = all questions have been answered
                        return true;
                        break;
                    }
                    case 4: { // 4 = test locked (for timeout)
                        return false;
                        break;
                    }
                }
            }
        }
    } else {
        F_display_db_error();
    }
    return false;
}

/**
 * Checks if the current user is the right testlog_id owner.<br>
 * This function is used for security reasons.
 * @param $test_id (int) test ID
 * @param $testlog_id (int) test log ID
 * @return boolean TRUE in case of success, FALSE otherwise
 */
function F_isRightTestlogUser($test_id, $testlog_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $testlog_id = intval($testlog_id);
    // check if the current user is the right testlog_id owner
    $sql = 'SELECT testuser_user_id, testuser_test_id
		FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
		WHERE testuser_id=testlog_testuser_id
			AND testlog_id='.$testlog_id.'';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            if (($m['testuser_user_id'] != $_SESSION['session_user_id']) or ($m['testuser_test_id'] != $test_id)) {
                return false;
            }
        } else {
            return false;
        }
    } else {
        F_display_db_error();
    }
    return true;
}

/**
 * Return an array containing answer_id field of selected answers.<br>
 * @param $question_id (int) Question ID.
 * @param $isright (int) Value (0 = false, 1 = true), if non-empty checks for answer_isright value on WHERE clause.
 * @param $ordering (int) Ordering type question (0 = false, 1 = true).
 * @param $limit (int) Maximum number of IDs to return.
 * @param $startindex (int) Array starting index (default = 0).
 * @param $randorder (boolean) If true user random order.
 * @param $ordmode (int) Ordering mode: 0=position; 1=alphabetical; 2=ID.
 * @return array id of selected answers
 */
function F_selectAnswers($question_id, $isright = '', $ordering = false, $limit = 0, $startindex = 0, $randorder = true, $ordmode = 0)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $question_id = intval($question_id);
    $isright = F_escape_sql($db, $isright);
    $limit = intval($limit);
    $answers_ids = array(); // stores answers IDs
    if ($ordering) {
        $randorder = true;
    }
    $sql_order_by = '';
    switch ($ordmode) {
        case 0: {
            $sql_order_by = ' AND answer_position>0 ORDER BY answer_position';
            break;
        }
        case 1: {
            $sql_order_by = ' ORDER BY answer_description';
            break;
        }
        case 2: {
            $sql_order_by = ' ORDER BY answer_id';
            break;
        }
    }
    $sql = 'SELECT answer_id, answer_position
		FROM '.K_TABLE_ANSWERS.'
		WHERE answer_question_id='.$question_id.'
		AND answer_enabled=\'1\'';
    if ($ordering) {
        $sql .= ' AND answer_position>0';
    } elseif (strlen($isright) > 0) {
        // MCSA
        $sql .= ' AND answer_isright=\''.$isright.'\'';
    }
    if ($randorder) {
        $sql .= ' ORDER BY RAND()';
    } else {
        $sql .= $sql_order_by;
    }
    if ($limit > 0) {
        if (K_DATABASE_TYPE == 'ORACLE') {
            $sql = 'SELECT * FROM ('.$sql.') WHERE rownum <= '.$limit.'';
        } else {
            $sql .= ' LIMIT '.$limit.'';
        }
    }
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            if ($randorder or ($ordmode != 0)) {
                if ($ordmode == 2) {
                    // order by ID
                    $answers_ids[$m['answer_id']] = $m['answer_id'];
                } else {
                    // default
                    $answers_ids[$startindex++] = $m['answer_id'];
                }
            } else {
                $answers_ids[$m['answer_position']] = $m['answer_id'];
            }
        }
    } else {
        F_display_db_error(false);
        return false;
    }
    return $answers_ids;
}

/**
 * Add specified answers on tce_tests_logs_answer table.
 * @param $testlog_id (int) testlog ID
 * @param $answers_ids (array) array of answer IDs to add
 * @return boolean true in case of success, false otherwise
 */
function F_addLogAnswersOrig($testlog_id, $answers_ids)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testlog_id = intval($testlog_id);
    $i = 0;
    //while (list($key, $answid) = each($answers_ids)) {
    foreach ($answers_ids as $key => $answid) {
        $i++;
		$sqli = 'INSERT INTO '.K_TABLE_LOG_ANSWER.' (
			logansw_testlog_id,
			logansw_answer_id,
			logansw_selected,
			logansw_order
			) VALUES (
			'.$testlog_id.',
			'.$answid.',
			-1,
			'.$i.'
			)';
		if (!$ri = F_db_query($sqli, $db)) {
			F_display_db_error(false);
			return false;
		}
    }
    return true;
}

function F_addLogAnswers($testlog_id, $answers_ids)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testlog_id = intval($testlog_id);
    $i = 0;
    $ans_data=array();

    //while (list($key, $answid) = each($answers_ids)) {
    foreach ($answers_ids as $key => $answid) {
        $i++;
		$ans_data[] = '('.$testlog_id.', '.$answid.', -1, '.$i.')';
    }
	$ans_data_val = implode(", ", $ans_data);
	$sqli = 'INSERT INTO '.K_TABLE_LOG_ANSWER.' (
			logansw_testlog_id,
			logansw_answer_id,
			logansw_selected,
			logansw_order
			) VALUES '.$ans_data_val;
    if (!$ri = F_db_query($sqli, $db)) {
        F_display_db_error(false);
        return false;
    }
    return true;
}

function F_addLogAnswersAdmin($testlog_id, $answers_ids)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testlog_id = intval($testlog_id);
    $i = 0;
    $ans_data=array();

    //while (list($key, $answid) = each($answers_ids)) {
    foreach ($answers_ids as $key => $answid) {
        $i++;
		$ans_data[] = '('.$testlog_id.', '.$answid.', -1, '.$i.')';
    }
	$ans_data_val = implode(", ", $ans_data);
	$sqli = 'INSERT IGNORE INTO '.K_TABLE_LOG_ANSWER.' (
			logansw_testlog_id,
			logansw_answer_id,
			logansw_selected,
			logansw_order
			) VALUES '.$ans_data_val;
    if (!$ri = F_db_query($sqli, $db)) {
        F_display_db_error(false);
        return false;
    }
    return true;
}

function F_addLogAnswersAdminMIV($arrForAnswer)
{
    require_once('../config/tce_config.php');
    global $db, $l;
	//var_dump($arrForAnswer);
	//die();
	
    //$testlog_id = intval($testlog_id);
    
	$ans_data=array();
	
    //while (list($key, $answid) = each($answers_ids)) {
    foreach ($arrForAnswer as $key => $aFA) {
    $i = 0;    
		//print_r($aFA['answid']);
		//die();
		foreach ($aFA['answid'] as $key => $answid){
			$i++;
			$ans_data[] = '('.$aFA['tlid'].', '.$answid.', -1, '.$i.')';
		}
		//$ans_data[] = array(0 => '(', 1 => $aFA['tlid'], 2 => ', ', 3 => array($aFA['answid']), 4 => -1, 5 => $i, 6 => ')');
		//echo ($aFA['tlid']);
		//echo '<br/>';
		//print_r($aFA['answid']);
		//echo '<br/>';echo '<br/>';echo '<br/>';
    }
	$ans_data_val = implode(", ", $ans_data);
	//echo '<pre>';
	//var_dump($ans_data);
	//echo '</pre>';
	//die();
	$sqli = 'INSERT IGNORE INTO '.K_TABLE_LOG_ANSWER.' (
			logansw_testlog_id,
			logansw_answer_id,
			logansw_selected,
			logansw_order
			) VALUES '.$ans_data_val;
    if (!$ri = F_db_query($sqli, $db)) {
        F_display_db_error(false);
        return false;
    }
    return true;
}

/**
 * Returns the ID of the tce_tests_users table corresponding to a complete test of $test_id type.
 * @param $test_id (int) test ID
 * @return int testuser ID
 */
function F_getFirstTestUser($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    // check if this is the first test creation
    $firsttest = 0;
    $sql = 'SELECT testuser_id
		FROM '.K_TABLE_TEST_USER.'
		WHERE testuser_test_id='.$test_id.'
			AND testuser_status>0
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $firsttest = $m['testuser_id'];
        }
    } else {
        F_display_db_error(false);
    }
    return $firsttest;
}

/**
 * Creates a new tce_tests_logs table entry and returns inserted ID.
 * @param $testuser_id (int) ID of tce_tests_users
 * @param $question_id (int) question ID
 * @param $score (int) score for unanswered questions
 * @param $order (int) question display order
 * @param $num_answers (int) number of alternative answers
 * @return int testlog ID
 */
function F_newTestLog($testuser_id, $question_id, $score, $order, $num_answers = 0)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testuser_id = intval($testuser_id);
    $question_id = intval($question_id);
    $score = floatval($score);
    $sqll = 'INSERT INTO '.K_TABLE_TESTS_LOGS.' (
		testlog_testuser_id,
		testlog_question_id,
		testlog_score,
		testlog_creation_time,
		testlog_reaction_time,
		testlog_order,
		testlog_num_answers
		) VALUES (
		'.$testuser_id.',
		'.$question_id.',
		'.$score.',
		\''.date(K_TIMESTAMP_FORMAT).'\',
		0,
		'.$order.',
		'.$num_answers.'
		)';
    if (!$rl = F_db_query($sqll, $db)) {
        F_display_db_error(false);
        return false;
    }
    // get inserted ID
    return F_db_insert_id($db, K_TABLE_TESTS_LOGS, 'testlog_id');
}

function F_newTestLogAdmin($testuser_id, $question_id, $score, $order, $num_answers = 0)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $testuser_id = intval($testuser_id);
    $question_id = intval($question_id);
    $score = floatval($score);
    $sqll = 'INSERT IGNORE INTO '.K_TABLE_TESTS_LOGS.' (
		testlog_testuser_id,
		testlog_question_id,
		testlog_score,
		testlog_creation_time,
		testlog_reaction_time,
		testlog_order,
		testlog_num_answers
		) VALUES (
		'.$testuser_id.',
		'.$question_id.',
		'.$score.',
		\'0001-01-01 00:00:00\',
		0,
		'.$order.',
		'.$num_answers.'
		)';
    if (!$rl = F_db_query($sqll, $db)) {
        F_display_db_error(false);
        return false;
    }
    // get inserted ID
    return F_db_insert_id($db, K_TABLE_TESTS_LOGS, 'testlog_id');
}

function F_newTestLogAdminMIV($qData)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    /**$testuser_id = intval($testuser_id);
    $question_id = intval($question_id);
    $score = floatval($score);**/
	$values = implode(", ", $qData);
    $sqll = 'INSERT IGNORE INTO '.K_TABLE_TESTS_LOGS.' (
		testlog_id,
		testlog_testuser_id,
		testlog_question_id,
		testlog_score,
		testlog_creation_time,
		testlog_reaction_time,
		testlog_order,
		testlog_num_answers
		) VALUES '.$values;
    if (!$rl = F_db_query($sqll, $db)) {
        F_display_db_error(false);
        return false;
    }
    // get inserted ID
    //return $testlog_last_id;
}


/**
 * Returns false if the number of executed tests is under the limits, true otherwise.
 * @return boolean true/false.
 */
function F_isTestOverLimits()
{
    require_once('../config/tce_config.php');
    if ((K_REMAINING_TESTS !== false) and (K_REMAINING_TESTS <= 0)) {
        return true;
    }
    $now = time();
    $enddate = date(K_TIMESTAMP_FORMAT, $now);
    if (K_MAX_TESTS_DAY !== false) {
        // check day limit (last 24 hours)
        $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_DAY));
        $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
        if ($numtests >= K_MAX_TESTS_DAY) {
            return true;
        }
    }
    if (K_MAX_TESTS_MONTH !== false) {
        // check month limit (last 30 days)
        $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_MONTH));
        $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
        if ($numtests >= K_MAX_TESTS_MONTH) {
            return true;
        }
    }
    if (K_MAX_TESTS_YEAR !== false) {
        // check year limit (last 365 days)
        $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_YEAR));
        $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
        if ($numtests >= K_MAX_TESTS_YEAR) {
            return true;
        }
    }
    return false;
}

/**
 * Returns the number of executed tests on the specified time interval.
 * @param $startdate (string) Star date-time interval.
 * @param $enddate (string) End  date-time interval.
 * @return int number of executed tests.
 */
function F_count_executed_tests($startdate, $enddate)
{
    require_once('../config/tce_config.php');
    if (!empty($startdate)) {
        $startdate_time = strtotime($startdate);
        $startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
    } else {
        $startdate = date('Y').'-01-01 00:00:00';
    }
    if (!empty($enddate)) {
        $enddate_time = strtotime($enddate);
        $enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
    } else {
        $enddate = date('Y').'-12-31 23:59:59';
    }
    return F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
}

/** Insert Violation Logs 
**/
function F_insertViolation()
{
    require_once('../config/tce_config.php');
    global $db;
    $sql = 'INSERT INTO '.K_TABLE_VIO_LOGS.' (user_id, user_name, user_firstname, user_lastname, jurusan, kelas, user_ip, datetime) VALUES (
		'.$_SESSION['session_user_id'].',
		\''.$_SESSION['session_user_name'].'\',
		\''.$_SESSION['print_firstname'].'\',
		\''.$_SESSION['session_user_lastname'].'\',
		\''.$_SESSION['jurusan'].'\',
		\''.$_SESSION['kelas'].'\',
		\''.$_SERVER['REMOTE_ADDR'].'\',
		\''.date("Y-m-d h:m:s").'\'
	)';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error();
    }
}



/**
 * Track generated tests.
 * @param $date (string) date-time when the test was generated.
 */
function F_updateTestuserStat($date)
{
    require_once('../config/tce_config.php');
    global $db;
    $sql = 'INSERT INTO '.K_TABLE_TESTUSER_STAT.' (tus_date) VALUES (\''.$date.'\')';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error();
    }
}

function F_createTestAdmin($test_id, $testdata, $usrgrptest_uid)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    /**if (F_isTestOverLimits()) {
        return false;
    }**/
    $test_id = intval($test_id);
    //$user_id = intval($user_id);
    $firsttest = 0; // id of the firts test of this type
    // get test data
    $test_random_questions_select = F_getBoolean($testdata['test_random_questions_select']);
    $test_random_questions_order = F_getBoolean($testdata['test_random_questions_order']);
    $test_questions_order_mode = intval($testdata['test_questions_order_mode']);
    $test_random_answers_select = F_getBoolean($testdata['test_random_answers_select']);
    $test_random_answers_order = F_getBoolean($testdata['test_random_answers_order']);
    $test_answers_order_mode = intval($testdata['test_answers_order_mode']);
    $random_questions = ($test_random_questions_select or $test_random_questions_order);
    $sql_answer_position = '';
    if (!$test_random_answers_order and ($test_answers_order_mode == 0)) {
        $sql_answer_position = ' AND answer_position>0';
    }
    $sql_questions_order_by = '';
    switch ($test_questions_order_mode) {
        case 0: { // position
            $sql_questions_order_by = ' AND question_position>0 ORDER BY question_position';
            break;
        }
        case 1: { // alphabetic
            $sql_questions_order_by = ' ORDER BY question_description';
            break;
        }
        case 2: { // ID
            $sql_questions_order_by = ' ORDER BY question_id';
            break;
        }
        case 3: { // type
            $sql_questions_order_by = ' ORDER BY question_type';
            break;
        }
        case 4: { // subject ID
            $sql_questions_order_by = ' ORDER BY question_subject_id';
            break;
        }
    }
    // IDs of MCSA questions with more than one correct answer
    $right_answers_mcsa_questions_ids = '';
    // IDs of MCSA questions with more than one wrong answer
    $wrong_answers_mcsa_questions_ids = array();
    // IDs of MCMA questions with more than one answer
    $answers_mcma_questions_ids = array();
    // IDs of ORDER questions with more than one ordering answer
    $answers_order_questions_ids = '';
    
	/**
	// 1. create user's test entry
    // ------------------------------
    $date = '0001-01-01 00:00:00';
    $sql = 'INSERT INTO '.K_TABLE_TEST_USER.' (
		testuser_test_id,
		testuser_user_id,
		testuser_status,
		testuser_creation_time
		) VALUES (
		'.$test_id.',
		'.$user_id.',
		9,
		\''.$date.'\'
		)';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error(false);
        return false;
    } else {
        // get inserted ID
        $testuser_id = F_db_insert_id($db, K_TABLE_TEST_USER, 'testuser_id');
        //F_updateTestuserStat($date);
    }**/
	
    // get ID of first user's test (if exist)
    //$firsttest = F_getFirstTestUser($test_id);
    // select questions
    if ($test_random_questions_select or ($firsttest == 0)) {
        // selected questions IDs
        $selected_questions = '0';
        // 2. for each set of subjects
        // ------------------------------
        $sql = 'SELECT *
			FROM '.K_TABLE_TEST_SUBJSET.'
			WHERE tsubset_test_id='.$test_id.'
			ORDER BY tsubset_type, tsubset_difficulty, tsubset_answers DESC';
        if ($r = F_db_query($sql, $db)) {
            $questions_data = array();
            while ($m = F_db_fetch_array($r)) {
                // 3. select the subjects IDs
                $selected_subjects = '0';
                $sqlt = 'SELECT subjset_subject_id FROM '.K_TABLE_SUBJECT_SET.' WHERE subjset_tsubset_id='.$m['tsubset_id'];
                if ($rt = F_db_query($sqlt, $db)) {
                    while ($mt = F_db_fetch_array($rt)) {
                        $selected_subjects .= ','.$mt['subjset_subject_id'];
                    }
                }
                // 4. select questions
                // ------------------------------
                $sqlq = 'SELECT question_id, question_type, question_difficulty, question_position
					FROM '.K_TABLE_QUESTIONS.'';
                $sqlq .= ' WHERE question_subject_id IN ('.$selected_subjects.')
					AND question_difficulty='.$m['tsubset_difficulty'].'
					AND question_enabled=\'1\'
					AND question_id NOT IN ('.$selected_questions.')';
                if ($m['tsubset_type'] > 0) {
                    $sqlq .= ' AND question_type='.$m['tsubset_type'];
                }
                if ($m['tsubset_type'] == 1) {
                    // (MCSA : Multiple Choice Single Answer) ----------
                    // get questions with the right number of answers
                    if (empty($right_answers_mcsa_questions_ids)) {
                        $right_answers_mcsa_questions_ids = '0';
                        $sqlt = 'SELECT DISTINCT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_isright=\'1\''.$sql_answer_position.'';
                        if ($rt = F_db_query($sqlt, $db)) {
                            while ($mt = F_db_fetch_array($rt)) {
                                $right_answers_mcsa_questions_ids .= ','.$mt['answer_question_id'];
                            }
                        }
                    }
                    $sqlq .= ' AND question_id IN ('.$right_answers_mcsa_questions_ids.')';
                    if ($m['tsubset_answers'] > 0) {
                        if (!isset($wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''])) {
                            $wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''] = '0';
                            $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_isright=\'0\''.$sql_answer_position.' GROUP BY answer_question_id HAVING (COUNT(answer_id)>='.($m['tsubset_answers']-1).')';
                            if ($rt = F_db_query($sqlt, $db)) {
                                while ($mt = F_db_fetch_array($rt)) {
                                    $wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''] .= ','.$mt['answer_question_id'];
                                }
                            }
                        }
                        $sqlq .= ' AND question_id IN ('.$wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''].')';
                    }
                } elseif ($m['tsubset_type'] == 2) {
                    // (MCMA : Multiple Choice Multiple Answers) -------
                    // get questions with the right number of answers
                    if ($m['tsubset_answers'] > 0) {
                        if (!isset($answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''])) {
                            $answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''] = '0';
                            $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\''.$sql_answer_position.' GROUP BY answer_question_id HAVING (COUNT(answer_id)>='.$m['tsubset_answers'].')';
                            if ($rt = F_db_query($sqlt, $db)) {
                                while ($mt = F_db_fetch_array($rt)) {
                                    $answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''] .= ','.$mt['answer_question_id'];
                                }
                            }
                        }
                        $sqlq .= ' AND question_id IN ('.$answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''].')';
                    }
                } elseif ($m['tsubset_type'] == 4) {
                    // ORDERING ----------------------------------------
                    if (empty($answers_order_questions_ids)) {
                        $answers_order_questions_ids = '0';
                        $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_position>0 GROUP BY answer_question_id HAVING (COUNT(answer_id)>1)';
                        if ($rt = F_db_query($sqlt, $db)) {
                            while ($mt = F_db_fetch_array($rt)) {
                                $answers_order_questions_ids .= ','.$mt['answer_question_id'];
                            }
                        }
                    }
                    $sqlq .= ' AND question_id IN ('.$answers_order_questions_ids.')';
                }
                if ($random_questions) {
                    $sqlq .= ' ORDER BY RAND()';
                } else {
                    $sqlq .= $sql_questions_order_by;
                }
                if (K_DATABASE_TYPE == 'ORACLE') {
                    $sqlq = 'SELECT * FROM ('.$sqlq.') WHERE rownum <= '.$m['tsubset_quantity'].'';
                } else {
                    $sqlq .= ' LIMIT '.$m['tsubset_quantity'].'';
                }
                if ($rq = F_db_query($sqlq, $db)) {
                    while ($mq = F_db_fetch_array($rq)) {
                        // store questions data
                        $tmp_data = array(
                            'id' => $mq['question_id'],
                            'type' => $mq['question_type'],
                            'answers' => $m['tsubset_answers'],
                            'score' => ($testdata['test_score_unanswered'] * $mq['question_difficulty'])
                            );
                        if ($random_questions or ($test_questions_order_mode != 0)) {
                            $questions_data[] = $tmp_data;
                        } else {
                            $questions_data[$mq['question_position']] = $tmp_data;
                        }
                        $selected_questions .= ','.$mq['question_id'].'';
                    } // end while select questions
                } else {
                    F_display_db_error(false);
                    return false;
                } // --- end 3
            } // end while for each set of subjects

            // add questions to database
            
			// $sqlmtlid='SELECT MAX(testlog_id) FROM '.K_TABLE_TESTS_LOGS.' LIMIT 1';
			$sqlmtlid='SELECT AUTO_INCREMENT - 1 as CurrentId FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = \''.K_DATABASE_NAME.'\' AND TABLE_NAME = \''.K_TABLE_TESTS_LOGS.'\' LIMIT 1';
			if ($rmtlid = F_db_query($sqlmtlid, $db)) {
				if ($mmtlid = F_db_fetch_array($rmtlid)) {
					$testlog_last_id = $mmtlid[0];
				}
			}
			$qData = array();
			$qAData = array();
			foreach ($usrgrptest_uid as $key => $userdata) {
				// 5. STORE QUESTIONS AND ANSWERS
				// ------------------------------
				if ($random_questions) {
					shuffle($questions_data);
				} else {
					ksort($questions_data);
				}
				$question_order = 0;
				$testuser_id=$userdata['testuser_id'];	
				foreach ($questions_data as $key => $q) {
					$question_order++;
					$testlog_last_id++;
					$qData[] = '('.$testlog_last_id.', '.$testuser_id.', '.$q['id'].', '.$q['score'].', \'0001-01-01 00:00:00\', 0, '.$question_order.', '.$q['answers'].')';
					$qAData[] = array('tlid' => $testlog_last_id, 'qid' => $q['id'], 'qtype' => $q['type'], 'qanswer' => $q['answers'], 'qfirsttest' => $firsttest, 'qtestdata' => $testdata);
				}
			}

			//echo '<pre>';
			//var_dump($qData);
			//echo '</pre><br/><br/>';
			F_newTestLogAdminMIV($qData);
			
			$arrForAnswer=array();
			
				// Add answers
				//F_addQuestionAnswersAdmin($qa['tlid'], $qa['qid'], $qa['qtype'], $qa['qanswer'], $qa['qfirsttest'], $qa['qtestdata'],$arrForAnswer);
				F_addQuestionAnswersAdmin($qAData, $arrForAnswer);
			
			//var_dump($arrForAnswer);
			/**foreach ($arrForAnswer as $key => $aFA) {
				echo $aFA;
			}**/
			//die();
			// add answers
			//F_addLogAnswersAdmin($testlog_id, $answers_ids);
            
        } else {
            F_display_db_error(false);
            return false;
        } // --- end 2
    } else {
        // same questions for all test-takers
        // ---------------------------------------
        $sql = 'SELECT *
			FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
			WHERE question_id=testlog_question_id
				AND testlog_testuser_id='.$firsttest.'';
        if (F_getBoolean($testdata['test_random_questions_order'])) {
            $sql .= ' ORDER BY RAND()';
        } else {
            $sql .= ' ORDER BY testlog_order';
        }
        if ($r = F_db_query($sql, $db)) {
            $question_order = 0;
            while ($m = F_db_fetch_array($r)) {
                $question_order++;
                // copy values to new user test
                $question_unanswered_score = $testdata['test_score_unanswered'] * $m['question_difficulty'];
                $testlog_id = F_newTestLogAdmin($testuser_id, $m['testlog_question_id'], $question_unanswered_score, $question_order, $m['testlog_num_answers']);
                // Add answers
                if (!F_addQuestionAnswersAdmin($testlog_id, $m['question_id'], $m['question_type'], $m['testlog_num_answers'], $firsttest, $testdata)) {
                    return false;
                }
            }
        } else {
            F_display_db_error(false);
            return false;
        }
    }
    // 6. update user's test status as 9 = the test has been successfully created
    // ------------------------------
    /**$sql = 'UPDATE '.K_TABLE_TEST_USER.' SET
		testuser_status=9,
		testuser_creation_time=\'0001-01-01 00:00:00\'
		WHERE testuser_id='.$testuser_id.'';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error(false);
        return false;
    }**/
    return true;
}


/**
 * Create user's test and returns TRUE on success.
 * @param $test_id (int) test ID.
 * @param $user_id (int) user ID.
 * @return boolean TRUE in case of success, FALSE otherwise.
 */
function F_createTest($test_id, $user_id)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    if (F_isTestOverLimits()) {
        return false;
    }
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $firsttest = 0; // id of the firts test of this type
    // get test data
    $testdata = F_getTestData($test_id);
    $test_random_questions_select = F_getBoolean($testdata['test_random_questions_select']);
    $test_random_questions_order = F_getBoolean($testdata['test_random_questions_order']);
    $test_questions_order_mode = intval($testdata['test_questions_order_mode']);
    $test_random_answers_select = F_getBoolean($testdata['test_random_answers_select']);
    $test_random_answers_order = F_getBoolean($testdata['test_random_answers_order']);
    $test_answers_order_mode = intval($testdata['test_answers_order_mode']);
    $random_questions = ($test_random_questions_select or $test_random_questions_order);
    $sql_answer_position = '';
    if (!$test_random_answers_order and ($test_answers_order_mode == 0)) {
        $sql_answer_position = ' AND answer_position>0';
    }
    $sql_questions_order_by = '';
    switch ($test_questions_order_mode) {
        case 0: { // position
            $sql_questions_order_by = ' AND question_position>0 ORDER BY question_position';
            break;
        }
        case 1: { // alphabetic
            $sql_questions_order_by = ' ORDER BY question_description';
            break;
        }
        case 2: { // ID
            $sql_questions_order_by = ' ORDER BY question_id';
            break;
        }
        case 3: { // type
            $sql_questions_order_by = ' ORDER BY question_type';
            break;
        }
        case 4: { // subject ID
            $sql_questions_order_by = ' ORDER BY question_subject_id';
            break;
        }
    }
    // IDs of MCSA questions with more than one correct answer
    $right_answers_mcsa_questions_ids = '';
    // IDs of MCSA questions with more than one wrong answer
    $wrong_answers_mcsa_questions_ids = array();
    // IDs of MCMA questions with more than one answer
    $answers_mcma_questions_ids = array();
    // IDs of ORDER questions with more than one ordering answer
    $answers_order_questions_ids = '';
    // 1. create user's test entry
    // ------------------------------
    $date = date(K_TIMESTAMP_FORMAT);
    $sql = 'INSERT INTO '.K_TABLE_TEST_USER.' (
		testuser_test_id,
		testuser_user_id,
		testuser_status,
		testuser_creation_time
		) VALUES (
		'.$test_id.',
		'.$user_id.',
		0,
		\''.$date.'\'
		)';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error(false);
        return false;
    } else {
        // get inserted ID
        $testuser_id = F_db_insert_id($db, K_TABLE_TEST_USER, 'testuser_id');
        F_updateTestuserStat($date);
    }
    // get ID of first user's test (if exist)
    $firsttest = F_getFirstTestUser($test_id);
    // select questions
    if ($test_random_questions_select or ($firsttest == 0)) {
        // selected questions IDs
        $selected_questions = '0';
        // 2. for each set of subjects
        // ------------------------------
        $sql = 'SELECT *
			FROM '.K_TABLE_TEST_SUBJSET.'
			WHERE tsubset_test_id='.$test_id.'
			ORDER BY tsubset_type, tsubset_difficulty, tsubset_answers DESC';
        if ($r = F_db_query($sql, $db)) {
            $questions_data = array();
            while ($m = F_db_fetch_array($r)) {
                // 3. select the subjects IDs
                $selected_subjects = '0';
                $sqlt = 'SELECT subjset_subject_id FROM '.K_TABLE_SUBJECT_SET.' WHERE subjset_tsubset_id='.$m['tsubset_id'];
                if ($rt = F_db_query($sqlt, $db)) {
                    while ($mt = F_db_fetch_array($rt)) {
                        $selected_subjects .= ','.$mt['subjset_subject_id'];
                    }
                }
                // 4. select questions
                // ------------------------------
                $sqlq = 'SELECT question_id, question_type, question_difficulty, question_position
					FROM '.K_TABLE_QUESTIONS.'';
                $sqlq .= ' WHERE question_subject_id IN ('.$selected_subjects.')
					AND question_difficulty='.$m['tsubset_difficulty'].'
					AND question_enabled=\'1\'
					AND question_id NOT IN ('.$selected_questions.')';
                if ($m['tsubset_type'] > 0) {
                    $sqlq .= ' AND question_type='.$m['tsubset_type'];
                }
                if ($m['tsubset_type'] == 1) {
                    // (MCSA : Multiple Choice Single Answer) ----------
                    // get questions with the right number of answers
                    if (empty($right_answers_mcsa_questions_ids)) {
                        $right_answers_mcsa_questions_ids = '0';
                        $sqlt = 'SELECT DISTINCT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_isright=\'1\''.$sql_answer_position.'';
                        if ($rt = F_db_query($sqlt, $db)) {
                            while ($mt = F_db_fetch_array($rt)) {
                                $right_answers_mcsa_questions_ids .= ','.$mt['answer_question_id'];
                            }
                        }
                    }
                    $sqlq .= ' AND question_id IN ('.$right_answers_mcsa_questions_ids.')';
                    if ($m['tsubset_answers'] > 0) {
                        if (!isset($wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''])) {
                            $wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''] = '0';
                            $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_isright=\'0\''.$sql_answer_position.' GROUP BY answer_question_id HAVING (COUNT(answer_id)>='.($m['tsubset_answers']-1).')';
                            if ($rt = F_db_query($sqlt, $db)) {
                                while ($mt = F_db_fetch_array($rt)) {
                                    $wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''] .= ','.$mt['answer_question_id'];
                                }
                            }
                        }
                        $sqlq .= ' AND question_id IN ('.$wrong_answers_mcsa_questions_ids['\''.$m['tsubset_answers'].'\''].')';
                    }
                } elseif ($m['tsubset_type'] == 2) {
                    // (MCMA : Multiple Choice Multiple Answers) -------
                    // get questions with the right number of answers
                    if ($m['tsubset_answers'] > 0) {
                        if (!isset($answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''])) {
                            $answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''] = '0';
                            $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\''.$sql_answer_position.' GROUP BY answer_question_id HAVING (COUNT(answer_id)>='.$m['tsubset_answers'].')';
                            if ($rt = F_db_query($sqlt, $db)) {
                                while ($mt = F_db_fetch_array($rt)) {
                                    $answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''] .= ','.$mt['answer_question_id'];
                                }
                            }
                        }
                        $sqlq .= ' AND question_id IN ('.$answers_mcma_questions_ids['\''.$m['tsubset_answers'].'\''].')';
                    }
                } elseif ($m['tsubset_type'] == 4) {
                    // ORDERING ----------------------------------------
                    if (empty($answers_order_questions_ids)) {
                        $answers_order_questions_ids = '0';
                        $sqlt = 'SELECT answer_question_id FROM '.K_TABLE_ANSWERS.' WHERE answer_enabled=\'1\' AND answer_position>0 GROUP BY answer_question_id HAVING (COUNT(answer_id)>1)';
                        if ($rt = F_db_query($sqlt, $db)) {
                            while ($mt = F_db_fetch_array($rt)) {
                                $answers_order_questions_ids .= ','.$mt['answer_question_id'];
                            }
                        }
                    }
                    $sqlq .= ' AND question_id IN ('.$answers_order_questions_ids.')';
                }
                if ($random_questions) {
                    $sqlq .= ' ORDER BY RAND()';
                } else {
                    $sqlq .= $sql_questions_order_by;
                }
                if (K_DATABASE_TYPE == 'ORACLE') {
                    $sqlq = 'SELECT * FROM ('.$sqlq.') WHERE rownum <= '.$m['tsubset_quantity'].'';
                } else {
                    $sqlq .= ' LIMIT '.$m['tsubset_quantity'].'';
                }
                if ($rq = F_db_query($sqlq, $db)) {
                    while ($mq = F_db_fetch_array($rq)) {
                        // store questions data
                        $tmp_data = array(
                            'id' => $mq['question_id'],
                            'type' => $mq['question_type'],
                            'answers' => $m['tsubset_answers'],
                            'score' => ($testdata['test_score_unanswered'] * $mq['question_difficulty'])
                            );
                        if ($random_questions or ($test_questions_order_mode != 0)) {
                            $questions_data[] = $tmp_data;
                        } else {
                            $questions_data[$mq['question_position']] = $tmp_data;
                        }
                        $selected_questions .= ','.$mq['question_id'].'';
                    } // end while select questions
                } else {
                    F_display_db_error(false);
                    return false;
                } // --- end 3
            } // end while for each set of subjects
            // 5. STORE QUESTIONS AND ANSWERS
            // ------------------------------
            if ($random_questions) {
                shuffle($questions_data);
            } else {
                ksort($questions_data);
            }
            // add questions to database
            $question_order = 0;
            foreach ($questions_data as $key => $q) {
                $question_order++;
                $testlog_id = F_newTestLog($testuser_id, $q['id'], $q['score'], $question_order, $q['answers']);
                // Add answers
                if (!F_addQuestionAnswers($testlog_id, $q['id'], $q['type'], $q['answers'], $firsttest, $testdata)) {
                    return false;
                }
            }
        } else {
            F_display_db_error(false);
            return false;
        } // --- end 2
    } else {
        // same questions for all test-takers
        // ---------------------------------------
        $sql = 'SELECT *
			FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
			WHERE question_id=testlog_question_id
				AND testlog_testuser_id='.$firsttest.'';
        if (F_getBoolean($testdata['test_random_questions_order'])) {
            $sql .= ' ORDER BY RAND()';
        } else {
            $sql .= ' ORDER BY testlog_order';
        }
        if ($r = F_db_query($sql, $db)) {
            $question_order = 0;
            while ($m = F_db_fetch_array($r)) {
                $question_order++;
                // copy values to new user test
                $question_unanswered_score = $testdata['test_score_unanswered'] * $m['question_difficulty'];
                $testlog_id = F_newTestLog($testuser_id, $m['testlog_question_id'], $question_unanswered_score, $question_order, $m['testlog_num_answers']);
                // Add answers
                if (!F_addQuestionAnswers($testlog_id, $m['question_id'], $m['question_type'], $m['testlog_num_answers'], $firsttest, $testdata)) {
                    return false;
                }
            }
        } else {
            F_display_db_error(false);
            return false;
        }
    }
    // 6. update user's test status as 1 = the test has been successfully created
    // ------------------------------
    $sql = 'UPDATE '.K_TABLE_TEST_USER.' SET
		testuser_status=1,
		testuser_creation_time=\''.date(K_TIMESTAMP_FORMAT).'\'
		WHERE testuser_id='.$testuser_id.'';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error(false);
        return false;
    }
    return true;
}

/**
 * Add answers to selected question.
 * @param $testlog_id (int) testlog ID.
 * @param $question_id (int) question ID.
 * @param $question_type (int) type of question.
 * @param $num_answers (int) number of alternative answers to display.
 * @param $firsttest (int) ID of first test testuser_id.
 * @param $testdata (array) array of test data.
 * @return boolean TRUE in case of success, FALSE otherwise.
 */
function F_addQuestionAnswers($testlog_id, $question_id, $question_type, $num_answers, $firsttest, $testdata)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    if ($question_type == 3) {
        // free text question
        return true;
    }
    $randorder = F_getBoolean($testdata['test_random_answers_order']);
    $ordmode = intval($testdata['test_answers_order_mode']);
    // for each question
    if (F_getBoolean($testdata['test_random_questions_select']) or F_getBoolean($testdata['test_random_answers_select']) or ($firsttest == 0)) {
            $answers_ids = array(); // array used to store answers IDs
        switch ($question_type) {
            case 1: { // MCSA
                // select first right answer
                $answers_ids += F_selectAnswers($question_id, 1, false, 1, 0, $randorder, $ordmode);
                // select remaining answers
                $answers_ids += F_selectAnswers($question_id, 0, false, ($num_answers - 1), 1, $randorder, $ordmode);
                if ($ordmode == 1) {
                    // reorder answers alphabetically
                    $sql = 'SELECT answer_id FROM '.K_TABLE_ANSWERS.' WHERE answer_id IN ('.implode(',', $answers_ids).') ORDER BY answer_description';
                    $answers_ids = array();
                    if ($r = F_db_query($sql, $db)) {
                        while ($m = F_db_fetch_array($r)) {
                            $answers_ids[] = $m['answer_id'];
                        }
                    } else {
                        F_display_db_error(false);
                        return false;
                    }
                }
                break;
            }
            case 2: { // MCMA
                // select answers
                $answers_ids += F_selectAnswers($question_id, '', false, $num_answers, 0, $randorder, $ordmode);
                break;
            }
            case 4: { // ORDERING
                // select answers
                $randorder = true;
                $answers_ids += F_selectAnswers($question_id, '', true, 0, 0, $randorder, $ordmode);
                break;
            }
        }
            // randomizes the order of the answers
        if ($randorder) {
            shuffle($answers_ids);
        } else {
            ksort($answers_ids);
        }
            // add answers
            F_addLogAnswers($testlog_id, $answers_ids);
    } else {
        // same answers for all test-takers
        // --------------------------------
        $sql = 'SELECT logansw_answer_id
			FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_TESTS_LOGS.'
			WHERE logansw_testlog_id=testlog_id
				AND testlog_testuser_id='.$firsttest.'
				AND testlog_question_id='.$question_id.'';
        if ($randorder) {
            $sql .= ' ORDER BY RAND()';
        } else {
            $sql .= ' ORDER BY logansw_order';
        }
        if ($r = F_db_query($sql, $db)) {
            $answers_ids = array();
            while ($m = F_db_fetch_array($r)) {
                $answers_ids[] = $m['logansw_answer_id'];
            }
            F_addLogAnswers($testlog_id, $answers_ids);
        } else {
            F_display_db_error(false);
            return false;
        }
    }
    return true;
}

function F_addQuestionAnswersAdmin($qAData, $arrForAnswer)
{
	require_once('../config/tce_config.php');
    global $db, $l;
foreach ($qAData as $key => $qa) {
	$testlog_id=$qa['tlid'];
	$question_id=$qa['qid'];
	$question_type=$qa['qtype'];
	$num_answers=$qa['qanswer'];
	$testdata=$qa['qtestdata'];
	$firsttest=$qa['qfirsttest'];
    //echo $question_type.'<br/>';
	
    /**if ($question_type == 3) {
        // free text question
        return true;
    }**/
    $randorder = F_getBoolean($testdata['test_random_answers_order']);
    $ordmode = intval($testdata['test_answers_order_mode']);
    // for each question
    if (F_getBoolean($testdata['test_random_questions_select']) or F_getBoolean($testdata['test_random_answers_select']) or ($firsttest == 0)) {
            $answers_ids = array(); // array used to store answers IDs
        switch ($question_type) {
            case 1: { // MCSA
                // select first right answer
                $answers_ids += F_selectAnswers($question_id, 1, false, 1, 0, $randorder, $ordmode);
                // select remaining answers
                $answers_ids += F_selectAnswers($question_id, 0, false, ($num_answers - 1), 1, $randorder, $ordmode);
                if ($ordmode == 1) {
                    // reorder answers alphabetically
                    $sql = 'SELECT answer_id FROM '.K_TABLE_ANSWERS.' WHERE answer_id IN ('.implode(',', $answers_ids).') ORDER BY answer_description';
                    $answers_ids = array();
                    if ($r = F_db_query($sql, $db)) {
                        while ($m = F_db_fetch_array($r)) {
                            $answers_ids[] = $m['answer_id'];
                        }
                    } else {
                        F_display_db_error(false);
                        return false;
                    }
                }
                break;
            }
            case 2: { // MCMA
                // select answers
                $answers_ids += F_selectAnswers($question_id, '', false, $num_answers, 0, $randorder, $ordmode);
                break;
            }
            case 4: { // ORDERING
                // select answers
                $randorder = true;
                $answers_ids += F_selectAnswers($question_id, '', true, 0, 0, $randorder, $ordmode);
                break;
            }
        }
            // randomizes the order of the answers
			
				
				//echo $qa['tlid']."<br/>";
				if ($randorder) {
					shuffle($answers_ids);
				} else {
					ksort($answers_ids);
				}
				
			$arrForAnswer[]=array('tlid' => $testlog_id,'answid' => $answers_ids);
			//return $arrForAnswer;
			//echo '<pre>';
			//var_dump($arrForAnswer);
			//echo '</pre>';
    } else {
        // same answers for all test-takers
        // --------------------------------
        $sql = 'SELECT logansw_answer_id
			FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_TESTS_LOGS.'
			WHERE logansw_testlog_id=testlog_id
				AND testlog_testuser_id='.$firsttest.'
				AND testlog_question_id='.$question_id.'';
        if ($randorder) {
            $sql .= ' ORDER BY RAND()';
        } else {
            $sql .= ' ORDER BY logansw_order';
        }
        if ($r = F_db_query($sql, $db)) {
            $answers_ids = array();
            while ($m = F_db_fetch_array($r)) {
                $answers_ids[] = $m['logansw_answer_id'];
            }
            F_addLogAnswersAdmin($testlog_id, $answers_ids);
        } else {
            F_display_db_error(false);
            return false;
        }
    }
}
//var_dump($arrForAnswer);
F_addLogAnswersAdminMIV($arrForAnswer);
return true;
}

/**
 * Updates question log data (register user's answers and calculate scores).
 * @param $test_id (int) test ID
 * @param $testlog_id (int) test log ID
 * @param $answpos (array) Array of answer positions
 * @param $answer_text (string) answer text
 * @param $reaction_time (int) reaction time in milliseconds
 * @return boolean TRUE in case of success, FALSE otherwise
 */
function F_updateQuestionLog($test_id, $testlog_id, $answpos = array(), $answer_text = '', $reaction_time = 0, $ragu)
{
//    echo $test_id."<br/>".$testlog_id."<br/>".$answpos."<br/>".$answer_tex."<br/>".$reaction_time."<br/>".$ragu;
//	die();

    require_once('../config/tce_config.php');
    global $db, $l;
    $question_id = 0; // question ID
    $question_type = 3; // question type
    $question_difficulty = 1; // question difficulty
    $oldtext = ''; // old text answer
    $answer_changed = false; // true when answer change
    $answer_score = 0; // answer total score
    $num_answers = 0; // counts alternative answers
    $test_id = intval($test_id);
    $testlog_id = intval($testlog_id);
    $unanswered = true;
    $answer_id = F_getAnswerIdFromPosition($testlog_id, $answpos);
    // get test data
    $testdata = F_getTestData($test_id);
    // get question information
    $sql = 'SELECT *
		FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
		WHERE testlog_question_id=question_id
			AND testlog_id='.$testlog_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            // get previous answer text
            $oldtext = $m['testlog_answer_text'];
            $question_id = $m['question_id'];
            $question_type = $m['question_type'];
            $question_difficulty = $m['question_difficulty'];
	    $ragu_dbval = $m['ragu'];

	   // if($ragu=='fromdb'){
	//	$ragu=$m['ragu'];
	  //  }

	    if($ragu_dbval != $ragu){
		$ragu_change = true;
	    }else{
		$ragu_change = false;
	    }
        }
    } else {
        F_display_db_error();
        return false;
    }
    // calculate question score
    $question_right_score = $testdata['test_score_right'] * $question_difficulty;
    $question_wrong_score = $testdata['test_score_wrong'] * $question_difficulty;
    $question_unanswered_score = $testdata['test_score_unanswered'] * $question_difficulty;
    if ($question_type != 3) {
        $sql = 'SELECT *
			FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_ANSWERS.'
			WHERE logansw_answer_id=answer_id
				AND logansw_testlog_id='.$testlog_id.'
			ORDER BY logansw_order';
        if ($r = F_db_query($sql, $db)) {
            while (($m = F_db_fetch_array($r))) {
                $num_answers++;
                // update each answer
                $sqlu = 'UPDATE '.K_TABLE_LOG_ANSWER.' SET';
                switch ($question_type) {
                    case 1: {
                        // MCSA - Multiple Choice Single Answer
                        if (empty($answer_id)) {
                            // unanswered
                            $answer_score = $question_unanswered_score;
                            if ($m['logansw_selected'] != -1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1';
                        } elseif (!empty($answer_id[$m['logansw_answer_id']])) {
                            $unanswered = false;
							
                            // selected
                            if (F_getBoolean($m['answer_isright'])) {
                                // $answer_score = $question_right_score;
								if($m['answer_weight']!=0){
                                	$answer_score = $m['answer_weight']/100*$question_right_score;
								}else{
									$answer_score = 100/100*$question_right_score;
								}
                            } else {
                                // $answer_score = $question_wrong_score;
								if($m['answer_weight']!=0){
									$answer_score = $m['answer_weight']/100*$question_right_score;
								}else{
									$answer_score = 0/100*$question_right_score;
								}
                            }
							
                            if ($m['logansw_selected'] != 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=1';

                        } else {
                            $unanswered = false;
                            // unselected
                            if ($m['logansw_selected'] == 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0 ';

                        }
                        break;
                    }
                    case 2: {
                        // MCMA - Multiple Choice Multiple Answer
                        if (isset($answer_id[$m['logansw_answer_id']])) {
                            // radiobutton or selected checkbox
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == -1) {
                                // unanswered
                                $answer_score += $question_unanswered_score;
                            } elseif (F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 1)) {
                                // right (selected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } elseif (!F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 0)) {
                                // right (unselected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } else {
                                // wrong
                                $unanswered = false;
                                $answer_score += $question_wrong_score;
                            }
                            if ($m['logansw_selected'] != $answer_id[$m['logansw_answer_id']]) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected='.$answer_id[$m['logansw_answer_id']].'';
                        } else {
                            // unselected checkbox
                            $unanswered = false;
                            if (F_getBoolean($m['answer_isright'])) {
                                $answer_score += $question_wrong_score;
                            } else {
                                $answer_score += $question_right_score;
                            }
                            if ($m['logansw_selected'] != 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0';
                        }
                        break;
                    }
                    case 4: {
                        // ORDER
                        if (!empty($answer_id[$m['logansw_answer_id']])) {
                            // selected
                            $unanswered = false;
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == $m['answer_position']) {
                                $answer_score += $question_right_score;
                            } else {
                                $answer_score += $question_wrong_score;
                            }
                            if ($answer_id[$m['logansw_answer_id']] != $m['logansw_position']) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_position='.$answer_id[$m['logansw_answer_id']].', logansw_selected=1';
                        } else {
                            // unanswered
                            $answer_score += $question_unanswered_score;
                            if ($m['logansw_position'] > 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1, logansw_position=0';
                        }
                        break;
                    }
                } // end of switch
                $sqlu .= ' WHERE logansw_testlog_id='.$testlog_id.' AND logansw_answer_id='.$m['logansw_answer_id'].'';
                if (!$ru = F_db_query($sqlu, $db)) {
                    F_display_db_error();
                    return false;
                }
            }
            if ($question_type > 1) {
                // normalize score
                if (F_getBoolean($testdata['test_mcma_partial_score'])) {
                    // use partial scoring for MCMA and ORDER questions
                    $answer_score = round(($answer_score / $num_answers), 3);
                } else {
                    // all-or-nothing points
                    if ($answer_score >= ($question_right_score * $num_answers)) {
                        // right
                        $answer_score = $question_right_score;
                    } elseif ($answer_score == ($question_unanswered_score * $num_answers)) {
                        // unanswered
                        $answer_score = $question_unanswered_score;
                    } else {
                        // wrong
                        $answer_score = $question_wrong_score;
                    }
                }
            }
        } else {
            F_display_db_error();
            return false;
        }
    }
    // update log if answer is changed
    if ($answer_changed or ($oldtext != $answer_text) or $ragu_change) {
        if (strlen($answer_text) > 0) {
            $unanswered = false;
            $answer_score = 'NULL';
            // check exact answers score
            $sql = 'SELECT *
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_question_id='.$question_id.'
					AND answer_enabled=\'1\'
					AND answer_isright=\'1\'';
            if ($r = F_db_query($sql, $db)) {
                while ($m = F_db_fetch_array($r)) {
                    if ((K_SHORT_ANSWERS_BINARY and (strcmp(trim($answer_text), $m['answer_description']) == 0))
                        or (!K_SHORT_ANSWERS_BINARY and (strcasecmp(trim($answer_text), $m['answer_description']) == 0))) {
                        $answer_score += $question_right_score;
                        break;
                    }
                }
            } else {
                F_display_db_error();
                return false;
            }
        }
        if ($unanswered) {
            $change_time = '';
        } else {
            $change_time = date(K_TIMESTAMP_FORMAT);
        }
        $sqlu = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET';
        $sqlu .= ' testlog_answer_text='.htmlentities(F_empty_to_null($answer_text)).',';
        $sqlu .= ' testlog_score='.$answer_score.',';
        $sqlu .= ' testlog_change_time='.F_empty_to_null($change_time).',';
        $sqlu .= ' testlog_reaction_time='.intval($reaction_time).',';
        $sqlu .= ' testlog_user_ip=\''.getNormalizedIP($_SERVER['REMOTE_ADDR']).'\',';
	$sqlu .= ' ragu=\''.$ragu.'\'';
        $sqlu .= ' WHERE testlog_id='.$testlog_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
            return false;
        }
    }
    return true;
}


/**
 * Updates question log data (register user's answers and calculate scores).
 * @param $test_id (int) test ID
 * @param $testlog_id (int) test log ID
 * @param $answpos (array) Array of answer positions
 * @param $answer_text (string) answer text
 * @param $reaction_time (int) reaction time in milliseconds
 * @return boolean TRUE in case of success, FALSE otherwise
 */
function F_updateQuestionLogRegrade($test_id, $testlog_id, $answpos = array(), $answer_text = '', $reaction_time = 0, $ragu)
{
//print_r($answpos);
//echo $test_id."<br/>".$testlog_id."<br/>".$answpos."<br/>".$answer_tex."<br/>".$reaction_time."<br/>".$ragu;
//	die();

    require_once('../config/tce_config.php');
    global $db, $l;
    $question_id = 0; // question ID
    $question_type = 3; // question type
    $question_difficulty = 1; // question difficulty
    $oldtext = ''; // old text answer
    $answer_changed = true; // true when answer change
    $answer_score = 0; // answer total score
    $num_answers = 0; // counts alternative answers
    $test_id = intval($test_id);
    $testlog_id = intval($testlog_id);
    $unanswered = true;
    $answer_id = F_getAnswerIdFromPosition($testlog_id, $answpos);
    // get test data
    $testdata = F_getTestData($test_id);
    // get question information
    $sql = 'SELECT *
		FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
		WHERE testlog_question_id=question_id
			AND testlog_id='.$testlog_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            // get previous answer text
            $oldtext = $m['testlog_answer_text'];
            $question_id = $m['question_id'];
            $question_type = $m['question_type'];
            $question_difficulty = $m['question_difficulty'];
	    $ragu_dbval = $m['ragu'];

	   // if($ragu=='fromdb'){
	//	$ragu=$m['ragu'];
	  //  }

	    if($ragu_dbval != $ragu){
		$ragu_change = true;
	    }else{
		$ragu_change = false;
	    }
        }
    } else {
        F_display_db_error();
        return false;
    }
    // calculate question score
    $question_right_score = $testdata['test_score_right'] * $question_difficulty;
    $question_wrong_score = $testdata['test_score_wrong'] * $question_difficulty;
    $question_unanswered_score = $testdata['test_score_unanswered'] * $question_difficulty;
//	echo $question_right_score.'-'.$question_wrong_score.'-'.$question_unanswered_score.'<br/>';
	//die();
    if ($question_type != 3) {
        $sql = 'SELECT *
			FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_ANSWERS.'
			WHERE logansw_answer_id=answer_id
				AND logansw_testlog_id='.$testlog_id.'
			ORDER BY logansw_order';
        if ($r = F_db_query($sql, $db)) {
            while (($m = F_db_fetch_array($r))) {
                $num_answers++;
                // update each answer
                $sqlu = 'UPDATE '.K_TABLE_LOG_ANSWER.' SET';
                switch ($question_type) {
                    case 1: {
                        // MCSA - Multiple Choice Single Answer
                        if (empty($answer_id)) {
                            // unanswered
                            $answer_score = $question_unanswered_score;
                            if ($m['logansw_selected'] != -1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1 ';

                        } elseif (!empty($answer_id[$m['logansw_answer_id']])) {
                            $unanswered = false;
                            // selected
                            if (F_getBoolean($m['answer_isright'])) {
                                $answer_score = $question_right_score;
//				echo $m['answer_explanation'];
                            } else {
                                $answer_score = $question_wrong_score;
//				echo $m['answer_explanation'];
                            }
                            if ($m['logansw_selected'] != 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=1 ';

                        } else {
                            $unanswered = false;
                            // unselected
                            if ($m['logansw_selected'] == 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0 ';

                        }
                        break;
                    }
                    case 2: {
                        // MCMA - Multiple Choice Multiple Answer
                        if (isset($answer_id[$m['logansw_answer_id']])) {
                            // radiobutton or selected checkbox
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == -1) {
                                // unanswered
                                $answer_score += $question_unanswered_score;
                            } elseif (F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 1)) {
                                // right (selected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } elseif (!F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 0)) {
                                // right (unselected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } else {
                                // wrong
                                $unanswered = false;
                                $answer_score += $question_wrong_score;
                            }
                            if ($m['logansw_selected'] != $answer_id[$m['logansw_answer_id']]) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected='.$answer_id[$m['logansw_answer_id']].'';
                        } else {
                            // unselected checkbox
                            $unanswered = false;
                            if (F_getBoolean($m['answer_isright'])) {
                                $answer_score += $question_wrong_score;
                            } else {
                                $answer_score += $question_right_score;
                            }
                            if ($m['logansw_selected'] != 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0';
                        }
                        break;
                    }
                    case 4: {
                        // ORDER
                        if (!empty($answer_id[$m['logansw_answer_id']])) {
                            // selected
                            $unanswered = false;
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == $m['answer_position']) {
                                $answer_score += $question_right_score;
                            } else {
                                $answer_score += $question_wrong_score;
                            }
                            if ($answer_id[$m['logansw_answer_id']] != $m['logansw_position']) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_position='.$answer_id[$m['logansw_answer_id']].', logansw_selected=1';
                        } else {
                            // unanswered
                            $answer_score += $question_unanswered_score;
                            if ($m['logansw_position'] > 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1, logansw_position=0';
                        }
                        break;
                    }
                } // end of switch
                $sqlu .= ' WHERE logansw_testlog_id='.$testlog_id.' AND logansw_answer_id='.$m['logansw_answer_id'].'';
                if (!$ru = F_db_query($sqlu, $db)) {
                    F_display_db_error();
                    return false;
                }
            }
            if ($question_type > 1) {
                // normalize score
                if (F_getBoolean($testdata['test_mcma_partial_score'])) {
                    // use partial scoring for MCMA and ORDER questions
                    $answer_score = round(($answer_score / $num_answers), 3);
                } else {
                    // all-or-nothing points
                    if ($answer_score >= ($question_right_score * $num_answers)) {
                        // right
                        $answer_score = $question_right_score;
                    } elseif ($answer_score == ($question_unanswered_score * $num_answers)) {
                        // unanswered
                        $answer_score = $question_unanswered_score;
                    } else {
                        // wrong
                        $answer_score = $question_wrong_score;
                    }
                }
            }
        } else {
            F_display_db_error();
            return false;
        }
    }
    // update log if answer is changed
    if ($answer_changed or ($oldtext != $answer_text) or $ragu_change) {
        if (strlen($answer_text) > 0) {
            $unanswered = false;
            $answer_score = 'NULL';
            // check exact answers score
            $sql = 'SELECT *
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_question_id='.$question_id.'
					AND answer_enabled=\'1\'
					AND answer_isright=\'1\'';
            if ($r = F_db_query($sql, $db)) {
                while ($m = F_db_fetch_array($r)) {
                    if ((K_SHORT_ANSWERS_BINARY and (strcmp(trim($answer_text), $m['answer_description']) == 0))
                        or (!K_SHORT_ANSWERS_BINARY and (strcasecmp(trim($answer_text), $m['answer_description']) == 0))) {
                        $answer_score += $question_right_score;
                        break;
                    }
                }
            } else {
                F_display_db_error();
                return false;
            }
        }
        if ($unanswered) {
            $change_time = '';
        } else {
            $change_time = date(K_TIMESTAMP_FORMAT);
        }
        $sqlu = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET';
        $sqlu .= ' testlog_answer_text='.htmlentities(F_empty_to_null($answer_text)).',';
        $sqlu .= ' testlog_score='.$answer_score.',';
        $sqlu .= ' testlog_change_time='.F_empty_to_null($change_time).',';
        $sqlu .= ' testlog_reaction_time='.intval($reaction_time).',';
        $sqlu .= ' testlog_user_ip=\''.getNormalizedIP($_SERVER['REMOTE_ADDR']).'\',';
	$sqlu .= ' ragu=\''.$ragu.'\'';
        $sqlu .= ' WHERE testlog_id='.$testlog_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
            return false;
        }
    }
    return true;
}

function F_updateQuestionLogRegradeWAP($test_id, $testlog_id, $answpos = array(), $answer_text = '', $reaction_time = 0, $ragu)
{
    //echo $test_id."<br/>".$testlog_id."<br/>".$answpos."<br/>".$answer_tex."<br/>".$reaction_time."<br/>".$ragu;
//	die();

    require_once('../config/tce_config.php');
    global $db, $l;
    $question_id = 0; // question ID
    $question_type = 3; // question type
    $question_difficulty = 1; // question difficulty
    $oldtext = ''; // old text answer
    $answer_changed = true; // true when answer change
    $answer_score = 0; // answer total score
    $num_answers = 0; // counts alternative answers
    $test_id = intval($test_id);
    $testlog_id = intval($testlog_id);
    $unanswered = true;
    $answer_id = F_getAnswerIdFromPosition($testlog_id, $answpos);
    // get test data
    $testdata = F_getTestData($test_id);
    // get question information
    $sql = 'SELECT *
		FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
		WHERE testlog_question_id=question_id
			AND testlog_id='.$testlog_id.'
		LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            // get previous answer text
            $oldtext = $m['testlog_answer_text'];
            $question_id = $m['question_id'];
            $question_type = $m['question_type'];
            $question_difficulty = $m['question_difficulty'];
	    $ragu_dbval = $m['ragu'];

	   // if($ragu=='fromdb'){
	//	$ragu=$m['ragu'];
	  //  }

	    if($ragu_dbval != $ragu){
		$ragu_change = true;
	    }else{
		$ragu_change = false;
	    }
        }
    } else {
        F_display_db_error();
        return false;
    }
    // calculate question score
    $question_right_score = $testdata['test_score_right'] * $question_difficulty;
    $question_wrong_score = $testdata['test_score_wrong'] * $question_difficulty;
    $question_unanswered_score = $testdata['test_score_unanswered'] * $question_difficulty;
//	echo $question_right_score.'-'.$question_wrong_score.'-'.$question_unanswered_score.'<br/>';
	//die();
    if ($question_type != 3) {
        $sql = 'SELECT *
			FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_ANSWERS.'
			WHERE logansw_answer_id=answer_id
				AND logansw_testlog_id='.$testlog_id.'
			ORDER BY logansw_order';
        if ($r = F_db_query($sql, $db)) {
            while (($m = F_db_fetch_array($r))) {
                $num_answers++;
                // update each answer
                $sqlu = 'UPDATE '.K_TABLE_LOG_ANSWER.' SET';
                switch ($question_type) {
                    case 1: {
                        // MCSA - Multiple Choice Single Answer
                        if (empty($answer_id)) {
                            // unanswered
                            $answer_score = $question_unanswered_score;
                            if ($m['logansw_selected'] != -1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1 ';

                        } elseif (!empty($answer_id[$m['logansw_answer_id']])) {
                            $unanswered = false;
                            // selected
                            if (F_getBoolean($m['answer_isright'])) {
				if($m['answer_explanation']!=null){
                                	$answer_score = $m['answer_explanation']/100*$question_right_score;
				}else{
                                	$answer_score = 100/100*$question_right_score;
				}
//				echo $m['answer_explanation'].'-';
//				echo $question_right_score;
                            } else {
				if($m['answer_explanation']!=null){
                                	$answer_score = $m['answer_explanation']/100*$question_right_score;
				}else{
                                	$answer_score = 0/100*$question_right_score;
				}
//                                $answer_score = $question_wrong_score;
//				echo $m['answer_explanation'].'x';
//				echo $question_right_score;
                            }
                            if ($m['logansw_selected'] != 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=1 ';

                        } else {
                            $unanswered = false;
                            // unselected
                            if ($m['logansw_selected'] == 1) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0 ';

                        }
                        break;
                    }
                    case 2: {
                        // MCMA - Multiple Choice Multiple Answer
                        if (isset($answer_id[$m['logansw_answer_id']])) {
                            // radiobutton or selected checkbox
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == -1) {
                                // unanswered
                                $answer_score += $question_unanswered_score;
                            } elseif (F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 1)) {
                                // right (selected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } elseif (!F_getBoolean($m['answer_isright']) and ($answer_id[$m['logansw_answer_id']] == 0)) {
                                // right (unselected)
                                $unanswered = false;
                                $answer_score += $question_right_score;
                            } else {
                                // wrong
                                $unanswered = false;
                                $answer_score += $question_wrong_score;
                            }
                            if ($m['logansw_selected'] != $answer_id[$m['logansw_answer_id']]) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected='.$answer_id[$m['logansw_answer_id']].'';
                        } else {
                            // unselected checkbox
                            $unanswered = false;
                            if (F_getBoolean($m['answer_isright'])) {
                                $answer_score += $question_wrong_score;
                            } else {
                                $answer_score += $question_right_score;
                            }
                            if ($m['logansw_selected'] != 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=0';
                        }
                        break;
                    }
                    case 4: {
                        // ORDER
                        if (!empty($answer_id[$m['logansw_answer_id']])) {
                            // selected
                            $unanswered = false;
                            $answer_id[$m['logansw_answer_id']] = intval($answer_id[$m['logansw_answer_id']]);
                            if ($answer_id[$m['logansw_answer_id']] == $m['answer_position']) {
                                $answer_score += $question_right_score;
                            } else {
                                $answer_score += $question_wrong_score;
                            }
                            if ($answer_id[$m['logansw_answer_id']] != $m['logansw_position']) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_position='.$answer_id[$m['logansw_answer_id']].', logansw_selected=1';
                        } else {
                            // unanswered
                            $answer_score += $question_unanswered_score;
                            if ($m['logansw_position'] > 0) {
                                $answer_changed = true;
                            }
                            $sqlu .= ' logansw_selected=-1, logansw_position=0';
                        }
                        break;
                    }
                } // end of switch
                $sqlu .= ' WHERE logansw_testlog_id='.$testlog_id.' AND logansw_answer_id='.$m['logansw_answer_id'].'';
                if (!$ru = F_db_query($sqlu, $db)) {
                    F_display_db_error();
                    return false;
                }
            }
            if ($question_type > 1) {
                // normalize score
                if (F_getBoolean($testdata['test_mcma_partial_score'])) {
                    // use partial scoring for MCMA and ORDER questions
                    $answer_score = round(($answer_score / $num_answers), 3);
                } else {
                    // all-or-nothing points
                    if ($answer_score >= ($question_right_score * $num_answers)) {
                        // right
                        $answer_score = $question_right_score;
                    } elseif ($answer_score == ($question_unanswered_score * $num_answers)) {
                        // unanswered
                        $answer_score = $question_unanswered_score;
                    } else {
                        // wrong
                        $answer_score = $question_wrong_score;
                    }
                }
            }
        } else {
            F_display_db_error();
            return false;
        }
    }
    // update log if answer is changed
    if ($answer_changed or ($oldtext != $answer_text) or $ragu_change) {
        if (strlen($answer_text) > 0) {
            $unanswered = false;
            $answer_score = 'NULL';
            // check exact answers score
            $sql = 'SELECT *
				FROM '.K_TABLE_ANSWERS.'
				WHERE answer_question_id='.$question_id.'
					AND answer_enabled=\'1\'
					AND answer_isright=\'1\'';
            if ($r = F_db_query($sql, $db)) {
                while ($m = F_db_fetch_array($r)) {
                    if ((K_SHORT_ANSWERS_BINARY and (strcmp(trim($answer_text), $m['answer_description']) == 0))
                        or (!K_SHORT_ANSWERS_BINARY and (strcasecmp(trim($answer_text), $m['answer_description']) == 0))) {
                        $answer_score += $question_right_score;
                        break;
                    }
                }
            } else {
                F_display_db_error();
                return false;
            }
        }
        if ($unanswered) {
            $change_time = '';
        } else {
            $change_time = date(K_TIMESTAMP_FORMAT);
        }
        $sqlu = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET';
        $sqlu .= ' testlog_answer_text='.htmlentities(F_empty_to_null($answer_text)).',';
        $sqlu .= ' testlog_score='.$answer_score.',';
        $sqlu .= ' testlog_change_time='.F_empty_to_null($change_time).',';
        $sqlu .= ' testlog_reaction_time='.intval($reaction_time).',';
        $sqlu .= ' testlog_user_ip=\''.getNormalizedIP($_SERVER['REMOTE_ADDR']).'\',';
	$sqlu .= ' ragu=\''.$ragu.'\'';
        $sqlu .= ' WHERE testlog_id='.$testlog_id.'';
        if (!$ru = F_db_query($sqlu, $db)) {
            F_display_db_error();
            return false;
        }
    }
    return true;
}

/**
 * Returns the answer ID from position
 * @param $testlog_id (int) Test Log ID
 * @param $answpos (array) Answer positions (order in wich they are displayed)
 * @return int answer ID
 */
function F_getAnswerIdFromPosition($testlog_id, $answpos)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $answer_id = array();
    foreach ($answpos as $pos => $val) {
        $sql = 'SELECT logansw_answer_id'
            .' FROM '.K_TABLE_LOG_ANSWER
            .' WHERE logansw_testlog_id='.intval($testlog_id)
            .' AND logansw_order='.intval($pos)
            .' LIMIT 1';
        if ($r = F_db_query($sql, $db)) {
            if ($m = F_db_fetch_array($r)) {
                $answer_id[intval($m['logansw_answer_id'])] = $val;
            }
        } else {
            F_display_db_error();
        }
    }
    return $answer_id;
}

/**
 * Returns a formatted XHTML form code to handle the specified question.<br>
 * Form fields names are: answer_text, answer_id<br>
 * CSS classes:<ul>
 * <li>div.tcecontentbox</li>
 * <li>div.rowl</li>
 * <li>textarea.answertext</li>
 * </ul>
 * @param $test_id (int) test ID
 * @param $testlog_id (int) test log ID
 * @param $formname (string) form name (form ID)
 * @return string XHTML code
 */
function F_questionForm($test_id, $testlog_id, $formname)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l, $examtime, $timeout_logout;
    $test_id = intval($test_id);
    $testlog_id = intval($testlog_id);
    $user_id = intval($_SESSION['session_user_id']);
    $aswkeys = array();
    $str = '';
    if (!isset($test_id) or ($test_id == 0)) {
        return;
    }
    $testdata = F_getTestData($test_id);
    $noanswer_hidden = '';
    $noanswer_disabled = '';
    if (!F_getBoolean($testdata['test_noanswer_enabled'])) {
        $noanswer_hidden = ' style="visibility:hidden;display:none;"';
        $noanswer_disabled = ' readonly="readonly" disabled="disabled"';
    }
    // select question for the first time
    if (!isset($testlog_id) or ($testlog_id == 0)) {
        //select first question
        $sql = 'SELECT testlog_id
			FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
			WHERE testlog_testuser_id=testuser_id
				AND testuser_test_id='.$test_id.'
				AND testuser_user_id='.$user_id.'
				AND testuser_status<5
			ORDER BY testlog_id
			LIMIT 1';
        if ($r = F_db_query($sql, $db)) {
            if ($m = F_db_fetch_array($r)) {
                $testlog_id = $m['testlog_id'];
            } else {
                return;
            }
        } else {
            F_display_db_error();
        }
    }
    // build selection query for question to display
    $sql = 'SELECT *
			FROM '.K_TABLE_QUESTIONS.', '.K_TABLE_TESTS_LOGS.'
			WHERE question_id=testlog_question_id
				AND testlog_id='.$testlog_id.'
			LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            if (F_getBoolean($m['question_fullscreen'])) {
                // hide some section for fullscreen mode
                $str .= '<style>'.K_NEWLINE;
                $str .= '.header{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.infolink{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= 'h1{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.pagehelp{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.userbar{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.minibutton{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.navlink{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '.testcomment{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '#terminatetest{visibility:hidden;display:none;}'.K_NEWLINE;
                $str .= '</style>'.K_NEWLINE;
            }
            
            $str .= '</p>'.K_NEWLINE;

	    //$str .= '<div id="toggle-button" class="pwrap brad bd-yellow"><div>&#10094;</div><div>DAFTAR SOAL</div></div>';


	if(K_MODUS_CAHAYA){
            $str .= '<p class="fsBR">'.K_NEWLINE;

            $str .= '<span>Modus Cahaya:</span>'.K_NEWLINE;
            $str .= '<span><a id="normal" class="pcborder">Normal</a></span>'.K_NEWLINE;
            $str .= '<span><a id="redup" class="pcborder">Redup</a></span>'.K_NEWLINE;
            $str .= '<span><a id="malam" class="pcborder">Malam</a></span>'.K_NEWLINE;

            $str .= '</p>'.K_NEWLINE;
	}//tutup if k_modus_cahaya
            $str .= '</div>'.K_NEWLINE; //tutup div fsBar
            
            $str .= '<script type="text/javascript">'.K_NEWLINE;
            $str .= 'if(localStorage.modus=="normal"){'.K_NEWLINE;
			$str .= '$("a#normal").addClass("aktif").html("&check; &nbsp; Normal");'.K_NEWLINE;
			$str .= '}else if(localStorage.modus=="redup"){'.K_NEWLINE;
			$str .= '$("a#redup").addClass("aktif").html("&check; &nbsp; Redup");'.K_NEWLINE;
			$str .= '}else{'.K_NEWLINE;
			$str .= '$("a#malam").addClass("aktif").html("&check; &nbsp; Malam");'.K_NEWLINE;
			$str .= '}'.K_NEWLINE;
			$str .= '</script>'.K_NEWLINE;

            $str .= '<input type="hidden" name="testid" id="testid" value="'.$test_id.'" />'.K_NEWLINE;
            $str .= '<input type="hidden" name="testlogid" id="testlogid" value="'.$testlog_id.'" />'.K_NEWLINE;
            $str .= '<input type="hidden" name="testuser_id" id="testuser_id" value="'.$m['testlog_testuser_id'].'" />'.K_NEWLINE;

            // get test data
            $test_data = F_getTestData($test_id);
            // store time information for interactive timer
            $examtime = F_getTestStartTime($m['testlog_testuser_id']) + ($test_data['test_duration_time'] * K_SECONDS_IN_MINUTE);
            $str .= '<input type="hidden" name="examtime" id="examtime" value="'.$examtime.'" />'.K_NEWLINE;
            if (F_getBoolean($test_data['test_logout_on_timeout'])) {
                $str .= '<input type="hidden" name="timeout_logout" id="timeout_logout" value="1" />'.K_NEWLINE;
            }
            $str .= '<a name="questionsection" id="questionsection"></a>'.K_NEWLINE;
            $str .= '<div class="tcecontentbox w-auto m-10 py-10 px-10 brad-10 bd-gray1" id="soalcontainer">'.K_NEWLINE;
            //fieldset
            //$str .= '<legend>';
            //$str .= $l['w_question'];
            //$str .= '</legend>'.K_NEWLINE;
            // display question description
            if ($m['question_type'] == 3) {
                $str .= '<label for="answertext">';
            }

	    //maman
	    if(K_JPLAYER){
		//include '../../cache/listening/setting.php';
		//echo date("Y-m-d h:m:s");
		$str .= '<div id="audiobox" style="display:none"><div id="jquery_jplayer_1" class="jp-jplayer"></div><div id="jp_container_1" class="jp-audio" role="application" aria-label="media player" style="display:inline-block;margin-right:1em"><div class="jp-type-single"><div class="jp-gui jp-interface"><div style="display:none" class="jp-controls"><button class="jp-play" role="button" tabindex="0">play</button></div><div class="jp-progress"></div><div class="jp-volume-controls"><button class="jp-mute" role="button" tabindex="0">mute</button><button class="jp-volume-max" role="button" tabindex="0">max volume</button><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div><div class="jp-time-holder"><div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div><div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div></div></div><div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.</div></div></div><div style="display:inline-block;vertical-align:top"><em style="color:red">Jika Audio tidak dapat diputar coba tekan tombol F5. <br/>Selama audio sedang diputar, Anda tidak dapat berpindah ke soal lain.<br/><b>Audio hanya dapat diputar sebanyak '.K_LISTENING_FREQ.' kali</b></em></div></div>'.K_NEWLINE;
	    }

            //$str .= F_decode_tcecode($m['question_description']).K_NEWLINE;
		//uncomment baris di bawah untuk mendisable tag tceexam
            $str .= html_entity_decode($m['question_description']).K_NEWLINE;

            if ($m['question_type'] == 3) {
                $str .= '</label>';
            }
            $str .= '<div class="row">'.K_NEWLINE;
            //$str .= '<hr/>'.K_NEWLINE;
            $str .= '</div>'.K_NEWLINE;
            $str .= '<div class="rowl">'.K_NEWLINE;
            if ($m['question_type'] == 3) {
                // TEXT - free text question
                if (K_ENABLE_VIRTUAL_KEYBOARD) {
                    $str .= '<script src="'.K_PATH_SHARED_JSCRIPTS.'vk/vk_easy.js?vk_skin=default" type="text/javascript"></script>'.K_NEWLINE;
                }
                $str .= '<textarea cols="'.K_ANSWER_TEXTAREA_COLS.'" rows="'.K_ANSWER_TEXTAREA_ROWS.'" name="answertext" id="answertext" class="focusshd bg-biru-ltr bd-biru" onchange="saveAnswer()"';
                if (K_ENABLE_VIRTUAL_KEYBOARD) {
                    $str .= 'keyboardInput ';
                }
                $str .= 'answertext">';
                $str .= $m['testlog_answer_text'];
                $str .= '</textarea>'.K_NEWLINE;
            } else {
                // multiple-choice question
                $checked = false;
                if (F_getBoolean($m['question_inline_answers'])) {
                    // inline display
                    $str .= '<ol class="answer_inline">'.K_NEWLINE;
                } else {
                    $str .= '<ol class="answer">'.K_NEWLINE;
                }
                if ($m['question_type'] == 4) {
                    // get max positions for odering questions
                    $max_position = F_count_rows(K_TABLE_LOG_ANSWER, 'WHERE logansw_testlog_id='.$testlog_id.'');
                }
                // display answer options
                $sqla = 'SELECT *
					FROM '.K_TABLE_ANSWERS.', '.K_TABLE_LOG_ANSWER.'
					WHERE logansw_answer_id=answer_id
						AND logansw_testlog_id='.$testlog_id.'
					ORDER BY logansw_order';
                if ($ra = F_db_query($sqla, $db)) {
                    while ($ma = F_db_fetch_array($ra)) {
						$anspos = $ma['logansw_order'];
						//maman
                            $str .= '<li>';

                        switch ($m['question_type']) {
                            case 1: {
                                // MCSA - single-answer question
								if($anspos==1){
									$huruf='A';
								}elseif($anspos==2){
									$huruf='B';
								}elseif($anspos==3){
									$huruf='C';
								}elseif($anspos==4){
									$huruf='D';
								}elseif($anspos==5){
									$huruf='E';
								}
									$styleChecked= 'class="ansUncek"';
                                $str .= '<input style="display:none;visibility:hidden" type="radio" name="answpos" id="answpos_'.$anspos.'" value="'.$anspos.'"';
                                if (intval($ma['logansw_selected']) == 1) {
                                    $str .= ' checked="checked"';
                                    $checked = true;
									$styleChecked= 'class="ansCek"';
                                }
                                if (F_getBoolean($m['question_auto_next'])) {
				    $str .= " onclick=\"autoNextOnClick()\"";
                                    //$str .= " onclick=\"var submittime=new Date();document.getElementById('reaction_time').value=submittime.getTime()-document.getElementById('display_time').value;document.getElementById('confirmanswer').value=1;document.getElementById('".$formname."').submit();\"";
                                }
                                $str .= ' />';
				$str .= '<div id="mamanoptionwrapper">';
                                $str .= '<label id="answpos_'.$anspos.'" for="answpos_'.$anspos.'">';
				$str .= '<div id="answpos">';
				$str .= '<span '.$styleChecked.' id="opbut">'.$huruf.'</span>';
				$str .= '</div>';

				//maman
                                //$str .= '<div id="ansops">'.F_decode_tcecode($ma['answer_description']).'</div>';
				//uncomment di bawah untuk mematikan tag tcexam, lalu comment baris diatas
                                $str .= '<div id="ansops">'.html_entity_decode($ma['answer_description']).'</div>';

                                $str .= '</label>';
				$str .= '</div>';
                                if ($ma['answer_keyboard_key'] > 0) {
                                    $aswkeys[$ma['answer_keyboard_key']] = 'answpos_'.$anspos;
                                }
                                break;
                            }

                            case 2: {
                                // MCMA - multiple-answer question
                                //echo F_getBoolean($testdata['test_mcma_radio']);
				// maman mod force mcma to checkbox
                                $testdata['test_mcma_radio'] = 0;
                                if (F_getBoolean($testdata['test_mcma_radio'])) {
					//echo "raDIOOOO";
                                    // radiobuttons

					?>
					<style id="mcma-radio">
						ol.answer li p {display:inline}
					</style>
					<?php

                                    // no-answer option
                                    $str .= '<span id="answpos_noans" style="background-color:#DDDDDD;display:none"'.$noanswer_hidden.'>&nbsp;';
                                    $str .= '<label for="answpos_'.$anspos.'u" title="Tanpa Jawaban">T</label>';
                                    $str .= '<input type="radio"'.$noanswer_disabled.' name="answpos['.$anspos.']" id="answpos_'.$anspos.'u" value="-1" title="Tanpa Jawaban"';
                                    if (intval($ma['logansw_selected']) == -1) {
                                        $str .= ' checked="checked"';
                                    }
                                    $str .= ' />';
                                    $str .= '</span>&nbsp;';

                                    // false option
                                    $str .= '<span id="answpos_false" style="background-color:#FFBBBB;display:none">&nbsp;';
                                    $str .= '<label for="answpos_'.$anspos.'f" title="Salah">S</label>';
                                    $str .= '<input type="radio" name="answpos['.$anspos.']" id="answpos_'.$anspos.'f" value="0"';
                                    if (intval($ma['logansw_selected']) == 0) {
                                        $str .= ' checked="checked"';
                                    }
                                    $str .= ' />';
                                    $str .= '</span>&nbsp;';

                                    // true option
                                    //$str .= '<span id="answpos_true" style="background-color:#BBFFBB;">&nbsp;';
                                    $str .= '<span id="answpos_true">&nbsp;';
                                    $str .= '<label style="display:none" for="answpos_'.$anspos.'t" title="Benar">B</label>';
                                    //$str .= '<input type="radio" names="answpos_'.$anspos.'" name="answpos['.$anspos.']" id="answpos_'.$anspos.'t" value="1"';
                                    $str .= '<input style="display:none" type="radio" name="answpos['.$anspos.']" id="answpos_'.$anspos.'t" value="1"';
                                    if (intval($ma['logansw_selected']) == 1) {
                                        $str .= ' checked="checked"';
                                    }
                                    $str .= ' />';
    				    //$str .= '<input type="checkbox" value="test" id="answpos_'.$anspos.'" name="mcma_cb" />';
    				    $str .= '<label class="checkbox-label"><input type="checkbox" value="test" id="answpos_'.$anspos.'" name="mcma_cb" /><span class="checkbox-custom"></span></label>';
                                    $str .= '</span>&nbsp;';

					//$str .= '<span>';
					//$str .= '</span>';

                                    if ($ma['answer_keyboard_key'] > 0) {
                                        $aswkeys[] = array($ma['answer_keyboard_key'] => 'answpos_'.$anspos.'t');
                                    }

                                    //$str .= F_decode_tcecode($ma['answer_description']);
                                    $str .= $ma['answer_description'];
                                } else {
                                    // checkbox
					//echo "CEBOXX";
				    $str .= '<div id="maman_mcma_wrapper">';
				    $str .= '<div id="maman_mcma_cb_wrapper" style="line-height:0px;width:31px;text-align:left">';
				    ?>
				    <style>
					span#mcma_cb label[for="<?php echo 'answpos_'.$anspos; ?>"]:before{
					<?php
						if($anspos==1){
							$huruf_cb="A";
						}elseif($anspos==2){
							$huruf_cb="B";
						}elseif($anspos==3){
							$huruf_cb="C";
						}elseif($anspos==4){
							$huruf_cb="D";
						}elseif($anspos==5){
							$huruf_cb="E";
						}elseif($anspos==6){
							$huruf_cb="F";
						}elseif($anspos==7){
							$huruf_cb="G";
						}elseif($anspos==8){
							$huruf_cb="H";
						}elseif($anspos==9){
							$huruf_cb="I";
						}else{
							$huruf_cb="J";
						}

					?>
						content:"<?php echo $huruf_cb; ?>";
					}
				    </style>
				    <?php
				    $str .= '<span id="mcma_cb">';
                                    $str .= '<input type="checkbox" name="answpos['.$anspos.']" id="answpos_'.$anspos.'" value="1"';
                                    if (intval($ma['logansw_selected']) == 1) {
                                        $str .= ' checked="checked"';
                                        $checked = true;
                                    }
                                    $str .= ' />&nbsp;';
                                    $str .= '<label for="answpos_'.$anspos.'"></label>';
				    $str .= '</span>';
				    $str .= '</div>';
				    $str .= '<div style="line-height:30px" id="maman_mcma_lb_wrapper">';
                                    $str .= '<label for="answpos_'.$anspos.'">';
                                    //$str .= F_decode_tcecode($ma['answer_description']);
                                    $str .= $ma['answer_description'];
                                    $str .= '</label>';
                                    $str .= '</div>';
                                    $str .= '</div>';
                                }
                                break;
                            }
                            case 4: {
                                // ORDER - ordering questions
				$str .= '<div id="maman_order_wrapper">';
				$str .= '<div style="padding-right:7px" id="maman_order_sel_wrapper">';
                                $str .= '<select class="brad-5" name="answpos['.$anspos.']" id="answpos_'.$anspos.'" size="0">'.K_NEWLINE;
                                if (F_getBoolean($testdata['test_noanswer_enabled'])) {
                                    $str .= '<option value="0">&nbsp;</option>'.K_NEWLINE;
                                }
                                for ($pos=1; $pos <= $max_position; $pos++) {
                                    $str .= '<option value="'.$pos.'"';
                                    if ($pos == $ma['logansw_position']) {
                                        $str .= ' selected="selected"';
                                    }
                                    $str .= '>'.$pos.'</option>'.K_NEWLINE;
                                }
                                $str .= '</select>'.K_NEWLINE;
                                $str .= '</div>'.K_NEWLINE;
				$str .= '<div id="maman_order_lb_wrapper">';
                                $str .= '<label for="answpos_'.$anspos.'">';
                                //$str .= F_decode_tcecode($ma['answer_description']);
                                $str .= $ma['answer_description'];
                                $str .= '</label>';
				$str .= '</div>';
				$str .= '</div>';
                                break;
                            }
                        } // end of switch
                        $str .= '</li>'.K_NEWLINE;
                    } // end of while
                } else {
                    F_display_db_error();
                }
                if ($m['question_type'] == 1) {
                    // display default "unanswered" option for MCSA
                    $str .= '<li style="display:none" '.$noanswer_hidden.'>';
                    $str .= '<input type="radio"'.$noanswer_disabled.' name="answpos" id="answpos_0" value="0"';
                    if (!$checked) {
                        $str .= ' checked="checked"';
                    }
                    $str .= ' />&nbsp;';
                    $str .= '<label for="answpos_0">';
                    $str .= 'Tanpa Jawaban';
                    $str .= '</label>';
                    $str .= '</li>'.K_NEWLINE;
                }

                $str .= '</ol>'.K_NEWLINE;
            } // end multiple answers
            $str .= '</div>'.K_NEWLINE;
            $str .= '</div>'.K_NEWLINE; //fieldset
            // javascript code
            $str .= '<script type="text/javascript">'.K_NEWLINE;
            $str .= '//<![CDATA['.K_NEWLINE;

            // script to handle keyboard events
            $str .= 'function actionByChar(e){e=(e)?e:window.event;keynum=(e.keyCode)?e.keyCode:e.which;switch(keynum){'.K_NEWLINE;
            foreach ($aswkeys as $key => $fieldid) {
                $str .= 'case '.$key.':{document.getElementById(\''.$fieldid.'\').checked=true;var submittime=new Date();document.getElementById(\'reaction_time\').value=submittime.getTime()-document.getElementById(\'display_time\').value;document.getElementById(\'confirmanswer\').value=1;document.getElementById(\''.$formname.'\').submit();break;}'.K_NEWLINE;
            }
            $str .= '}}'.K_NEWLINE;
            $str .= 'if (!document.all) {document.captureEvents(Event.KEYPRESS);}';
            $str .= 'document.onkeypress=actionByChar;'.K_NEWLINE;
            // script for autosaving text answers
            if ($m['question_type'] == 3) {
                // check if local storage is enabled (HTML5)
                $str .= 'var enable_storage=(typeof(Storage)!=="undefined");'.K_NEWLINE;
                // function to save the text answer locally
                $str .= 'function saveAnswer(){if(enable_storage){localStorage.answertext'.$testlog_id.'=document.getElementById("answertext").value;}}'.K_NEWLINE;
                // initialize the text answer with the saved value
                $str .= 'if(enable_storage && localStorage.answertext'.$testlog_id.'){document.getElementById("answertext").value=localStorage.answertext'.$testlog_id.';}'.K_NEWLINE;
            }
            // script for confirmanswer
            if ($m['question_timer'] > 0) {
                // automatic submit form after specified amount of time
                $str .= "setTimeout('document.getElementById(\'confirmanswer\').value=1;document.getElementById(\'".$formname."\').submit();', ".($m['question_timer'] * 1000).");".K_NEWLINE;
            }
            $str .= '//]]>'.K_NEWLINE;
            $str .= '</script>'.K_NEWLINE;
            // display questions menu
            $str .= F_questionsMenu($testdata, $m['testlog_testuser_id'], $testlog_id, F_getBoolean($m['question_fullscreen']));
        }
        if (empty($m['testlog_display_time'])) {
            // mark test as displayed:
            $sqlu = 'UPDATE '.K_TABLE_TESTS_LOGS.'
				SET testlog_display_time=\''.date(K_TIMESTAMP_FORMAT).'\'
				WHERE testlog_id='.$testlog_id.'';
            if (!$ru = F_db_query($sqlu, $db)) {
                F_display_db_error();
            }
        }
    } else {
        F_display_db_error();
    }
    return $str;
}

/**
 * Returns a questions menu and navigator buttons.
 * @param $testdata (array) test data
 * @param $testuser_id (int) user's test ID
 * @param $testlog_id (int) test log ID
 * @param $disable (boolean) if TRUE disable the questions list.
 * @return string XHTML code
 */

function F_questionsMenu($testdata, $testuser_id, $testlog_id = 0, $disable = false)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    $testuser_id = intval($testuser_id);
    $testlog_id = intval($testlog_id);
    $str = '';
    $testlog_id_prev = 0; // previous question ID
    $testlog_id_next = 0; // next question ID
    $testlog_id_last = 0; // temp variable
    $sql = 'SELECT question_description, question_difficulty, question_timer, testlog_id, testlog_answer_text, testlog_display_time, testlog_change_time, ragu, question_type
		FROM '.K_TABLE_QUESTIONS.', '.K_TABLE_TESTS_LOGS.'
		WHERE question_id=testlog_question_id
			AND testlog_testuser_id='.$testuser_id.'
		ORDER BY testlog_id';
    if ($r = F_db_query($sql, $db)) {
	//maman++
        $i = 0;
        $qprev = '';
        $qsel = 1;
        while ($m = F_db_fetch_array($r)) {

            ++$i;
		if($m['question_type']==1){
		  ////////////////// maman } menampilkan opsi yang terpilih
		  if(K_ANS_LETTER){
			$span_display="";
			$blm_terjawab="";
			$sqlmaman = 'SELECT logansw_order FROM tce_tests_logs_answers, tce_answers WHERE logansw_answer_id=answer_id AND logansw_testlog_id='.$m['testlog_id'].' AND logansw_selected=1';
						if ($rmaman = F_db_query($sqlmaman, $db)) {
							while ($mmaman = F_db_fetch_array($rmaman)) {
								if($mmaman[0]==1){
									$jawaban_terpilih="A";
								}elseif($mmaman[0]==2){
									$jawaban_terpilih="B";
								}elseif($mmaman[0]==3){
									$jawaban_terpilih="C";
								}elseif($mmaman[0]==4){
									$jawaban_terpilih="D";
								}else{
									$jawaban_terpilih="E";
								}
							}
						}
		  }else{
		      if(K_ANS_DISPLAY){
			$span_display="";
		      }else{
		      	$span_display="style='visibility:hidden;width:10px'";
		      }

		      $blm_terjawab="";
		      //$jawaban_terpilih="<span style='color:#ffffff;background:#818181;width:100%;border-radius:100%;display:inline-block'>&plus;</span>";
		      //$jawaban_terpilih="&#10010;";
		      $jawaban_terpilih="S";
		  }
		}elseif($m['question_type']==2){
		      if(K_ANS_DISPLAY){
			$span_display="";
		      }else{
		       	$span_display="style='visibility:hidden;width:10px'";
		      }
			$blm_terjawab="<span style='line-height:23px' class='glyphicon glyphicon-check'></span>";
			$jawaban_terpilih="<span style='line-height:23px'>M</span>";
		}elseif($m['question_type']==3){
		      if(K_ANS_DISPLAY){
			$span_display="";
		      }else{
   		      	$span_display="style='visibility:hidden;width:10px'";
		      }
			$blm_terjawab="<span style='font-size:small;line-height:23px' class='glyphicon glyphicon-list-alt'></span>";
			$jawaban_terpilih="<span style='line-height:23px'>T</span>";
		}elseif($m['question_type']==4){
		      if(K_ANS_DISPLAY){
			$span_display="";
		      }else{
		      	$span_display="style='visibility:hidden;width:10px'";
		      }

			$blm_terjawab="<span style='font-size:small;line-height:23px' class='glyphicon glyphicon-sort'></span>";
			$jawaban_terpilih="<span style='line-height:23px'>O</span>";
		}

			if (!empty($m['testlog_change_time'])) {
				$answeredbg = "#000;color:#fff";
				$bold = "font-weight:bold;";
				//if(!K_ANS_LETTER){
				//	$jawaban_terpilih="S";
				//}
				if($m['ragu']=='on'){
					$a_label = '<span '.$span_display.' class="raguOn_fill">'.$jawaban_terpilih.'</span>';
				}else{
					$a_label = '<span '.$span_display.' class="raguOff_fill">'.$jawaban_terpilih.'</span>';
				}
				$terjawab = 1;

			} else {
				$answeredbg = "#fff";
				$bold = "font-weight:bold;";
				if($m['ragu']=='on'){
					$a_label = '<span '.$span_display.' class="label_answered raguOn_empty">'.$blm_terjawab.'</span>';
				}else{
					$a_label = '<span '.$span_display.' class="label_answered raguOff_empty">'.$blm_terjawab.'</span>';
				}
				$terjawab = 0;
			}

		$tooltip_tpl = '<div class="tooltip_templates"><span id="tooltip_content_'.$m['testlog_id'].'">'.str_replace("img","img id='tooltip_img'",F_decode_tcecode($m['question_description'])).'</span></div>';

            if ($m['testlog_id'] != $testlog_id) {

		if($m['ragu']=='on'){
			if(K_TOOLTIPSTER){
				if(K_TOOLTIP_TYPE=="html"){
                    $str .= '<input style="display:none" class="tooltip raguOn" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
                    $str .= '<input class="tooltip raguOn" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
                    //$str .= '<input class="tooltip raguOn" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
					$str .= $tooltip_tpl;
				}elseif(K_TOOLTIP_TYPE=="title"){
                    //$str .= '<input class="tooltip raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.substr(F_tcecodeToTitle($m['question_description']), 0, K_TOOLTIP_CHAR).K_TOOLTIP_END.'" />'.K_NEWLINE;
                   // $str .= '<input class="tooltip raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.F_tcecodeToTitle($m['question_description']).'" />'.K_NEWLINE;
		$teksoal = strip_tags(preg_replace('/<math[^>]*>([\s\S]*?)<\/math[^>]*>/','[RUMUS]',$m['question_description']));
		if(strlen($teksoal)>200){
			$pos = strpos($teksoal,' ',200);
			$teksoal = substr($teksoal,0,$pos);
		}

                    //$str .= '<input class="tooltip raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                    $str .= '<input class="tooltip raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                    $str .= '<input style="display:none" class="tooltip raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                    //$str .= '<input class="tooltip raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$m['question_description'].'" />'.K_NEWLINE;
				}
			}elseif(K_SIMPLETOOLTIP or K_TOOLTIP_BASIC){
               // $str .= '<input class="raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.F_tcecodeToTitle($m['question_description']).'" />'.K_NEWLINE;
		$teksoal = strip_tags(preg_replace('/<math[^>]*>([\s\S]*?)<\/math[^>]*>/','[RUMUS]',$m['question_description']));
		if(strlen($teksoal)>200){
			$pos = strpos($teksoal,' ',200);
			$teksoal = substr($teksoal,0,$pos);
		}

                //$str .= '<input class="raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                $str .= '<input class="raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                $str .= '<input style="display:none" class="raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                //$str .= '<input class="raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$m['question_description'].'" />'.K_NEWLINE;
			}else{
                //$str .= '<input class="raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
                $str .= '<input class="raguOn" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
                $str .= '<input style="display:none" class="raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
                //$str .= '<input class="raguOn" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.'/>'.K_NEWLINE;
            }
		}else{
			if(K_TOOLTIPSTER){
				if(K_TOOLTIP_TYPE=="html"){
			                $str .= '<input style="display:none" class="tooltip raguOff" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
			                $str .= '<input class="tooltip raguOff" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
			                //$str .= '<input class="tooltip raguOff" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" />'.K_NEWLINE;
					$str .= $tooltip_tpl;
				}elseif(K_TOOLTIP_TYPE=="title"){
		                	//$str .= '<input class="tooltip raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.F_tcecodeToTitle($m['question_description']).'" />'.K_NEWLINE;
		$teksoal = strip_tags(preg_replace('/<math[^>]*>([\s\S]*?)<\/math[^>]*>/','[RUMUS]',$m['question_description']));
		if(strlen($teksoal)>200){
			$pos = strpos($teksoal,' ',200);
			$teksoal = substr($teksoal,0,$pos);
		}

		                	$str .= '<input style="display:none" class="tooltip raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
		                	$str .= '<input class="tooltip raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
		                	//$str .= '<input class="tooltip raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
				}
			}elseif(K_SIMPLETOOLTIP or K_TOOLTIP_BASIC){
                		//$str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.F_tcecodeToTitle($m['question_description']).'" />'.K_NEWLINE;
		//$teksoal = strip_tags(preg_replace('/<math[^>]*>([\s\S]*?)<\/math[^>]*>/', '[RUMUS]', $m['question_description']));
		$teksoal = strip_tags(preg_replace('/<math[^>]*>([\s\S]*?)<\/math[^>]*>/', '[RUMUS]', $m['question_description']));
		if(strlen($teksoal) > 200){
			$pos = strpos($teksoal, ' ', 200);
			$teksoal = substr($teksoal, 0, $pos)." ...";
		}


                		//$str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                		$str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                		$str .= '<input style="display:none" class="raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$teksoal.'" />'.K_NEWLINE;
                		//$str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' title="'.$m['question_description'].'" />'.K_NEWLINE;
			}else{
                //$str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
                $str .= '<input class="raguOff" style="background-color:'.$answeredbg.'" type="button" name="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
                $str .= '<input style="display:none" class="raguOff" style="background-color:'.$answeredbg.'" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value='.$i.' />'.K_NEWLINE;
            }
		}
				$str .= $a_label;
                if ($testlog_id_last == $testlog_id) {
                    $testlog_id_next = $m['testlog_id'];
                }
            } else {
		if($m['ragu']=='on'){
			if(K_TOOLTIPSTER){
				if(K_TOOLTIP_TYPE=="html"){
		                	$str .= '<input style="display:none" class="tooltip" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" class="raguOn_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
		                	$str .= '<input class="tooltip" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
		                	//$str .= '<input class="tooltip" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
					$str .= $tooltip_tpl;
				}elseif(K_TOOLTIP_TYPE=="title"){
	        	        	//$str .= '<input class="tooltip" id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
	        	        	$str .= '<input class="tooltip" id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
	        	        	$str .= '<input style="display:none" class="tooltip" id="qsel" class="raguOn_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
				}
			}elseif(K_SIMPLETOOLTIP or K_TOOLTIP_BASIC){
	               		//$str .= '<input id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
	               		$str .= '<input id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
	               		$str .= '<input style="display:none" id="qsel" class="raguOn_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
			}else{
                //$str .= '<input id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                $str .= '<input id="qsel" class="raguOn_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                $str .= '<input style="display:none" id="qsel" class="raguOn_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
            }
		}else{
			if(K_TOOLTIPSTER){
				if(K_TOOLTIP_TYPE=="html"){
			                //$str .= '<input class="tooltip raguOff_qsel" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
			                $str .= '<input class="tooltip raguOff_qsel" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
			                $str .= '<input style="display:none" class="tooltip raguOff_qsel" data-tooltip-content="#tooltip_content_'.$m['testlog_id'].'" id="qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
					$str .= $tooltip_tpl;
				}elseif(K_TOOLTIP_TYPE=="title"){
		                	//$str .= '<input class="tooltip raguOff_qsel" id="qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
		                	$str .= '<input class="tooltip raguOff_qsel" id="qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
		                	$str .= '<input style="display:none" class="tooltip raguOff_qsel" id="qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
				}
			}elseif(K_SIMPLETOOLTIP or K_TOOLTIP_BASIC){
                		//$str .= '<input id="qsel" class="raguOff_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                		$str .= '<input id="qsel" class="raguOff_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                		$str .= '<input style="display:none" id="qsel" class="raguOff_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
			}else{
                //$str .= '<input id="qsel" class="raguOff_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                $str .= '<input id="qsel" class="raguOff_qsel" type="button" name="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
                $str .= '<input style="display:none" id="qsel" class="raguOff_qsel" type="submit" name="jumpquestion_'.$m['testlog_id'].'" id="jumpquestion_'.$m['testlog_id'].'" value="'.$i.'" disabled="disabled"/>'.K_NEWLINE;
            }
		}
			if($terjawab==0){
				if($m['ragu']=='on'){
					$str .= '<span '.$span_display.' id="qsel" class="label_answered raguOn_qsel">'.$blm_terjawab.'</span>';
				}else{
					$str .= '<span '.$span_display.' id="qsel" class="label_answered raguOff_qsel">'.$blm_terjawab.'</span>';
				}
			}else{
				if($m['ragu']=='on'){
				//if(!K_ANS_LETTER){
				//	$jawaban_terpilih="S";
				//}
					$str .= '<span '.$span_display.' id="qsel" class="raguOn_qsel_fill">'.$jawaban_terpilih.'</span>';
				}else{
					$str .= '<span '.$span_display.' id="qsel" class="raguOff_qsel_fill">'.$jawaban_terpilih.'</span>';
				}
			}
                $testlog_id_prev = $testlog_id_last;
                $question_timer = F_getBoolean($m['question_timer']);
                $qsel = $i;
                if ($qsel > 1) {
                    $qprev = ' ('.($i - 1).')';
                }
		$ragu_checked = $m['ragu'];
		echo '<span style="display:none">'.$ragu_checked.'</span>';

		if($m['ragu']=='on'){
			$bg_numbox='numboxRaguOn';
		}else{
			$bg_numbox='numboxRaguOff';
		}

		echo K_NEWLINE;
		?>
<script type="text/javascript">$("div#timerwrap").show();</script>
		<?php
		echo '<div id="nosoal" class="bg-white brad-top-10 bdb-gray1">'.K_NEWLINE;
		echo '<p class="ft-bold d-iblock ml-15"><span id="nosoal"><span id="ns-1">NO</span> <span id="ns-2">SOAL</span></span> <span class="numbox '.$bg_numbox.'">'.$qsel.'</span></p><div style="display:none" id="loaderSimpan" class="loader-simpan ml-3"></div>'.K_NEWLINE;
		echo '</div>'.K_NEWLINE;
		echo '<div class="fsBar">'.K_NEWLINE;

		echo '<p class="fsBL">Ukuran font soal:<span style="font-weight:bold;cursor:pointer"><span id="fsSmall">A</span><span id="fsMedium">A</span><span id="fsLarge">A</span><span id="fsXlarge">A</span></span></p>'.K_NEWLINE;

		echo '<p class="bg-biru ft-white brad-100 p-7 c-pointer" onclick="location.reload()"><span class="glyphicon glyphicon-refresh"></span> <span class="hideOnSmall">Reload</span>';
//		echo '</p>'.K_NEWLINE;
            }
            // show question score

            $n_question_score = $testdata['test_score_right'] * $m['question_difficulty'];
            if ($testlog_id == 0) {
                $testlog_id = $m['testlog_id'];
                $testlog_id_last = $testlog_id;
            }
            $testlog_id_last = $m['testlog_id'];
        }

    } else {
        F_display_db_error();
    }

    // build quick navigator links (previous - next)
    $navlink = '';

    // button for previous question
    if (!$question_timer) {
        if (($testlog_id_prev <= 0) or ($testlog_id_prev > $testlog_id)) {
		$pointer='';
		$value='SOAL PERTAMA';
		$arrow='';
		$status='disabled="disabled"';
		$display='style="display:none"';
		$com1='!--';
		$com2='--';
        }else{
		$pointer='style="cursor:pointer"';
		$value='SOAL SEBELUMNYA';
		$arrow='&#10094;';
		$status='';
		$display='';
		$com1='';
		$com2='';
        }
        $navlink .= '<input '.$status.' style="display:none" '.$pointer.' type="submit" name="prevquestion" id="prevquestion" title="SOAL SEBELUMNYA" value="'.$arrow.$value.$qprev.'" />';
        //$navlink .= '<'.$com1 .'a '.$display.' name="prevquestion" id="prevquestion" title="'.$l['w_previous'].'">'.$arrow.$value.'</a';
        $navlink .= '<'.$com1 .'a '.$display.' name="prevquestion" id="prevquestion" title="SOAL SEBELUMNYA"><div style="display:none" id="loaderSimpanPrev" class="loader-simpan"></div><span id="iconPrev">'.$arrow.'</span><span id="s-sbl-1">&nbsp;&nbsp;SOAL SEBELUMNYA</span></a';
        //$navlink .= '<a name="prevquestion" id="prevquestion" title="'.$l['w_previous'].'">'.$l['w_previous'].' '.$qprev.'</a';

	//maman edit prevquestion nav link
        //$navlink .= '<input '.$pointer.' type="submit" name="prevquestion" id="prevquestion" title="'.$l['w_previous'].'" value="&nbsp;"';
        if (($testlog_id_prev <= 0) or ($testlog_id_prev > $testlog_id)) {
            //$navlink .= ' disabled="disabled"';
        }
        $navlink .= ' / '.$com2.'>';

        // button for confirm current question
		// maman confirmanswer
        $navlink .= '<input type="hidden" name="confirmanswer" id="confirmanswer" value="('.$qsel.') Konfirmasi" />';

	$navlink .= '<span id="ragu" style="padding:10px 0px 10px 17px;border-right:0;border-radius:50px 0 0 50px !important">';

	if($ragu_checked=='on'){
		$ragu_checked='checked="checked"';
	}else{
		$ragu_checked='';
	}

        $navlink .= '<input type="checkbox" name="ragu" id="ragu" '.$ragu_checked.' /><label for="ragu"></label>';
	$navlink .= '</span><span id="ragu" class="ragu" style="border-left:0;border-radius:0 50px 50px 0 !important"><span id="rg-1">RAGU-</span><span id="rg-2">RAGU</span></span>';

    }

    // button for next question
    $qnext = '';
    if ($testlog_id_next > 0) {
        $qnext = '('.($qsel + 1).') ';
    }
    
    //maman
    if ($testlog_id_next <= 0) {
        //$navlink .= '<input type="button" name="cektes" id="cektes" title="SELESAI" value="SELESAI &nbsp; &#10095;" />';
        $navlink .= '<a name="cektes" id="cektes" title="Selesai" class="bg-fuchsia ft-white ft-bold py-10 px-15 brad-100 fl-r mr-20 no-underl c-pointer"><span>SELESAI&nbsp;&nbsp;</span><span id="nextIcon">&#10095;</span><div style="display:none" id="loaderSimpanSelesai" class="loader-simpan"></div></a>';
        $navlink .= '<input type="submit" name="terminatetest" id="terminatetest" title="SELESAI" value="SELESAI &nbsp; &#10095;"';
    }else{
        $navlink .= '<input style="display:none" type="submit" name="nextquestion" id="nextquestion" title="SOAL SELANJUTNYA" value="'.$qnext.'SOAL SELANJUTNYA &nbsp; &rang;" />';
        //$navlink .= '<a name="nextquestion" id="nextquestion" title="'.$l['w_next'].'">'.$l['w_next'].' &nbsp; &#10095;</a';
        $navlink .= '<a name="nextquestion" id="nextquestion" title="SOAL SELANJUTNYA"><span id="s-slj-1">SOAL SELANJUTNYA&nbsp;&nbsp;</span><span id="nextIcon">&#10095;</span><div style="display:none" id="loaderSimpanNext" class="loader-simpan"></div></a';
    }

    $navlink .= ' />'.K_NEWLINE;

    if (($question_timer or $disable) and ($testlog_id_next <= 0)) {
        // force test termination
        $navlink .= '<input type="hidden" name="forceterminate" id="forceterminate" value="lasttimedquestion" />'.K_NEWLINE;
    }
//maman navlink
    $navlink .= '<input type="hidden" name="prevquestionid" id="prevquestionid" value="'.$testlog_id_prev.'" />'.K_NEWLINE;
    $navlink .= '<input type="hidden" name="nextquestionid" id="nextquestionid" value="'.$testlog_id_next.'" />'.K_NEWLINE;
    $navlink .= '<input type="hidden" name="autonext" id="autonext" value="" />'.K_NEWLINE;

    $navlink = '<div class="navlink"><div class="navlink2">'.$navlink.'</div></div>'.K_NEWLINE;
    $rstr = '';
    //$rstr .= '<br />'.K_NEWLINE;
    $rstr .= $navlink;
    //$rstr .= '<br />'.K_NEWLINE;
if(K_JPLAYER){
	//maman jplayer audio player
?>
			<script>
			$(document).ready(function(){
				<?php
				echo "localStorage.audiofile".$qsel." = $('audio').attr('src');".K_NEWLINE;
				?>
	<?php
	echo "audiopos".$qsel." = parseFloat(localStorage.audiopos".$qsel.");".K_NEWLINE;
	?>

	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			$(this).jPlayer("setMedia", {
				<?php
				echo "mp3: localStorage.audiofile".$qsel.K_NEWLINE;
			echo "}).jPlayer('pause', audiopos".$qsel.");".K_NEWLINE;
			?>
		},
		swfPath: '../jplayer/dist/jplayer',
		supplied: "mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: false,
		toggleDuration: false
	});

	$("#jquery_jplayer_1").bind($.jPlayer.event.pause, function(event) {
		$("div#mamanoptionwrapper label").css("pointer-events","auto");
		$("input").removeAttr("disabled");
		$("div#toggle-button, a#prevquestion, a#nextquestion").show();
		<?php
		echo "localStorage.audiopos".$qsel." = event.jPlayer.status.currentTime;".K_NEWLINE;
		?>
	});
	//<?php echo "localStorage.audiofreq".$qsel." = 0;".K_NEWLINE; ?>
	<?php
		echo "if (localStorage.getItem(\"audiofreq".$qsel."\") === null) {";
		echo "localStorage.setItem(\"audiofreq".$qsel."\",0);".K_NEWLINE;
		echo "}";
	?>

	$("#jquery_jplayer_1").bind($.jPlayer.event.ended, function(event) {
		//<?php echo "localStorage.getItem(\"audiofreq".$qsel."\") || 0;".K_NEWLINE; ?>

		<?php //include '../../cache/listening/setting.php'; ?>

		<?php echo "if (localStorage.audiofreq".$qsel." < ".K_LISTENING_FREQ.") {".K_NEWLINE;
			echo "var audiofreq".$qsel." = parseInt(localStorage.getItem(\"audiofreq".$qsel."\"));".K_NEWLINE;
			echo "localStorage.setItem(\"audiofreq".$qsel."\", ++audiofreq".$qsel.");".K_NEWLINE;
			echo "localStorage.setItem(\"audiopos".$qsel."\", 0);".K_NEWLINE;
			echo "}".K_NEWLINE;
		?>

		<?php
			echo "if (localStorage.audiofreq".$qsel." == ".K_LISTENING_FREQ.") {".K_NEWLINE;
			echo "localStorage.setItem(\"audiofreq".$qsel."\", ".K_LISTENING_FREQ.");".K_NEWLINE;
		?>

			$(this).jPlayer("clearMedia");
			<?php
			echo "localStorage.audioend".$qsel." = 'yes';".K_NEWLINE;
			?>
			$("div.jp-controls").hide();
			$("div#mamanoptionwrapper label").css("pointer-events","auto");
			//$("#jp_container_1").hide();
		<?php echo "}".K_NEWLINE; ?>
	});

	<?php
	echo "if(localStorage.audioend".$qsel." == 'yes'){".K_NEWLINE;
	?>
		//$("#jp_container_1").hide();
		$("div.jp-controls").hide();
	}else{
		$("div.jp-controls").delay(500).fadeIn("slow");
	}

	$("#jquery_jplayer_1").bind($.jPlayer.event.play, function(event) {
	$("input#prevquestion").prop("disabled",true);
	$("input#nextquestion").prop("disabled",true);
	//$("div#mamanoptionwrapper label").css("pointer-events","none");
	$("div#toggle-button, a#prevquestion, a#nextquestion").hide();
	});
});
</script>
<?php
}

if (K_VIO_LOCK and ($_SESSION['session_user_level'] < 3)){
echo "<script>".K_NEWLINE;
echo "  $(window).blur(function(){".K_NEWLINE;
echo "		window.location = \"?violation\";".K_NEWLINE;
echo "	});".K_NEWLINE;
echo "</script>".K_NEWLINE;
}
?>

<?php

    if (F_getBoolean($testdata['test_menu_enabled']) and (!$disable)) {
        // display questions menu
        $rstr .= '<a name="questionssection" id="questionssection"></a>'.K_NEWLINE;
        $rstr .= '<div class="target boxshd">'.K_NEWLINE;
        $rstr .= '<span class="ft-bold ft-dark px-20 mb-15 d-iblock">Nomor Soal</span><div id="toggle-button-mini" class="fl-r d-iblock mr-20 ft-bold ft-dark ft-lg c-pointer">&times;</div>'.K_NEWLINE;
	$rstr .= '<div class="qlistc">'.K_NEWLINE; //fieldset

        $rstr .= K_NEWLINE.$str.''.K_NEWLINE;
	$rstr .= '</div>'.K_NEWLINE; //fieldset
        $rstr .= '</div>'.K_NEWLINE; //fieldset
	//$rstr .= '<div id="toggle-button"><div style="font-size:large;width:17px;float:left">&#10094;</div> <div style="float:left;font-size:x-small;width:40px">DAFTAR SOAL</div></div>';
	//$rstr .= '<div id="toggle-button-mini"><div style="font-size:larger;width:17px;float:left">&#10095;</div></div>';
        $rstr .= '<br />'.K_NEWLINE;
    }

    return $rstr;
}
/**
 * Returns the number of omitted questions (unanswered + undisplayed).
 * @param $test_id (int) test ID
 * @return integer number
 */
function F_getNumOmittedQuestions($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    // get the number of omitted questions
    $omitted = F_count_rows(
        K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS,
        'WHERE testlog_testuser_id=testuser_id
			AND testuser_test_id='.$test_id.'
			AND testuser_user_id='.$user_id.'
			AND testuser_status<5
			AND (testlog_change_time IS NULL OR testlog_display_time IS NULL)'
    );
    return $omitted;
}

/**
 * Display a textarea for user's comment.<br>
 * @param $test_id (int) test ID
 * @return string XHTML code
 * @since 4.0.000 (2006-10-01)
 */
function F_testComment($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $td = F_getTestData($test_id);
    $user_id = intval($_SESSION['session_user_id']);
    $str = '';
    // user's comment
    if (F_getBoolean($td['test_comment_enabled'])) {
        // get user's test comment
        $comment = '';
        $sql = 'SELECT testuser_comment
		FROM '.K_TABLE_TEST_USER.'
		WHERE testuser_user_id='.$user_id.'
			AND testuser_test_id='.$test_id.'
			AND testuser_status<4
		LIMIT 1';
        if ($r = F_db_query($sql, $db)) {
            if ($m = F_db_fetch_array($r)) {
                $comment = $m['testuser_comment'];
            }
        } else {
            F_display_db_error();
        }
        $str .= '<label for="testcomment">komentar</label><br />';
        $str .= '<textarea cols="'.K_ANSWER_TEXTAREA_COLS.'" rows="4" name="testcomment" id="testcomment" class="answertext" title="Komentar Test">'.$comment.'</textarea><br />'.K_NEWLINE;
    }
    return $str;
}

/**
 * Updates user's test comment.<br>
 * @param $test_id (int) test ID
 * @param $testcomment (string) user comment.
 * @return string XHTML code
 * @since 4.0.000 (2006-10-01)
 */
function F_updateTestComment($test_id, $testcomment)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $testcomment = F_escape_sql($db, $testcomment);
    $user_id = intval($_SESSION['session_user_id']);
    $sql = 'UPDATE '.K_TABLE_TEST_USER.'
		SET testuser_comment=\''.$testcomment.'\'
		WHERE testuser_test_id='.$test_id.'
			AND testuser_user_id='.$user_id.'
			AND testuser_status<4';
    if (!$r = F_db_query($sql, $db)) {
        F_display_db_error();
    }
}

/**
 * Returns XHTML / CSS formatted page string to insert the test password.<br>
 * The CSS classes used are:
 * <ul>
 * <li>div.login_form : container for login box</li>
 * <li>div.login_form div.login_row : container for label + input field or button</li>
 * <li>div.login_form div.login_row span.label : container for input label</li>
 * <li>div.login_form div.login_row span.formw : container for input form</li>
 * </ul>
 * @param faction String action attribute
 * @param fid String form ID attribute
 * @param fmethod String method attribute (get/post)
 * @param fenctype String enctype attribute
 * @param test_id int ID of the test
 * @return XHTML string for login form
 */
function F_testLoginForm($faction, $fid, $fmethod, $fenctype, $test_id)
{
    global $l;
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_form.php');
	
    $str = '';
   $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
   $str .= '<div class="d-tcell w-150 va-middle"><p class="ft-bold">Token</p></div>'.K_NEWLINE;
   $str .= '<div class="va-middle d-tcell pl-15">'.K_NEWLINE;
   $str .= '<form action="'.$faction.'" method="'.$fmethod.'" id="'.$fid.'" enctype="'.$fenctype.'">'.K_NEWLINE;
	$str .= '<input placeholder="Masukkan Token" type="text" name="xtest_password" id="xtest_password" value="" size="20" maxlength="255" title="Masukkan Token untuk memulai Ujian">'.K_NEWLINE;
	$str .= '</div>'.K_NEWLINE;
        $str .= '<div id="div_cb_pernyataan" class="va-middle d-tcell pl-15">'.K_NEWLINE;
	$str .= '<input type="checkbox" id="pernyataan" name="pernyataan"><label for="pernyataan">Saya berjanji akan mengerjakan Ujian ini dengan jujur, sesuai dengan kemampuan saya sendiri</label>.'.K_NEWLINE;
	$str .= '</div>'.K_NEWLINE;

	$str .= '</div>'.K_NEWLINE;

   $str .= '<div class="bdb-gray1 py-5 px-20 ft-sm">'.K_NEWLINE;
   $str .= '<p style="text-align:right;font-size:medium">'.K_NEWLINE;
    $str .= '<input type="submit" name="mulai" id="mulai" class="bg-grad-hijau bd-none ft-white ft-bold c-pointer brad-100" value="MULAI" title="Klik untuk memulai Test" />'.K_NEWLINE;
   $str .= '</p>'.K_NEWLINE;

   $str .= '<script type="text/javascript">$("input#xtest_password").focus();</script>';
   
   $str .= '</div>'.K_NEWLINE;

    // the following field is used to check if the form has been submitted
    $str .= '<input type="hidden" name="testpswaction" id="testpswaction" value="login" />'.K_NEWLINE;
    $str .= '<input type="hidden" name="testid" id="testid" value="'.intval($test_id).'" />'.K_NEWLINE;
    $str .= F_getCSRFTokenField().K_NEWLINE;
	
    $str .= '</form>'.K_NEWLINE;
    $str .= '</div>'.K_NEWLINE;
    $str .= '</div>'.K_NEWLINE;
    $str .= '</div>'.K_NEWLINE;
    return $str;
}

/**
 * Get a comma separated list of valid group IDs for the selected test.
 * @param $test_id (int) ID of the selected test
 * @return string containing a comma separated list fo group IDs.
 */
function F_getTestGroups($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $ids = '0';
    // select groups in this test
    $sql = 'SELECT tstgrp_group_id FROM '.K_TABLE_TEST_GROUPS.' WHERE tstgrp_test_id='.$test_id.' ORDER BY tstgrp_group_id';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_assoc($r)) {
            $ids .= ','.$m['tstgrp_group_id'];
        }
    } else {
        F_display_db_error();
    }
    return $ids;
}

/**
 * Get a comma separated list of valid SSL certificates IDs for the selected test.
 * @param $test_id (int) ID of the selected test
 * @return string containing a comma separated list SSL certificates IDs.
 */
function F_getTestSSLCerts($test_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $ids = '0';
    // select SSL certificates in this test
    $sql = 'SELECT tstssl_ssl_id FROM '.K_TABLE_TEST_SSLCERTS.' WHERE tstssl_test_id='.$test_id.' ORDER BY tstssl_ssl_id';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_assoc($r)) {
            $ids .= ','.$m['tstssl_ssl_id'];
        }
    } else {
        F_display_db_error();
    }
    return $ids;
}

//============================================================+
// END OF FILE FROM UPDATE 12072020
//============================================================+
