<?php


$boardId = $_GET['board_id'];

$url = URL."Boards/viewBoard/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;





?>

    <div class="tableHeader">
        <a href="<?php echo URL_VIEW . 'boards/editBoard?org_id=' . $orgId.'&board_id='.$boardId; ?>"><button class="addBtn">Edit Board</button></a>

    

<div class="branchDetails">
	<table width="100%">
		<tr>
        	<th>Board Name</th>
            <td>: <?php echo $board->Board->title;?></td>
        </tr>
        
        <tr>
        	<th>Branch Name</th>
            <td>: <?php echo $board->Branch->title;?></td>
        </tr>
        
        <tr>
        	<th>Branch Manager</th>
            <td>: <?php echo $board->User->fname.' '.$board->User->lname;?></td>
        </tr> 
        
        <tr>
        	<th>Shifts in Board</th>
           <td>: 
                    <?php $j = 0; 
                    foreach($board->ShiftBoard as $shift):
                        echo ($j != 0)?', ':'';
                        echo $shift->Shift->title;
                    $j++;
                    endforeach;?>
                    
                </td>
        </tr> 

    </table>
</div>