<?php

require_once('../config/tce_config.php');
$pagelevel = K_AUTH_INDEX;
require_once('../../shared/code/tce_authorization.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('tce_page_header.php');
echo '
<style>
#licensingInfo{direction:ltr;border-radius:3px;text-align: left;padding: 1em;margin: 1em;background-color:#2196F3;font-weight: bold;color: #fff}
#licensingInfo a {color:yellow}
#adminIndex{margin: 1em;background: #fff;border-radius: 3px;padding: 1em;box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.1);}
#adminIndex a {border-bottom:1px solid #2196f3}
#adminIndex a:hover {color:#fff;background:#2196f3}
</style>
';

function F_widget($title,$subtitle,$content,$bg,$icon='',$url='#',$col='text-white',$iconx=''){
	echo '<div style="cursor:pointer" onclick="window.location.href = &quot;'.$url.'&quot;" class="card shadow-none position-relative mb-3 widget-content '.$bg.'">';
	// echo '<a href="https://google.com">';
	echo '<span class="'.$col.' shadow-none rounded px-2 py-1 position-absolute '.$bg.'" style="top:-15px;right:auto;left:auto"><i class="'.$icon.'">'.$iconx.'</i></span>';
	echo '<div class="widget-content-wrapper '.$col.'">';
	echo '<div class="widget-content-left">';
	echo '<div class="widget-heading">';
	echo $title;
	echo '</div>';
	echo '<div class="widget-subheading">';
	echo $subtitle;
	echo '</div>';
	echo '</div>';
	echo '<div class="widget-content-right">';
	echo '<div class="widget-numbers '.$col.'">';
	// echo F_count_rows(K_TABLE_USERS)-1;
	echo $content;
	echo '</div>';
	echo '</div>';
	echo '</div>';
	// echo '</a>';
	echo '</div>';
}

echo '<div class="row mt-5">';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Group','',F_count_rows(K_TABLE_GROUPS),'bg-midnight-bloom','fa fa-users','tce_edit_group.php');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah User','Semua group',(F_count_rows(K_TABLE_USERS)-1),'bg-arielle-smile','fa fa-user','tce_select_users.php');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah User','Online (termasuk login ganda)',F_count_rows(K_TABLE_SESSIONS),'bg-grow-early','fa fa-wifi','tce_show_online_users.php');
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Modul','',F_count_rows(K_TABLE_MODULES),'bg-sunny-morning','fa fa-book','tce_edit_module.php');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Topik','Semua modul',F_count_rows(K_TABLE_SUBJECTS),'bg-night-fade','fa fa-bookmark','tce_edit_subject.php');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Soal','di Semua Topik',F_count_rows(K_TABLE_QUESTIONS),'bg-strong-bliss','fa fa-question','tce_show_all_questions.php');
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Tes','Total',F_count_rows(K_TABLE_TESTS),'bg-heavy-rain','fa fa-desktop','tce_select_tests.php','text-dark');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
$curdate = date('Y-m-d H:i:s');
F_widget('Jumlah Tes','Selesai',F_count_rows(K_TABLE_TESTS,'where test_end_time < \''.$curdate.'\''),'bg-night-sky','fa fa-lock','tce_select_tests.php');
echo '</div>';
echo '<div class="col-md-4 col-xl-4 mb-1">';
F_widget('Jumlah Tes','Tersisa',F_count_rows(K_TABLE_TESTS,'where test_end_time > \''.$curdate.'\''),'bg-sunny-morning','fa fa-fw','tce_select_tests.php','text-dark','');
echo '</div>';
echo '</div>';

// if (!F_count_rows(K_TABLE_SESSIONS)) { //if the table is void (no items) display message
        // echo '<h2>'.$l['m_databasempty'].'</h2>';
        // return false;
    // }
	
// echo 


echo '<div class="card bg-info text-white"><div class="card-body font-weight-bold">TCEXAM IS SUBJECT TO THE <a class="text-dark" href="http://www.fsf.org/licensing/licenses/agpl-3.0.html" title="External link to GNU Affero General Public License">GNU-AGPL v.3 LICENSE</a> LICENSE WITH THE FOLLOWING ADDITIONAL TERMS:<ul><li>YOU CAN\'T ALTER, REMOVE, MOVE OR HIDE THE ORIGINAL TCEXAM LOGO, COPYRIGHTS STATEMENTS, LINKS TO <a class="text-dark" href="http://www.tecnick.com" title="External link to Tecnick.com">TECNICK.COM</a> AND <a class="text-dark" href="http://www.tcexam.org" title="External link to TCExam">TCEXAM</a> WEBSITES, OTHER PROPRIETARY NOTICES, LEGENDS, SYMBOLS OR LABELS IN THE SOFTWARE.</li><li>TCEXAM NAME AND LOGO ARE TRADEMARKS OF <a class="text-dark" href="http://www.tecnick.com" title="External link to Tecnick.com">TECNICK.COM LTD</a> AND SHALL BE USED IN ACCORDANCE WITH ACCEPTED TRADEMARK PRACTICE, INCLUDING IDENTIFICATION OF TRADEMARK OWNER\'S NAME.</li></ul>FOR ANY USAGE THAT REQUIRES DIFFERENT (COMMERCIAL) LICENSING TERMS, PLEASE CONTACT <a class="text-dark" href="mailto:info@tecnick.com" title="mail to tecnick.com">INFO@TECNICK.COM</a> TO PURCHASE A COMMERCIAL LICENSE.</div></div>'.K_NEWLINE;

