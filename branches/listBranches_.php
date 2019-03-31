<?php
$orgId = $_GET['org_id'];

//$page = $_GET['page'];
if(isset($_GET['page'])){
    $page = "page:".$_GET['page'];
}else{
    $page = '';
}

//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;


//Get list of Branches
$url = URL."Branches/listBranches/".$orgId."/".$page.".json";
$brancheList = \Httpful\Request::get($url)->send();
//print_r($brancheList);
$branches = $brancheList->body->branches;
 // echo "<pre>";
// print_r($brancheList);

$totalPage = $brancheList->body->output->pageCount;
$currentPage = $brancheList->body->output->currentPage;
?>

<script type="text/javascript">

 $(document).ready(function()
    {
        $("#bulkBtn").click(function()
            {
                confirm('Are you sure you want to delete?');
            });
    });
</script>

<script type="text/javascript">
    
    $(document).ready(function()
        {
           var table = document.getElementById('myTable').tBodies[0];

           var n = table.rows.length;

           var celln = table.rows[0].cells.length;

           var i, j;

           var cindex = findcindex();

            $("#myTable td:nth-child("+cindex+")").css({'text-transform':'lowercase'});

           // alert(cindex);

            function findcindex()
            {
               for(j=0; j<=celln; j++)
                {
                    var email = table.rows[0].cells[j].innerHTML;

                    if(email == 'Email')
                    {
                        cindex = table.rows[0].cells[j].cellIndex;

                        cindex = cindex + 1;

                        // $("#myTable td:nth-child("+cindex+")").css({'text-transform':'lowercase'});

                        return cindex;
                    }
                }
            }
                
        });
</script>

<!-- Save Success Notification -->
<script type="text/javascript">
    $(document).ready(function()
        {
            var top_an = $("#save_success").css('top');
            $("#save_success").css('top','0px');

            <?php if(isset($_SESSION['success'])):?>
                $("#save_success").show().animate({top:top_an});
                <?php unset($_SESSION['success']);?>
                setTimeout(function()
                    {
                        $("#save_success").fadeOut();
                    }, 3000);
            <?php endif;?>
        });
</script>
<!-- End of Save Success Notification -->

<!-- Success Div -->
<div id="save_success">Saved Successfully !!</div>
<!-- End of Success Div -->

<!-- tableHeader -->
			<div class="tableHeader">
				<div class="blueHeader">
                    <div class="table-heading">Branch List</div>
					<!--<ul class="subNav subNav_left">
						<li><a href="">Menu1</a></li>
						<li><a href="">Menu2</a></li>
						<li><a href="">Menu3</a></li>
						<li><a href="">Menu4</a></li>
					</ul>-->
                   <a href="<?php echo URL_VIEW . 'branches/createBranches?org_id=' . $orgId.'&user_id='.$userId; ?>"><button class="addBtn">Add New</button></a>
				</div>
