<?php
$y = $_GET['year'];
$ddate = $y."-07-01";

$i = 1;

	$startDate = date("Y-m-d",strtotime('last Sunday',strtotime($ddate)));

	$sat = date("N", strtotime($ddate));

	if($sat == 6)
	{
		$endDate = date("Y-m-d",strtotime('next Saturday',strtotime($ddate)));
	}
	else
	{

		$endDate = date("Y-m-d",strtotime('next Saturday + 1 week',strtotime($ddate)));
	}
	
	$fortnight = array();

	$fortnight[1] = $y."-07-01"."/".$endDate;

	$year = $y;
	$month = 07;
	$date = date("d", strtotime($endDate));
for ($i=2; $i <=27 ; $i++) { 

	$dates = $year."-".$month."-".$date;

	$s = date("Y-m-d",strtotime('this Sunday',strtotime($dates)));//2015-06-01
	$stop = 0;

	$e = date("Y-m-d",strtotime('next Saturday + 1 week',strtotime($s)));
	if($i == 26 && strtotime($e) >= strtotime("$year-06-30"))
	{
		$e = date("Y-m-d",strtotime($year."-6-30"));
		$stop = 1;
	}

	if($i == 27)
	{
		$e = date("Y-m-d",strtotime($year."-6-30"));//2015-0-30
	}
	else
	{
		$e = date("Y-m-d",strtotime('next Saturday + 1 week',strtotime($s)));//2015-06-07
	}

	$fortnight[$i] = $s."/".$e;
	if($stop == 1)
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
// print_r($fortnight);

echo json_encode($fortnight);


?>