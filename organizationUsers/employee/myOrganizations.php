<?php
$url = URL . "OrganizationUsers/myOrganizations/" . $user_id . ".json";
$data = \Httpful\Request::get($url)->send();
$myOrganizations = $data->body->myOrganizations;
?>

<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>My Organisations <small>View my organisation</small></h1>
		</div>  
     </div>
     </div>
     <div class="page-content">
        <div class="container">
            <ul class="page-breadcrumb breadcrumb">
                <li>
					<i class="fa fa-home"></i>
					<a href="<?=URL_VIEW;?>">Home</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="<?=URL_VIEW."organizationUsers/employee/myOrganizations";?>">My Organisations</a>
				</li>
            </ul>   
                      
<?php //echo "<pre>";print_r($myOrganizations);?>              
<div class="row">

<?php if(isset($myOrganizations) && !empty($myOrganizations)):?>
<?php foreach($myOrganizations as $myOrganization){?>
	<div class="col-md-6 col-sm-12">
        <div class="portlet green box ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Organisation
                </div>
                <!--<div class="actions">
                    <a href="javascript:;" class="btn btn-default btn-sm">
                    <i class="fa fa-pencil"></i> Edit </a>
                </div>-->
            </div>
            <div class="portlet-body">
            <div class="scroller" style="min-height:200px;max-height:400px;">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Organisation Name:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->title;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->email;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         State:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->address;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone Number:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->phone;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Fax:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->fax;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Website:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->website;?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="portlet green box ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Branch
                </div>
                <div class="actions">
                    <a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>" class="btn btn-default btn-sm">
                    <i class="fa fa-eye"></i> View detail </a>
                </div>
            </div>
            <div class="portlet-body">
            <div class="scroller" style="min-height:200px;max-height:400px;">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Branch Name:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Branch->title;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Branch->email;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         State:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Branch->City->title;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone Number:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Branch->phone;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Fax:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Branch->fax;?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Website:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $myOrganization->Organization->website;?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php else:?>
    <div>No organisations.</div>
<?php endif;?> 
    
</div>
</div>

<?php /*?><h1>My Organizations</h1>
<table class="table_list" width="98%;" align="center">
    <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
    	<th>SN</th>
        <th>Organization Name</th>
        <th>Branch Name</th>
        <th>Organization Role</th>
        <th>Action</th>
	</tr>
    <?php
		$count = 1;
	 foreach($myOrganizations as $myOrganization){?>   
    <tr class="list_users">
    	<td><?php echo $count;?></td>
        <td><a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><?php echo $myOrganization->Organization->title;?></a></td>
        <td><?php echo $myOrganization->Branch->title;?></td>
        <td><?php echo $myOrganization->OrganizationUser->designation;?></td>
        <td class="action_td">
                    <ul class="action_btn">
                        <li><div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><button 
                                    class="view_img"></button>
                            </a>
                        </li>
                    </ul>
        </td>
    <?php $count++; } ?>
</table><?php */?>