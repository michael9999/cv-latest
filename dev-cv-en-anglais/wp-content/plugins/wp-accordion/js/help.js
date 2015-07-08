jQuery(document).ready(function(){

// ------------------ CHECK WHICH PANES SHOULD BE OPEN



// ------------------ END PANES

    formerOpen = '';
    mode = jQuery('#mode').val();
    jQuery('.accWidget > li > h2').each(function(){
        jQuery(this).siblings().wrap('<div class="accordion_content"></div>')       
    })
    .click(function(event){

//alert("test from within help.js" + jQuery(this).event); 
var id = jQuery(this).attr('class');
var id2 = jQuery(this).parent().attr('id');

//alert("test " + id + " parent id " + id2);
	
        if(mode == 'all'){
            if(jQuery(this).hasClass('on')){
                jQuery(this).addClass('off').removeClass('on');
                jQuery(this).siblings('div').hide('slow');    
            }
            else{

		// pane is being opened

                jQuery(this).addClass('on').removeClass('off');
	
// means there is no fade in when pane opens

	jQuery(this).next().attr('style', 'display: block');

//jQuery("#"+mobVarTest+" div:first").attr('style', 'display: block');                
//jQuery(this).siblings('div').show('slow');
		
		// my insert

		//var id2 = jQuery(this).parent().attr('id');
		// to cookie function 

		//testCookie(id2);		

		// end my insert    

            }
        }
        else{
            if(jQuery(this).hasClass('on')){
                jQuery(this).addClass('off').removeClass('on');
                //jQuery(this).siblings('div').hide('slow');    
//alert("1");
jQuery(this).next().attr('style', 'display: none');        

	    }
            else{
       // alert("2");
	        jQuery(this).addClass('on').removeClass('off');
                jQuery(this).siblings('div').show('slow');    
            }
            if(formerOpen && formerOpen.html() != jQuery(this).html()){
                
//alert("3");
                formerOpen.addClass('off').removeClass('on'); 
                formerOpen.siblings('div').hide('slow');
            }    
        }
        formerOpen = jQuery(this);
        
    })
    jQuery('.accordion_content').hide();
    jQuery('.accWidget').css({
        display: 'block'
    });
    
    def = jQuery('#default').val(); 
    if(def == 'one'){
        jQuery('.accWidget > li').each(function(x){
            if(!x){  

//alert("4");
                jQuery(this).find('h2').addClass('on');
                jQuery(this).find('div').show(); 
                if(mode == 'one'){
                    formerOpen = jQuery(this).find('h2');
    
                }
            }
            
        })        
    }


})