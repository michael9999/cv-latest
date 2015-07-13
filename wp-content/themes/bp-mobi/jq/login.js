jQuery("document").ready(function(){
								  
	jQuery("#nav a").attr("data-role","button");
	jQuery("#nav a").attr("data-theme","b");
	//jQuery("#nav a").attr("rel","external");
	jQuery("#backtoblog a").attr("data-role","button");
	jQuery("#backtoblog a").attr("data-theme","b");
	//jQuery("#backtoblog a").attr("rel","external");
	jQuery(".forgetmenot input").attr("data-role","none");
	//jQuery(".submit a").attr("rel","external");
	
	jQuery("a").each(function(){
							  
		jQuery(this).attr("rel","external");
		
	});
	
		
	jQuery("form").each(function(){
							  
		jQuery(this).attr("data-ajax","false");
		
	});
	
	jQuery(".header").show();
								  
});