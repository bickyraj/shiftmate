<!-- BEGIN HORIZANTAL MENU -->
		<!-- DOC: Remove "hor-menu-light" class to have a horizontal menu with theme background instead of white background -->
		<!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) in the responsive menu below along with sidebar menu. So the horizontal menu has 2 seperate versions -->
<?php
if($user_type == 'user' && @$branch_id > 0 && @$orgId > 0){
		include('user_organization_sub_menu.php');
		
	}
	if($user_type == 'organization' && @$board_id > 0){
		include('organization_organization_sub_menu.php');
	}

?>


		
		<!-- END HORIZANTAL MENU -->
		<!-- BEGIN HEADER SEARCH BOX -->
		<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
		<!--<form class="search-form" action="extra_search.html" method="GET">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search..." name="query">
				<span class="input-group-btn">
				<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
				</span>
			</div>
		</form>-->
		<!-- END HEADER SEARCH BOX -->