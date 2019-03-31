<?php
$orgId = $_GET['org_id'];
$url_holiday = URL . "Organizationfunctions/listFunctionForOrganization/".$orgId. ".json";
$data = \Httpful\Request::get($url_holiday)->send();
$holidays = $data->body->functions;
//echo "<pre>";
//print_r($holidays);
?>


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


<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Holiday List</div>
        <a href="<?php echo URL_VIEW . 'organizationfunctions/addHoliday'; ?>"><button class="addBtn">Add Holiday</button></a>
    </div>
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Branch Name</p></th>
            <th><p>Name</p></th>
            <th><p>Date</p></th>
            <th><p>Action</p></th>
		</tr>
		<?php
			if(isset($holidays) && !empty($holidays)){
				$sno = 1;
				foreach($holidays as $holiday){
		?>
        <tr style="height:40px;">
        	<td><?php echo $sno; $sno++ ;?><input class="listShift-checkbox" type="checkbox"/></td>
            <td><?php echo $holiday->Branch->title;?></td>
            <td><?php echo $holiday->Organizationfunction->note;?></td>
            <td><?php echo $holiday->Organizationfunction->function_date;?></td>
            <td><button class="delete_img"></button></td>
        
      	<?php }}else{ ?>
        	
        <?php }?>
        </table>
    <!-- End of Table -->

    <!-- Bulk Action -->
                <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div>
                <!-- End of Bulk Action -->