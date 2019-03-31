<?php
$orgId = $_GET['org_id'];

$url_paymentFactor = URL . "MultiplyPaymentFactors/listPaymentFactors/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactor)->send();
$listPaymentFactors = $data->body->listPaymentFactors;
//echo "<pre>";
//print_r($listPaymentFactors);
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
            
        <a href="<?php echo URL_VIEW . 'paymentRates/addPaymentFactor'; ?>"><button class="addBtn">Add Payment Factor</button></a>
    </div>
    <div class="clear"></div>
     <div class="submenu">
<ul>
	<li><a style="color:#000;" href="<?php echo URL_VIEW . 'paymentRates/listPaymentFactorType?org_id=' . $orgId; ?>">Payment Factor Type</a></li>
    
</ul>
</div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Branch Name</p></th>
            <th><p>Payment Factor Type</p></th>
            <th><p>Multiply Factor</p></th>
            <th><p>Implement Date</p></th>
            <th><p>Expire Date</p></th>
            <th><p>Action</p></th>
		</tr>
        <?php if(isset($listPaymentFactors) && !empty($listPaymentFactors)){
			$sno = 1;
				foreach($listPaymentFactors as $listPaymentFactor){
			?>
        <tr style="height:40px;">
        	<td><?php echo $sno++;?></td>
            <td><?php echo $listPaymentFactor->Branch->title;?></td>
            <td><?php echo $listPaymentFactor->Multiplypaymentfactortype->title ;?></td>    
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->multiply_factor ;?></td>
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->implement_date ;?></td>
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->end_date ;?></td>
            <td><button class="delete_img"></button></td>
         <?php 
			}}
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