/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){




// ----------------- end trial click event on panes

// Get rid of border on Notes and links

jQuery(".link_table").css({'border': '0px'});



    /* -------------------- getNs is a test ajax request ---------------------------*/

// Trial link #php-page

jQuery('#php-page').live('click', function(event){

 var $et = $( event.target );


jQuery('#questions_trial22 > span').live('click', function(event){
    //var t = jQuery(event.target);
//alert("click event applied to #landing-page-data")

    var tick_value = jQuery(event.target).attr('checked');
    var id_quest = jQuery(event.target).attr('id');

    if(tick_value == true){

    //alert ("value2 is TRUE");
    tick_value = "checked";
    //alert (tick_value);
    }
    else {

    tick_value = "no";
    //alert (tick_value);

    }
    // udpate ns_questions based on

    updateNQuestions(user, id_quest, tick_value);

        })




// end trial
});

// End trial #php-page

//force page refresh




//--------------- Get current page's accordion section -------------

var qsParm = new Array();
function qs(){
var query = window.location.search.substring(1);
var parms = query.split('&');
for (var i=0; i<parms.length; i++) {
var pos = parms[i].indexOf('=');
if (pos > 0) {
var key = parms[i].substring(0,pos);
var val = parms[i].substring(pos+1);
qsParm[key] = val;
}
}
}

//-------------------- add Accordion section to variable -----------------

qsParm['id'] = null;
qs();

var test1 = qsParm['id'];

var all = "'#execphp-" + test1 + " h2:first'";

// ------------------------ test value of variable ----------------

//alert("this is accordion section " + all);


// ---- make particular pane open when page loads --- //

//jQuery('#execphp-4 h2:first').click(function() {
     //alert(qsParm['id']);
  // });

 //jQuery('#execphp-7 h2:first').click();

jQuery("#execphp-"+test1+" h2:first").click();

//jQuery( "#execphp-7 h2:first" ).addClass("widgettitle on");
//jQuery( "#execphp-7 div.accordion_content" ).attr('display', 'block');

//$('#greatphoto').attr('alt', 'Beijing Brush Seller');
    /* -------------------- BUILD ACCORDION ---------------------------*/

//------------------------- Mimick click on accordion pane ------------




// ----------------------- end mimick trial

/* eq carries pane number to open */

    jQuery(".accordion2 h3").eq(2).addClass("active");
        //jQuery(".accordion2 p").eq(2).show();

        jQuery(".accordion2 h3").click(function(){

    //alert("function click started");*/

            jQuery(this).next("p").slideToggle("fast")
            .siblings("p:visible").slideUp("fast");
            jQuery(this).toggleClass("active");
            jQuery(this).siblings("h3").removeClass("active");


      });

    // end of ACCORDION

    /* -------------------- GET DATA  ---------------------------*/

   
    getUcas(user);
 /*alert("start2");
	getBeforeLeaving(user);
	 alert("start3");
    getSquestions(user);
	 alert("start4");
    getEnglish(user);*/
    
    /*
    
    */

//alert("end of method run");
//jQuery(".link_table").css("border","1px solid #B6B6B5");

//jQuery(".link_table").css("border","1px solid red");
    /* -------------------- END, LIST OF UNIVERSITIES ---------------------------*/

// ----------------------------------- UPDATE NOTE


jQuery("#update-save").live("click", function(event){

   event.preventDefault();

var id = jQuery(event.target).attr('style');

//alert("this is the ID" + id);

var content_up = jQuery("#update-content").val();
var content_name = jQuery("#name-update").val();

          updateNote(user, id, content_up, content_name);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });





// --- end update note

// -------------------------------- UPDATE LINK

jQuery("#link_submit").live("click", function(event){

   event.preventDefault();

var id = jQuery(event.target).attr('style');

//alert("this is the ID" + id);


var link_update = jQuery("#link_link").val();
var link_name = jQuery("#link_name").val();

//alert("this is the link address" + link_update);
//alert("this is the link name" + link_name);

          updateLink(user, id, link_update, link_name);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });

// ---- end update link

// --------------------------------- DELETE LINK

jQuery("body").delegate("#delete_link","click", function(event){


var id = jQuery(this).parent().attr('style');

//alert("this is the ID" + id);


var link_update = jQuery("#link_link").val();
var link_name = jQuery("#link_name").val();

//alert("this is the link address" + link_update);
//alert("this is the link name" + link_name);

          deleteLink(user, id);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });



// end delete link
// ----------------------------------- SAVE NEW NOTE

jQuery("#notes-save").live("click", function(event){

   event.preventDefault();

          addNewNote(user);

  // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });


// ---------------------------- END SAVE NEW NOTE



    /* ------------------------- ADD TEST CLICK ACTION TO TICKBOXES --------------------- */

    jQuery("#box1").live("click", function(){

          var box_val=jQuery("#box1").val()
          //alert(box_val);

        });

    jQuery("#box2").live("click", function(){

          var box_val=jQuery("#box2").val()
          //alert(box_val);

        });


    jQuery("#form_1").live("click", function(){

    var t = jQuery(event.target);

          if (t.is("input")){

          var box_val = jQuery(event.target).val();
          //alert(box_val);

            }
          //var box_val=jQuery("#box2").val()


        });

    /* ------------------------- DELETE SELECTED UNIVERSITY ------------------------- */

    jQuery("#delete").live("click", function(event){


    event.preventDefault();

        //	var value1 = $(event.target).attr('id');

    /* GET VALUE */
          //var box_val2=jQuery('#uni-list').val();

          //var box_val2=jQuery('#uni-list').attr('id');

          var box_val2=jQuery('#uni-list2 :selected').attr('id');

    /* GET TEXT VALUE */
          var box_text2=jQuery('#uni-list2 :selected').text();

          //alert("1st check: Delete requested " + box_val2 + box_text2);
          //var box_val=jQuery("#box2").val()

    // ------------------------- DELETE ENTRY -----------------------------

        deleteEntry(user);


        });




    /* ------------------------- ONCLICK EVENT FOR SELECT BOX ------------------------ */

    jQuery("#select1").change(function(){

    /* GET VALUE */
          var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#select1 :selected').text();

          //alert("Uni being added " + box_val + box_text);
          addUni(user);

        });

   /* ------------------------ NOTES, DELETE BUTTON ------------------------------- */

   jQuery("body").delegate("#delete-button","click", function(event){

          //var t = jQuery(event.target).attr('id');

         // event.preventDefault();

          //var t = jQuery(event.target).attr('href');

          var t = jQuery(this).parent().attr('style');

          //alert("ID is: " + t);

          deleteNote(user, t);

          // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });




    /* ------------------------- ONCLICK EVENT FOR SELECT BOX ------------------------ */

    jQuery("body").delegate("#notes-add","click", function(event){


//alert("try to open pane programmatically -- delegate");

//$('#showHideCollapsible').trigger('expand');

jQuery('#link-trial-app').trigger('expand');


    //event.preventDefault();
    /* GET VALUE */
          //var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          //var box_text=jQuery('#select1 :selected').text();

          //alert("Add note has been clicked");

           jQuery("#note-item").fadeOut("slow", function() {

          //jQuery("#notes-item").empty();

          // build and show form
    jQuery("#note-item").html("<td><form id='notes-item-form'><a href='#' id='back' data-role='button'>< Retour</a><br /><br>Name: <input type='text' id='title_box' value=''/><br /><br/>Note: <br /><textarea rows='5' cols='20' id='note-new'></textarea> <br /><br /><input type='submit' value='Save' id='notes-save'><br /></form></td>").trigger( "create" );;
	
	

    jQuery("#note-item").fadeIn("slow");

    // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});
        // Animation complete.
      });


          //addUni(user);

        });





    /* ------------------------- ONCLICK EVENT FOR NOTES ------------------------ */

    jQuery("#notes-item").live("click", function(){

    /* GET VALUE */
          var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#select1 :selected').text();

          //alert("Uni being added " + box_val + box_text);
          addUni(user);

       // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });


    jQuery("#notes-each").live("click", function(event){

        //var t = jQuery(event.target).attr('href');

var t = jQuery(event.target).parent().parent().attr('style');
//alert("id is: " + t);
          event.preventDefault();
    /* GET VALUE */
          var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#select1 :selected').text();

         // alert("notes button clicked");
          //alert("this is id value" + t);

          jQuery("#note-item").empty();
          //alert("Uni being added " + box_val + box_text);
          getNotesFull(user, t);

          // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });

   // ----------------------------- UPDATE LINK

   jQuery("body").delegate("#update_link","click", function(event){


// Have to change due to JQM

        //var t = jQuery(event.target).attr('class');

//var t = jQuery(event.target).parent().attr('style');

//alert("the target clicked is: " + event.target);

var t = jQuery(this).parent().attr('style');

alert(t);
          //event.preventDefault();

//alert("update started: " + t);

/* GET VALUE */
          //var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          //var box_text=jQuery('#select1 :selected').text();

         // alert("notes button clicked");
         // alert("this is id value" + t);

          //jQuery("#links-item").empty();
          //alert("Uni being added " + box_val + box_text);

          getLinkFull(user, t);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });


   //---- END UPDATE LINK
    // --------------------- LINK BACK TO FULL LIST OF NOTES


    jQuery("#back").live("click", function(event){

        //var t = jQuery(event.target).attr('href');


          event.preventDefault();
    /* GET VALUE */
          //var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          //var box_text=jQuery('#select1 :selected').text();

    jQuery("#note-item").fadeOut("slow", function() {

    jQuery("#note-item").empty();

    getNotes(user);

    jQuery("#note-item").fadeIn("slow");

    //jQuery("#notes-content").fadeIn("slow");

    //getNotes(user);

    //jQuery("#notes-content").fadeIn("slow");
// hack for table border
     
     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


      });



          //alert("back button clicked");
          //alert("this is id value"
          });

    // END ------------------------




// ----------------------------- LINKS ADD

jQuery("body").delegate("#add_link_button","click", function(event){

//alert("clicked on add link button");


//event.preventDefault();


    /* GET VALUE */

   var link_name=jQuery('#add_link_name').val();


alert(link_name);


    /* GET TEXT VALUE */

   var add_link_address=jQuery('#add_link_address').val();


alert(add_link_address);



 addLink(user, link_name, add_link_address);

 // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


      });

// end add link


//-------------------------- Back link for show link

jQuery("#link-back").live("click", function(event){

        //var t = jQuery(event.target).attr('href');


          event.preventDefault();

    /* GET VALUE */

          //var box_val=jQuery('#select1').val();


    /* GET TEXT VALUE */

          //var box_text=jQuery('#select1 :selected').text();

    jQuery("#link-item").fadeOut("slow", function() {

    //
    //jQuery("#link-item").empty();

    jQuery("#update_link_full").empty();


    getLinks(user);

    //jQuery("#notes-content").fadeIn("slow");

    //getNotes(user);

    //jQuery("#notes-content").fadeIn("slow");
// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

      });



          //alert("back button clicked");
          //alert("this is id value"
          });





// -------------- DELEGATE, for IE -------------------

// Fires when user selects a different uni to work on. 

jQuery("#test2").delegate("select", "change", function(){
      //$(this).after("<p>Another paragraph!</p>");

//    var box_val=jQuery('#uni-list2').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#uni-list2 :selected').text();

// added to allow jqm to get the correct user ID

var box_val = jQuery('#uni-list2 :selected').attr("id");

// var box_text2=jQuery('#uni-list2 :id').val(); .attr("id")

       //alert("Different uni selected " + box_val + "  " + box_text + "  " + box_text2);
          //addUni(user);
//alert("Change function started");
    // Run makeActive method

    //makeActive(user);
//alert("after makeActive function");



});









    // end event tick boxes
   
   jQuery("input[type='checkbox']").live( "change", function(event, ui) { 
  

    // ---------- AVANT DE PARTIR - FOR CLICK ON TICK BOXES ---------------------
		
//alert("non specific questions is running");
    //----------------------------- CHECK IF ELEMENT CLICKED IS JUST A BUTTON, IF SO EXIT FUNCTION (LOWER DOWN)

    //var button_type = jQuery(this).closest("a").attr("data-role");
    //alert ("this is the buttons data role" + button_type);

 	button_type="";

    //---------------------- GET TICK ID FROM CLOSEST JQM LABEL
	
    var id_quest = jQuery(this).attr("id");
    
    //---------------------- GET TICK VALUE FROM CLOSEST JQM LABEL

    var tick_value = jQuery(this).next().attr("height");


    // ---------------------- CHECK IF CLICKED ELEMENT IS A BUTTON, IF YES DO NOT RUN UPDATE FUNCTION

    if (button_type == "button"){
    
    } 
    // ---------------------- IF CLICKED ELEMENT IS A TICKBOX CHECK VALUE OF "HEIGHT" ARGUMENT, LOGIC = CHECKED = NO
    else{
    if(tick_value == "checked" ){

		tick_value = "no";
		//alert (tick_value);
		//alert (jQuery(event.target).closest("label").attr("for"));
		jQuery(this).next().attr("height", "no");
	
		// ---------------------- RUN UPDATE TICKBOX FUNCTION
	   if(jQuery(this).parents("form").attr("id")=="non_specific_questions")
			{
			updateNQuestions(user, id_quest, tick_value);
			}
		if(jQuery(this).parents("form").attr("id")=="specific_questions")
			{	
			updateSQuestions(user, id_quest, tick_value);
			}
    }
    // ---------------------- LOGIC = NO = CHECKED
    
    else {

		tick_value = "checked";
		//alert (tick_value);
		//alert (jQuery(event.target).closest("label").attr("for"));
		jQuery(this).next().attr("height", "checked");
	
		// ---------------------- RUN UPDATE TICKBOX FUNCTION
		if(jQuery(this).parents("form").attr("id")=="non_specific_questions")
			{
			updateNQuestions(user, id_quest, tick_value);
			}
		if(jQuery(this).parents("form").attr("id")=="specific_questions")
			{	
			updateSQuestions(user, id_quest, tick_value);
			}
		}
    }    

 });
    /* END TEST CLICK ACTION */

    /* GET NON SPECIFIC QUESTION DATA FROM DATABASE */

    function getNs(user){

      jQuery.post("http://http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/Show_NS_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
          
//------------------ Apply styles

var el = $('#trial'); //Store a jQuery object of the result element in el



el.html(data).trigger( "create" );



jQuery('a').live('click', function() {
	var $this = $(this);
	if ( !$this.attr('rel') || $this.attr('rel') != 'external' )
		$(document.getElementById( $this.attr('href') )).remove();
});

// end formatting

       }
      })
    };

    /* END OF getNs functions */


//----------------------- GET SPECIFIC QUESTIONS -----------------------------

function getSquestions(user){

//alert("getS questions running");

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/Show_S_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
           //alert("getNs: ok to here");
         
        jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         jQuery("#s_questions").html(data).trigger( "create" );

//------------------ Apply styles
// ----------------- PANE OPEN CODE TAKEN FROM HERE
var testArray=new Array("structure-tab","contenu-tab","technique-tab","university-tab");
//testArray = array('1','2');
//nb = 0; (myarray.length);
//for (0<count())

for (nb=0;nb<=testArray.length;nb++)
{
//code to be executed
//alert(testArray[nb]);
testCookie(testArray[nb]);

}
// ----------------- END PANE OPEN

//alert("end of getSquestions");
getEnglish(user);

       }
      })
    };


//------------------------- END, GET SPECIFIC QUESTIONS ----------------------

    function getNotes(user){

      //$.mobile.showPageLoadingMsg();
	  
      jQuery.post("http://www.cv-en-anglais.com/php-mobile/Show_Notes.php", {user_current : user }, function(data){
       if (data.length>0){
           
         jQuery("#note-item").html(data).trigger( "create" );

      
		jQuery("#note-item").fadeIn("slow");
   

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

       }
	   $.mobile.hidePageLoadingMsg();
      })
    };

// --------------------------------------- GET LINK FOR UPDATE

function getLinkFull(user, id){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

var id_update = id;

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/Show_Full_Link.php", {user_current : user, id_update : id }, function(data){
       if (data.length>0){
          // alert("getFullLink: ok to here");
         //$("#search_results").html(data);


//jQuery("#notes-item").empty();
         //$("#search_results").html(data);
        //jQuery("#notes-content").html(data);
         jQuery("#link-item").html(data).trigger( "create" );

      //jQuery("#notes-item").empty();

      // build and show form
//jQuery("#notes-item").html("<form id='notes-item-form' style='width:180px';><a href='#' id='back'>< Retour</a><br /><br>Name: <input type='textbox' id='' value=''/><br /><br/>Note: <br /><textarea rows='10' cols='30'></textarea> <br /><br /><input type='submit' value='Save' id='notes-save'><br /></form>");

jQuery("#link-item").fadeIn("slow");
    // Animation complete.

// hack for table border
     
     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


    //jQuery("#notes-content").fadeIn("slow");
       }
      })
    };

// ------------------------------ GET UCAS QUESTIONS -------------------

/* GET NON SPECIFIC QUESTION DATA FROM DATABASE */

    function getUcas(user){


      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/Show_Ucas_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
          
		  //alert("ucas function"); 
         // empty target div
         jQuery("#ucas").empty();
         
         // update page via jqm
         jQuery("#ucas").html(data).trigger( "create" );
         
         openPane();
		 getBeforeLeaving(user);  

       }
	   })
    };

    /* END OF getNs functions */

