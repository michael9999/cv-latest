/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){

// live click event for form

jQuery('#support-form-button').live('click', function(event){

// prevent default form send
//alert("submit button clicked1");
event.preventDefault();


//alert("submit button clicked2");// get form values

var support_user = jQuery("#support_user").val();
var support_email = jQuery("#support_email").val();
var support_issue = jQuery("#support_issue").val();
var support_customer_type = jQuery("#support_customer_type").val();
var support_description = jQuery("#support_description").val();

// set some trial values just to get this working

support_issue = "trial";
support_customer_type = "normal";


//alert("after definition of variables");
// call function
sendValidation(support_user, support_email, support_issue, support_customer_type, support_description);

//alert("after function call");

});

// -------------------------------- Show new form

jQuery('#new-form').live('click', function(event){

// prevent default form send
//alert("submit button clicked1");
event.preventDefault();

var support_customer_type = jQuery("#support-form-current-type").attr('class');
var support_email = jQuery("#support-form-current-email").attr('class');
var support_user = jQuery("#support-form-current-user").attr('class');

// INSERT NEW FORM

getForm(support_customer_type, support_email, support_user);
//jQuery(".link_table").css({'border': '0px'});

// INSERT REAL FORM

//jQuery("#support-form-holder").html("<form><div class='fld_rw'><div class='fLt fld_lbl'><label for='txtUserName'>Name:</label></div><div class='fLt'><input id='support_user' class='textfield required missing' type='text' title='Please enter your user name.' tabindex='1' size='50' maxlength='50' test='0' available='0'><div class='bodyTextSmall'></div></div></div><div class='fld_rw'><div class='fLt fld_lbl'><label for='txtUserName'>Email:</label></div><div class='fLt'><input class='textfield required missing' id='support_email' type='text' title='Please enter your email address.' tabindex='1' size='20' maxlength='50' test='0' available='0'><div class='bodyTextSmall'></div></div></div><div class='fld_rw'><div class='fLt fld_lbl'><label for='txtUserName'>Subject:</label></div><div class='fLt'><input class='textfield required missing' type='text' id='support_issue' title='Please enter a subject.' tabindex='1' size='20' maxlength='50' test='0' available='0'><div class='bodyTextSmall'></div></div></div><div class='fld_rw'><div class='fLt fld_lbl'><label for='txtUserName'>Client:</label></div><div class='fLt'><input class='textfield required missing' id='support_customer_type' type='text' tabindex='1' size='20' maxlength='50' test='0' available='0'><div class='bodyTextSmall'></div></div></div><div class='fld_rw'><div class='fLt fld_lbl'><label for='txtUserName'>Description:</label></div><div class='fLt'><textarea cols='40' class='textfield required missing' id='support_description' rows='10' type='text' title='Please enter a description here.' tabindex='1' size='20' maxlength='50' test='0' available='0'></textarea><div class='bodyTextSmall'></div></div></div><input id='support-form-button' class='support-form-field' name='submit' type='submit' value='submit' /></form>");




})
// function definition

//--------------------------- GET FORM ----------------------------------




function sendValidation(support_user, support_email, support_issue, support_customer_type, support_description){

//alert("before post");
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/process-support-form.php", {user : support_user, email : support_email, issue : support_issue, customer_type : support_customer_type, description : support_description}, function(data){
       if (data.length>0){
         
         jQuery("#support-form-holder").empty();


jQuery("#support-form-holder").html(data).trigger( "create" );

         jQuery('.link-zendesk').css({'color' : '#3B5998', 'font-weight' : 'bolder'});


// if error text is present, change css to red
if ( jQuery("#error-message").length ) {
    jQuery('#error-message').css({'color' : 'red', 'font-weight' : 'bolder'});
// make borders red
    
  //jQuery('#support-form').filter(':input').css('border-color', 'red');
//jQuery("#support_email").css('border-color', 'red');
 // jQuery(".link_table").css({'border': '0px'});

}


       }
      })
    };

//---------------------------------- NEW FUNCTION TO RETURN A NEW FORM ---------------------------------

function getForm(support_customer_type, support_email, support_user){


    // GET INFO
    //var tick_value = tick_value;
    var type = "new-form";



//var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/get-form.php", {customer_type : support_customer_type, type1 : type, user : support_user, email : support_email}, function(data){
       if (data.length>0){
         //alert("DATA RETURNED, ok to hereE");
         //$("#search_results").html(data);
         jQuery("#support-form-holder").empty();

//$("#search_results").html(data);
         jQuery("#support-form-holder").html(data);

         jQuery('.link-zendesk').css({'color' : '#3B5998', 'font-weight' : 'bolder'});

// if error text is present, change css to red
if ( jQuery("#error-message").length ) {
    jQuery('#error-message').css({'color' : 'red', 'font-weight' : 'bolder'});
// make borders red

  //jQuery('#support-form').filter(':input').css('border-color', 'red');
//jQuery("#support_email").css('border-color', 'red');
 // jQuery(".link_table").css({'border': '0px'});

}


       }
      })
    };


//---------------------------------- END, NEW FUNCTION -------------------------------------------------


});