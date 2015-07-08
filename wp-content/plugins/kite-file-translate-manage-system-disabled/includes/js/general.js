var jQ=jQuery.noConflict();
jQ(document).ready( function(event) {
    
	// Put your JS in here, and it will run after the DOM has loaded.
        jQ("#drp_translator option").click(function(event){
            
                var ajaxAction=jQ(this).attr('href');
                //alert(ajaxAction);
             jQuery.post( ajaxurl, {
                    action: 'my_example_action',
                    current_action:ajaxAction,
                    dataType: 'json',
                    'cookie': encodeURIComponent(document.cookie),
                    'parameter_1': 'some_value'
             },
             function(data) {
                  //  alert(data);
                    jQ('.picture-gallery').html(data);
             });
            event.preventDefault();
          })
      

});