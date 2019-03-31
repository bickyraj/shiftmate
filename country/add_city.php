<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add City</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[MultiplyPaymentFactor][organization_id]" value="<?php echo $orgId;?>">
<input type="hidden" name="data[MultiplyPaymentFactor][status]" value="1">
	<table cellpadding="5px">
    	<tr>
    	<th>Country</th>
        <td><select name="data[country][country_id]">
        		<option value="0">All</option>
               <?php foreach($countrys as $country):?>
                <option value="<?php echo $country->id;?>"><?php echo $country->name;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
     <tr>
    	<th>City Name</th>
        <td><input type="text" name="data[city][name]" required /></td>
    </tr>	
    <tr>
    	<td colspan="2">
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>