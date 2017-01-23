<?php 
$yearSelected=date("Y");
$monthSelected=date("m");
$daySelected=date("d");
// $yearSelected=2017;
// $monthSelected=2;
// $daySelected=25;

echo'result holiday - ';
var_dump(result($yearSelected,$monthSelected,$daySelected));
echo'<br><br>';

echo'dynamic holiday - ';
var_dump(nearest_holiday_dynamic($yearSelected,$monthSelected,$daySelected));
echo'<br>';

echo'static holiday - ';
var_dump(nearest_holiday_static($yearSelected,$monthSelected,$daySelected));
echo'<br>';

echo'Easter - ';
var_dump(Easter($yearSelected));
echo'<br>';

function result($yearSelected,$monthSelected,$daySelected){
	$nearest_holiday_dynamic = nearest_holiday_dynamic($yearSelected,$monthSelected,$daySelected);
	$nearest_holiday_static = nearest_holiday_static($yearSelected,$monthSelected,$daySelected);
	$nearest_holiday_dynamic['mktime'] <= $nearest_holiday_static['mktime'] ? $result = $nearest_holiday_dynamic : $result = $nearest_holiday_static;
	return $result;
}

function nearest_holiday_dynamic($yearSelected,$monthSelected,$daySelected){
	$count = 0;
	$year = $yearSelected;
	while($count == 0){
		$Easter = Easter($year);
		$dayOfYear_Easter = $Easter['dayOfYear'];
		$dayOfYear_daySelected = date("z", mktime(0, 0, 0, $monthSelected, $daySelected, $yearSelected));
		$difference_Easter_daySelected = $dayOfYear_daySelected - $dayOfYear_Easter;
		$select = select($table = 'calendar_dynamic', $conditions = 'difference >= '.$difference_Easter_daySelected.' ORDER BY difference ASC LIMIT 1');
		
		while($row = mysql_fetch_array($select)){
			$count = $count + 1;
			$difference_holiday_Easter = $row['difference'];
			$title = $row['title'];
			$introduction = $row['introduction'];
			$text = $row['text'];
			$dayOfYear_holiday = $dayOfYear_Easter + $difference_holiday_Easter;
		}
		
		$year = $year + 1;
	}
	
	$nearest_holiday_dynamic = [
		'mktime' => $Easter['mktime']+$difference_holiday_Easter*24*60*60-24*60*60,
		'date' => date("d-m-Y", $Easter['mktime']+$difference_holiday_Easter*24*60*60),
		'datetime' => date("d-m-Y H:i:s", $Easter['mktime']+$difference_holiday_Easter*24*60*60),
		'title' => $title,
		'introduction' => $introduction,
		'text' => $text,
		'difference_holiday_Easter' => $difference_holiday_Easter,
	];
	
	return $nearest_holiday_dynamic;
}

function nearest_holiday_static($yearSelected,$monthSelected,$daySelected){
	$count = 0;
	$year = $yearSelected;
	$month = $monthSelected;
	$day = $daySelected;
	
	$select = select($table = 'calendar_static', $conditions = 'month='.$month.' AND day>='.$day.' ORDER BY day ASC LIMIT 1');
	while($row = mysql_fetch_array($select)){
		$count = $count + 1;
		$month = $row['month'];
		$day = $row['day'];
		$title = $row['title'];
		$introduction = $row['introduction'];
		$text = $row['text'];
	}
	
	while($count == 0){
		$month = $month + 1;
		if($month == 13){
			$month = 1;
			$year = $year+1;
		}
		$select = select($table = 'calendar_static', $conditions = 'month='.$month.' ORDER BY day ASC LIMIT 1' );
		while($row = mysql_fetch_array($select)) {
			$count = $count + 1;
			$month = $row['month'];
			$day = $row['day'];
			$title = $row['title'];
			$introduction = $row['introduction'];
			$text = $row['text'];
		}
	}
	
	$dayOfYear_holiday = date("z", mktime(0, 0, 0, $month, $day, $year));
	
	$nearest_holiday_static = [
		'mktime' => mktime(0, 0, 0, $month, $day, $year),
		'date' => date("d-m-Y", mktime(0, 0, 0, $month, $day, $year)),
		'datetime' => date("d-m-Y H:i:s", mktime(0, 0, 0, $month, $day, $year)),
		'title' => $title,
		'introduction' => $introduction,
		'text' => $text,
	];
	
	return $nearest_holiday_static;
}

function Easter($year){
	$a = $year % 19;
	$b = $year % 4;
	$c = $year % 7;
	$d = (19*$a + 15) % 30;
	$e = (2*$b + 4*$c + 6*$d + 6) % 7;

	if($d + $e < 10){
		$dEaster = 22 + $d + $e + 13; $mEaster = 3; $mEaster_spec = '03';
		if ($dEaster > 31){
			$dEaster = $dEaster - 31; $mEaster = 4; $mEaster_spec = '04';
		}
	}
	else{
		$dEaster = $d + $e - 9 + 13; $mEaster = 4; $mEaster_spec = '04';
		if ($dEaster > 30){
			$dEaster = $dEaster - 30; $mEaster = 5; $mEaster_spec = '05';
		}
	}
	
	$Easter = [
		'dayOfYear' => date("z", mktime(0, 0, 0, $mEaster, $dEaster, $year)),
		'date' => date("$year-$mEaster_spec-$dEaster"),
		'mktime' => mktime(0, 0, 0, $mEaster, $dEaster, $year),
	];
	
	return $Easter;
}

function select($table, $conditions){
	header( 'Content-Type: text/html; charset=utf-8' );
	$server = "localhost";
	$user = 'root';
	$pass = '';
	$database = "halva202_github_calendar";
	$db = mysql_connect($server, $user, $pass);
	if(!mysql_select_db($database)){
		echo 'bd is absent<br>';
		die(mysql_error());
	};
	mysql_set_charset( 'utf8' );

	$select = mysql_query('SELECT * FROM '.$table.' where '.$conditions);
	return $select;
}
