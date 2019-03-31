<?php

// require_once('httpful.phar');
require_once('config.php');
// require_once('config1.php');

$action = $_POST['action'];

// H:i:s to standart time format
function hisToTime($hisTime)
{
    $startTime = new DateTime($hisTime);
    return $startTime->format('g:i A');
}

function ymdtofjy($date)
{   
    $date = strtotime($date);
    return date('F j, Y', $date);
}


switch ($action) {

	case 'approveHoliday':

		if(isset($_POST['leaveId']))
		{
		    $url = URL."Leaveholidays/approveHoliday/".$_POST['leaveId'].".json";

		    $response = \Httpful\Request::post($url)
		                ->send();

		                echo $response->body->output->status;
		}
		break;

	case 'editNotes':
			if(isset($_POST['shiftId']))
			{
				$url = URL."Shiftnotes/viewNote/".$_POST['shiftId'].".json";
				$response = \Httpful\Request::post($url)
		                ->send();

		                echo json_encode($response->body);
			}
		break;

	case 'getBranchRelatedShift':
		if(isset($_POST['branchId']))
		{
			$url = URL. "ShiftBranches/getBranchRelatedShift/".$_POST['branchId'].".json";
			$response = \Httpful\Request::post($url)
		                ->send();

		                echo json_encode($response->body);
		}
		
        case 'getOrgProfile':
            if(isset($_POST['orgid'])){
                $url=URL."Organizations/organizationProfile/".$_POST['orgid'].".json";
                $response=\Httpful\Request::get($url)->send();
                echo json_encode($response->body->output);
            }
        break;

        case 'getLimitReviews':
            if(isset($_POST['orgid']) && isset($_POST['userid']) && isset($_POST['revType']) && isset($_POST['branchid']) && isset($_POST['page'])){
                $url = URL."Reviews/myReviews/".$_POST['revType']."/".$_POST['userid']."/".$_POST['orgid']."/".$_POST['branchid']."/".$_POST['page'].".json";
                $response=\Httpful\Request::get($url)->send();
                echo json_encode($response->body);
            }
        break;


    case 'feedbackPin':

     	if(isset($_POST['feedId']))
     	{

    	 	$url = URL.'Feeds/pinFeeds/'.$_POST['feedId'].'.json';
    	 	$response =\Httpful\Request::get($url)->send();
    	 	echo ($response->body->output->pinStatus);


     	}

 	case 'composeMessageGetUsers':

 			if(isset($_POST['listBoardId'])&& $_POST['listBoardId'] !='0')
 			{
 				$url = URL."BoardUsers/getBoardRelatedUsers/".$_POST['listBoardId']."/".$_POST['userId'].".json";

 				$response = \Httpful\Request::get($url)->send();

 				echo json_encode($response->body);
 			}
 			else
 			{
 				$url = URL."OrganizationUsers/getOrganizationUsers/".$_POST['orgId'].".json";

 				$response = \Httpful\Request::get($url)->send();

 				echo json_encode($response->body);
 			}
 		break;

 	case 'getboarduser':

     		if(isset($_POST['boardId']))
     		{
     			$url = URL."BoardUsers/boardEmployeeList/".$_POST['boardId'].".json";
     			$response = \Httpful\Request::get($url)->send();

     			echo json_encode($response->body->message->employeeList);
     		}

 		break;

 	case 'getShifts':

 		if(isset($_POST['boardId']))
 		{
 			$url = URL."ShiftBoards/boardShiftList/".$_POST['boardId'].".json";
 			$response = \Httpful\Request::get($url)->send();

 			echo json_encode($response->body->boardShifts);
 		}
 		
 		break;

 		case 'shiftCheckIn':

 		if(isset($_POST['userId']) && isset($_POST['shiftUserId']))
 		{
 			// print_r($_POST);
 			$url = URL."ShiftUsers/checkIn/".$_POST['userId']."/".$_POST['shiftUserId'].".json";
 			$response = \Httpful\Request::get($url)->send();

 			if($response->body->output->status == 1)
 			{
 				echo "1";
 			}
 			else
 			{
 				echo "0";
 			}
 		}
 		break;

 		case 'shiftCheckOut':

 		if(isset($_POST['shiftUserId']))
 		{
 			$url = URL."ShiftUsers/checkOut/".$_POST['shiftUserId'].".json";
 			$response = \Httpful\Request::get($url)->send();

 			if($response->body->output->status == 1)
 			{
 				// echo json_encode(1);
 				$url = URL."ShiftUsers/getRunningShifts/".$_POST['userId'].".json";
			    $response = \Httpful\Request::get($url)->send();
			    $response = $response->body->runningShift;

                if(isset($response) && !empty($response))
                {
                    if(isset($response->runningShift) && !empty($response->runningShift))
                    {
                        $runningShift = $response->runningShift;
                    }

                    if(isset($response->nextShift) && !empty($response->nextShift))
                    {
                        $upcommingShift = $response->nextShift;
                    }
                    if(isset($runningShift) && !empty($runningShift))
                    {
                        $time1 = new DateTime(date('H:i:s'));
                                $time2 = new DateTime($runningShift->Shift->endtime);
                                $interval = $time1->diff($time2);

                                if($interval->h > '0')
                                {
                                   $timeLeft = $interval->h.' hr '.$interval->i.' min left'; 
                                }
                                elseif($interval->i > '0')
                                {
                                    $timeLeft = $interval->i.' min left'; 
                                }
                                else
                                {
                                    $timeLeft = $interval->s.' sec left';
                                }

                            $data='<div class="md-checkbox has-success">
                                    <input type="checkbox" id="checkbox9" class="md-check shiftCheckIn">
                                    <label for="checkbox9">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box" id="'.$runningShift->ShiftUser->id.'"></span>'.
                                    $runningShift->Shift->title.", ".$runningShift->Board->title.'</label><br/>
                                    <span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;padding-left: 30px;">'.hisToTime($runningShift->Shift->starttime)." to ".hisToTime($runningShift->Shift->endtime).'</span>
                                    <br/><span class="caption-helper blue" style="color: rgb(13, 155, 20);font-size: 11px;padding-left: 30px;">'.$timeLeft.'</span></div>';
                    }
                    else
                    {
                        $data = "No shifts now.";
                    }

                            if(isset($upcommingShift) && !empty($upcommingShift))
                            {

                                $nextData = '<span class="box" id="'.$upcommingShift->ShiftUser->id.'"></span>'.
                                    $upcommingShift->Shift->title.", ".$upcommingShift->Board->title.'<br/>
                                            <span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;">'.ymdtofjy($upcommingShift->ShiftUser->shift_date).'</span>
                                            <div class="clear"></div>
                                            <span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;">'.hisToTime($upcommingShift->Shift->starttime)." to ".hisToTime($upcommingShift->Shift->endtime).'</span>';
                            }
                            else
                            {
                                $nextData = 'No upcoming Shift.';
                            }

                                                                            

                                echo json_encode(['now'=>$data, 'next'=>$nextData]);
                    
                }
                else
                {
                    echo json_encode(['now'=>"No shifts now.", 'next'=>"No upcoming Shift."]);
                }
            }
 			else
 			{
 				echo json_encode('0');
 			}
 		}
 		break;

 		case 'getCountryCity':
 			if (isset($_POST['countryID'])) {
                //print_r($_POST);
 				$url = URL."Cities/cityList/".$_POST['countryID'].".json";
 				$response = \Httpful\Request::get($url)->send();
               // print_r($response);
 				if($response->body->output->status == 1)
	 			{
	 				//print_r();
	 				echo json_encode($response->body->cities);
	 			}
	 			else
	 			{
	 				echo "0";
	 			}
	 			}
 			break;


 			  // Ashok Neupane      
        case 'responseShiftReq':
            if(isset($_POST['shiftId']) && isset($_POST['type'])){
                    $_POST['data']['ShiftUser']['id']=$_POST['shiftId'];
                    $_POST['data']['ShiftUser']['status']=$_POST['type'];
                    $url9= URL."ShiftUsers/responseRequests.json";
                    $response9 = \Httpful\Request::post($url9)
                        ->sendsJson()
                        ->body($_POST['data'])
                        ->send();
                        
                if($response9->body->message == '1'){
                    echo '1';
                }else{
                    echo '0';
                }
            }
        break;

        case 'userAssignShift':
           if (isset($_POST['shiftUserid'])) {
           // print_r($_POST);
           // die();
            $url = URL."ShiftUsers/shiftUserStatus/".$_POST['shiftUserid'].".json";
            $response = \Httpful\Request::get($url)->send();
            if ($response->body->output == '1') {
                echo '1';
            }
            else{
                echo '0';
            }
           }
            break;


        case 'getShiftPlan':
            if(isset($_POST['shiftplanId'])){
                $url=URL."Shiftplans/getAPlan/".$_POST['shiftplanId'].".json";
                $response = \Httpful\Request::get($url)->send();
                echo json_encode($response->body);
            }


            break;
        // Manohar

        case 'editChecklist':
            if(isset($_POST['shiftId']))    
            {
                $url = URL."Shiftchecklists/viewCheckList/".$_POST['shiftId'].".json";
                $response = \Httpful\Request::post($url)
                        ->send();

                        echo json_encode($response->body);
            }


            break;

            // Manohar
            
            case 'getAvailableUser':
                $url = URL."Useravailabilities/listAllAvailableUser/".$_POST['shiftId']."/".$_POST['boardId']."/".$_POST["shift_date"].".json";                
                $response = \Httpful\Request::get($url)
                ->send();

                echo json_encode($response->body);
	           // end

                break;
	default:
		# code...
		break;
}

?>