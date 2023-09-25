<?php
//============================================================+
// File name   : tce_functions_test_stats.php
// Begin       : 2004-06-10
// Last Update : 2020-06-12
//
// Description : Statistical functions for test results.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//
// License:
//    Copyright (C) 2004-2020 Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Statistical functions for test results.
 * @package com.tecnick.tcexam.shared
 * @author Nicola Asuni
 * @since 2004-06-10
 */

/**
* Returns statistic array for the test-user
* @param $test_id (int) test ID.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* @param $pubmode (boolean) If true filter the results for the public interface.
* return $data array containing test-user statistics.
*/
function F_getUserTestStat($test_id, $user_id = 0, $testuser_id = 0, $pubmode = false)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_test.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $testuser_id = intval($testuser_id);
    // get test data array
    $data = F_getTestData($test_id);
    $data += F_getUserTestTotals($test_id, $user_id, $testuser_id, $pubmode);
    return $data;
}

/**
* Returns test-user totals
* @param $test_id (int) test ID.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* @param $pubmode (boolean) If true filter the results for the public interface.
* return $data array containing test-user statistics.
*/
function F_getUserTestTotals($test_id, $user_id = 0, $testuser_id = 0, $pubmode = false)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_test.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $testuser_id = intval($testuser_id);
    // get test data array
    $data = array();
    $status_filter = 0;
    if ($pubmode) {
        $status_filter = 3;
    }
    // additional info
    if (($test_id > 0) and ($user_id > 0) and ($testuser_id > 0)) {
        // get user totals
        $sqlu = 'SELECT SUM(testlog_score) AS total_score, MAX(testlog_change_time) AS test_end_time, testuser_id, testuser_creation_time, testuser_status, testuser_comment
		FROM '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.'
		WHERE testlog_testuser_id=testuser_id
			AND testuser_id='.$testuser_id.'
			AND testuser_test_id='.$test_id.'
			AND testuser_user_id='.$user_id.'
			AND testuser_status>'.$status_filter.'
		GROUP BY testuser_id, testuser_creation_time, testuser_status, testuser_comment';
        if ($ru = F_db_query($sqlu, $db)) {
            if ($mu = F_db_fetch_array($ru)) {
                $data['testuser_id'] = $mu['testuser_id'];
                $data['user_score'] = $mu['total_score'];
                $data['user_test_start_time'] = $mu['testuser_creation_time'];
                $data['user_test_end_time'] = $mu['test_end_time'];
                $data['testuser_status'] = $mu['testuser_status'];
                $data['user_comment'] = $mu['testuser_comment'];
            }
        } else {
            F_display_db_error();
        }
    }
    return $data;
}

/**
* Returns statistic array for the selected test.
* @param $test_id (int) test ID.
* @param $group_id (int) group ID - if greater than zero, filter stats for the specified user group.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $startdate (int) start date ID - if greater than zero, filter stats for the specified starting date
* @param $enddate (int) end date ID - if greater than zero, filter stats for the specified ending date
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* @param $pubmode (boolean) If true filter the results for the public interface.
* return $data array containing test statistics.
*/
function F_getTestStat($test_id, $group_id = 0, $user_id = 0, $startdate = 0, $enddate = 0, $testuser_id = 0, $pubmode = false)
{
    $data = F_getRawTestStat($test_id, $group_id, $user_id, $startdate, $enddate, $testuser_id, array(), $pubmode);
    if (isset($data['qstats']['recurrence'])) {
        $data = F_normalizeTestStatAverages($data);
    }
    return $data;
}