// ------------------------------- END, GET UCAS QUESTIONS

/* GET ENGLISH QUESTIONS-LINKS */

    function getEnglish(user){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/Show_English_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
           //alert("get UCAS: ok to here");
         //$("#search_results").html(data);
         jQuery("#english").empty();
         //$("#search_results").html(data);
         jQuery("#english").html(data).trigger( "create" );

		  
       }
      })
    };

    /* END OF getNs functions */

// ------------------------------- END, GET ENGLISH QUESTIONS

// ------------------------------- Get info on before leaving

/* GET ENGLISH QUESTIONS-LINKS */

    function getBeforeLeaving(user){

		
		
      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/Show_Before_Leaving_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
		   
        //  alert("get before you leave: ok to here");
         //$("#search_results").html(data);
         jQuery("#before_you_leave").empty();
         //$("#search_results").html(data);
         //jQuery("#before_you_leave").html(data);
		  
		   
		 //jQuery("#before_you_leave").html(data).( "refresh" );   
		  
		 // works sort of  
		 jQuery("#before_you_leave").html(data).trigger( "create" );
		   
		 getSquestions(user);
		    

       }
      })
    };

    /* END OF getNs functions */

// ------------------------------- END, Get before you go info



// ----------------------------- END LINK UPDATE
// -------------------------------------- GET LINKS