<div class="clear"></div>
<!-- Table -->
	<table id="myTable" class="table_list" width="98%;" align="center">
					<!-- <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
						<th><p>SN</p></th>
						<th><p>Branch Name</p></th>
                        <th><p>Organization</p></th>
                        <th><p>Email</p></th>
                        <th><p>Address</p></th>
                        <th><p>City</p></th>
                        <th><p>Country</p></th>
                        <th><p>Action</p></th>
					</tr> -->

                    <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
                        <th>SN</th>
                        <th>Branch Name</th>
                        <th>Organization</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>

			<?php $i = 1;?>
            <?php foreach($branches as $branch):?>
                    <tr class="list_users">
                    	<td><?php echo $i++;?><input class="listShift-checkbox" type="checkbox" name="<?php echo $branch->Branch->id;?>"/></td>
                        <td><a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>"><?php echo $branch->Branch->title;?></a></td>
                        <td><?php echo $branch->Organization->title;?></td>
                        <td><?php echo $branch->Branch->email;?></td>
                        <td><?php echo $branch->Branch->address;?></td>
                        <td><?php echo $branch->City->title;?></td>
                        <td><?php echo $branch->Country->title;?></td>
                        <td class="action_td">
                        	<ul class="action_btn">
                            	<li><div class="hover_action"></div>
                            		<a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>"><button 
                            	 		class="view_img"></button>
                            		</a>
                            	</li>


                                <li>
                                	<div class="hover_action"></div>
                                	<a href="editBranch?branch_id=<?php echo $branch->Branch->id.'&org_id='.$orgId;?>"><button class="edit_img"></button>
                                	</a>
                                </li>


			                            <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
											<input type="hidden" name="_method" value="POST"/>
										</form>


                                <li>
                                	<div class="hover_action"></div>
                                	<a href="#" onclick="if (confirm(&quot;Are you sure you want to delete # 1?&quot;)) 
    	  								{ 
											document.post_5476f94dde83b126092591.submit(); 
										} 
										event.returnValue = false; return false;"><button class="delete_img"></button>
									</a>
								</li>
								
                            </ul>
                        </td>
                    </tr>
             <?php endforeach;?>
				</table>
                <!-- Bulk Action -->
                <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div>
                <!-- End of Bulk Action -->


<?php 
if($totalPage >1){
    $previousPage = $currentPage-1;
    $nextPage = $currentPage+1;
    ?>
<div class="paginator">
            <ul>
                <li>
                     <?php if($currentPage == 1){?>
                    <div class="deactive"><</div>
                    <?php }else{?>
                    <a class="no-underline" href="<?php echo URL_VIEW . 'branches/listBranches?org_id=' . $orgId.'&page='.$previousPage; ?>"><</a></li>
                    <?php }?>
                        <?php  for($i=1; $i<=$totalPage; $i++){?>
                    <li><a class="<?php echo ($currentPage==$i)? 'active':'';?>" href="<?php echo URL_VIEW . 'branches/listBranches?org_id=' . $orgId.'&page='.$i; ?>"><?php echo $i;?></a></li>
                 <?php  }?>
                <li>
                    <?php if($totalPage == $currentPage){?>
                    <div class="deactive">></div>
                    <?php }else{?>
                    <a class="no-underline" href="<?php echo URL_VIEW . 'branches/listBranches?org_id=' . $orgId.'&page='.$nextPage; ?>">></a></li>
                    <?php }?>
            </ul>
        </div>
<?php }
     ?>




<!-- End of Table -->


<!--  <table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th>S.No</th>
			<th>Branch Name</th>
                        <th>Organization</th>
			<th>Email</th>
			<th>Address</th>
			<th>Country</th>
			<th>City</th>
			<th class="actions">Actions</th>
	</tr>
	</thead>
	<tbody>
             <?php $i = 1;?>
            <?php foreach($branches as $branche):?>
           
		<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $branche->Branch->title;?></td>
		<td><?php echo $branche->Organization->title;?></td>
		<td><?php echo $branche->Branch->email;?></td>
                <td><?php echo $branche->Branch->address;?></td>
		<td><?php echo $branche->Country->title;?></td>
		<td><?php echo $branche->City->title;?></td>
		<td>9999999999&nbsp;</td>
		
		<td class="actions">
			<a href="orgView.php?branch_id=<?php echo $branche->Branch->id;?>">View</a>
                        <a href="orgEdit.php?branch_id=<?php echo $branche->Branch->id;?>">Edit</a>
    

    <form action="/newshiftmate/Organizations/delete/1" 

    	  name="post_5476f94dde83b126092591" 

    	  id="post_5476f94dde83b126092591" style="display:none;" method="post">

    	  <input type="hidden" name="_method" value="POST"/></form>

    	  <a href="#" 

    	  onclick="

    	  if (confirm(&quot;Are you sure you want to delete # 1?&quot;)) 
    	  		{ 

    	  			document.post_5476f94dde83b126092591.submit(); 

    	  		} event.returnValue = false; return false;">Delete</a>		</td>
	</tr>
        <?php endforeach;?>
	
	</tbody>
	</table> -->