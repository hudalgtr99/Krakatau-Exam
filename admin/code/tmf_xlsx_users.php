<?php


// check user's authorization
require_once('../config/tce_config.php');
$pagelevel = K_AUTH_EXPORT_USERS;
require_once('../../shared/code/tce_authorization.php');
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
$objPHPExcel    =   new PHPExcel();
$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);


echo F_tsv_export_users();


function F_tsv_export_users()
{
    global $l, $db;
    require_once('../config/tce_config.php');

    $tsv = ''; // TSV data to be returned

    // print column names
    $tsv .= 'user_id';
    $tsv .= K_TAB.'user_name';
    $tsv .= K_TAB.'user_password';
    $tsv .= K_TAB.'user_email';
    $tsv .= K_TAB.'user_regdate';
    $tsv .= K_TAB.'user_ip';
    $tsv .= K_TAB.'user_firstname';
    $tsv .= K_TAB.'user_lastname';
    $tsv .= K_TAB.'user_birthdate';
    $tsv .= K_TAB.'user_birthplace';
    $tsv .= K_TAB.'user_regnumber';
    $tsv .= K_TAB.'user_ssn';
    $tsv .= K_TAB.'user_level';
    $tsv .= K_TAB.'user_verifycode';
    $tsv .= K_TAB.'user_otpkey';
    $tsv .= K_TAB.'user_groups';

    $sql = 'SELECT * FROM '.K_TABLE_USERS.' WHERE (user_id>1)';
    if ($_SESSION['session_user_level'] < K_AUTH_ADMINISTRATOR) {
        // filter for level
        $sql .= ' AND ((user_level<'.$_SESSION['session_user_level'].') OR (user_id='.$_SESSION['session_user_id'].'))';
        // filter for groups
        $sql .= ' AND user_id IN (SELECT tb.usrgrp_user_id
			FROM '.K_TABLE_USERGROUP.' AS ta, '.K_TABLE_USERGROUP.' AS tb
			WHERE ta.usrgrp_group_id=tb.usrgrp_group_id
				AND ta.usrgrp_user_id='.intval($_SESSION['session_user_id']).'
				AND tb.usrgrp_user_id=user_id)';
    }
    $sql .= ' ORDER BY user_lastname,user_firstname,user_name';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            $tsv .= K_NEWLINE.$m['user_id'];
            $tsv .= K_TAB.$m['user_name'];
            $tsv .= K_TAB; // password cannot be exported because is encrypted
            $tsv .= K_TAB.$m['user_email'];
            $tsv .= K_TAB.$m['user_regdate'];
            $tsv .= K_TAB.$m['user_ip'];
            $tsv .= K_TAB.$m['user_firstname'];
            $tsv .= K_TAB.$m['user_lastname'];
            $tsv .= K_TAB.substr($m['user_birthdate'], 0, 10);
            $tsv .= K_TAB.$m['user_birthplace'];
            $tsv .= K_TAB.$m['user_regnumber'];
            $tsv .= K_TAB.$m['user_ssn'];
            $tsv .= K_TAB.$m['user_level'];
            $tsv .= K_TAB.$m['user_verifycode'];
            $tsv .= K_TAB.$m['user_otpkey'];
            $tsv .= K_TAB;
            $grp = '';
            // comma separated list of user's groups
            $sqlg = 'SELECT *
				FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
				WHERE usrgrp_group_id=group_id
					AND usrgrp_user_id='.$m['user_id'].'
				ORDER BY group_name';
            if ($rg = F_db_query($sqlg, $db)) {
                while ($mg = F_db_fetch_array($rg)) {
                    $grp .= $mg['group_name'].',';
                }
            } else {
                F_display_db_error();
            }
            if (!empty($grp)) {
                // add user's groups removing last comma
                $tsv .= substr($grp, 0, -1);
            }
        }
    } else {
        F_display_db_error();
    }
    // return $tsv;
	$temp_filename = 'xxx_tcexam_users_'.date('YmdHis').'.csv';
	file_put_contents(K_PATH_CACHE.$temp_filename, $tsv);
	// sleep(3);
	$objReader = PHPExcel_IOFactory::createReader('CSV');
	$objReader->setDelimiter("\t");
	$objPHPExcel = $objReader->load(K_PATH_CACHE.$temp_filename);

	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename=tcexam_users_'.date('YmdHis').'.xlsx'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
	$objWriter->save('php://output');
}

//============================================================+
// END OF FILE
//============================================================+
