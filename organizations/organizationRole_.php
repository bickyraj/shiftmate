<?php
$orgId = $_GET['org_id'];
$listRole = '';
$url_paymentFactor = URL . "Organizationroles/organizationRoleList/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactor)->send();
$listRole = $data->body->orgRoleList;
// echo "<pre>";
// print_r($listRole);
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
        <div class="table-heading">Roles List</div>
            
        <a href="<?php echo URL_VIEW . 'organizations/addroles'; ?>?org_id=<?php echo $orgId ?>"><button class="addBtn">Add Roles</button></a>
    </div>
    <div class="clear"></div>
     

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Role Name</p></th>
            <th><p>Action</p></th>
		</tr>
        <?php if(isset($listRole) && !empty($listRole)){
			if(count($listRole) > 0){
			$sno = 1;
				foreach($listRole as $listRoles){
					
			?>
        <tr style="height:40px;">
        	<td><?php echo $sno++;?></td>
            <td><?php echo $listRoles; ?></td>
            <td><button class="delete_img"></button></td>
         <?php 
			}}}
			 else{
				?>
                <tr style="height:40px;">
                <td colspan="4"><h4>No records found</h4></td>
                </tr>
                <?php
				}
		?>
		
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