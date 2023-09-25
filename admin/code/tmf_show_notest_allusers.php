<!--style>


#mmCloseBtn{
    align-self: center;
	padding: 1em 0.85em !important;
}


table tr td{
	width:auto !important
}

table tr:nth-child(odd) td {
    background: transparent!important;
}
td{
    border-right: 1px solid rgba(0,0,0,0.15);
}
</style-->
<style>
.table th, .table td {
    vertical-align: unset !important;
}
</style>
<?php
// print_r($_REQUEST);
require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
//$pagelevel = 7;
require_once('../../shared/code/tce_authorization.php');
$thispage_title = 'Rekap Kehadiran Test';
$thispage_title_icon = "<i class='pe-7s-display1 icon-gradient bg-love-kiss'></i> ";
// $thispage_help = "<i class='fas fa-chalkboard-teacher'></i> ";

$enable_calendar = true;
require_once('tce_page_header.php');

require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_test.php');
require_once('../../shared/code/tce_functions_test_stats.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('../../shared/code/tce_functions_statistics.php');
require_once('tce_functions_user_select.php');

$filter = 'sel=1';

if (isset($_REQUEST['selectcategory'])) {
    $changecategory = 1;
}
if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied']);
        exit;
    }
    $filter .= '&amp;test_id='.$test_id.'';
    $test_group_ids = F_getTestGroups($test_id);
} else {
    $test_id = 0;
}
if (isset($_REQUEST['user_id'])) {
    $user_id = intval($_REQUEST['user_id']);
    $filter .= '&amp;user_id='.$user_id;
} else {
    $user_id = 0;
}
if (isset($_REQUEST['group_id']) and !empty($_REQUEST['group_id'])) {
    $group_id = intval($_REQUEST['group_id']);
    $filter .= '&amp;group_id='.$group_id.'';
} else {
    $group_id = 0;
}

// filtering options
if (isset($_REQUEST['startdate'])) {
    $startdate = $_REQUEST['startdate'];
    $startdate_time = strtotime($startdate);
    $startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
} else {
    $startdate = date('Y').'-01-01 00:00:00';
}
$filter .= '&amp;startdate='.urlencode($startdate);
if (isset($_REQUEST['enddate'])) {
    $enddate = $_REQUEST['enddate'];
    $enddate_time = strtotime($enddate);
    $enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
} else {
    $enddate = date('Y').'-12-31 23:59:59';
}
$filter .= '&amp;enddate='.urlencode($enddate).'';

// echo $filter;
// echo $group_id;

echo '<div class="card mb-3">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_resultallusers">'.K_NEWLINE;