function getLinks(user){
	
		jQuery('#link-item').fadeIn(2000);
		//$.mobile.showPageLoadingMsg();
      	jQuery.post("http://www.cv-en-anglais.com/php-mobile/Show_Links.php", {user_current : user }, function(data){
			if (data.length>0){
				
			 jQuery("#link-item").html(data).trigger( "create" );
	
			 //alert("after trigger create function");
	
			 jQuery("#link-item").fadeIn("slow");
			 jQuery(".link_table").css("border","1px solid #B6B6B5");
			 jQuery(".link_table").css({'border': '0px'});
			 jQuery("table.link_table").css({'border': '0px'});
		//jQuery("#notes-content").fadeIn("slow");
			 $.mobile.hidePageLoadingMsg();
		   }
      	})

 }



// END GET LINKS
    //--------------------- PRESENTS NOTES IN A FORM --------------------------
    function getNotesFull(user, id){
    var id_click;
	//$.mobile.showPageLoadingMsg();
      jQuery.post("http://www.cv-en-anglais.com/php-mobile/getNotesFull.php", {user_current : user, id_click : id }, function(data){
       if (data.length>0){
           //alert("getNs: ok to here");
         //$("#search_results").html(data);
         //jQuery("#notes-content").empty();
         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         jQuery("#note-item").html(data).trigger( "create" );
         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});
	 $.mobile.hidePageLoadingMsg();

       }
      })
    };

    //--------------------- END PRESENTS NOTES IN A FORM --------------------------

    // -------------------- UPDATE NOTE

    function updateNote(user, id, content_up, content_name){
	//$.mobile.showPageLoadingMsg();
    var id_click;

    //alert("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/updateNote.php", {user_current : user, id_update : id, content : content_up, name : content_name}, function(data){
       if (data.length>0){
           //alert("getNs: ok to here");
         //$("#search_results").html(data);
         //jQuery("#notes-content").empty();
         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         jQuery("#notes-item").html(data).trigger( "create" );
         getNotes(user);

         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});
		

       }
	   $.mobile.hidePageLoadingMsg();
      })
    };



    // end update

    // ----------------------------- UPDATE LINK

    function updateLink(user, id, link_update, link_name){

      //document.write("search_val"); , $user, $id, $content, $name
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK
    //var id_click;

   // alert("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/updateLink.php", {user_current : user, id_update : id, link_address : link_update, name : link_name}, function(data){
       if (data.length>0){
           //alert("getNs: ok to here");
         //$("#search_results").html(data);
         //jQuery("#notes-content").empty();
         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         //jQuery("#notes-item").html(data);
         //getNotes(user);
       }
       getLinks(user);

       // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


  })
    };



    // END UPDATE LINK

    // ------------------------ Delete link

    function deleteLink(user, id){

      //document.write("search_val"); , $user, $id, $content, $name
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK
    //var id_click;
//jQuery('#link-item').fadeOut(1000);


jQuery("#link-item").fadeOut("slow", function() {

    //jQuery(".test_link_delete").empty();

jQuery("#link-item").empty();

    //getLinks(user);

    //jQuery("#notes-content").fadeIn("slow");

    //getNotes(user);

    //jQuery("#notes-content").fadeIn("slow");


      // was here








    //alert("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/deleteLink.php", {user_current : user, id_update : id}, function(data){
       if (data.length>0){
           //alert("getNs: ok to here");
         //$("#search_results").html(data);


         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         //jQuery("#notes-item").html(data);
         //getNotes(user);

         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


       }

});
       getLinks(user);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

  })
    };




    // end delete link
    /* ----------------------------- ADDS UNIVERSITY TO USER'S LIST OF CHOICES -------------------------- */

    function addUni(user){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

    // GET DATA FROM SELECT BOX

    /* GET VALUE */
          var uni_value=jQuery('#select1').val();
				//alert(uni_value);
    /* GET TEXT VALUE */
          var uni_title=jQuery('#select1 :selected').text();
					//alert(uni_title);
				
      jQuery.post("http://www.cv-en-anglais.com/php-mobile/addUni.php", {user_current : user, uni_nb : uni_value, uni_name : uni_title}, function(data){
       if (data.length>0){
         //alert("addUni: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();

         //alert("addUni: html cleared");
         //$("#search_results").html(data);
         jQuery("#test2").html(data).trigger( "create" );
         // show message to confirm choice has been saved
         jQuery("#update").html("Choix enregistre");
         //makeActive(user);
         // refresh everything


       }
      })
    };

