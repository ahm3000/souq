<?php


function date_int2string($date){
	$y=substr($date, 0,4);
	$m=substr($date, 4,2);
	$d=substr($date, 6,2);
	return "$y-$m-$d";
}

function date_string2int($date){
	return str_replace("-", "", $date);
}

function valid_date($date){
	$date_arr = explode("/", $date);
	if (strlen($date_arr[0]) == 4) {
		$y = $date_arr[0];
		$m = $date_arr[1];
		$d = $date_arr[2];
	}
	else {
		$y = $date_arr[2];
		$m = $date_arr[1];
		$d = $date_arr[0];
	}
	if ($y<1000) {
		$y = $y + 1900;
	}
	if ($d<1) {
		$d = 1 ;
	}
	if ($m<1) {
		$m = 1 ;
	}
	$date = sprintf("%04d-%02d-%02d",$y,$m,$d);
	return $date;
}