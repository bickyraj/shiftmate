<?php
$y = $_GET['year'];
$ddate = $y."-07-01";

$i = 1;

	$startDate = date("Y-m-d",strtotime('last Sunday',strtotime($ddate)));
	$endDate = date("Y-m-d",strtotime('this Saturday',strtotime($ddate)));
	
	$week = array();

	$week[1] = $y."-07-01"."/".$endDate;

	$year = $y;
	$month = 07;
	$date = date('d', strtotime($endDate));
for ($i=2; $i <=53; $i++) { 

	$dates = $year."-".$month."-".$date;

	$s = date("Y-m-d",strtotime('this Sunday',strtotime($dates)));//2015-06-01

	$stop = 0;
	$e = date("Y-m-d",strtotime('this Saturday',strtotime($s)));
	if($i == 52 && strtotime($e) >= strtotime("$year-06-30"))
	{
		$e = date("Y-m-d",strtotime($year."-6-30"));
		$stop = 1;
	}
	if($i == 53)
	{
		$e = date("Y-m-d",strtotime($year."-6-30"));//2015-0-30
	}
	else
	{
		$e = date("Y-m-d",strtotime('this Saturday',strtotime($s)));//2015-06-07
	}

	$week[$i] = $s."/".$e;
	if($stop ==1)
	{
		break;
	}

	$last_day_of_month = date("d",strtotime(date('Y-m-t', strtotime($year."-".$month."-".$date))));

	$year = date("Y", strtotime($e));
	$month = date("m", strtotime($e));
	$date = date("d", strtotime($e));
	$date++;

	if($date > $last_day_of_month)
	{
		$date = 01;
		$month++;
		if($month >12)
		{
			$month = 01; 
			$year++;
		}
	}
}

// echo "<pre>";
// print_r($week);
echo json_encode($week);


?>