// ----------------------------------------------------------- ADD NEW NOTE -------------------

function addNewNote(user){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

    // GET DATA FROM SELECT BOX

    /* GET VALUE */
          var new_title = jQuery('#title_box').val();

    /* GET TEXT VALUE */
          var note_new = jQuery('#note-new').val();

      //alert(note_new);
	//$.mobile.showPageLoadingMsg();
      jQuery.post("http://www.cv-en-anglais.com/php-mobile/addNotes.php", {user_current : user, title : new_title, note : note_new}, function(data){
       if (data.length>0){
         //alert("addUni: data returned");
         //$("#test2").html(data);
         //jQuery("#test2").empty();
         //alert("insert text has been run");
         //alert("addUni: html cleared");
         //$("#search_results").html(data);
         //jQuery("#test2").html(data);
         // show message to confirm choice has been saved
         //jQuery("#update").html("Choix enregistre");
         getNotes(user);
         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

             }
			 $.mobile.hidePageLoadingMsg();
      })
    }

// ----------------------------- NOTES, DELETE NOTE -----------------------------------


function deleteNote(user, id){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK


jQuery("#note-item").fadeOut("slow", function() {

    // GET DATA FROM SELECT BOX
    jQuery("#note-item").empty();
    /* GET VALUE */
      //    var deleteId = jQuery('#title_box').val();

//alert("entry id:" + id);
    /* GET TEXT VALUE */
      //    var note_new = jQuery('#note-new').val();

  //    alert("delete process running");
//$.mobile.showPageLoadingMsg();
      jQuery.post("http://www.cv-en-anglais.com/php-mobile/deleteNote.php", {user_current : user, entry : id}, function(data){
       if (data.length>0){
         //alert("addUni: data returned");
         //$("#test2").html(data);
         //jQuery("#test2").empty();
    //     alert("insert text has been run");
         //alert("addUni: html cleared");
         //$("#search_results").html(data);
         //jQuery("#test2").html(data);
         // show message to confirm choice has been saved
         //jQuery("#update").html("Choix enregistre");
         //getNotes(user);
         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

             }
             });
         //jQuery("#notes-item").empty();

         getNotes(user);
         jQuery('#note-item').fadeIn("slow");
		 //$.mobile.hidePageLoadingMsg();
      })
    }