/**
* Returns raw statistic array for the selected test.
* @param $test_id (int) test ID.
* @param $group_id (int) group ID - if greater than zero, filter stats for the specified user group.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $startdate (int) start date ID - if greater than zero, filter stats for the specified starting date
* @param $enddate (int) end date ID - if greater than zero, filter stats for the specified ending date
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* @param $data (array) Array of existing data to be merged with the current one.
* @param $pubmode (boolean) If true filter the results for the public interface.
* return $data array containing test statistics.
*/
function F_getRawTestStat($test_id, $group_id = 0, $user_id = 0, $startdate = 0, $enddate = 0, $testuser_id = 0, $data = array(), $pubmode = false)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_authorization.php');
    require_once('../../shared/code/tce_functions_test.php');
    global $db, $l;
    $test_id = intval($test_id);
    $group_id = intval($group_id);
    $user_id = intval($user_id);
    $testuser_id = intval($testuser_id);
    // query to calculate total number of questions
    $sqltot = K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS;
    $sqltb = K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.', '.K_TABLE_ANSWERS.', '.K_TABLE_LOG_ANSWER;
    $sqlm = K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.', '.K_TABLE_SUBJECTS.', '.K_TABLE_MODULES.'';
    // apply filters
    $sqlw = 'WHERE testlog_testuser_id=testuser_id';
    $sqlansw = 'WHERE logansw_answer_id=answer_id AND logansw_testlog_id=testlog_id AND testlog_testuser_id=testuser_id';
    if ($pubmode) {
        $test_ids_results = F_getTestIDResults($test_id, $user_id);
        $sqlw .= ' AND testuser_test_id IN ('.$test_ids_results.') AND testuser_status>3';
        $sqlansw .= ' AND testuser_test_id IN ('.$test_ids_results.') AND testuser_status>3';
    }
    if ($test_id > 0) {
        $sqlw .= ' AND testuser_test_id='.$test_id.'';
        $sqlansw .= ' AND testuser_test_id='.$test_id.'';
    }
    if ($user_id > 0) {
        $sqltot .= ', '.K_TABLE_USERS;
        $sqltb .= ', '.K_TABLE_USERS;
        $sqlm .= ', '.K_TABLE_USERS;
        $sqlw .= ' AND testuser_user_id=user_id AND user_id='.$user_id.'';
        $sqlansw .= ' AND testuser_user_id=user_id AND user_id='.$user_id.'';
        if ($testuser_id > 0) {
            $sqlw .= ' AND testuser_id='.$testuser_id.'';
            $sqlansw .= ' AND testuser_id='.$testuser_id.'';
        }
    } elseif ($group_id > 0) {
        $sqltot .= ', '.K_TABLE_USERS.', '.K_TABLE_USERGROUP;
        $sqltb .= ', '.K_TABLE_USERS.', '.K_TABLE_USERGROUP;
        $sqlm .= ', '.K_TABLE_USERS.', '.K_TABLE_USERGROUP;
        $sqlw .= ' AND testuser_user_id=user_id AND usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.'';
        $sqlansw .= ' AND testuser_user_id=user_id AND usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.'';
    }
    if (!empty($startdate)) {
        $startdate_time = strtotime($startdate);
        $startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
        $sqlw .= ' AND testuser_creation_time>=\''.$startdate.'\'';
        $sqlansw .= ' AND testuser_creation_time>=\''.$startdate.'\'';
    }
    if (!empty($enddate)) {
        $enddate_time = strtotime($enddate);
        $enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
        $sqlw .= ' AND testuser_creation_time<=\''.$enddate.'\'';
        $sqlansw .= ' AND testuser_creation_time<=\''.$enddate.'\'';
    }
    // check if a specific test is selected or not
    if ($test_id == 0) {
        $test_ids = array();
        $sqlt = 'SELECT testuser_test_id FROM '.$sqltot.' '.$sqlw.' GROUP BY testuser_test_id ORDER BY testuser_test_id';
        if ($rt = F_db_query($sqlt, $db)) {
            while ($mt = F_db_fetch_assoc($rt)) {
                // check user's authorization
                if (F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $mt['testuser_test_id'], 'test_user_id')) {
                    $test_ids[] = $mt['testuser_test_id'];
                }
            }
        } else {
            F_display_db_error();
        }
        foreach ($test_ids as $tid) {
            // select test IDs
            $data =  F_getRawTestStat($tid, $group_id, $user_id, $startdate, $enddate, $testuser_id, $data, $pubmode);
        }
        return $data;
    }
    $testdata = F_getTestData($test_id);
    // array to be returned
    if (!isset($data['qstats'])) {
        // total number of questions
        $data['qstats'] = array(
            'recurrence' => 0,
            'recurrence_perc' => 0,
            'average_score' => 0,
            'average_score_perc' => 0,
            'average_time' => 0,
            'right' => 0,
            'right_perc' => 0,
            'wrong' => 0,
            'wrong_perc' => 0,
            'unanswered' => 0,
            'unanswered_perc' => 0,
            'undisplayed' => 0,
            'undisplayed_perc' => 0,
            'unrated' => 0,
            'unrated_perc' => 0,
            'qnum' => 0,
            'module' => array());
    }
    $sql = 'SELECT
		module_id,
		subject_id,
		question_id,
		module_name,
		subject_name,
		subject_description,
		question_description,';
    if (($user_id > 0) and ($testuser_id > 0)) {
        $sql .= ' testlog_score,
			testlog_user_ip,
			testlog_display_time,
			testlog_change_time,
			testlog_reaction_time,
			testlog_answer_text,
			question_type,
			question_explanation,';
    }
    $sql .= ' COUNT(question_id) AS recurrence,
		AVG(testlog_score) AS average_score,
		AVG('.F_db_datetime_diff_seconds('testlog_display_time', 'testlog_change_time').') AS average_time,
		MIN(question_type) AS question_type,
		MIN(question_difficulty) AS question_difficulty';
    $sql .= ' FROM '.$sqlm;
    $sql .= ' WHERE testlog_testuser_id=testuser_id AND question_id=testlog_question_id AND subject_id=question_subject_id AND module_id=subject_module_id';
    if ($test_id > 0) {
        $sql .= ' AND testuser_test_id='.$test_id.'';
    }
    if ($testuser_id > 0) {
        $sql .= ' AND testuser_id='.$testuser_id.'';
    }
    if ($user_id > 0) {
        $sql .= ' AND testuser_user_id=user_id AND user_id='.$user_id.'';
    } elseif ($group_id > 0) {
        $sql .= ' AND testuser_user_id=user_id AND usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.'';
    }
    if (!empty($startdate)) {
        $sql .= ' AND testuser_creation_time>=\''.$startdate.'\'';
    }
    if (!empty($enddate)) {
        $sql .= ' AND testuser_creation_time<=\''.$enddate.'\'';
    }
    $sql .= ' GROUP BY module_id, subject_id, question_id, module_name, subject_name, subject_description, question_description';
    if (($user_id > 0) and ($testuser_id > 0)) {
        $sql .= ', testlog_score, testlog_user_ip, testlog_display_time, testlog_change_time, testlog_reaction_time, testlog_answer_text, question_type, question_explanation';
    } else {
        $sql .= ' ORDER BY module_name, subject_name, question_description';
    }
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            if (!isset($data['qstats']['module']['\''.$m['module_id'].'\''])) {
                $data['qstats']['module']['\''.$m['module_id'].'\''] = array(
                    'id' => $m['module_id'],
                    'name' => $m['module_name'],
                    'recurrence' => 0,
                    'recurrence_perc' => 0,
                    'average_score' => 0,
                    'average_score_perc' => 0,
                    'average_time' => 0,
                    'right' => 0,
                    'right_perc' => 0,
                    'wrong' => 0,
                    'wrong_perc' => 0,
                    'unanswered' => 0,
                    'unanswered_perc' => 0,
                    'undisplayed' => 0,
                    'undisplayed_perc' => 0,
                    'unrated' => 0,
                    'unrated_perc' => 0,
                    'qnum' => 0,
                    'subject' => array());
            }
            if (!isset($data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\''])) {
                $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\''] = array(
                    'id' => $m['subject_id'],
                    'name' => $m['subject_name'],
                    'description' => $m['subject_description'],
                    'recurrence' => 0,
                    'recurrence_perc' => 0,
                    'average_score' => 0,
                    'average_score_perc' => 0,
                    'average_time' => 0,
                    'right' => 0,
                    'right_perc' => 0,
                    'wrong' => 0,
                    'wrong_perc' => 0,
                    'unanswered' => 0,
                    'unanswered_perc' => 0,
                    'undisplayed' => 0,
                    'undisplayed_perc' => 0,
                    'unrated' => 0,
                    'unrated_perc' => 0,
                    'qnum' => 0,
                    'question' => array());
            }
            $question_max_score = ($testdata['test_score_right'] * $m['question_difficulty']);
            $question_half_score = ($question_max_score / 2);
            $qright = F_count_rows($sqltot, $sqlw.' AND testlog_question_id='.$m['question_id'].' AND testlog_score>'.$question_half_score.'');
            $qwrong = F_count_rows($sqltot, $sqlw.' AND testlog_question_id='.$m['question_id'].' AND testlog_score<='.$question_half_score.'');
            $qunanswered = F_count_rows($sqltot, $sqlw.' AND testlog_question_id='.$m['question_id'].' AND testlog_change_time IS NULL');
            $qundisplayed = F_count_rows($sqltot, $sqlw.' AND testlog_question_id='.$m['question_id'].' AND testlog_display_time IS NULL');
            $qunrated = F_count_rows($sqltot, $sqlw.' AND testlog_question_id='.$m['question_id'].' AND testlog_score IS NULL');
            if (stripos($m['average_time'], ':') !== false) {
                // PostgreSQL returns formatted time, while MySQL returns the number of seconds
                $m['average_time'] = strtotime($m['average_time']);
            }
            $num_all_answers = F_count_rows($sqltb, $sqlansw.' AND testlog_question_id='.$m['question_id']);
            if (!isset($data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\''])) {
                $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\''] = array(
                    'id' => $m['question_id'],
                    'description' => $m['question_description'],
                    'type' => $m['question_type'],
                    'difficulty' => $m['question_difficulty'],
                    'recurrence' => 0,
                    'recurrence_perc' => 0,
                    'average_score' => 0,
                    'average_score_perc' => 0,
                    'average_time' => 0,
                    'right' => 0,
                    'right_perc' => 0,
                    'wrong' => 0,
                    'wrong_perc' => 0,
                    'unanswered' => 0,
                    'unanswered_perc' => 0,
                    'undisplayed' => 0,
                    'undisplayed_perc' => 0,
                    'unrated' => 0,
                    'unrated_perc' => 0,
                    'qnum' => 0,
                    'anum' => 0,
                    'answer' => array());
            }

            // average score ratio
            if ($question_max_score > 0) {
                $average_score_perc = ($m['average_score'] / $question_max_score);
            } else {
                $average_score_perc = 0;
            }

            // sum values for questions
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['qnum'] += 1;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['recurrence'] += $m['recurrence'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['average_score'] += $m['average_score'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['average_score_perc'] += $average_score_perc;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['average_time'] += $m['average_time'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['right'] += $qright;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['wrong'] += $qwrong;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['unanswered'] += $qunanswered;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['undisplayed'] += $qundisplayed;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['unrated'] += $qunrated;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['anum'] += $num_all_answers;

            // sum values for subject
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['qnum'] += 1;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['recurrence'] += $m['recurrence'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['average_score'] += $m['average_score'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['average_score_perc'] += $average_score_perc;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['average_time'] += $m['average_time'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['right'] += $qright;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['wrong'] += $qwrong;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['unanswered'] += $qunanswered;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['undisplayed'] += $qundisplayed;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['unrated'] += $qunrated;

            // sum values for module
            $data['qstats']['module']['\''.$m['module_id'].'\'']['qnum'] += 1;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['recurrence'] += $m['recurrence'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['average_score'] += $m['average_score'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['average_score_perc'] += $average_score_perc;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['average_time'] += $m['average_time'];
            $data['qstats']['module']['\''.$m['module_id'].'\'']['right'] += $qright;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['wrong'] += $qwrong;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['unanswered'] += $qunanswered;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['undisplayed'] += $qundisplayed;
            $data['qstats']['module']['\''.$m['module_id'].'\'']['unrated'] += $qunrated;

            // sum totals
            $data['qstats']['qnum'] += 1;
            $data['qstats']['recurrence'] += $m['recurrence'];
            $data['qstats']['average_score'] += $m['average_score'];
            $data['qstats']['average_score_perc'] += $average_score_perc;
            $data['qstats']['average_time'] += $m['average_time'];
            $data['qstats']['right'] += $qright;
            $data['qstats']['wrong'] += $qwrong;
            $data['qstats']['unanswered'] += $qunanswered;
            $data['qstats']['undisplayed'] += $qundisplayed;
            $data['qstats']['unrated'] += $qunrated;

            // get answer statistics
            $sqlaa = 'SELECT answer_id, answer_description, COUNT(answer_id) AS recurrence';
            if (($user_id > 0) and ($testuser_id > 0)) {
                $sqlaa .= ', logansw_position, logansw_selected, answer_isright, answer_position, answer_explanation';
            }
            $sqlaa .= ' FROM '.$sqltb.'';
            $sqlaw = ' WHERE testlog_testuser_id=testuser_id
					AND logansw_testlog_id=testlog_id
					AND answer_id=logansw_answer_id
					AND answer_question_id='.$m['question_id'].'';
            if ($test_id > 0) {
                $sqlaw .= ' AND testuser_test_id='.$test_id.'';
            }
            if ($user_id > 0) {
                $sqlaw .= ' AND testuser_user_id='.$user_id.'';
            }
            if ($testuser_id > 0) {
                $sqlaw .= ' AND testuser_id='.$testuser_id.'';
            }
            if ($user_id > 0) {
                $sqlaw .= ' AND testuser_user_id=user_id AND user_id='.$user_id.'';
            } elseif ($group_id > 0) {
                $sqlaw .= ' AND testuser_user_id=user_id AND usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.'';
            }
            if (!empty($startdate)) {
                $sql .= ' AND testuser_creation_time>=\''.$startdate.'\'';
            }
            if (!empty($enddate)) {
                $sql.= ' AND testuser_creation_time<=\''.$enddate.'\'';
            }
            $sqlab = ' GROUP BY answer_id, answer_description';

            if (($user_id > 0) and ($testuser_id > 0)) {
                $sqlab .= ', logansw_position, logansw_selected, answer_isright, answer_position, answer_explanation';
            }
            $sqlab .= ' ORDER BY answer_description';
            $sqla = $sqlaa.$sqlaw.$sqlab;
            if ($ra = F_db_query($sqla, $db)) {
                while ($ma = F_db_fetch_array($ra)) {
                    $aright = F_count_rows($sqltb, $sqlaw.' AND answer_id='.$ma['answer_id'].' AND ((answer_isright=\'0\' AND logansw_selected=0) OR (answer_isright=\'1\' AND logansw_selected=1) OR (answer_position IS NOT NULL AND logansw_position IS NOT NULL AND answer_position=logansw_position))');
                    $awrong = F_count_rows($sqltb, $sqlaw.' AND answer_id='.$ma['answer_id'].' AND ((answer_isright=\'0\' AND logansw_selected=1) OR (answer_isright=\'1\' AND logansw_selected=0) OR (answer_position IS NOT NULL AND answer_position!=logansw_position))');
                    $aunanswered = F_count_rows($sqltb, $sqlaw.' AND answer_id='.$ma['answer_id'].' AND logansw_selected=-1');
                    if (!isset($data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\''])) {
                            $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\''] = array(
                            'id' => $ma['answer_id'],
                            'description' => $ma['answer_description'],
                            'recurrence' => 0,
                            'recurrence_perc' => 0,
                            'right' => 0,
                            'right_perc' => 0,
                            'wrong' => 0,
                            'wrong_perc' => 0,
                            'unanswered' => 0,
                            'unanswered_perc' => 0);
                    }

                    $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\'']['recurrence'] += $ma['recurrence'];
                    $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\'']['right'] += $aright;
                    $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\'']['wrong'] += $awrong;
                    $data['qstats']['module']['\''.$m['module_id'].'\'']['subject']['\''.$m['subject_id'].'\'']['question']['\''.$m['question_id'].'\'']['answer']['\''.$ma['answer_id'].'\'']['unanswered'] += $aunanswered;
                }
            } else {
                F_display_db_error();
            }
        }
    } else {
        F_display_db_error();
    }
    return $data;
}