// echo K_REMAINING_TESTS;
// Display test limits (if any)

$limits = '';
if (K_REMAINING_TESTS !== false) {
    // count
    $limits .= '<tr';
    if (K_REMAINING_TESTS <= 0) {
        $limits .= ' style="text-align:right;background-color:#FFCCCC;" title="'.$l['w_over_limit'].'"';
    } else {
        $limits .= ' style="text-align:right;background-color:#CCFFCC;" title="'.$l['w_under_limit'].'"';
    }
    $limits .= '><td style="text-align:left;">'.$l['w_total'].'</td><td>&nbsp;</td><td>&nbsp;</td><td>'.K_REMAINING_TESTS.'</td></tr>';
}
$now = time();
$enddate = date(K_TIMESTAMP_FORMAT, $now);
if (K_MAX_TESTS_DAY !== false) {
    // day limit (last 24 hours)
    $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_DAY));
    $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
    $limits .= '<tr';
    if ((K_MAX_TESTS_DAY - $numtests) <= 0) {
        $limits .= ' style="text-align:right;background-color:#FFCCCC;" title="'.$l['w_over_limit'].'"';
    } else {
        $limits .= ' style="text-align:right;background-color:#CCFFCC;" title="'.$l['w_under_limit'].'"';
    }
    $limits .= '><td style="text-align:left;">'.$l['w_day'].'</td><td>'.K_MAX_TESTS_DAY.'</td><td>'.$numtests.'</td><td><strong>'.(K_MAX_TESTS_DAY - $numtests).'</strong></td></tr>';
}
if (K_MAX_TESTS_MONTH !== false) {
    // month limit (last 30 days)
    $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_MONTH));
    $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
    $limits .= '<tr';
    if ((K_MAX_TESTS_MONTH - $numtests) <= 0) {
        $limits .= ' style="text-align:right;background-color:#FFCCCC;" title="'.$l['w_over_limit'].'"';
    } else {
        $limits .= ' style="text-align:right;background-color:#CCFFCC;" title="'.$l['w_under_limit'].'"';
    }
    $limits .= '><td style="text-align:left;">'.$l['w_month'].'</td><td>'.K_MAX_TESTS_MONTH.'</td><td>'.$numtests.'</td><td><strong>'.(K_MAX_TESTS_MONTH - $numtests).'</strong></td></tr>';
}
if (K_MAX_TESTS_YEAR !== false) {
    // year limit (last 365 days)
    $startdate = date(K_TIMESTAMP_FORMAT, ($now - K_SECONDS_IN_YEAR));
    $numtests = F_count_rows(K_TABLE_TESTUSER_STAT, 'WHERE tus_date>=\''.$startdate.'\' AND tus_date<=\''.$enddate.'\'');
    $limits .= '<tr';
    if ((K_MAX_TESTS_YEAR - $numtests) <= 0) {
        $limits .= ' style="text-align:right;background-color:#FFCCCC;" title="'.$l['w_over_limit'].'"';
    } else {
        $limits .= ' style="text-align:right;background-color:#CCFFCC;" title="'.$l['w_under_limit'].'"';
    }
    $limits .= '><td style="text-align:left;">'.$l['w_year'].'</td><td>'.K_MAX_TESTS_YEAR.'</td><td>'.$numtests.'</td><td><strong>'.(K_MAX_TESTS_YEAR - $numtests).'</strong></td></tr>';
}
if (strlen($limits) > 0) {
    echo '<table style="border: 1px solid #808080;margin-left:auto; margin-right:auto;"><tr><th colspan="4" style="text-align:center;">'.$l['w_remaining_tests'].'</th></tr><tr style="background-color:#CCCCCC;"><th>'.$l['w_limit'].'</th><th>'.$l['w_max'].'</th><th>'.$l['w_executed'].'</th><th>'.$l['w_remaining'].'</th></tr>'.$limits.'</table><br />'.K_NEWLINE;
}
echo '<div class="card my-3">';
echo '<div class="card-body">';
echo $l['d_admin_index'];
echo '</div>';
echo '</div>';

require_once('tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