// end, delete note

    // --------------------------- DELETES UNI FROM DATABASE ----------------------------

    function deleteEntry(user){

    /* GET VALUES OF ENTRY TO DELETE */

    //alert("deleteEntry: delete entry started");

    var id_val=jQuery('#uni-list2 :selected').attr('id');

    /* GET TEXT VALUE */
    var name_text=jQuery('#uni-list2 :selected').text();

    //alert("deleteEntry: testing variables");

    //alert(id_val + name_text);


    /* GET UNI NB TO DELETE S_QUESTIONS */

    //var uni_nb = jQuery('#uni-list2 :selected').attr('name');

    //var uni_nb = jQuery('#uni-list2').attr('name');

    //alert(uni_nb);
    //alert(name_text);
    //alert(user);

    //alert("deleteEntry: just before ajax call");

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/delete.php", {user_current : user, id : id_val, name : name_text}, function(data){
       if (data.length>0){
         //alert("deleteEntry: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();

         //alert("deleteEntry: html cleared");
         //$("#search_results").html(data);
         jQuery("#test2").html(data).trigger( "create" );

         // fade out message to confirm delete

         jQuery('#test2').fadeOut(2000, function() {
        // Animation complete.
        GetChoicesInit(user);
        // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


    });

    // Add message to say entry has been deleted

       }
      });
    }; // end Delete Uni

    function GetChoicesInit(user){

    /* GET VALUE */
          var uni_value=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var uni_title=jQuery('#select1 :selected').text();

     // alert ("uni title" + uni_title + "uni code" + uni_value);

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/GetChoicesInit.php", {user_current : user, uni_nb : uni_value, uni_name : uni_title}, function(data){
       if (data.length>0){
         //alert("GetChoicesInit: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();

         //alert("GetChoicesInit: html cleared");
         //$("#search_results").html(data);
         //jQuery("#test2").html(data);
         jQuery("#test2").html(data).trigger( "create" );
         //alert("Running in the makeActive function call");
         jQuery('#test2').fadeIn(1500);
         //makeActive(user);

         // --- CHECK UNI LIST VALUE
         //checkUniList();
         
       }
      })
    }

    // ---------------- MAKE CHOSEN UNI ACTIVE

    function makeActive(user){

    // get choice uni_nb and current user

    // id_val contains uni_nb
    var id_val=jQuery('#uni-list2 :selected').attr('id');

    //alert("makeActive: this is the uni number " + id_val);

    /* contains uni name */
    var name_text=jQuery('#uni-list2 :selected').text();

  //alert("makeActive: this is the uni name " + name_text + "uni ID" + id_val);
    
    //alert("makeActive: this is the current user " + user);

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/update.php", {user_current : user, id : id_val, name : name_text}, function(data){
       if (data.length>0){
          // alert("makeActive: ok to here on UPDATE");
         //$("#search_results").html(data);
         jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         jQuery("#s_questions").html(data).trigger( "create" );
         getNs(user);
    getUcas(user);
    getEnglish(user);
    getBeforeLeaving(user);
       }
      })
    };

    // ----------------------- UPDATE NS_QUESTIONS

    function updateSQuestions(user, id_quest, tick_value){


    // GET INFO
    var tick_value = tick_value;
    var id_uni = id_quest;
	//$.mobile.showPageLoadingMsg();
    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("/staging-cv-en-anglais/php-mobile/update_tickbox_N_questions.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
				
       if (data.length>0){
          // alert("updateSQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         //jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         //jQuery("#s_questions").html(data);

       }
	  // $.mobile.hidePageLoadingMsg();
      })
    };

    function addNote(user, id_quest, tick_value){

    // GET INFO
    var tick_value = tick_value;
    var id_uni = id_quest;

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.cv-en-anglais.com/php-mobile/update_tickbox.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       if (data.length>0){
          //alert("updateSQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         jQuery("#s_questions").html(data);

         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


       }
      })
    };