/**
 * Calculate average values from TestStat array
 * @param $data (array) Raw data array.
 * return $data (array) Processed array.
 */
function F_normalizeTestStatAverages($data)
{
    if (!isset($data['qstats']['recurrence']) or ($data['qstats']['recurrence'] <= 0)) {
        return $data;
    }
    // calculate totals and average values
    $data['qstats']['recurrence_perc'] = 100;
    $data['qstats']['average_score'] = ($data['qstats']['average_score'] / $data['qstats']['qnum']);
    $data['qstats']['average_score_perc'] = round(100 * $data['qstats']['average_score_perc'] / $data['qstats']['recurrence']);
    $data['qstats']['average_time'] = ($data['qstats']['average_time'] / $data['qstats']['qnum']);
    $data['qstats']['right_perc'] = round(100 * $data['qstats']['right'] / $data['qstats']['recurrence']);
    $data['qstats']['wrong_perc'] = round(100 * $data['qstats']['wrong'] / $data['qstats']['recurrence']);
    $data['qstats']['unanswered_perc'] = round(100 * $data['qstats']['unanswered'] / $data['qstats']['recurrence']);
    $data['qstats']['undisplayed_perc'] = round(100 * $data['qstats']['undisplayed'] / $data['qstats']['recurrence']);
    $data['qstats']['unrated_perc'] = round(100 * $data['qstats']['unrated'] / $data['qstats']['recurrence']);
    foreach ($data['qstats']['module'] as $mk => $mv) {
        $data['qstats']['module'][$mk]['recurrence_perc'] = round(100 * $mv['recurrence'] / $data['qstats']['recurrence']);
        $data['qstats']['module'][$mk]['average_score'] = ($mv['average_score'] / $mv['qnum']);
        $data['qstats']['module'][$mk]['average_score_perc'] = round(100 * $mv['average_score_perc'] / $mv['recurrence']);
        $data['qstats']['module'][$mk]['average_time'] = ($mv['average_time'] / $mv['qnum']);
        $data['qstats']['module'][$mk]['right_perc'] = round(100 * $mv['right'] / $mv['recurrence']);
        $data['qstats']['module'][$mk]['wrong_perc'] = round(100 * $mv['wrong'] / $mv['recurrence']);
        $data['qstats']['module'][$mk]['unanswered_perc'] = round(100 * $mv['unanswered'] / $mv['recurrence']);
        $data['qstats']['module'][$mk]['undisplayed_perc'] = round(100 * $mv['undisplayed'] / $mv['recurrence']);
        $data['qstats']['module'][$mk]['unrated_perc'] = round(100 * $mv['unrated'] / $mv['recurrence']);
        foreach ($mv['subject'] as $sk => $sv) {
            $data['qstats']['module'][$mk]['subject'][$sk]['recurrence_perc'] = round(100 * $sv['recurrence'] / $data['qstats']['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['average_score'] = ($sv['average_score'] / $sv['qnum']);
            $data['qstats']['module'][$mk]['subject'][$sk]['average_score_perc'] = round(100 * $sv['average_score_perc'] / $sv['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['average_time'] = ($sv['average_time'] / $sv['qnum']);
            $data['qstats']['module'][$mk]['subject'][$sk]['right_perc'] = round(100 * $sv['right'] / $sv['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['wrong_perc'] = round(100 * $sv['wrong'] / $sv['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['unanswered_perc'] = round(100 * $sv['unanswered'] / $sv['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['undisplayed_perc'] = round(100 * $sv['undisplayed'] / $sv['recurrence']);
            $data['qstats']['module'][$mk]['subject'][$sk]['unrated_perc'] = round(100 * $sv['unrated'] / $sv['recurrence']);
            foreach ($sv['question'] as $qk => $qv) {
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['recurrence_perc'] = round(100 * $qv['recurrence'] / $data['qstats']['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['average_score'] = ($qv['average_score'] / $qv['qnum']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['average_score_perc'] = round(100 * $qv['average_score_perc'] / $qv['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['average_time'] = ($qv['average_time'] / $qv['qnum']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['right_perc'] = round(100 * $qv['right'] / $qv['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['wrong_perc'] = round(100 * $qv['wrong'] / $qv['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['unanswered_perc'] = round(100 * $qv['unanswered'] / $qv['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['undisplayed_perc'] = round(100 * $qv['undisplayed'] / $qv['recurrence']);
                $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['unrated_perc'] = round(100 * $qv['unrated'] / $qv['recurrence']);
                foreach ($qv['answer'] as $ak => $av) {
                    $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['answer'][$ak]['recurrence_perc'] = round(100 * $av['recurrence'] / $qv['anum']);
                    $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['answer'][$ak]['right_perc'] = round(100 * $av['right'] / $av['recurrence']);
                    $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['answer'][$ak]['wrong_perc'] = round(100 * $av['wrong'] / $av['recurrence']);
                    $data['qstats']['module'][$mk]['subject'][$sk]['question'][$qk]['answer'][$ak]['unanswered_perc'] = round(100 * $av['unanswered'] / $av['recurrence']);
                }
            }
        }
    }
    return $data;
}

/**
* Returns test stats as HTML table
* @param $test_id (int) test ID.
* @param $group_id (int) group ID - if greater than zero, filter stats for the specified user group.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $startdate (int) start date ID - if greater than zero, filter stats for the specified starting date
* @param $enddate (int) end date ID - if greater than zero, filter stats for the specified ending date
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* @param $ts (array) array of stats to print (leave empty to automatically generate new data).
* @param $display_mode display (int) mode: 0 = disabled; 1 = minimum; 2 = module; 3 = subject; 4 = question; 5 = answer.
* @param $pubmode (boolean) If true filter the results for the public interface.
* return $data string containing HTML table.
*/
function F_printTestStat($test_id, $group_id = 0, $user_id = 0, $startdate = 0, $enddate = 0, $testuser_id = 0, $ts = array(), $display_mode = 2, $pubmode = false)
{
    if ($display_mode < 2) {
        return;
    }
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    if (empty($ts['qstats']['recurrence'])) {
        return;
    }
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $testuser_id = intval($testuser_id);
    if (empty($ts)) {
        // get statistics array
        $ts = F_getTestStat($test_id, $group_id, $user_id, $startdate, $enddate, $testuser_id, $pubmode);
    }
    if ($l['a_meta_dir'] == 'rtl') {
        $txtdir = 'right';
    } else {
        $txtdir = 'left';
    }
    $ret = '';
    $ret .= '<table class="userselect table table-responsive">'.K_NEWLINE;
    $ret .= '<tr><td colspan="12" class="bg-light text-capitalize"><strong>'.$l['w_statistics'].' ['.$l['w_all'].' + '.$l['w_module'].'';
    if ($display_mode > 2) {
        $ret .= ' + '.$l['w_subject'].'';
        if ($display_mode > 3) {
            $ret .= ' + '.$l['w_question'].'';
            if ($display_mode > 4) {
                $ret .= ' + '.$l['w_answer'].'';
            }
        }
    }
    $ret .= ']</strong></td></tr>'.K_NEWLINE;
    $ret .= '<tr class="text-capitalize">'.K_NEWLINE;
    $ret .= '<th title="'.$l['w_module'].'">M#</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['w_subject'].'">S#</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['w_question'].'">Q#</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['w_answer'].'">A#</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_question_recurrence'].'">'.$l['w_recurrence'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_score_average'].'">'.$l['w_score'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_answer_time'].'">'.$l['w_answer_time'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_answers_right'].'">'.$l['w_answers_right'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_answers_wrong'].'">'.$l['w_answers_wrong'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_questions_unanswered'].'">'.$l['w_questions_unanswered'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_questions_undisplayed'].'">'.$l['w_questions_undisplayed'].'</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_questions_unrated'].'">'.$l['w_questions_unrated'].'</th>'.K_NEWLINE;
    $ret .= '</tr>'.K_NEWLINE;
    $ret .= '<tr style="background-color:#FFEEEE;">';
    $ret .= '<td colspan="4">'.$l['w_all'].'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['recurrence'].' '.F_formatPercentage($ts['qstats']['recurrence_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.($ts['qstats']['average_score_perc']).'%</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">&nbsp;'.date('i:s', $ts['qstats']['average_time']).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['right'].' '.F_formatPercentage($ts['qstats']['right_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['wrong'].' '.F_formatPercentage($ts['qstats']['wrong_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['unanswered'].' '.F_formatPercentage($ts['qstats']['unanswered_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['undisplayed'].' '.F_formatPercentage($ts['qstats']['undisplayed_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '<td class="numeric text-monospace text-right">'.$ts['qstats']['unrated'].' '.F_formatPercentage($ts['qstats']['unrated_perc'], false).'</td>'.K_NEWLINE;
    $ret .= '</tr>'.K_NEWLINE;
    $num_module = 0;
    foreach ($ts['qstats']['module'] as $module) {
        $num_module++;
        $ret .= '<tr style="background-color:#E3F2FD;">';
        if ($pubmode) {
            $ret .= '<td rowspan="2" valign="middle"><strong>M'.$num_module.'</strong></td>'.K_NEWLINE;
        } else {
            $ret .= '<td rowspan="2" valign="middle"><a href="tce_edit_module.php?module_id='.$module['id'].'" title="'.$l['t_modules_editor'].'"><strong>M'.$num_module.'</strong></a></td>'.K_NEWLINE;
        }
        $ret .= '<td rowspan="2" colspan="3">&nbsp;</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['recurrence'].' '.F_formatPercentage($module['recurrence_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.($module['average_score_perc']).'%</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">&nbsp;'.date('i:s', $module['average_time']).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['right'].' '.F_formatPercentage($module['right_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['wrong'].' '.F_formatPercentage($module['wrong_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['unanswered'].' '.F_formatPercentage($module['unanswered_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['undisplayed'].' '.F_formatPercentage($module['undisplayed_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right">'.$module['unrated'].' '.F_formatPercentage($module['unrated_perc'], false).'</td>'.K_NEWLINE;
        $ret .= '</tr>'.K_NEWLINE;
        $ret .= '<tr>';
        $ret .= '<td colspan="8" align="'.$txtdir.'" style="background-color:white;">'.F_decode_tcecode($module['name']).'</td>';
        $ret .= '</tr>'.K_NEWLINE;
        if ($display_mode > 2) {
            $num_subject = 0;
            foreach ($module['subject'] as $subject) {
                $num_subject++;
                $ret .= '<tr style="background-color:#DDFFDD;">';
                $ret .= '<td rowspan="2" style="background-color:#E3F2FD;">M'.$num_module.'</td>'.K_NEWLINE;
                if ($pubmode) {
                    $ret .= '<td rowspan="2" valign="middle"><strong>S'.$num_subject.'</strong></td>'.K_NEWLINE;
                } else {
                    $ret .= '<td rowspan="2" valign="middle"><a href="tce_edit_subject.php?subject_id='.$subject['id'].'" title="'.$l['t_subjects_editor'].'"><strong>S'.$num_subject.'</strong></a></td>'.K_NEWLINE;
                }
                $ret .= '<td rowspan="2" colspan="2">&nbsp;</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['recurrence'].' '.F_formatPercentage($subject['recurrence_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.($subject['average_score_perc']).'%</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">&nbsp;'.date('i:s', $subject['average_time']).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['right'].' '.F_formatPercentage($subject['right_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['wrong'].' '.F_formatPercentage($subject['wrong_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['unanswered'].' '.F_formatPercentage($subject['unanswered_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['undisplayed'].' '.F_formatPercentage($subject['undisplayed_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '<td class="numeric text-monospace text-right">'.$subject['unrated'].' '.F_formatPercentage($subject['unrated_perc'], false).'</td>'.K_NEWLINE;
                $ret .= '</tr>'.K_NEWLINE;
                $ret .= '<tr>';
                $ret .= '<td colspan="8" align="'.$txtdir.'" style="background-color:white;">'.F_decode_tcecode($subject['name']).'</td>';
                $ret .= '</tr>'.K_NEWLINE;
                if ($display_mode > 3) {
                    $num_question = 0;
                    foreach ($subject['question'] as $question) {
                        $num_question++;
                        $ret .= '<tr style="background-color:#FFFACD;">';
                        $ret .= '<td rowspan="2" style="background-color:#E3F2FD;">M'.$num_module.'</td>'.K_NEWLINE;
                        $ret .= '<td rowspan="2" style="background-color:#DDFFDD;">S'.$num_subject.'</td>'.K_NEWLINE;
                        if ($pubmode) {
                            $ret .= '<td rowspan="2" valign="middle"><strong>Q'.$num_question.'</strong></td>'.K_NEWLINE;
                        } else {
                            $ret .= '<td rowspan="2" valign="middle"><a href="tce_edit_question.php?question_id='.$question['id'].'" title="'.$l['t_questions_editor'].'"><strong>Q'.$num_question.'</strong></a></td>'.K_NEWLINE;
                        }
                        $ret .= '<td rowspan="2">&nbsp;</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['recurrence'].' '.F_formatPercentage($question['recurrence_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.($question['average_score_perc']).'%</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">&nbsp;'.date('i:s', $question['average_time']).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['right'].' '.F_formatPercentage($question['right_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['wrong'].' '.F_formatPercentage($question['wrong_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['unanswered'].' '.F_formatPercentage($question['unanswered_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['undisplayed'].' '.F_formatPercentage($question['undisplayed_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '<td class="numeric text-monospace text-right">'.$question['unrated'].' '.F_formatPercentage($question['unrated_perc'], false).'</td>'.K_NEWLINE;
                        $ret .= '</tr>'.K_NEWLINE;
                        $ret .= '<tr>';
                        $ret .= '<td colspan="8" align="'.$txtdir.'" style="background-color:white;">'.F_decode_tcecode($question['description']).'</td>';
                        $ret .= '</tr>'.K_NEWLINE;
                        if ($display_mode > 4) {
                            $num_answer = 0;
                            foreach ($question['answer'] as $answer) {
                                $num_answer++;
                                $ret .= '<tr style="">';
                                $ret .= '<td rowspan="2" style="background-color:#E3F2FD;">M'.$num_module.'</td>'.K_NEWLINE;
                                $ret .= '<td rowspan="2" style="background-color:#DDFFDD;">S'.$num_subject.'</td>'.K_NEWLINE;
                                $ret .= '<td rowspan="2" style="background-color:#FFFACD;">Q'.$num_question.'</td>'.K_NEWLINE;
                                if ($pubmode) {
                                    $ret .= '<td rowspan="2" valign="middle"><strong>A'.$num_answer.'</strong></td>'.K_NEWLINE;
                                } else {
                                    $ret .= '<td rowspan="2" valign="middle"><a href="tce_edit_answer.php?answer_id='.$answer['id'].'" title="'.$l['t_answers_editor'].'"><strong>A'.$num_answer.'</strong></a></td>'.K_NEWLINE;
                                }
                                $ret .= '<td class="numeric text-monospace text-right">'.$answer['recurrence'].' '.F_formatPercentage($answer['recurrence_perc'], false).'</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">&nbsp;</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">&nbsp;</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">'.$answer['right'].' '.F_formatPercentage($answer['right_perc'], false).'</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">'.$answer['wrong'].' '.F_formatPercentage($answer['wrong_perc'], false).'</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">'.$answer['unanswered'].' '.F_formatPercentage($answer['unanswered_perc'], false).'</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">&nbsp;</td>'.K_NEWLINE;
                                $ret .= '<td class="numeric text-monospace text-right">&nbsp;</td>'.K_NEWLINE;
                                $ret .= '</tr>'.K_NEWLINE;
                                $ret .= '<tr>';
                                $ret .= '<td colspan="8" align="'.$txtdir.'" style="background-color:white;">'.F_decode_tcecode($answer['description']).'</td>';
                                $ret .= '</tr>'.K_NEWLINE;
                            } // end for answer
                        }
                    } // end for question
                }
            } // end for subject
        }
    } // end for module
    $ret .= '</table>'.K_NEWLINE;
    return $ret;
}

/**
* Returns test stats as HTML table
* @param $data (array) Array containing test statistics.
* @param $nextorderdir (int) next order direction.
* @param $order_field (string) order fields.
* @param $filter (string) filter string for URLs.
* @param $pubmode (boolean) If true filter the results for the public interface.
* @param $stats (int) 2 = full stats; 1 = user stats; 0 = disabled stats;
* return HTML table string.
*/
function F_printTestResultStat($data, $nextorderdir, $order_field, $filter, $pubmode = false, $stats = 1)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    if (empty($data['num_records'])) {
        return;
    }
    if ($l['a_meta_dir'] == 'rtl') {
        $tdalignr = 'left';
        $tdalign = 'right';
    } else {
        $tdalignr = 'right';
        $tdalign = 'left';
    }
    $ret = '';
    $ret .= '<table class="userselect table table-responsive table-hover" id="test_result_users">'.K_NEWLINE;
    $ret .= '<thead>'.K_NEWLINE;
    $ret .= '<tr class="text-uppercase">'.K_NEWLINE;
    $ret .= '<th>&nbsp;</th>'.K_NEWLINE;
    $ret .= '<th>#</th>'.K_NEWLINE;
    $ret .= F_select_table_header_element('testuser_creation_time', $nextorderdir, $l['h_time_begin'], $l['w_time_begin'], $order_field, $filter);
    //$ret .= F_select_table_header_element('testuser_end_time', $nextorderdir, $l['h_time_end'], $l['w_time_end'], $order_field, $filter);
    $ret .= '<th title="'.$l['h_test_time'].'">'.$l['w_time'].'</th>'.K_NEWLINE;
    $ret .= F_select_table_header_element('testuser_test_id', $nextorderdir, $l['h_test'], $l['w_test'], $order_field, $filter);
    if (!$pubmode) {
        $ret .= F_select_table_header_element('user_name', $nextorderdir, $l['h_login_name'], $l['w_user'], $order_field, $filter);
        $ret .= F_select_table_header_element('user_lastname', $nextorderdir, $l['h_lastname'], $l['w_lastname'], $order_field, $filter);
        $ret .= F_select_table_header_element('user_firstname', $nextorderdir, $l['h_firstname'], $l['w_firstname'], $order_field, $filter);
		$ret .= F_select_table_header_element('usrgrp_group_id', $nextorderdir, '', $l['w_group'], $order_field, $filter);
    }
    $ret .= F_select_table_header_element('total_score', $nextorderdir, $l['h_score_total'], $l['w_score'], $order_field, $filter);
    $ret .= F_select_table_header_element('perc_score', $nextorderdir, $l['h_score_total'], $l['h_score_total'].' (%)', $order_field, $filter);
    if ($stats > 0) {
        $ret .= '<th title="'.$l['h_answers_right'].'">'.$l['w_answers_right'].'</th>'.K_NEWLINE;
        $ret .= '<th title="'.$l['h_answers_wrong'].'">'.$l['w_answers_wrong'].'</th>'.K_NEWLINE;
        $ret .= '<th title="'.$l['h_questions_unanswered'].'">'.$l['w_questions_unanswered'].'</th>'.K_NEWLINE;
        $ret .= '<th title="'.$l['h_questions_undisplayed'].'">'.$l['w_questions_undisplayed'].'</th>'.K_NEWLINE;
        $ret .= '<th title="'.$l['h_questions_unrated'].'">'.$l['w_questions_unrated'].'</th>'.K_NEWLINE;
    }
    $ret .= '<th title="'.$l['w_status'].' ('.$l['w_time'].' ['.$l['w_minutes'].'])">'.$l['w_status'].' ('.$l['w_time'].' ['.$l['w_minutes'].'])</th>'.K_NEWLINE;
    $ret .= '<th title="'.$l['h_testcomment'].'">'.$l['w_comment'].'</th>'.K_NEWLINE;
	if(!$pubmode){
		$ret .= '<th title="Offline sheet">Offline Sheet</th>'.K_NEWLINE;
	}
    $ret .= '</tr>'.K_NEWLINE;
    $ret .= '</thead>'.K_NEWLINE;
    $ret .= '<tbody>'.K_NEWLINE;
	// $restest_arr = array();
    foreach ($data['testuser'] as $tu) {
		/* foreach(F_get_user_groups($tu['user_id']) as $guid){
			
		} */
        $tu['test']['test_name'] = unhtmlentities(strip_tags($tu['test']['test_name']));
        $ret .= '<tr>';
        $ret .= '<td>';
        $ret .= '<div class="custom-checkbox custom-control">';
        $ret .= '<input class="custom-control-input" type="checkbox" name="testuserid'.$tu['num'].'" id="testuserid'.$tu['num'].'" value="'.$tu['id'].'" title="'.$l['w_select'].'"';
        if (isset($_REQUEST['checkall']) and ($_REQUEST['checkall'] == 1)) {
            $ret .= ' checked="checked"';
        }
        $ret .= ' /><label class="custom-control-label" for="testuserid'.$tu['num'].'"></label>';
        $ret .= '</div>'.K_NEWLINE;
        $ret .= '</td>'.K_NEWLINE;
        if (!$pubmode or F_getBoolean($tu['test']['test_report_to_users'])) {
            $ret .= '<td><a href="tce_show_result_user.php?testuser_id='.$tu['id'].'&amp;test_id='.$tu['test']['test_id'].'&amp;user_id='.$tu['user_id'].'" title="'.$l['h_view_details'].'">'.$tu['num'].'</a></td>'.K_NEWLINE;
        } else {
            $ret .= '<td>'.$tu['num'].'</td>'.K_NEWLINE;
        }
        $ret .= '<td style="text-align:center;">'.$tu['testuser_creation_time'].'</td>'.K_NEWLINE;
        //$ret .= '<td style="text-align:center;">'.$tu['testuser_end_time'].'</td>'.K_NEWLINE;
        $ret .= '<td style="text-align:center;">'.$tu['time_diff'].'</td>'.K_NEWLINE;
        $passmsg = '';
        if ($tu['passmsg'] === true) {
            $passmsg = ' title="'.$l['w_passed'].'" class="w_passed"';
        } elseif ($tu['passmsg'] === false) {
            $passmsg = ' title="'.$l['w_not_passed'].'" class="w_not_passed"';
        }
        if ($pubmode) {
            $ret .= '<td style="text-align:'.$tdalign.';">'.$tu['test']['test_name'].'</td>'.K_NEWLINE;
        } else {
            $ret .= '<td style="text-align:'.$tdalign.';"><a href="tce_edit_test.php?test_id='.$tu['test']['test_id'].'">'.$tu['test']['test_name'].'</a></td>'.K_NEWLINE;
            $ret .= '<td style="text-align:'.$tdalign.';"><a href="tce_edit_user.php?user_id='.$tu['user_id'].'">'.$tu['user_name'].'</a></td>'.K_NEWLINE;
            $ret .= '<td style="text-align:'.$tdalign.';">&nbsp;'.$tu['user_lastname'].'</td>'.K_NEWLINE;
            $ret .= '<td style="text-align:'.$tdalign.';">&nbsp;'.$tu['user_firstname'].'</td>'.K_NEWLINE;
            $ret .= '<td style="text-align:'.$tdalign.';">';
			$grpname = array();
			// foreach(F_get_user_groups($tu['user_id']) as $key => $value){
				// $ret .= $value;
				$sqlg = 'SELECT DISTINCT *
					FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
					WHERE usrgrp_group_id=group_id
						AND usrgrp_user_id='.$tu['user_id'];
                if ($rg = F_db_query($sqlg, $db)) {
                    while ($mg = F_db_fetch_array($rg)) {
						$grpname[] = $mg['group_name'];
                        $ret .= '<span class="badge badge-primary">'.$mg['group_name'].'</span>&nbsp;';
                    }
                } else {
                    F_display_db_error();
                }
			// }
			$ret .= '</td>'.K_NEWLINE;
        }
        $ret .= '<td class="numeric text-monospace text-right"><span '.$passmsg.'>'.F_formatFloatAlt($tu['total_score']).'</span></td>'.K_NEWLINE;
        $ret .= '<td class="numeric text-monospace text-right"><span '.$passmsg.'>'.str_replace('&nbsp;','',F_formatPercentageAlt($tu['total_score_perc'], false)).'</span></td>'.K_NEWLINE;
        if ($stats > 0) {
            $ret .= '<td class="numeric text-monospace text-right">'.$tu['right'].'&nbsp;'.F_formatPercentage($tu['right_perc'], false).'</td>'.K_NEWLINE;
            $ret .= '<td class="numeric text-monospace text-right">'.$tu['wrong'].'&nbsp;'.F_formatPercentage($tu['wrong_perc'], false).'</td>'.K_NEWLINE;
            $ret .= '<td class="numeric text-monospace text-right">'.$tu['unanswered'].'&nbsp;'.F_formatPercentage($tu['unanswered_perc'], false).'</td>'.K_NEWLINE;
            $ret .= '<td class="numeric text-monospace text-right">'.$tu['undisplayed'].'&nbsp;'.F_formatPercentage($tu['undisplayed_perc'], false).'</td>'.K_NEWLINE;
            $ret .= '<td class="numeric text-monospace text-right">'.$tu['unrated'].'&nbsp;'.F_formatPercentage($tu['unrated_perc'], false).'</td>'.K_NEWLINE;
        }
        if ($tu['locked']) {
            $ret .= '<td><span class="w_not_passed badge badge-danger">'.$l['w_locked'];
        } else {
            $ret .= '<td><span class="w_passed badge badge-warning">'.$l['w_unlocked'];
        }
        if ($tu['remaining_time'] < 0) {
            $ret .= ' ('.$tu['remaining_time'].')';
        }
        $ret .= '</span></td>'.K_NEWLINE;
        if (!empty($tu['user_comment'])) {
            $ret .= '<td title="'.substr(F_compact_string(htmlspecialchars($tu['user_comment'], ENT_NOQUOTES, $l['a_meta_charset'])), 0, 255).'">'.$l['w_yes'].'</td>'.K_NEWLINE;
        } else {
            $ret .= '<td>&nbsp;</td>'.K_NEWLINE;
        }
		if(!$pubmode){
			$grpname_a = '';
			foreach($grpname as $value){
				$grpname_a .= $value.'_';
			}
			$grpname_a = rtrim($grpname_a,'_');
			
			$grpid = F_get_user_groups($tu['user_id']);
			$grpid_a = '';
			foreach($grpid as $grpid_v){
				$grpid_a .= $grpid_v;
			}
			// echo $grpid_a;
			//
			
			if(file_exists('../../admin/code/tmf_show_offline_sheet.php')){
				// $restest_arr[] = array('test_id' => $tu['id'], 'testuser_id' => $tu['test']['test_id'], 'user_id' => $tu['user_id'], 'username' => $tu['user_name'], 'firstname' => $tu['user_firstname'], 'testname' => $tu['test']['test_name'], 'groupname' => $grpname_a, 'groupid' => $grpid_a);
				// $restest_arr[] = array($tu['id'], $tu['test']['test_id'], $tu['user_id'], $tu['user_name'], $tu['user_firstname'], $tu['test']['test_name'], $grpname_a, $grpid_a);
				
				$ret .= '<td align="center"><a href="tmf_show_offline_sheet.php?testuser_id='.$tu['id'].'&amp;test_id='.$tu['test']['test_id'].'&amp;user_id='.$tu['user_id'].'&amp;username='.$tu['user_name'].'&amp;firstname='.$tu['user_firstname'].'&amp;testname='.$tu['test']['test_name'].'&amp;groupname='.$grpname_a.'&amp;groupid='.$grpid_a.'&amp;ext=html" title="Download offline sheet"><i class="fas fa-download"></i></a></td>'.K_NEWLINE;
			}else{
				$ret .= '<td align="center"><a onclick="alert(\'File untuk keperluan ini harus request secara pribadi ke Maman Sulaeman\')" href="#" title="Download offline sheet"><i class="fas fa-download"></i></a></td>';
			}
		}
        $ret .= '</tr>'.K_NEWLINE;
    }
    $ret .= '<tr>';
    $colspan = 19;
    if ($pubmode) {
        $colspan -= 4;
    }
    if ($stats == 0) {
        $colspan -= 5;
    }
    $ret .= '<td colspan="'.$colspan.'" ';
    if ($data['passed_perc'] > 50) {
        $bg = 'class="badge badge-success"';
    } else {
        $bg = 'class="badge badge-danger"';
    }
    $ret .= '"><span '.$bg.'>'.$l['w_passed'].': '.$data['passed'].' '.F_formatPercentage($data['passed_perc'], false).'</span></td>'.K_NEWLINE;
    $ret .= '</tr>';
    // print statistics
    $printstat = array('mean', 'median', 'mode', 'standard_deviation', 'skewness', 'kurtosi');
    $noperc = array('skewness', 'kurtosi');
    foreach ($data['statistics'] as $row => $col) {
        if (in_array($row, $printstat)) {
            $ret .= '<tr>';
            $scolspan = 10;
            if ($pubmode) {
                $scolspan -= 4;
            }
            $ret .= '<th colspan="'.$scolspan.'" style="text-align:'.$tdalignr.';">'.$l['w_'.$row].'</th>'.K_NEWLINE;
            if (in_array($row, $noperc)) {
                $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['score_perc']).'</td>'.K_NEWLINE;
                if ($stats > 0) {
                    $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['right_perc']).'</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['wrong_perc']).'</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['unanswered_perc']).'</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['undisplayed_perc']).'</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.F_formatFloat($col['unrated_perc']).'</td>'.K_NEWLINE;
                }
            } else {
                $ret .= '<td class="numeric text-monospace text-right">'.round($col['score_perc']).'</td>'.K_NEWLINE;
                if ($stats > 0) {
                    $ret .= '<td class="numeric text-monospace text-right">'.round($col['right_perc']).'%</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.round($col['wrong_perc']).'%</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.round($col['unanswered_perc']).'%</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.round($col['undisplayed_perc']).'%</td>'.K_NEWLINE;
                    $ret .= '<td class="numeric text-monospace text-right">'.round($col['unrated_perc']).'%</td>'.K_NEWLINE;
                }
            }
            $ret .= '<td colspan="3">&nbsp;</td>'.K_NEWLINE;
            $ret .= '</tr>';
        }
    }
    $ret .= '</tbody>'.K_NEWLINE;
    $ret .= '</table>'.K_NEWLINE;
	// echo '<pre>';
	// echo serialize($restest_arr);
	// echo '<a href="tmf_show_offline_sheet.php?'.http_build_query($restest_arr).'"><i class="fas fa-download"></i></a>';
	
	// echo http_build_query($restest_arr);
	// echo '<pre>';
    return $ret;
}

/**
* Returns user test stats as HTML table
* @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
* return $data string containing HTML table.
*/
function F_printUserTestStat($testuser_id)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_tcecode.php');
    global $db, $l;
    $testuser_id = intval($testuser_id);

    $ret = '';

    // display user questions
    $sql = 'SELECT *
		FROM '.K_TABLE_QUESTIONS.', '.K_TABLE_TESTS_LOGS.', '.K_TABLE_SUBJECTS.', '.K_TABLE_MODULES.'
		WHERE question_id=testlog_question_id
			AND testlog_testuser_id='.$testuser_id.'
			AND question_subject_id=subject_id
			AND subject_module_id=module_id
		ORDER BY testlog_id';
    if ($r = F_db_query($sql, $db)) {
		$no=0;
        $ret .= '<div class="allquestion">'.K_NEWLINE;
        while ($m = F_db_fetch_array($r)) {
			$no++;
            $ret .= '<div class="form-row border rounded p-2 my-2">'.K_NEWLINE;
            // display question stats
			$ret .= '<div id="qstat'.$no.'" class="col-md-2">'.K_NEWLINE;
			$ret .= '<div id="q-num'.$no.'">'.K_NEWLINE;
            $ret .= '<div><button type="button" class="btn btn-sm btn-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Nomor Soal">#'.$no.'</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Skor">'.$m['testlog_score'].'</button>'.K_NEWLINE;
            $ret .= '<button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="IP Address">';
            $ret .= getIpAsString($m['testlog_user_ip']).K_NEWLINE;
            if (isset($m['testlog_display_time']) and (strlen($m['testlog_display_time']) > 0)) {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Waktu tayang soal">'.substr($m['testlog_display_time'], 11, 8).K_NEWLINE;
            } else {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Durasi tayang soal">--:--:--'.K_NEWLINE;
            }
            if (isset($m['testlog_change_time']) and (strlen($m['testlog_change_time']) > 0)) {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Waktu soal terjawab">'.substr($m['testlog_change_time'], 11, 8).K_NEWLINE;
            } else {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Waktu soal terjawab">--:--:--'.K_NEWLINE;
            }
            if (isset($m['testlog_display_time']) and isset($m['testlog_change_time'])) {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Lamanya soal terjawab">'.date('i:s', (strtotime($m['testlog_change_time']) - strtotime($m['testlog_display_time']))).'';
            } else {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Lamanya soal terjawab">--:--'.K_NEWLINE;
            }
            if (isset($m['testlog_reaction_time']) and ($m['testlog_reaction_time'] > 0)) {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="Lamanya reaksi terhadap soal">'.($m['testlog_reaction_time']/1000).'';
            } else {
                $ret .= '</button><button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-original-title="IP Address">------</button>'.K_NEWLINE;
            }
            $ret .= '</div>'.K_NEWLINE;
            $ret .= '</div>'.K_NEWLINE;
            $ret .= '</div>'.K_NEWLINE;
            // display question description
			$ret .= '<div id="contentBlock'.$no.'" class="col-md-10">';
            $ret .= F_decode_tcecode($m['question_description']).K_NEWLINE;
            if (K_ENABLE_QUESTION_EXPLANATION and !empty($m['question_explanation'])) {
                $ret .= '<span class="explanation">'.$l['w_explanation'].':</span><br />'.F_decode_tcecode($m['question_explanation']).''.K_NEWLINE;
            }
            if ($m['question_type'] == 3) {
                // TEXT
                $ret .= '<ul class="answer" id="qtype3"><li>'.K_NEWLINE;
                //$ret .= F_decode_tcecode($m['testlog_answer_text']);
                $ret .= $m['testlog_answer_text'];
                $ret .= '&nbsp;</li></ul>'.K_NEWLINE;
            } else {
                $ret .= '<ol class="answer list-group list-group-flush">'.K_NEWLINE;
                // display each answer option
                $sqla = 'SELECT *
					FROM '.K_TABLE_LOG_ANSWER.', '.K_TABLE_ANSWERS.'
					WHERE logansw_answer_id=answer_id
						AND logansw_testlog_id=\''.$m['testlog_id'].'\'
					ORDER BY logansw_order';
                if ($ra = F_db_query($sqla, $db)) {
                    while ($ma = F_db_fetch_array($ra)) {
                        $ret .= '<li class="list-group-item py-1">';
                        if ($m['question_type'] == 4) {
                            // ORDER
                            if ($ma['logansw_position'] > 0) {
                                if ($ma['logansw_position'] == $ma['answer_position']) {
                                    $ret .= '<acronym title="'.$l['h_answer_right'].'" class="okbox">'.$ma['logansw_position'].'</acronym>';
                                } else {
                                    $ret .= '<acronym title="'.$l['h_answer_wrong'].'" class="nobox">'.$ma['logansw_position'].'</acronym>';
                                }
                            } else {
                                $ret .= '<acronym title="'.$l['m_unanswered'].'" class="offbox">&nbsp;</acronym>';
                            }
                        } elseif ($ma['logansw_selected'] > 0) {
                            if (F_getBoolean($ma['answer_isright'])) {
                                $ret .= '<span title="'.$l['h_answer_right'].'" class="okbox badge badge-success py-1 px-2">x</span>';
                            } else {
                                $ret .= '<span title="'.$l['h_answer_wrong'].'" class="nobox badge badge-danger px-2 py-1">x</span>';
                            }
                        } elseif ($m['question_type'] == 1) {
                            // MCSA
                            $ret .= '<span title="-" class="offbox badge badge-light border">&nbsp;</span>';
                        } else {
                            if ($ma['logansw_selected'] == 0) {
                                if (F_getBoolean($ma['answer_isright'])) {
                                    $ret .= '<span title="'.$l['h_answer_wrong'].'" class="nobox badge badge-primary">&nbsp;</span>';
                                } else {
                                    $ret .= '<span title="'.$l['h_answer_right'].'" class="okbox badge badge-primary">&nbsp;</span>';
                                }
                            } else {
                                $ret .= '<span title="'.$l['m_unanswered'].'" class="offbox badge badge-dark">&nbsp;</span>';
                            }
                        }
                        $ret .= '&nbsp;';
                        if ($m['question_type'] == 4) {
                            $ret .= '<span title="'.$l['w_position'].'" class="onbox badge badge-info">'.$ma['answer_position'].'</span>';
                        } elseif (F_getBoolean($ma['answer_isright'])) {
                            $ret .= '<span title="'.$l['w_answers_right'].'" class="onbox badge badge-success px-2 py-1 small"><i class="fa fa-check"></i></span>';
                        } else {
                            $ret .= '<span title="'.$l['w_answers_wrong'].'" class="offbox badge badge-danger">&nbsp;</span>';
                        }
                        $ret .= ' ';
                        $ret .= F_decode_tcecode($ma['answer_description']);
                        if (K_ENABLE_ANSWER_EXPLANATION and !empty($ma['answer_explanation'])) {
                            $ret .= '<br /><span class="explanation">'.$l['w_explanation'].':</span><br />'.F_decode_tcecode($ma['answer_explanation']).''.K_NEWLINE;
                        }
                        $ret .= '</li>'.K_NEWLINE;
                    }
                } else {
                    F_display_db_error();
                }
                $ret .= '</ol>'.K_NEWLINE;
            } // end multiple answers
            // display teacher/supervisor comment to the question
            if (isset($m['testlog_comment']) and (!empty($m['testlog_comment']))) {
                $ret .= '<ul class="answer"><li class="comment">'.K_NEWLINE;
                $ret .= F_decode_tcecode($m['testlog_comment']);
                $ret .= '&nbsp;</li></ul>'.K_NEWLINE;
            }
            // $ret .= '<br /><br />'.K_NEWLINE;
            $ret .= '</div>'.K_NEWLINE;
            $ret .= '</div>'.K_NEWLINE;
        }
        $ret .= '</div>'.K_NEWLINE;
    } else {
        F_display_db_error();
    }
    return $ret;
}


/**
* Returns users statistic array for the selected test.
* @param $test_id (int) test ID.
* @param $group_id (int) group ID - if greater than zero, filter stats for the specified user group.
* @param $user_id (int) user ID - if greater than zero, filter stats for the specified user.
* @param $startdate (string) start date ID - if greater than zero, filter stats for the specified starting date
* @param $enddate (string) end date ID - if greater than zero, filter stats for the specified ending date
* @param $full_order_field (string) Ordering fields for SQL query.
* @param $pubmode (boolean) If true filter the results for the public interface.
* @param $stats (int) 2 = full stats; 1 = user stats; 0 = disabled stats;
* return $data array containing test statistics.
*/
function F_getAllUsersTestStat($test_id, $group_id = 0, $user_id = 0, $startdate = 0, $enddate = 0, $full_order_field = 'total_score', $pubmode = false, $stats = 2)
{
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_test.php');
    require_once('../../shared/code/tce_functions_statistics.php');
    global $db, $l;
    $test_id = intval($test_id);
    $group_id = intval($group_id);
    $user_id = intval($user_id);
    $data = array();
    $data['svgpoints'] = '';
    $data['testuser'] = array();
    $sqlr = 'SELECT
		testuser_id,
		testuser_test_id,
		testuser_creation_time,
		testuser_status,
		user_id,
		user_lastname,
		user_firstname,
		user_name,
		user_email,
		SUM(testlog_score) AS total_score,
		MAX(testlog_change_time) AS testuser_end_time
		FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_TEST_USER.', '.K_TABLE_USERS.'';
    if ($group_id > 0) {
        $sqlr .= ','.K_TABLE_USERGROUP.'';
    }
    $sqlr .= ' WHERE testlog_testuser_id=testuser_id AND testuser_user_id=user_id';
    if ($pubmode) {
        $sqlr .= ' AND testuser_test_id IN ('.F_getTestIDResults($test_id, $user_id).') AND testuser_user_id='.$user_id.' AND testuser_status>3';
    }
    if ($test_id > 0) {
        $sqlr .= ' AND testuser_test_id='.$test_id.'';
    }
    if ($group_id > 0) {
        $sqlr .= ' AND usrgrp_user_id=user_id AND usrgrp_group_id='.$group_id.'';
    }
    if ($user_id > 0) {
        $sqlr .= ' AND user_id='.$user_id.'';
    }
    if (!empty($startdate)) {
        $startdate_time = strtotime($startdate);
        $startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
        $sqlr .= ' AND testuser_creation_time>=\''.$startdate.'\'';
    }
    if (!empty($enddate)) {
        $enddate_time = strtotime($enddate);
        $enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
        $sqlr .= ' AND testuser_creation_time<=\''.$enddate.'\'';
    }
    if ($stats > 1) {
        // get stats
        $data += F_getTestStat($test_id, $group_id, $user_id, $startdate, $enddate, 0, $pubmode);
    }
    $sqlr .= ' GROUP BY testuser_id, testuser_test_id, testuser_creation_time, user_id, user_lastname, user_firstname, user_name, user_email, testuser_status
		ORDER BY '.$full_order_field.'';
    if ($rr = F_db_query($sqlr, $db)) {
        $itemcount = 0;
        $passed = 0;
        $statsdata = array();
        $statsdata['score'] = array();
        $statsdata['right'] = array();
        $statsdata['wrong'] = array();
        $statsdata['unanswered'] = array();
        $statsdata['undisplayed'] = array();
        $statsdata['unrated'] = array();
		$statsdata['recurrence'] = array();
        while ($mr = F_db_fetch_array($rr)) {
            $itemcount++;
            $usrtestdata = F_getUserTestStat($mr['testuser_test_id'], $mr['user_id'], $mr['testuser_id']);
            if ($stats > 0) {
                $teststat = F_getTestStat($mr['testuser_test_id'], $group_id, $mr['user_id'], $startdate, $enddate, $mr['testuser_id'], $pubmode);
            }
            $data['testuser']['\''.$mr['testuser_id'].'\''] = array();
            $data['testuser']['\''.$mr['testuser_id'].'\'']['test'] = $usrtestdata;
            $data['testuser']['\''.$mr['testuser_id'].'\'']['num'] = $itemcount;
            $data['testuser']['\''.$mr['testuser_id'].'\'']['id'] = $mr['testuser_id'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_id'] = $mr['user_id'];
            $halfscore = ($usrtestdata['test_max_score'] / 2);
            $data['testuser']['\''.$mr['testuser_id'].'\'']['testuser_creation_time'] = $mr['testuser_creation_time'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['testuser_end_time'] = $mr['testuser_end_time'];
            if (($mr['testuser_end_time'] <= 0) or (strtotime($mr['testuser_end_time']) < strtotime($mr['testuser_creation_time']))) {
                $time_diff =  ($usrtestdata['test_duration_time'] * K_SECONDS_IN_MINUTE);
            } else {
                $time_diff = strtotime($mr['testuser_end_time']) - strtotime($mr['testuser_creation_time']); //sec
            }
            $data['testuser']['\''.$mr['testuser_id'].'\'']['time_diff'] = gmdate('H:i:s', $time_diff);
            $passmsg = false;
            if ($usrtestdata['test_score_threshold'] > 0) {
                if ($usrtestdata['user_score'] >= $usrtestdata['test_score_threshold']) {
                    $passmsg = true;
                    $passed++;
                }
            } elseif ($usrtestdata['user_score'] > $halfscore) {
                $passmsg = true;
                $passed++;
            }
            if ($usrtestdata['test_max_score'] > 0) {
                $total_score_perc = round(100 * $mr['total_score'] / $usrtestdata['test_max_score']);
            } else {
                $total_score_perc = 0;
            }
            $data['testuser']['\''.$mr['testuser_id'].'\'']['passmsg'] = $passmsg;
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_name'] = $mr['user_name'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_email'] = $mr['user_email'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_lastname'] = $mr['user_lastname'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_firstname'] = $mr['user_firstname'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['total_score'] = $mr['total_score'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['total_score_perc'] = $total_score_perc;
            if ($stats > 0) {
				$data['testuser']['\''.$mr['testuser_id'].'\'']['recurrence'] = $teststat['qstats']['recurrence'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['right'] = $teststat['qstats']['right'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['right_perc'] = $teststat['qstats']['right_perc'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['wrong'] = $teststat['qstats']['wrong'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['wrong_perc'] = $teststat['qstats']['wrong_perc'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unanswered'] = $teststat['qstats']['unanswered'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unanswered_perc'] = $teststat['qstats']['unanswered_perc'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['undisplayed'] = $teststat['qstats']['undisplayed'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['undisplayed_perc'] = $teststat['qstats']['undisplayed_perc'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unrated'] = $teststat['qstats']['unrated'];
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unrated_perc'] = $teststat['qstats']['unrated_perc'];
            } else {
				$data['testuser']['\''.$mr['testuser_id'].'\'']['recurrence'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['right'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['right_perc'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['wrong'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['wrong_perc'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unanswered'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unanswered_perc'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['undisplayed'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['undisplayed_perc'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unrated'] = '';
                $data['testuser']['\''.$mr['testuser_id'].'\'']['unrated_perc'] = '';
            }
            if ($mr['testuser_status'] > 3) {
                $data['testuser']['\''.$mr['testuser_id'].'\'']['locked'] = true;
            } else {
                $data['testuser']['\''.$mr['testuser_id'].'\'']['locked'] = false;
            }
            // remaining user time in minutes
            $data['testuser']['\''.$mr['testuser_id'].'\'']['remaining_time'] = round(((time() - strtotime($usrtestdata['user_test_start_time']))) / K_SECONDS_IN_MINUTE) - $usrtestdata['test_duration_time'];
            $data['testuser']['\''.$mr['testuser_id'].'\'']['user_comment'] = $usrtestdata['user_comment'];
            // SVG points
            $data['svgpoints'] .= 'x'.$data['testuser']['\''.$mr['testuser_id'].'\'']['total_score_perc'].'v'.$data['testuser']['\''.$mr['testuser_id'].'\'']['right_perc'];
            // collects data for descriptive statistics
            $statsdata['score'][] = $mr['total_score'];
            $statsdata['score_perc'][] = $total_score_perc;
            if ($stats > 0) {
				$statsdata['recurrence'][] = $teststat['qstats']['recurrence'];
                $statsdata['right'][] = $teststat['qstats']['right'];
                $statsdata['right_perc'][] = $teststat['qstats']['right_perc'];
                $statsdata['wrong'][] = $teststat['qstats']['wrong'];
                $statsdata['wrong_perc'][] = $teststat['qstats']['wrong_perc'];
                $statsdata['unanswered'][] = $teststat['qstats']['unanswered'];
                $statsdata['unanswered_perc'][] = $teststat['qstats']['unanswered_perc'];
                $statsdata['undisplayed'][] = $teststat['qstats']['undisplayed'];
                $statsdata['undisplayed_perc'][] = $teststat['qstats']['undisplayed_perc'];
                $statsdata['unrated'][] = $teststat['qstats']['unrated'];
                $statsdata['unrated_perc'][] = $teststat['qstats']['unrated_perc'];
            } else {
				$statsdata['recurrence'][] = '';
                $statsdata['right'][] = '';
                $statsdata['right_perc'][] = '';
                $statsdata['wrong'][] = '';
                $statsdata['wrong_perc'][] = '';
                $statsdata['unanswered'][] = '';
                $statsdata['unanswered_perc'][] = '';
                $statsdata['undisplayed'][] = '';
                $statsdata['undisplayed_perc'][] = '';
                $statsdata['unrated'][] = '';
                $statsdata['unrated_perc'][] = '';
            }
        }
    } else {
        F_display_db_error();
    }
    $data['passed'] = $passed;
    $passed_perc = 0;
    if ($itemcount > 0) {
        $passed_perc = round(100 * $passed / $itemcount);
    }
    $data['passed_perc'] = $passed_perc;
    $data['num_records'] = $itemcount;
    if ($itemcount > 0) {
        // calculate statistics
        $data['statistics'] = F_getArrayStatistics($statsdata);
    }
    return $data;
}

/**
 * Lock the user's test.<br>
 * @param $test_id (int) test ID
 * @param $user_id (int) user ID
 */
function F_lockUserTest($test_id, $user_id)
{
    require_once('../config/tce_config.php');
    global $db, $l;
    $test_id = intval($test_id);
    $user_id = intval($user_id);
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
 * Returns a comma separated string of test IDs with test_results_to_users enabled
 * @param $test_id (int) Test ID.
 * @return string
 */
function F_getTestIDResults($test_id, $user_id)
{
    return F_getTestIDs($test_id, $user_id, 'test_results_to_users');
}

/**
 * Returns a comma separated string of test IDs with test_results_to_users enabled
 * @param $test_id (int) Test ID.
 * @return string
 */
function F_getTestIDReports($test_id, $user_id)
{
    return F_getTestIDs($test_id, $user_id, 'test_report_to_users');
}

/**
 * Returns a comma separated string of test IDs with test_results_to_users enabled
 * @param $test_id (int) Test ID.
 * @return string
 */
function F_getTestIDs($test_id, $user_id, $filter = 'test_results_to_users')
{
    global $l,$db;
    require_once('../config/tce_config.php');
    $str = '0'; // string to return
    $test_id = intval($test_id);
    $user_id = intval($user_id);
    $sql = 'SELECT test_id FROM '.K_TABLE_TESTS.' WHERE test_id IN (SELECT DISTINCT testuser_test_id FROM '.K_TABLE_TEST_USER.' WHERE testuser_user_id='.intval($user_id).' AND testuser_status>3) AND '.$filter.'=1';
    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_assoc($r)) {
            $str .= ','.$m['test_id'];
        }
    } else {
        F_display_db_error();
    }
    return $str;
}

//============================================================+
// END OF FILE
//============================================================+
