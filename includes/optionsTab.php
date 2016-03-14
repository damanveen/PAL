<div id="optionsTab">
	<div id ="scroll">
	<div class="tabs" id="tab1">		
		
		<a href="/PAL/index.php"> 
			Home
		</a>	
		
	</div>
	
	<div class="tabs" id="tab2">
		
		<a href="/PAL/searchPage.php"> 
			Search
		</a>
		
	</div>
	
	
		<?php 
		
		if(userAllowedAccess($sso_pdo, "sso_admin") ) { ?>
	
	
	<div class="tabs" id="tab3">
		
		<a href="/PAL/advancedSearch.php"> 
			Advanced Search
		</a>
		
	</div>	
	
	<div class="tabs" id="tab6">
		
		<a href="/PAL/editReport.php"> 
			Edit Report
		</a>
		
	</div>	
	
	<div class="tabs" id="tab7">
		
		<a href="/PAL/editSite.php"> 
			Edit Site
		</a>
		
	</div>	
	
	<div class="tabs" id="tab8">
		
		<a href="/PAL/export.php"> 
			Export/Import
		</a>
		
	</div>	
	
	<?php } ?>
	
	<div class="tabs" id="tab4">
		
		<a href="/PAL/allClasses.php"> 
			My Classes
		</a>
		
	</div>	
	
	<div class="tabs" id="tab5">
		
		<a href="/sso/logout.php?t=/PAL/"> 
			Logout
		</a>
		
	</div>	
	
	<div class="tabs" id="tab12">
		
		<a href="/sso/logout.php?t=/PAL/"> 
			Logout
		</a>
		
	</div>
	
	</div>
	
</div>