// ------------------------ CHECK CONTENTS OF UNI-LIST



// ------------------------ END UNI-LIST CONTENTS
    // end, update ns_questions

    //-------------------------------- UPDATE NON SPECIFIC QUESTIONS

    function updateNQuestions(user, id_quest, tick_value){

    // GET INFO
    var tick_value = tick_value;
    var id_uni = id_quest;
	//$.mobile.showPageLoadingMsg();
    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');
     
     // jQuery.post("http://www.cv-en-anglais.com/php-mobile/update_tickbox_N_questions.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       
jQuery.post("/staging-cv-en-anglais/php-mobile/update_tickbox_N_questions.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){

	if (data.length>0){
          //alert("2nd check");
         //$("#search_results").html(data);
         jQuery("#trial").empty();
         //$("#search_results").html(data);
         jQuery("#trial").html(data);

       }
	   $.mobile.hidePageLoadingMsg();
      })
    };


    function addLink(user, link_name, link_address){



//alert(user + link_name + link_address);

    // GET INFO

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.test-sw2.com/staging-cv-en-anglais/php-mobile/add_link.php", {user1 : user, link_name1 : link_name, link_address1 : link_address}, function(data){
       if (data.length>0){
           //alert("updateSQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         //jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         //jQuery("#s_questions").html(data);
         //getLinks(user);



jQuery("#link-item").empty();

//getLinks(user);


       }
      
	//alert("about to retrieve links");
      

	getLinks(user);


      // ----------------------------- empty form

     // jQuery("#add_link_address").empty();
     jQuery("#add_link_address").attr('value', '');
     jQuery("#add_link_name").attr('value', '');
     jQuery("#add_link_address").attr('value', 'www.');
     // --- end empty form
     // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


  })
    };


    // END ADD LINK


