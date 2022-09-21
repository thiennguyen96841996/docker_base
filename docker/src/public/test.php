<?php


    $bit = 2 ;
    echo $bit & 1;
    echo "<br>";
    echo ($bit & 2) >> 1;

    echo "<br>-----------<br>";
    $bit1 = 1;
    $bit2 = 1;
    echo ($bit2 << 1) | $bit1;

    $timestamp_cl_attendance_application = "2021-07-06";
    echo getNthDay($timestamp_cl_attendance_application, 14) < date("Y-m-d");


/**
 * 	日付からN日過ぎの日付を取得
 *
 *  @return date
 */
function getNthDay($curdate,$n,$delimeter='-') {
	if (!isset($curdate)) {
		$curdate = date('Y-m-d');
	}
	if (!preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$curdate,$match)) {
		return $curdate;
	}
	$newdate = mktime(0,0,0,$match[2],$match[3],$match[1]);
	return date('Y'.$delimeter.'m'.$delimeter.'d', $newdate + ($n * 24 * 60 * 60));
};


?>