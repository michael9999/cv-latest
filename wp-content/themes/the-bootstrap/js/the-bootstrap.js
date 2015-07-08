jQuery(function($){
	$( 'table' ).addClass( 'table table-striped table-hover' );
	$( '#submit' ).addClass( 'btn btn-primary btn-large' );
	$( '#wp-calendar' ).addClass( 'table table-striped table-bordered' );
	
	// Bootstrap plugins
	$( '#content [rel="tooltip"]' ).tooltip();
	$( '#content [rel="popover"]' ).popover();
	$( '.alert' ).alert();
	$( '.carousel-inner figure:first-child' ).addClass( 'active' );
	$( '.carousel' ).carousel();
	
// ****************************** MY CHANGES *****************************

// Upload buttons on Paypal form

$('p.hide').not(':eq(0)').hide();

    $('a.add_file').on('click', function(e){
      //show by click the first one from hidden inputs
      $('p.hide:not(:visible):first').show('slow');
      e.preventDefault();
    });

//functionality for del-file link

    $('a.del_file').on('click', function(e){
      //var init
      var input_parent = $(this).parent();
      var input_wrap = input_parent.find('span');
      //reset field value
      input_wrap.html(input_wrap.html());
      //hide by click
      input_parent.hide('slow');
      e.preventDefault();
      
    });


 // show-hide paypal form
 
 $('#pp-show-hide').on('click', function(e){
      
      e.preventDefault();
      $('#pp-holder').toggle("slow");
      $( "#test-name" ).focus();
      
      
    }); 

// scroll down page

function scrollToAnchor(aid){
    var aTag = $("a[name='"+ aid +"']");
    $('html,body').animate({scrollTop: aTag.offset().top},'slow');
}


function myTrial(){
    
    alert("function called from cf7 jquery");
    
    
}


// end my changes
	
});