jQuery(".link_table").css({'border': '0px'});
jQuery("table.link_table").css({'border': '0px'});

    // end non specific questions

// ------------------------ CHECK CONTENTS OF UNI-LIST

    function checkUniList(){

    // GET INFO
    var uniValue = jQuery("#uni-list2").val();

    //alert("this is the current value of the uni-list " + uniValue)
    //var id_uni = id_quest;

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');


    };

// ------------------------ END UNI-LIST CONTENTS

// -------------------------- COOKIES -----------------------

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
// --------------------------- END COOKIES ------------------


// ------------------------------ OPEN CORRECT PANES -----------------------

// ------ check if any windows have been opened
function testCookie (mobVarTest) {

//mobVarTest = "link1";

testTest = readCookie(mobVarTest);

if(testTest){

    if (testTest == "open"){

        
        // open correct pane
        jQuery('div[name|='+mobVarTest+']').trigger('expand');
    }
    else{

        //alert("pane is closed");
        // create cookie for pane
        initialValue = "";
        lifeTime = 7;
        createCookie(mobVarTest,initialValue,lifeTime);

    }

}
else {

//alert("no cookie set");
initialValue = "";
lifeTime = 7;
createCookie(mobVarTest,initialValue,lifeTime);

}
}
// ------------- add click event to panes

