<?php
//============================================================+
// File name	: tmf_import_offline_users_answer.php
// Author		: Maman Sulaeman
// Lisensi		: -
//============================================================+

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
$thispage_title = $l['t_test_execute'];
$thispage_description = $l['hp_test_execute'];
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_test.php');

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
// echo strlen($_GET['data_jawaban']);
if(strlen($_GET['data_jawaban'])>12){
		// echo $filename;
		echo $_GET['data_jawaban'];
		// echo 'ooo';
		// die();
		
		$encodedFile = strip_tags($_GET['data_jawaban']);
		
		$eFArr = explode(',',$encodedFile);
		$sukses = 'Import data sukses untuk TestUserID: ';
		foreach($eFArr as $value){
			//$arrValue = strip_tags($value);
			$decodeFile = base64_decode($value);
			// echo $decodeFile;
			// die();
			$exp = explode('%0D%0', urlencode($decodeFile));
			// echo urlencode($exp[0]);
			// die();
			file_put_contents(K_PATH_MAIN.'cache/offline-answers/'.$exp[0].'.txt', $decodeFile);
			
			$arrAnswer = file(K_PATH_MAIN.'cache/offline-answers/'.$exp[0].'.txt');
			
			// echo $arrAnswer[0];
			// die();
			$testiduserid = $arrAnswer[0];
			// print_r($testiduserid);
			//cek
		//	echo $testiduserid_enc."<br/>";

		//	$testiduserid_dec = base64_decode($testiduserid_enc);
			$testiduserid_arr = explode('-', $testiduserid);
		//	print_r($testiduserid_arr);
			//get test id and user id from encoded string
			$test_id=$testiduserid_arr[0];
			$user_id=$testiduserid_arr[1];

			//cek
		//	echo $test_id."<br/>";
		//	echo $user_id."<br/>";
		//	die();
		//	echo "<br/>";

			$sqltu = 'SELECT * FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_user_id='.$user_id;
			F_startOfflineTest($test_id, $user_id);

		//	echo $test_id."<br/>";
		//	echo $user_id."<br/>";
			// find test_id, user_id, and testuser_id
			// testuser_id will find question allocated for the user

			if($r = F_db_query($sqltu, $db)){
				if($m = F_db_fetch_array($r)){
					$testuser_id = $m[0];
					//cek
		//			echo $testuser_id."<br/>";
		//			echo "<br/>";


					$sqltl = 'SELECT * FROM '.K_TABLE_TESTS_LOGS.' WHERE testlog_testuser_id='.$testuser_id.' ORDER BY testlog_id ASC';

					if($rtl = F_db_query($sqltl, $db)){

						$sss = array('1','2','3','4','5','6','7','8','9','0');
						$rrr = array('','','','','','','','','','');
						$rm_num = str_replace($sss,$rrr,$arrAnswer);

						$search = array('A','B','C','D','E','.',',');
						$rep = array(1,2,3,4,5,'','');
						$carr = str_replace($search,$rep,$rm_num);

						//answer start from 2nd index, coz 1st index is testhash
						//$i=1;
						array_shift($carr);
		//				print_r(array($carr));
						//cek

		//				echo "<br/>";
		//				echo "<br/>";
						$i=0;
		//				print_r($rtl);
						while($mtl = F_db_fetch_array($rtl)){
							//cek
		//					sort($mtl);
		//					echo $test_id."<br/>";
		//					echo $mtl[0]."<br/>";
		//					print_r($mtl);

		//					foreach($carr as $ans_item){
		//						echo $user_id."-".$test_id."-".$ans_item."<br/>";
		//						echo $test_id."<br/><br/>";
		//						echo $mtl[0]."<br/>";
		//						echo "F_updateQuestionLog(".$test_id.", ".$mtl[0].", array(".$ans_item."=>1), '', 0, '')<br/>";
		//						echo $carr[$i]."<br/><br/>";
		//						F_updateQuestionLog($test_id, $mtl[0], array($ans_item=>1), '', 0, '');
		//					}

							//echo print_r(array($carr[$i]=>1))."<br/>";

							F_updateQuestionLog($test_id, $mtl[0], array($carr[$i]=>1), '', 0, '');
							$i++;
						}
					}
				}
			}
			file_put_contents(K_PATH_MAIN.'cache/offline-answers/'.$exp[0].'.txt', $value);	
			$sukses .= $exp[0].', ';
			
		
		
		
		
		}
		// $sukses .= rtrim($sukses,', ');
		$sukses .= 'Reload halaman untuk melihat perubahan nilai.';
		echo $sukses;
		// die();
}else{
	// echo 'zzz';
	//get answer file
	$path = K_PATH_MAIN.'cache/offline-answers';
	$answer_files = scandir($path);
	$answer_files = array_diff(scandir($path), array('.', '..'));
	// $matches = array_diff(scandir($path), array('.', '..'));

	// print_r($answer_files);
	// die();
	
	/**if(isset($_GET['test_id']) and $_GET['test_id'] > 0){
		$search = $_GET['test_id']."-";
	}else{
		echo "Pilih terlebih dahulu Nama Test yang akan diproses.";
		die();
	}**/
	$search = ".txt";
	$matches = array_filter($answer_files, function($var) use ($search) { return preg_match("/\b$search\b/i", $var); });
	// print_r($matches);
	//die();
	//print_r($matches);
	//die();
	foreach($matches as $filename){
		// echo $filename;
		$encodedFile = strip_tags(file_get_contents(K_PATH_MAIN.'cache/offline-answers/'.$filename));
		$djArray=explode(',',$encodedFile);
		
		foreach($djArray as $value){
			// file_put_contents($no.'.txt',$value);
			// $no++;
			$decodeFile = base64_decode($value);
			// echo $decodeFile;
			file_put_contents(K_PATH_MAIN.'cache/offline-answers/'.$filename, $decodeFile);
			
			$arrAnswer = file(K_PATH_MAIN.'cache/offline-answers/'.$filename);
			
			// echo base64_decode($arrAnswer[0]);
			$testiduserid = $arrAnswer[0];
			// print_r($testiduserid);
			//cek
		//	echo $testiduserid_enc."<br/>";

		//	$testiduserid_dec = base64_decode($testiduserid_enc);
			$testiduserid_arr = explode('-', $testiduserid);
		//	print_r($testiduserid_arr);
			//get test id and user id from encoded string
			$test_id=$testiduserid_arr[0];
			$user_id=$testiduserid_arr[1];

			//cek
		//	echo $test_id."<br/>";
		//	echo $user_id."<br/>";
		//	die();
		//	echo "<br/>";

			$sqltu = 'SELECT * FROM '.K_TABLE_TEST_USER.' WHERE testuser_test_id='.$test_id.' AND testuser_user_id='.$user_id;
			F_startOfflineTest($test_id, $user_id);

		//	echo $test_id."<br/>";
		//	echo $user_id."<br/>";
			// find test_id, user_id, and testuser_id
			// testuser_id will find question allocated for the user

			if($r = F_db_query($sqltu, $db)){
				if($m = F_db_fetch_array($r)){
					$testuser_id = $m[0];
					//cek
		//			echo $testuser_id."<br/>";
		//			echo "<br/>";

					$sqltl = 'SELECT * FROM '.K_TABLE_TESTS_LOGS.' WHERE testlog_testuser_id='.$testuser_id.' ORDER BY testlog_id ASC';

					if($rtl = F_db_query($sqltl, $db)){

						$sss = array('1','2','3','4','5','6','7','8','9','0');
						$rrr = array('','','','','','','','','','');
						$rm_num = str_replace($sss,$rrr,$arrAnswer);

						$search = array('A','B','C','D','E','.',',');
						$rep = array(1,2,3,4,5,'','');
						$carr = str_replace($search,$rep,$rm_num);

						//answer start from 2nd index, coz 1st index is testhash
						//$i=1;
						array_shift($carr);
		//				print_r(array($carr));
						//cek

		//				echo "<br/>";
		//				echo "<br/>";
						$i=0;
		//				print_r($rtl);
						while($mtl = F_db_fetch_array($rtl)){
							//cek
		//					sort($mtl);
		//					echo $test_id."<br/>";
		//					echo $mtl[0]."<br/>";
		//					print_r($mtl);

		//					foreach($carr as $ans_item){
		//						echo $user_id."-".$test_id."-".$ans_item."<br/>";
		//						echo $test_id."<br/><br/>";
		//						echo $mtl[0]."<br/>";
		//						echo "F_updateQuestionLog(".$test_id.", ".$mtl[0].", array(".$ans_item."=>1), '', 0, '')<br/>";
		//						echo $carr[$i]."<br/><br/>";
		//						F_updateQuestionLog($test_id, $mtl[0], array($ans_item=>1), '', 0, '');
		//					}

							//echo print_r(array($carr[$i]=>1))."<br/>";

							F_updateQuestionLog($test_id, $mtl[0], array($carr[$i]=>1), '', 0, '');
							$i++;
						}
					}
				}
			}
			file_put_contents(K_PATH_MAIN.'cache/offline-answers/'.$filename, $encodedFile);
			rename(K_PATH_MAIN.'cache/offline-answers/'.$filename, K_PATH_MAIN.'cache/offline-answers-backup/'.$filename);
		}
		
		
	}
	echo 'Selesai melakukan koreksi jawaban. Reload halaman untuk melihat perubahan nilai.';
}
// echo "Selesai";