echo '<div class="rowlll mb-3">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_id" class="text-capitalize">'.$l['w_test'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
//echo '<select name="test_id" id="test_id" size="0" onchange="document.getElementById(\'form_resultallusers\').changecategory.value=1; document.getElementById(\'form_resultallusers\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
echo '<select class="form-control custom-control select2-single" name="test_id" id="test_id" size="0" title="'.$l['h_test'].'">'.K_NEWLINE;
$sql = F_select_executed_tests_sql();
if ($r = F_db_query($sql, $db)) {

//maman mod start
if($_SESSION['session_user_level']==10){
//if($a_authUsers){
    echo '<option value="0"';
    if ($test_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
}
// maman mod end
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['test_id'].'"';
        if ($m['test_id'] == $test_id) {
            echo ' selected="selected"';
        }
        echo '>'.substr($m['test_begin_time'], 0, 10).' '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_tests_popup.php?cid=test_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\');return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo getFormRowTextInput('startdate', $l['w_time_begin'], $l['w_time_begin'].' '.$l['w_datetime_format'], '', $startdate, '', 19, false, false, 'datetime-local', '', true);
echo getFormRowTextInput('enddate', $l['w_time_end'], $l['w_time_end'].' '.$l['w_datetime_format'], '', $enddate, '', 19, false, false, 'datetime-local', '', true);

echo '<div class="rowlll input-group">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label for="group_id" class="input-group-text">'.$l['w_group'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<span class="formw">'.K_NEWLINE;
//echo '<select name="group_id" id="group_id" size="0" onchange="document.getElementById(\'form_resultallusers\').submit()">'.K_NEWLINE;
echo '<select class="custom-control select2-single" name="group_id" id="group_id" size="0">'.K_NEWLINE;
$sql = 'SELECT * FROM '.K_TABLE_GROUPS.'';
if ($test_id > 0) {
    $sql .= ' WHERE group_id IN ('.$test_group_ids.')';
}
$sql .= ' ORDER BY group_name';
if ($r = F_db_query($sql, $db)) {
    echo '<option value="0"';
    if ($group_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['group_id'].'"';
        if ($m['group_id'] == $group_id) {
            echo ' selected="selected"';
        }
        echo '>'.htmlspecialchars($m['group_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
    }
} else {
    // echo '</select></span></div>'.K_NEWLINE;
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
// echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="rowlll mt-3">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="user_id" class="text-capitalize">'.$l['w_user'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
//echo '<select name="user_id" id="user_id" size="0" onchange="document.getElementById(\'form_resultallusers\').submit()">'.K_NEWLINE;
echo '<select class="custom-control select2-single" name="user_id" id="user_id" size="0">'.K_NEWLINE;
$sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.'';
if ($test_id > 0) {
    $sql .= ', '.K_TABLE_TEST_USER.' WHERE testuser_user_id=user_id AND testuser_test_id='.$test_id.'';
} elseif ($group_id > 0) {
    $sql .= ', '.K_TABLE_USERGROUP.' WHERE usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.' AND user_id>1';
} else {
    $sql .= ' WHERE user_id>1';
}
$sql .= ' GROUP BY user_id, user_lastname, user_firstname, user_name ORDER BY user_lastname, user_firstname, user_name';
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    echo '<option value="0"';
    if ($user_id == 0) {
        echo ' selected="selected"';
    }
    echo '>&nbsp;-&nbsp;</option>'.K_NEWLINE;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['user_id'].'"';
        if ($m['user_id'] == $user_id) {
            echo ' selected="selected"';
        }
        echo '>'.$countitem.'. '.htmlspecialchars($m['user_lastname'].' '.$m['user_firstname'].' - '.$m['user_name'].'', ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
} else {
    echo '</select></span></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
// $jsaction = 'selectWindow=window.open(\'tce_select_users_popup.php?cid=user_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;';
// echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo getFormNoscriptSelect('selectgroup');

echo '<div class="card-footer">'.K_NEWLINE;
echo '<span class="label">&nbsp;</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input class="btn btn-primary" type="submit" name="selectcategory" id="selectcategory" value="'.$l['w_select'].'" />'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// ---------------------------------------------------------------------
$itemcount = 0;
if (isset($_REQUEST['sel'])) {
//maman mod
if($test_id>0){
	$wheretl=' WHERE test_id='.$test_id;
}else{
	$wheretl='';
}
//	$no=1;
?>
<div class="card mb-3">
<div class="card-body">
<table id="rekapKehadiran" class="table table-responsive">
	<thead>
		<tr>
			<th>No</th><th>Nama Ujian</th><th>Jumlah Peserta</th><th>Jumlah Hadir</th><th>Persentase Kehadiran</th><th>Jumlah Tidak Hadir</th><th>Persentase Ketidakhadiran</th>
		</tr>
	</thead>
	<tbody>
<?php
	$sqltl = 'SELECT test_id,test_name FROM '.K_TABLE_TESTS.$wheretl;
	if($rtl = F_db_query($sqltl, $db)){
		$notest=1;
		while($mtl = F_db_fetch_array($rtl)){
			echo "<tr>";
			echo "<td rowspan=2>".$notest."</td><td>".$mtl[1]."</td>";
			$sqlgl = 'SELECT DISTINCT tstgrp_group_id FROM '.K_TABLE_TEST_GROUPS.' WHERE tstgrp_test_id='.$mtl[0];
			if($rgl = F_db_query($sqlgl, $db)){
				$no=1;
				$b_ujian=1;
				$s_ujian=1;
				$dt_b_ujian=array();
				$dt_s_ujian=array();
				while($mgl = F_db_fetch_array($rgl)){
//					echo "&nbsp;&nbsp;&nbsp;Group ID = ".$mgl[0]."<br/>";
					if($group_id>0){
						// $group_ids = $group_id;
						// echo $group_id.'___'.$mgl[0];
						if($group_id==$mgl[0]){
							// echo $mgl[0];
							$group_ids = $mgl[0];
						}
					}else{
						$group_ids = $mgl[0];
					}
					// echo $group_ids.'<br/>';
					
					if(isset($group_ids)){
						// echo $user_id.'<br/>';
					$sqlul = 'SELECT usrgrp_user_id FROM '.K_TABLE_USERGROUP.' WHERE usrgrp_group_id='.$group_ids;
					if($user_id>0){
						$sqlul .= ' AND usrgrp_user_id='.$user_id;
					}
					if($rul = F_db_query($sqlul, $db)){
						while($mul = F_db_fetch_array($rul)){
							// echo $startdate;
//							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User ID = ".$mul[0]."<br/>";
							// $sqltu = 'SELECT COUNT(testuser_id),testuser_creation_time FROM '.K_TABLE_TEST_USER.' WHERE testuser_user_id='.$mul[0].' AND testuser_test_id='.$mtl[0].' AND testuser_creation_time != \'0001-01-01 00:00:00\' LIMIT 1';
							$sqltu = 'SELECT COUNT(testuser_id),testuser_creation_time FROM '.K_TABLE_TEST_USER.' WHERE testuser_user_id='.$mul[0].' AND testuser_test_id='.$mtl[0].' AND testuser_creation_time >= \''.$startdate.'\' AND testuser_creation_time <= \''.$enddate.'\' LIMIT 1';
							if($rtu = F_db_query($sqltu, $db)){
								if($mtu = F_db_fetch_array($rtu)){
									$testdata = F_getUserData($mul[0]);
									// print_r($testdata);
									
									if($mtu[0]==0){
										$status_test="Belum Ujian";
										$b_ujian++;
										$ret = '';
										$sqlg = 'SELECT DISTINCT *
											FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
											WHERE usrgrp_group_id=group_id
												AND usrgrp_user_id='.$testdata['user_id'];
										if ($rg = F_db_query($sqlg, $db)) {
											while ($mg = F_db_fetch_array($rg)) {
												$ret .= '<span class="badge badge-alternate">'.$mg['group_name'].'</span>&nbsp;';
											}
										} else {
											F_display_db_error();
										}
				
										array_push($dt_b_ujian,"<span class='badge badge-secondary'>".$testdata['user_name']."</span> <span class='badge badge-info'>".$testdata['user_firstname']."</span> ".$ret);										
									}else{
										$status_test="Sudah Ujian";
										$s_ujian++;
										array_push($dt_s_ujian,"<span class='badge badge-light'>".$testdata['user_name']."</span> <span class='badge badge-primary'>".$testdata['user_firstname']."</span>");
									}
									$no++;
								}
							}
						}
					}
					}
					
					
					
				}
			}
			// echo count(array_unique($dt_s_ujian));

			// echo count(array_unique($dt_b_ujian));

			$jml_pes=count(array_unique($dt_s_ujian))+count(array_unique($dt_b_ujian));
			$jml_b_ujian=count(array_unique($dt_b_ujian));
			$jml_s_ujian=count(array_unique($dt_s_ujian));
			$perc_b_ujian=@round($jml_b_ujian/$jml_pes*100,2);
			$perc_s_ujian=@round($jml_s_ujian/$jml_pes*100,2);
			if(is_nan($perc_b_ujian)){
				$perc_b_ujian='-';
			}else{
				$perc_b_ujian=$perc_b_ujian.'%';
			}
			if(is_nan($perc_s_ujian)){
				$perc_s_ujian='-';
			}else{
				$perc_s_ujian=$perc_s_ujian.'%';
			}
			if($jml_pes===0){
				$jml_pes='-';
				$jml_s_ujian='-';
				$jml_b_ujian='-';
			}

			echo "<td>".$jml_pes."</td>";
			echo "<td>".$jml_s_ujian."</td><td>".$perc_s_ujian."</td>";
			echo "<td>".$jml_b_ujian."</td><td>".$perc_b_ujian;
			
			echo "</td></tr><tr><td colspan=2>Peserta tidak hadir</td><td colspan=4><ol>";
			if(count(array_unique($dt_b_ujian))>0){
				foreach(array_unique($dt_b_ujian) as $item){
					echo "<li>".$item."</li>";
				}
			}else{
				echo '<li><span class="badge badge-danger">-</span></li>';
			}
			echo "</ol></td></tr>";
			$notest++;
		}
	}
	echo "</tbody></table>";
	echo '<a id="export_to_excel" href="#" class="btn btn-primary" title="'.$l['h_pdf'].'" onclick="exportTableToExcel(\'rekapKehadiran\');"><i class="fa fa-file-excel"></i>&nbsp;Export ke Excel</a> '.K_NEWLINE;
//die();
}
echo '</div>';
echo '</div>';

echo '<input type="hidden" name="sel" id="sel" value="1" />'.K_NEWLINE;
//echo '<input type="hidden" name="order_field" id="order_field" value="'.$order_field.'" />'.K_NEWLINE;
//echo '<input type="hidden" name="orderdir" id="orderdir" value="'.$orderdir.'" />'.K_NEWLINE;
// comma separated list of required fields
echo '<input type="hidden" name="ff_required" id="ff_required" value="" />'.K_NEWLINE;
echo '<input type="hidden" name="ff_required_labels" id="ff_required_labels" value="" />'.K_NEWLINE;
echo '<input type="hidden" name="itemcount" id="itemcount" value="'.$itemcount.'>" />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</div>';
echo '</div>';

require_once('../code/tce_page_footer.php');
//============================================================+
// END OF FILE
//============================================================+
