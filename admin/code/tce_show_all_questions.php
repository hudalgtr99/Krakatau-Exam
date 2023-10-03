<?php

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
require_once('../../shared/code/tce_authorization.php');

// $thispage_title = $l['t_questions_list'];
$thispage_title = "Kelola Bank Soal";
$thispage_title_icon = '<i class="pe-7s-news-paper icon-gradient bg-sunny-morning"></i> ';
$thispage_help = $l['hp_select_all_questions'];

require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form_admin.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('tce_functions_questions.php');
?>
<!--style>
	table tr td{width:auto}
	table tr:nth-child(odd) td{background:initial}
	table tr:nth-child(even) {background:#f7f7f7}
	ul.question li div:nth-child(2) *{font-size:inherit}
</style-->
<?php
// --- Initialize variables

// set default values
$wherequery='';
$order_field = 'question_enabled DESC, question_position,';
if (K_DATABASE_TYPE == 'ORACLE') {
    $order_field .= ' CAST(question_description as varchar2(100))';
} else {
    $order_field .= ' question_description';
}
if (!isset($orderdir)) {
    $orderdir=0;
}
if (!isset($firstrow)) {
    $firstrow=0;
}
if (!isset($rowsperpage)) {
    $rowsperpage=K_MAX_ROWS_PER_PAGE;
}
if (!isset($hide_answers)) {
    $hide_answers=false;
}

if (isset($selectmodule)) {
    $changemodule = 1;
}
if (isset($selectcategory)) {
    $changecategory = 1;
}
if ((isset($changemodule) and ($changemodule > 0)) or (isset($changecategory) and ($changecategory > 0))) {
    $wherequery = '';
    $firstrow = 0;
    $orderdir = 0;
    $order_field = 'question_enabled DESC, question_position,';
    if (K_DATABASE_TYPE == 'ORACLE') {
        $order_field .= ' CAST(question_description as varchar2(100))';
    } else {
        $order_field .= ' question_description';
    }
}
if (isset($subject_module_id)) {
    $subject_module_id = intval($subject_module_id);
} else {
    // select default module/subject (if not specified)
    $sql = F_select_modules_sql().' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $subject_module_id = $m['module_id'];
        } else {
            $subject_module_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

// check user's authorization
if (!F_isAuthorizedUser(K_TABLE_MODULES, 'module_id', $subject_module_id, 'module_user_id')) {
    F_print_error('ERROR', $l['m_authorization_denied']);
    require_once('../code/tce_page_footer.php');
    exit;
}

if (isset($subject_id)) {
    $subject_id = intval($subject_id);
}

// select subject
if ((isset($changemodule) and ($changemodule > 0))
    or (!(isset($subject_id) and ($subject_id > 0)))) {
    $sql = F_select_subjects_sql('subject_module_id='.$subject_module_id.'').' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $subject_id = $m['subject_id'];
        } else {
            $subject_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

if (isset($menu_mode) and ($menu_mode == 'update') and isset($menu_action) and !empty($menu_action)) {
    $istart = 1 + $firstrow;
    $iend = $rowsperpage + $firstrow;
    for ($i = $istart; $i <= $iend; $i++) {
        // for each selected question
        $keyname = 'questionid'.$i;
        if (isset($$keyname)) {
            $question_id = $$keyname;
            switch ($menu_action) {
                case 'move': {
                    if (isset($new_subject_id) and ($new_subject_id > 0)) {
                        F_question_copy($question_id, $new_subject_id);
                        F_question_delete($question_id, $subject_id);
                    }
                    break;
                }
                case 'copy': {
                    if (isset($new_subject_id) and ($new_subject_id > 0)) {
                        F_question_copy($question_id, $new_subject_id);
                    }
                    break;
                }
                case 'delete': {
                    F_question_delete($question_id, $subject_id);
                    break;
                }
                case 'disable': {
                    F_question_set_enabled($question_id, false);
                    break;
                }
                case 'enable': {
                    F_question_set_enabled($question_id, true);
                    break;
                }
            } // end of switch
        }
    }
    F_print_error('MESSAGE', $l['m_updated']);
}

echo '<link href="../../shared/jscripts/vendor/dropzonejs/dropzone.css" rel="stylesheet">'.K_NEWLINE;
echo '<script src="../../shared/jscripts/vendor/dropzonejs/dropzone.js"></script>'.K_NEWLINE;
echo '<style>'.K_NEWLINE;
echo '.dropzone{border: 2px dashed rgba(0, 0, 0, 0.3);border-radius:10px}';
echo '</style>'.K_NEWLINE;

echo '<div class="main-card mb-3 card">'.K_NEWLINE;

echo '<div class="card-body">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_selectquestions">'.K_NEWLINE;

echo '<div class="form-row">'.K_NEWLINE;
echo '<div class="input-group col-md-6">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="subject_module_id">'.ucfirst($l['w_module']).'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="subject_module_id" id="subject_module_id" size="0" onchange="document.getElementById(\'form_selectquestions\').changemodule.value=1;document.getElementById(\'form_selectquestions\').changecategory.value=1; document.getElementById(\'form_selectquestions\').submit();" title="'.$l['w_module'].'">'.K_NEWLINE;
$nama_modul = '';
$nama_topik = '';
$sql = F_select_modules_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['module_id'].'"';
        if ($m['module_id'] == $subject_module_id) {
            echo ' selected="selected"';
			$nama_modul = $m['module_name'];
        }
        echo '>'.$countitem.'. ';
        if (F_getBoolean($m['module_enabled'])) {
            echo '+';
        } else {
            echo '-';
        }
		
        echo ' '.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'&nbsp;</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<input type="hidden" name="changemodule" id="changemodule" value="" />'.K_NEWLINE;

echo getFormNoscriptSelect('selectmodule');

echo '<div class="input-group col-md-6">'.K_NEWLINE;
echo '<div class="input-group-prepend">'.K_NEWLINE;
echo '<label class="input-group-text" for="subject_id">'.$l['w_subject'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '<select class="custom-select select2-single" name="subject_id" id="subject_id" size="0" onchange="document.getElementById(\'form_selectquestions\').changecategory.value=1;document.getElementById(\'form_selectquestions\').submit()" title="'.$l['h_subject'].'">'.K_NEWLINE;
$sql = F_select_subjects_sql('subject_module_id='.$subject_module_id);
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['subject_id'].'"';
        if ($m['subject_id'] == $subject_id) {
            echo ' selected="selected"';
			$nama_topik = $m['subject_name'];
        }
        echo '>'.$countitem.'. ';
        if (F_getBoolean($m['subject_enabled'])) {
            echo '+';
        } else {
            echo '-';
        }
        echo ' '.htmlspecialchars($m['subject_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
} else {
    echo '</select></div>'.K_NEWLINE;
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo '<div class="custom-checkbox custom-control mt-2">'.K_NEWLINE;
echo '<input class="custom-control-input" type="checkbox" name="hide_answers" id="hide_answers" value="1"';
if ($hide_answers) {
    echo ' checked="checked"';
}
echo ' title="'.$l['w_hide_answers'].'" onclick="toggleAnswer()" />';
echo '<label class="custom-control-label" for="hide_answers">'.$l['w_hide_answers'].'</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

// echo '<div class="row"><hr /></div>'.K_NEWLINE;

// display questions statistics
$qtype = array(
	'<button type="button" data-toggle="tooltip" class="border-0 badge badge-primary rounded-pill" data-original-title="'.$l['w_single_answer'].'" title="'.$l['w_single_answer'].'">S</button>', 
	'<button type="button" data-toggle="tooltip" class="border-0 badge badge-success rounded-pill" data-original-title="'.$l['w_multiple_answers'].'" title="'.$l['w_multiple_answers'].'">M</button>', 
	'<button type="button" data-toggle="tooltip" class="border-0 badge badge-warning rounded-pill" data-original-title="'.$l['w_free_answer'].'" title="'.$l['w_free_answer'].'">T</button>', 
	'<button type="button" data-toggle="tooltip" class="border-0 badge badge-alternate rounded-pill" data-original-title="'.$l['w_ordering_answer'].'" title="'.$l['w_ordering_answer'].'">O</button>'); // question types
$qstat = '';
$nqsum = 0;
$sql = 'SELECT question_type, COUNT(*) as numquestions
	FROM '.K_TABLE_QUESTIONS.'
	WHERE question_subject_id='.$subject_id.'
	GROUP BY question_type';
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        $nqsum += $m['numquestions'];
        $qstat .= '  <span class="spanbox questionNum">'.$m['numquestions'].' '.$qtype[($m['question_type']-1)].'</span>';
    }
} else {
    F_display_db_error();
}

echo '<div id="qStatbar" class="alert alert-light border border-light fade show mt-2">';
echo '<div class="d-flex justify-content-between align-items-center">';
echo '<div>Jumlah '.$l['w_questions'].' <div class="badge badge-dark rounded-pill">'.$nqsum.'</div></div>';
echo '<div class="d-flex justify-content-end mb-1"><a data-toggle="tooltip" title="Menambahkan butir soal baru pada topik terpilih saat ini" class="btn btn-sm btn-outline-primary border-0" href="tce_edit_question.php?subject_module_id='.$subject_module_id.'&amp;question_subject_id='.$subject_id.'"><span class=""><i class="fa fa-plus-square"></i> Tambah soal baru</span></a></div>'.K_NEWLINE;
echo '<div class="text-right"><i class="pe-7s-keypad"></i>'.substr_replace($qstat,'',1,1).'</div>';
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo '<div class="rowl">'.K_NEWLINE;

if (isset($subject_id) and ($subject_id > 0)) {
    F_show_select_questions($wherequery, $subject_module_id, $subject_id, $order_field, $orderdir, $firstrow, $rowsperpage, $hide_answers);
}

// echo '&nbsp;'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
// echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo '<div class="card-footer" id="btnAction">'.K_NEWLINE;
// echo $nama_modul;
// echo $nama_topik;

// show buttons by case
echo '<div class="card border shadow-none">';
echo '<div class="card-header"><i class="fa fa-download"></i>&nbsp;Export Bank Soal</div>';
echo '<div class="card-body p-1">';
echo '<div class="form-row justify-content-center">';
if (isset($subject_id) and ($subject_id > 0)) {
    $pdflink = 'tce_pdf_all_questions.php';
    $pdflink .= '?module_id='.$subject_module_id;
    $pdflink .= '&amp;subject_id='.$subject_id;
    $pdflink .= '&amp;hide_answers='.intval($hide_answers); // hide answers option
    echo '<a class="btn btn-danger col-md-2 m-1" href="'.$pdflink.'&amp;expmode=1" title="'.$l['h_pdf'].'"><i class="fa fa-file-pdf"></i>&nbsp;PDF</a>';
    echo '<a class="btn btn-danger col-md-2 m-1" href="'.$pdflink.'&amp;expmode=2" title="'.$l['h_pdf'].'"><i class="fa fa-file-pdf"></i>&nbsp;PDF '.$l['w_module'].'</a>';
    echo '<a href="'.$pdflink.'&amp;expmode=3" class="btn btn-danger col-md-2 m-1" title="'.$l['h_pdf'].'"><i class="fa fa-file-pdf"></i>&nbsp;PDF '.$l['w_all'].'</a>';
    $xmllink = 'tce_xml_questions.php';
    $xmllink .= '?module_id='.$subject_module_id;
    $xmllink .= '&amp;subject_id='.$subject_id;
    echo ' <a href="'.$xmllink.'&amp;expmode=1" class="btn btn-primary col-md-2 m-1" title="'.$l['h_xml_export'].'"><i class="fa fa-file"></i>&nbsp;XML</a>';
    echo '<a href="'.$xmllink.'&amp;expmode=2" class="btn btn-primary col-md-2 m-1" title="'.$l['h_xml_export'].'"><i class="fa fa-file"></i>&nbsp;XML '.$l['w_module'].'</a>';
    echo '<a href="'.$xmllink.'&amp;expmode=3" class="btn btn-primary col-md-2 m-1" title="'.$l['h_xml_export'].'"><i class="fa fa-file"></i>&nbsp;XML '.$l['w_all'].'</a>';
    echo ' <a href="'.$xmllink.'&amp;expmode=1&amp;format=JSON" class="btn btn-success col-md-2 m-1" title="JSON"><i class="fa fa-file-alt"></i>&nbsp;JSON</a>';
    echo '<a href="'.$xmllink.'&amp;expmode=2&amp;format=JSON" class="btn btn-success col-md-2 m-1" title="JSON"><i class="fa fa-file-alt"></i>&nbsp;JSON '.$l['w_module'].'</a>';
    echo '<a href="'.$xmllink.'&amp;expmode=3&amp;format=JSON" class="btn btn-success col-md-2 m-1" title="JSON"><i class="fa fa-file-alt"></i>&nbsp;JSON '.$l['w_all'].'</a>';
    $tsvlink = 'tce_tsv_questions.php';
    $tsvlink .= '?module_id='.$subject_module_id;
    $tsvlink .= '&amp;subject_id='.$subject_id;
    echo ' <a href="'.$tsvlink.'&amp;expmode=1" class="btn btn-alternate col-md-2 m-1" title="'.$l['h_tsv_export'].'"><i class="fa fa-file-csv"></i>&nbsp;TSV</a>';
    echo '<a href="'.$tsvlink.'&amp;expmode=2" class="btn btn-alternate m-1 col-md-2" title="'.$l['h_tsv_export'].'"><i class="fa fa-file-csv"></i>&nbsp;TSV '.$l['w_module'].'</a>';
    echo '<a href="'.$tsvlink.'&amp;expmode=3" class="btn btn-alternate col-md-2 m-1" title="'.$l['h_tsv_export'].'"><i class="fa fa-file-csv"></i>&nbsp;TSV '.$l['w_all'].'</a>';
}

// echo '&nbsp;'.K_NEWLINE;
echo '<input type="hidden" name="firstrow" id="firstrow" value="'.$firstrow.'" />'.K_NEWLINE;
echo '<input type="hidden" name="order_field" id="order_field" value="'.$order_field.'" />'.K_NEWLINE;
echo '<input type="hidden" name="orderdir" id="orderdir" value="'.$orderdir.'" />'.K_NEWLINE;
echo '<input type="hidden" name="submitted" id="submitted" value="0" />'.K_NEWLINE;
echo '<input type="hidden" name="usersearch" id="usersearch" value="" />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

if (isset($subject_id) and ($subject_id > 0)) {
?>
<div class="card mx-3 mb-3">
<div class="card-header"><label id="upload_mediafile" for="upload_mediafile"><i class="fa fa-upload"></i>&nbsp;Upload media</label></div>
<div class="card-body">
<span class="formw" style="width:90%"><form id="upload_mediafile_form" action="tmf_upload_mediafile.php?nama_modul=<?php echo $nama_modul; ?>&nama_topik=<?php echo $nama_topik; ?>" class="dropzone w-100p" style="display:block"></form></span>
</div>
</div>
<?php
}

// echo '<div class="pagehelp">'.$l['hp_select_all_questions'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');
?>
<script>
$(document).ready(function(){
	$("#qStatbar").scrollToFixed({
		fixed: function(){
			$(this).addClass('rounded-0 shadow').removeClass('mt-2');
		},
		postFixed: function(){
			$(this).removeClass('rounded-0 shadow').addClass('mt-2');
		}
	});	
})
</script>
<?php
// ------------------------------

/**
 * Display a list of selected questions.
 * @author Nicola Asuni
 * @since 2005-07-06
 * @param $wherequery (string) question selection query
 * @param $subject_module_id (string) module ID
 * @param $subject_id (string) topic ID
 * @param $order_field (string) order by column name
 * @param $orderdir (int) oreder direction
 * @param $firstrow (int) number of first row to display
 * @param $rowsperpage (int) number of rows per page
 * @param $hide_answers (boolean) if true hide answers
 * @return false in case of empty database, true otherwise
 */
// $bank_soal_problem_desc_res = ''; 
function F_show_select_questions($wherequery, $subject_module_id, $subject_id, $order_field, $orderdir, $firstrow, $rowsperpage, $hide_answers = false)
{
    global $l, $db;
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_page.php');
	$alphabet = range('A', 'Z');
	
	$jml_mcsa = 0;
	$jml_mcma = 0;
	$jml_mcsa_right = 0;
	$jml_mcma_right = 0;
	
	
	
    $subject_module_id = intval($subject_module_id);
    $subject_id = intval($subject_id);
    $orderdir = intval($orderdir);
    $firstrow = intval($firstrow);
    $rowsperpage = intval($rowsperpage);
    if (empty($order_field) or (!in_array($order_field, array('question_id', 'question_subject_id', 'question_description', 'question_explanation', 'question_type', 'question_difficulty', 'question_enabled', 'question_position', 'question_timer', 'question_fullscreen', 'question_inline_answers', 'question_auto_next', 'question_enabled DESC, question_position, CAST(question_description as varchar2(100))', 'question_enabled DESC, question_position, question_description')))) {
        $order_field = 'question_description';
    }
    if ($orderdir == 0) {
        $nextorderdir = 1;
        $full_order_field = $order_field;
    } else {
        $nextorderdir = 0;
        $full_order_field = $order_field.' DESC';
    }

    if (!F_count_rows(K_TABLE_QUESTIONS)) { //if the table is void (no items) display message
        F_print_error('WARNING', $l['m_databasempty']);
        return false;
    }

    if (empty($wherequery)) {
        $wherequery = 'WHERE question_subject_id='.$subject_id.'';
    } else {
        $wherequery = F_escape_sql($db, $wherequery);
        $wherequery .= ' AND question_subject_id='.$subject_id.'';
    }
    $sql = 'SELECT *
		FROM '.K_TABLE_QUESTIONS.'
		'.$wherequery.'
		ORDER BY '.$full_order_field;
    if (K_DATABASE_TYPE == 'ORACLE') {
        $sql = 'SELECT * FROM ('.$sql.') WHERE rownum BETWEEN '.$firstrow.' AND '.($firstrow + $rowsperpage).'';
    } else {
        $sql .= ' LIMIT '.$rowsperpage.' OFFSET '.$firstrow.'';
    }
    if ($r = F_db_query($sql, $db)) {
        $questlist = '';
        $itemcount = $firstrow;
        while ($m = F_db_fetch_array($r)) {
			if (F_getBoolean($m['question_enabled'])) {
                $txtDisable = '';
                $bgStrong = 'btn-primary';
				$titleStrong = $l['w_enable'];
            } else {
				$txtDisable = '<small class="m-1 text-danger font-italic">Soal ini dinon-aktifkan.<br/>Klik Edit untuk mengaktifkan kembali.</small>';
                $bgStrong = 'btn-danger';
				$titleStrong = $l['w_disable'];
            }
			
            $itemcount++;

            $questlist .= '<li class="d-flex flex-sm-row flex-column list-group-item p-0" id="qid_'.$m['question_id'].'">'.K_NEWLINE;
            $questlist .= '<div class="p-3 rounded" style="background:#fcfcfc"><div title="'.$titleStrong.'" class="d-flex flex-column">'.K_NEWLINE;
			$questlist .= '<div class="custom-checkbox custom-control">'.K_NEWLINE;
			$questlist .= '<input class="custom-control-input" type="checkbox" name="questionid'.$itemcount.'" id="questionid'.$itemcount.'" value="'.$m['question_id'].'" title="'.$l['w_select'].'"';
            if (isset($_REQUEST['checkall']) and ($_REQUEST['checkall'] == 1)) {
                $questlist .= ' checked="checked"';
            }
            $questlist .= ' />'.K_NEWLINE;
            $questlist .= ' <label class="custom-control-label" for="questionid'.$itemcount.'"></label>'.K_NEWLINE;
			$questlist .= '</div>'.K_NEWLINE;
			
			$questlist .= '<h5>#&nbsp;'.$itemcount.'</h5></div>';
			$questlist .= '<div class="d-flex flex-column">';
            // display question description
            
			if ($m['question_position'] > 0) {
                $questlist .= ' <button type="button" data-toggle="tooltip" class="onbox btn btn-sm btn-light border text-wrap m-1" data-original-title="'.$l['h_position'].'" title="'.$l['h_position'].'">Posisi <span class="badge badge-secondary p-1">'.intval($m['question_position']).'</span></button>';
            } else {
                // $questlist .= ' <span class="offbox" title="'.$l['h_position'].'">&nbsp;</span>';
                $questlist .= '';
            }			     
			
            $questlist .= ' <button data-toggle="tooltip" class="offbox btn btn-sm btn-light border text-wrap m-1" title="'.$l['h_question_difficulty'].'" data-original-title="'.$l['h_question_difficulty'].'">Kesulitan <span class="badge badge-secondary p-1">'.$m['question_difficulty'].'</span></button>';
            
            if (F_getBoolean($m['question_fullscreen'])) {
                $questlist .= ' <button data-toggle="tooltip" class="onbox btn btn-sm btn-light border text-wrap m-1" title="'.$l['w_fullscreen'].': '.$l['w_enabled'].'" data-original-title="'.$l['w_fullscreen'].': '.$l['w_enabled'].'"><span class="badge badge-alternate">Fullscreen</span></button>';
            } else {
                // $questlist .= ' <span class="offbox" title="'.$l['w_fullscreen'].': '.$l['w_disabled'].'">&nbsp;</span>';
                $questlist .= '';
            }
            if (F_getBoolean($m['question_inline_answers'])) {
                $questlist .= ' <button data-toggle="tooltip" class="onbox btn btn-sm btn-light border text-wrap m-1" title="'.$l['w_inline_answers'].': '.$l['w_enabled'].'" data-original-title="'.$l['w_inline_answers'].': '.$l['w_enabled'].'"><span class="badge badge-alternate">Inline</span></button>';
            } else {
                // $questlist .= ' <span class="offbox" title="'.$l['w_inline_answers'].': '.$l['w_disabled'].'">&nbsp;</span>';
                $questlist .= '';
            }
            if (F_getBoolean($m['question_auto_next'])) {
                $questlist .= ' <button data-toggle="tooltip" class="onbox btn btn-sm btn-light border text-wrap m-1" title="'.$l['w_auto_next'].': '.$l['w_enabled'].'" data-original-title="'.$l['w_auto_next'].': '.$l['w_enabled'].'"><span class="badge badge-alternate">Auto next</span></button>';
            } else {
                // $questlist .= ' <span class="offbox" title="'.$l['w_auto_next'].': '.$l['w_disabled'].'">&nbsp;</span>';
                $questlist .= '';
            }
            if ($m['question_timer'] > 0) {
                $questlist .= ' <button data-toggle="tooltip" class="onbox btn btn-sm btn-light border text-wrap m-1" title="'.$l['h_question_timer'].'" data-original-title="'.$l['h_question_timer'].'">Timer <span class="badge badge-alternate">'.intval($m['question_timer']).'</span></button>';
            } else {
                // $questlist .= ' <span class="offbox" title="'.$l['h_question_timer'].'">&nbsp;</span>';
                $questlist .= '';
            }

			switch ($m['question_type']) {
                case 1: {
                    $questlist .= ' <button type="button" data-toggle="tooltip" class="offbox m-1 btn-transition btn btn-sm btn-outline-primary" title="'.$l['w_single_answer'].'" data-original-title="'.$l['w_single_answer'].'">Pilihan Ganda</button>';
					$jml_mcsa = $jml_mcsa+1;
                    break;
                }
                case 2: {
                    $questlist .= ' <button type="button" data-toggle="tooltip" class="offbox m-1 btn-transition btn btn-sm btn-outline-primary" title="'.$l['w_multiple_answers'].'" data-original-title="'.$l['w_multiple_answers'].'">Jawaban Jamak</button>';
                    $jml_mcma = $jml_mcma+1;
					break;
                }
                case 3: {
                    $questlist .= ' <button type="button" data-toggle="tooltip" class="offbox m-1 btn-transition btn btn-sm btn-outline-primary" title="'.$l['w_free_answer'].'" data-original-title="'.$l['w_free_answer'].'">Uraian</button>';
                    break;
                }
                case 4: {
                    $questlist .= ' <button type="button" data-toggle="tooltip" class="offbox m-1 btn-transition btn btn-sm btn-outline-primary" title="'.$l['w_ordering_answer'].'" data-original-title="'.$l['w_ordering_answer'].'">Menjodohkan</button>';
                    break;
                }
            }
			
            $questlist .= ' <a data-toggle="tooltip" href="tce_edit_question.php?subject_module_id='.$subject_module_id.'&amp;question_subject_id='.$subject_id.'&amp;question_id='.$m['question_id'].'" title="'.$l['t_questions_editor'].' [ID = '.$m['question_id'].']" class="btn '.$bgStrong.' m-1 text-uppercase font-weight-bold"><i class="fas fa-edit"></i>&nbsp;'.ucfirst($l['w_edit']).'</a>';
            $questlist .= $txtDisable;
            $questlist .= '</div>';
			$questlist .= '</div>';
            $questlist .= '<div class="p-3 w-100"><div>';
			$questlist .= '<div>'.html_entity_decode($m['question_description']).'</div>'.K_NEWLINE;
            if (K_ENABLE_QUESTION_EXPLANATION and !empty($m['question_explanation'])) {
                $questlist .=  '<div><span class="explanation">'.$l['w_explanation'].':</span>'.html_entity_decode($m['question_explanation']).'</div>'.K_NEWLINE;
            }
            if (!$hide_answers) {
                // display alternative answers
                $sqla = 'SELECT *
					FROM '.K_TABLE_ANSWERS.'
					WHERE answer_question_id=\''.$m['question_id'].'\'
					ORDER BY answer_enabled DESC,answer_position,answer_isright DESC';
					$ansNum=0;
                if ($ra = F_db_query($sqla, $db)) {					
                    $answlist = '';
                    while ($ma = F_db_fetch_array($ra)) {
						if (F_getBoolean($ma['answer_enabled'])) {
                            $bgAcro = '';
                            $bgAcroLi = '';
                            $opsiTxtDisable = '';
                        } else {
                            $bgAcro = 'bg-danger text-white ';
                            $bgAcroLi = ' list-group-item-danger';
							$opsiTxtDisable = '<hr class="my-1" /><small class="text-danger font-italic">Opsi ini dinon-aktifkan. Klik icon edit di samping kanan untuk mengaktifkan kembali.</small>';
                        }
						
						if ($m['question_type'] != 4) {
                            if (F_getBoolean($ma['answer_isright'])) {
                                $bgRight = 'badge-success';
                                $bgRightT = 'list-group-item-success';
                                $bdLRight = 'border-success';
                                $txtRight = 'text-success';
								if($m['question_type'] == 1){
									$jml_mcsa_right = $jml_mcsa_right+1;
								}
								if($m['question_type'] == 2){
									$jml_mcma_right = $jml_mcma_right+1;
								}
                            } else {
                                $bgRight = 'badge-light border';
                                $bgRightT = '';
                                $bdLRight = '';
								$txtRight = '';
                            }
                        }else{
							$bgRight = 'badge-success';
                            $bgRightT = 'list-group-item-success';
                            $bdLRight = 'border-success';
                            $txtRight = 'text-success';
						}
						
                        $answlist .= '<li class="p-0 list-group-item d-flex '.$bgRightT.$bgAcroLi.'"><div class="d-flex mr-1 m-2"><span class="align-self-start badge '.$bgAcro.$bgRight.'">'.$alphabet[$ansNum].'</span>';
                        $ansNum++;
                        
                        if ($ma['answer_position'] > 0) {
                            $answlist .= ' <span class="offbox d-none" title="'.$l['h_position'].'">'.intval($ma['answer_position']).'</span>';
                        } else {
                            $answlist .= '';
                        }
                        if ($ma['answer_keyboard_key'] > 0) {
                            $answlist .= ' <span class="onbox" title="'.$l['h_answer_keyboard_key'].'">'.F_text_to_xml(chr($ma['answer_keyboard_key'])).'</span>';
                        } else {
                            $answlist .= '';
                        }
                      
                        $answlist .= '</div>'.K_NEWLINE;
						
						$answlist .= '<div class="d-flex flex-row flex-grow-1 justify-content-between ml-0 mr-2 my-2">'.K_NEWLINE;
						// $ansNum++;
						$answlist .= '<div class="answer_description'.$ansNum.'">'.html_entity_decode($ma['answer_description']).$opsiTxtDisable.'</div>'.K_NEWLINE;
                        if (K_ENABLE_ANSWER_EXPLANATION and !empty($ma['answer_explanation'])) {
                            $answlist .=  '<div><span>'.$l['w_explanation'].':</span>'.html_entity_decode($ma['answer_explanation']).'</div>'.K_NEWLINE;
                        }
						
						
                        $answlist .= '</div>'.K_NEWLINE;
						
						$answlist .= '<div class="actionCtrl'.$ansNum.' border-left p-2 '.$bdLRight.'">';
						if ($m['question_type'] != 4) {
                            if (F_getBoolean($ma['answer_isright'])) {
                                $answlist .= ' <span data-toggle="tooltip" class="okbox text-success font-weight-bold" title="persentase bobot untuk opsi ini">'.$ma['answer_weight'].'%</span>';
                                $answlist .= ' <span data-toggle="tooltip" onclick="if(confirm(\'Apakah Anda yakin ingin membuang kunci jawaban pada opsi ini?\')){toggleIsRight(0,'.$ma['answer_question_id'].','.$ma['answer_id'].')}" style="cursor:pointer;user-select:none" class="okbox text-success font-weight-bold" title="'.$l['h_answer_right'].' (klik untuk membuang)"><i class="pe-7s-check '.$txtRight.' font-size-lg"></i></span>';
                            } else {
                                $answlist .= ' <span data-toggle="tooltip" class="offbox" title="persentase bobot untuk opsi ini">'.$ma['answer_weight'].'%</span>';
                                $answlist .= ' <span data-toggle="tooltip" onclick="if(confirm(\'Apakah Anda yakin ingin menjadikan opsi ini sebagai kunci jawaban?\')){toggleIsRight(1,'.$ma['answer_question_id'].','.$ma['answer_id'].')}" class="offbox" style="user-select:none;cursor:pointer;color:#ddd;box-shadow:none" title="'.$l['h_answer_wrong'].' (klik untuk menjadikannya jawaban benar)"><i class="pe-7s-check '.$txtRight.' font-size-lg"></i></span>';
                                // $answlist .= '';
                            }
                        }
						
						$answlist .= '<a data-toggle="tooltip" onclick="if(confirm(\'Yakin ingin lanjut mengedit?\')){location.replace(\'tce_edit_answer.php?subject_module_id='.$subject_module_id.'&amp;question_subject_id='.$subject_id.'&amp;answer_question_id='.$m['question_id'].'&amp;answer_id='.$ma['answer_id'].'\')}" title="'.$l['t_answers_editor'].' [ID = '.$ma['answer_id'].']" style="cursor:pointer" class="btn-edit-revert ps-start"><i class="pe-7s-note font-size-lg '.$txtRight.'"></i></a>';
						
                        $answlist .= '</div>'.K_NEWLINE;
						
                        $answlist .= '</li>'.K_NEWLINE;
                    }
					$questlist .= "</div>";
                    if (strlen($answlist) > 0) {
                        $questlist .= "<ol class=\"answer list-group mt-2\">\n".$answlist."</ol>\n";
                    }
                } else {
                    F_display_db_error();
                }
            } // end if hide_answers
            $questlist .= '</div></li>'.K_NEWLINE;
        }
		
		$bank_soal_problem = 0;
		$bank_soal_problem_desc = '';
		if($jml_mcsa!=$jml_mcsa_right){
			$bank_soal_problem = $bank_soal_problem+1;
			$bank_soal_problem_desc .= '<li class=mb-2>Ada butir soal dengan tipe <span class=font-weight-bold>Single Answer (Pilihan Ganda Jawaban Tunggal)</span> yang belum memiliki kunci jawaban</li>';
		}
		
		if($jml_mcma>$jml_mcma_right){
			$bank_soal_problem = $bank_soal_problem + 1;
			$bank_soal_problem_desc .= '<li>Ada butir soal dengan tipe <span class=font-weight-bold>Multi Answer (Pilihan Ganda Jawaban Ganda)</span> yang belum memiliki kunci jawaban</li>';
		}
		
		if($bank_soal_problem>0){
			// echo '<style>.pagehelp i{color:#fff !important}</style>';
			// echo '<div class="pagehelp bg-red txt-white message" style="margin-top:0;padding:0 !important;font-weight:normal;top:0;right:0"><div><div class="d-flex" style="justify-content: space-between"><h3 class="m-5">Oops!!! Bank Soal Bermasalah</h3><span class="p-5">&cross;</span></div>';
			// echo '<ol class="m-5" style="padding:0 1em">';
			echo '<script>let bankSoalProblem = "'.$bank_soal_problem_desc.'"; </script>';
			// echo '</ol>';
			// echo '</div>';
			// echo '</div>';
		}
		// echo $tambahsoalbaru;
		
		
        if (strlen($questlist) > 0) {
            // display the list
            echo '<ul class="question list-group">'.K_NEWLINE;
            echo $questlist;
            echo '</ul>'.K_NEWLINE;
            
            // check/uncheck all options
            // echo '<span dir="'.$l['a_meta_dir'].'" class="mt-1em ltrdir">';
			
			echo '<div class="form-row p-2">';
			echo '<div class="position-relative custom-radio custom-control mr-3">'.K_NEWLINE;
            echo '<input class="custom-control-input" type="radio" name="checkall" id="checkall1" value="1" onclick="checkAll(\'#form_selectquestions li input[type=checkbox]\')" />';
            echo '<label class="custom-control-label" for="checkall1">'.$l['w_check_all'].'</label> ';
			echo '</div>';
			
			echo '<div class="position-relative custom-radio custom-control">'.K_NEWLINE;
            echo '<input class="custom-control-input" type="radio" name="checkall" id="checkall0" value="0" onclick="unCheckAll(\'#form_selectquestions li input[type=checkbox]\')" />';
            echo '<label class="custom-control-label" for="checkall0">'.$l['w_uncheck_all'].'</label>';
			echo '</div>';
			echo '</div>';
			
			
            // echo '</span>'.K_NEWLINE;
            // echo '&nbsp;';
            if ($l['a_meta_dir'] == 'rtl') {
                $arr = '&larr;';
            } else {
                $arr = '&rarr;';
            }
            // action options
			echo '<div class="form-row">';
			echo '<div class="col-md-4">';
            echo '<select class="custom-select select2-single" name="menu_action" id="menu_action" size="0">'.K_NEWLINE;
            echo '<option value="0" style="color:gray">'.$l['m_with_selected'].'</option>'.K_NEWLINE;
            echo '<option value="enable">'.$l['w_enable'].'</option>'.K_NEWLINE;
            echo '<option value="disable">'.$l['w_disable'].'</option>'.K_NEWLINE;
            echo '<option value="delete">'.$l['w_delete'].'</option>'.K_NEWLINE;
            echo '<option value="copy">'.$l['w_copy'].' '.$arr.'</option>'.K_NEWLINE;
            echo '<option value="move">'.$l['w_move'].' '.$arr.'</option>'.K_NEWLINE;
            echo '</select>'.K_NEWLINE;
			echo '</div>';
			echo '<div class="col-md-4">';
            // select new topic (for copy or move action)
            echo '<select class="custom-select select2-single" name="new_subject_id" id="new_subject_id" size="0" title="'.$l['h_subject'].'">'.K_NEWLINE;
            $sql = F_select_module_subjects_sql('module_enabled=\'1\' AND subject_enabled=\'1\'');
            if ($r = F_db_query($sql, $db)) {
                echo '<option value="0" style="color:gray">'.$l['w_subject'].'</option>'.K_NEWLINE;
                $prev_module_id = 0;
                while ($m = F_db_fetch_array($r)) {
                    if ($m['module_id'] != $prev_module_id) {
                        $prev_module_id = $m['module_id'];
                        echo '<option value="0" style="color:gray;font-weight:bold;" disabled="disabled">* '.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
                    }
                    echo '<option value="'.$m['subject_id'].'">&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars($m['subject_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
                }
            } else {
                echo '</select>'.K_NEWLINE;
                F_display_db_error();
            }
            echo '</select>'.K_NEWLINE;
            // submit button
			echo '</div>';
			echo '<div class="col-md-4">';
            F_submit_button_alt("update", $l['w_update'], $l['h_update'], 'btn btn-primary btn-block');
			echo '</div>';
			echo '</div>';
        }

        // ---------------------------------------------------------------
        // -- page jumper (menu for successive pages)
        if ($rowsperpage > 0) {
            $sql = 'SELECT count(*) AS total FROM '.K_TABLE_QUESTIONS.' '.$wherequery.'';
            if (!empty($order_field)) {
                $param_array = '&amp;order_field='.urlencode($order_field).'';
            }
            if (!empty($orderdir)) {
                $param_array .= '&amp;orderdir='.$orderdir.'';
            }
            if (!empty($hide_answers)) {
                $param_array .= '&amp;hide_answers='.intval($hide_answers).'';
            }
            $param_array .= '&amp;subject_module_id='.$subject_module_id.'';
            $param_array .= '&amp;subject_id='.$subject_id.'';
            $param_array .= '&amp;submitted=1';
            F_show_page_navigator($_SERVER['SCRIPT_NAME'], $sql, $firstrow, $rowsperpage, $param_array);
        }
    } else {
        F_display_db_error();
    }
    return true;
}

//============================================================+
// END OF FILE
//============================================================+
?>
<script>

if(bankSoalProblem){
	var msgType = 'error';
	var msgTitle = 'Oops! Bank soal bermasalah!';
	var msgContent = '<ol class="pl-2 py-0 small">'+bankSoalProblem+'</ol>';
	toastr.options = {
		closeButton: 0,
		debug: !1,
		newestOnTop: !0,
		progressBar: !0,
		positionClass: "toast-top-right",
		preventDuplicates: !1,
		onclick: null,
		showDuration: "300",
		hideDuration: "1000",
		timeOut: "3600000",
		extendedTimeOut: "3600000",
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut"
	}
	
	toastr[msgType](msgContent,msgTitle)
}

</script>