jQuery("#link-trial-app").live("click", function(event){

//-------------------------



//mobVarTest = jQuery('div[name|='+myVar+']').trigger('expand');
mobVarTest = jQuery(event.target).closest("div").attr('name');
//alert(mobVarTest);
testTest = readCookie(mobVarTest);

if(testTest){

    if (testTest == "open"){

        //alert("pane is already open, change value to closed");
        // open correct pane
        //jQuery('div[name|='+mobVarTest+']').trigger('expand');
        //alert("this is the cookie value(2) " + testTest);
        value_closed ="closed";
        timeLength=7;
        createCookie(mobVarTest,value_closed,timeLength);
    }
    else{

        //alert("pane is closed, change value to open");
        // create cookie for pane
        value_open="open";
        timeLength=7;
        createCookie(mobVarTest,value_open,timeLength);

    }

}
else {


initialValue = "open";
lifeTime = 7;
createCookie(mobVarTest,initialValue,lifeTime);
testTest = readCookie(mobVarTest);


}




});

// ----------------------------- Open panes

function openPane(){

var testArray=new Array("structure-tab","contenu-tab","technique-tab","university-tab");

for (nb=0;nb<=testArray.length;nb++)
{
//code to be executed

testCookie(testArray[nb]);

}

    };



// ------------------------------ END CORRECT PANES
    });



