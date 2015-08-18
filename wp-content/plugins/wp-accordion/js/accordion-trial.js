jQuery(document).ready(function(){

// function to get current url
	
	function getBaseURL() {
    var url = location.href;  // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));


    if (baseURL.indexOf('http://localhost') != -1) {
        // Base Url for localhost
        var url = location.href;  // window.location.href;
        var pathname = location.pathname;  // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

        return baseLocalUrl + "/";
    }
    else {
        // Root Url for domain name
        return baseURL + "/";
    }

}
	
// set var to contain base url 
	
var baseAddress = getBaseURL();	
	

// end function 	
	
	
	
//jQuery("select, input[type=checkbox]").uniform();


jQuery('#php-page').live('click', function(event){



var $et = jQuery( event.target );

jQuery('#questions_trial22 > span').live('click', function(event){

    var tick_value = jQuery(event.target).attr('checked');
    var id_quest = jQuery(event.target).attr('id');

    if(tick_value == true){

    // ("value2 is TRUE");
    tick_value = "checked";
    // (tick_value);
    }
    else {

    tick_value = "no";
    // (tick_value);

    }
    // udpate ns_questions based on

    //updateNQuestions(user, id_quest, tick_value);



        })




// end trial
});

//--------------- Get current page's accordion section -------------

var qsParm = new Array();
function qs() {
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

//("this is accordion section " + all);


// ---- make particular pane open when page loads --- //

//jQuery('#execphp-4 h2:first').click(function() {
     //(qsParm['id']);
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

    //("function click started");*/

            jQuery(this).next("p").slideToggle("fast")
            .siblings("p:visible").slideUp("fast");
            jQuery(this).toggleClass("active");
            jQuery(this).siblings("h3").removeClass("active");


      });

// -------------------------- Run functions

   //GetChoicesInit(user);

getNs(user);
//getUcas(user);
getSquestions(user);
getEnglish(user);

getBeforeLeaving(user);




// -------------------------- end functions

jQuery("#update-save").live("click", function(event){

   event.preventDefault();

var id = jQuery(event.target).attr('class');

//("this is the ID" + id);

var content_up = jQuery("#update-content").val();
var content_name = jQuery("#name-update").val();

          updateNote(user, id, content_up, content_name);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });

// -------------------------------- UPDATE LINK

jQuery("#link_submit").live("click", function(event){

   event.preventDefault();

var id = jQuery(event.target).attr('class');

//("this is the ID" + id);


var link_update = jQuery("#link_link").val();
var link_name = jQuery("#link_name").val();

//("this is the link address" + link_update);
//("this is the link name" + link_name);

          updateLink(user, id, link_update, link_name);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });


// --------------------------------- DELETE LINK

jQuery("#delete_link").live("click", function(event){

   event.preventDefault();

   //jQuery('#link-item').fadeOut(1000);


var id = jQuery(event.target).attr('class');

//("this is the ID" + id);


var link_update = jQuery("#link_link").val();
var link_name = jQuery("#link_name").val();

//("this is the link address" + link_update);
//("this is the link name" + link_name);

          deleteLink(user, id);

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });


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
          //(box_val);

        });

    jQuery("#box2").live("click", function(){

          var box_val=jQuery("#box2").val()
          //(box_val);

        });


    jQuery("#form_1").live("click", function(){

    var t = jQuery(event.target);

          if (t.is("input")){

          var box_val = jQuery(event.target).val();
          //(box_val);

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

          //("1st check: Delete requested " + box_val2 + box_text2);
          //var box_val=jQuery("#box2").val()

    // ------------------------- DELETE ENTRY -----------------------------

        deleteEntry(user);


        });




    /* ------------------------- ONCLICK EVENT FOR SELECT BOX ------------------------ */

    jQuery("#select1").live("click", function(){

    /* GET VALUE */
          var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#select1 :selected').text();

          //("Uni being added " + box_val + box_text);
          addUni(user);

        });

   /* ------------------------ NOTES, DELETE BUTTON ------------------------------- */

   jQuery("#delete-button").live("click", function(event){

          //var t = jQuery(event.target).attr('id');

          event.preventDefault();

          var t = jQuery(event.target).attr('href');

          //("value of href " + t);

          deleteNote(user, t);

          // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

        });


    /* ------------------------- ONCLICK EVENT FOR SELECT BOX ------------------------ */

    jQuery("#notes-add").live("click", function(event){



    event.preventDefault();
    /* GET VALUE */
          //var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          //var box_text=jQuery('#select1 :selected').text();

          //("Add note has been clicked");

           jQuery("#note-item").fadeOut("slow", function() {

          //jQuery("#notes-item").empty();

          // build and show form
    jQuery("#note-item").html("<td><form id='notes-item-form' style='width:150px';><a href='#' id='back'>< Retour</a><br /><br>Name: <input type='textbox' id='title_box' value=''/><br /><br/>Note: <br /><textarea rows='5' cols='20' id='note-new'></textarea> <br /><br /><input type='submit' value='Save' id='notes-save'><br /></form></td>");

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

          //("Uni being added " + box_val + box_text);
          addUni(user);

       // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });


    jQuery("#notes-each").live("click", function(event){

        var t = jQuery(event.target).attr('href');


          event.preventDefault();
    /* GET VALUE */
          var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#select1 :selected').text();

         // ("notes button clicked");
          //("this is id value" + t);

          jQuery("#note-item").empty();
          //("Uni being added " + box_val + box_text);
          getNotesFull(user, t);

          // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


        });


   // ----------------------------- UPDATE LINK

   jQuery("#update_link").live("click", function(event){

        var t = jQuery(event.target).attr('class');


          event.preventDefault();
    /* GET VALUE */
          //var box_val=jQuery('#select1').val();

    /* GET TEXT VALUE */
          //var box_text=jQuery('#select1 :selected').text();

         // ("notes button clicked");
         // ("this is id value" + t);

          //jQuery("#links-item").empty();
          //("Uni being added " + box_val + box_text);

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



          //("back button clicked");
          //("this is id value"
          });

    // END ------------------------


// ----------------------------- LINKS ADD

jQuery("#add_link_button").live("click", function(event){

//("click event fired");
    event.preventDefault();
    /* GET VALUE */
   var link_name=jQuery('#add_link_name').val();

    /* GET TEXT VALUE */
   var add_link_address=jQuery('#add_link_address').val();

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



          //("back button clicked");
          //("this is id value"
          });



// end, back link

    /* ------------------------- ONCHANGE EVENT FOR DROPDOWN LIST ------------------------ */
    // use to select active university


//    jQuery("#uni-list2").live("change", function(){

    /* GET VALUE */
//          var box_val=jQuery('#uni-list2').val();

    /* GET TEXT VALUE */
//          var box_text=jQuery('#uni-list2 :selected').text();

         // ("Different uni selected " + box_val + box_text);
          //addUni(user);
//("Change function started");
    // Run makeActive method

  //  makeActive(user);
//("after makeActive function");

  //      });

// -------------- DELEGATE, for IE -------------------

jQuery("#test2").delegate("select", "change", function(){
      //$(this).after("<p>Another paragraph!</p>");

    var box_val=jQuery('#uni-list2').val();

    /* GET TEXT VALUE */
          var box_text=jQuery('#uni-list2 :selected').text();

         // ("Different uni selected " + box_val + box_text);
          //addUni(user);
//("Change function started");
    // Run makeActive method

    makeActive(user);
//("after makeActive function");



});


    // ---------- FOR CLICK ON TICK BOXES---------------------

    jQuery("#specific_questions").live("click", function(event){


    //var t = jQuery(event.target);

    var tick_value = jQuery(event.target).attr('checked');
    var id_quest = jQuery(event.target).attr('id');

    // ("tick value is "+tick_value);
    // ("question id is "+id_quest);


    if(tick_value == "checked"){

    // ("value2 is TRUE");
    tick_value = "checked";
   //alert(id_quest);
        jQuery('.'+id_quest).css({"text-decoration":"line-through"});
        //css({"css property name":"css property value"});

    }
    else {

    tick_value = "no";
    // (tick_value);
    jQuery('.'+id_quest).css({"text-decoration":"none"});

    }
    // udpate ns_questions based on

    //updateSQuestions(user, id_quest, tick_value);

updateNQuestions(user, id_quest, tick_value);

        })

    // end event tick boxes

    //---------------------------- UPDATE NON SPECIFIC QUESTIONS

    // ---------- FOR CLICK ON TICK BOXES---------------------

    jQuery("#non_specific_questions").live("click", function(event){

    var tick_value = jQuery(event.target).attr('checked');
    var id_quest = jQuery(event.target).attr('id');

    if(tick_value == "checked"){

    // ("value2 is TRUE");
    tick_value = "checked";
    jQuery('.'+id_quest).css({"text-decoration":"line-through"});
    // (tick_value);
    }
    else {

    tick_value = "no";
    jQuery('.'+id_quest).css({"text-decoration":"none"});
    // (tick_value);

    }
    // udpate ns_questions based on

    updateNQuestions(user, id_quest, tick_value);

        })
    /* END TEST CLICK ACTION */

    /* GET NON SPECIFIC QUESTION DATA FROM DATABASE */

    function getNs(user){


	jQuery.post(baseAddress+"php/Show_NS_Questions.php", {user_current : user }, function(data){
       	
      //jQuery.post("http://preview.ot2a49z8z4hx5hfrmvtylogdb9ey7gb93l8tnzv7xtakyb9.box.codeanywhere.com/php/Show_NS_Questions.php", {user_current : user }, function(data){
       
	   if (data.length>0){

//alert("data returned");

// ------------------ CHECK WHICH PANES SHOULD BE OPEN

var testArray=new Array("text-2", "text-4", "text-6", "text-7");

//testArray = array('1','2');
//nb = 0; (myarray.length);
//for (0<count())

for (nb=0;nb<=testArray.length;nb++)
   {

testCookie(testArray[nb]);

}

// ------------------ END PANES 

//------------------ Apply styles

var el = jQuery('#trial'); //Store a jQuery object of the result element in el

jQuery("#trial").empty();

el.html(data);


jQuery("input[type=checkbox]").uniform();

// Sort out formatting

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

//("getS questions running");

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post(baseAddress+"php/Show_S_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
           
jQuery("#structure").empty();
         
//$("#search_results").html(data);
         jQuery("#structure").html(data);
//("getNs: data returned to DIV");
//------------------ Apply styles



jQuery("input[type=checkbox]").uniform();
//el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});

//el.find('div[data-role=fieldcontain]').fieldcontain({theme:'c',refresh:true});
//("try: page function");
//jQuery('.non_specific_questions').page();
//("after results returned");
//------------------ end apply styles

// Sort out formatting

/* $('a').live('click', function() {
	var $this = $(this);
	if ( !$this.attr('rel') || $this.attr('rel') != 'external' )
		$(document.getElementById( $this.attr('href') )).remove();
});*/

// end formatting

       }
      })
    };


//------------------------- END, GET SPECIFIC QUESTIONS ----------------------

    function getNotes(user){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post("http://www.cv-en-anglais.com/php/Show_Notes.php", {user_current : user }, function(data){
       if (data.length>0){
           //("getNs: ok to here");
         //$("#search_results").html(data);


//jQuery("#notes-item").empty();
         //$("#search_results").html(data);
        //jQuery("#notes-content").html(data);
         jQuery("#note-item").html(data)

      //jQuery("#notes-item").empty();

      // build and show form
//jQuery("#notes-item").html("<form id='notes-item-form' style='width:180px';><a href='#' id='back'>< Retour</a><br /><br>Name: <input type='textbox' id='' value=''/><br /><br/>Note: <br /><textarea rows='10' cols='30'></textarea> <br /><br /><input type='submit' value='Save' id='notes-save'><br /></form>");

jQuery("#note-item").fadeIn("slow");
    // Animation complete.

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

    //jQuery("#notes-content").fadeIn("slow");
       }
      })
    };


//------------------------- GET SPECIFIC QUESTIONS ----------------------

    function sQuestions(user){

//("other squestions function running");
    var data;
    data = "hello world";
    //("this is the value of data " + data);
    jQuery("#s_questions").empty();
    //jQuery("#s_questions").html(data);

      jQuery.post(baseAddress+"Show_S_Questions.php", {user_current : user }, function(data){
       if (data.length>0){

         jQuery("#structure").html(data);


//jQuery("#note-item").fadeIn("slow");

       }
      });

    }





// --------------------------------------- GET LINK FOR UPDATE

function getLinkFull(user, id){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

var id_update = id;

      jQuery.post("http://www.cv-en-anglais.com/php/Show_Full_Link.php", {user_current : user, id_update : id }, function(data){
       if (data.length>0){
          // ("getFullLink: ok to here");
         //$("#search_results").html(data);


//jQuery("#notes-item").empty();
         //$("#search_results").html(data);
        //jQuery("#notes-content").html(data);
         jQuery("#link-item").html(data)

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

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK

      jQuery.post("http://cv-en-anglais.com/php/Show_Ucas_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
          // ("get UCAS: ok to here");
         //$("#search_results").html(data);
         jQuery("#ucas").empty();
         //$("#search_results").html(data);
         jQuery("#ucas").html(data);

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

      jQuery.post(baseAddress+"php/Show_English_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
           //("get UCAS: ok to here");
         //$("#search_results").html(data);
         jQuery("#contenu").empty();
         //$("#search_results").html(data);
         jQuery("#contenu").html(data);

	jQuery("input[type=checkbox]").uniform();	

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

      jQuery.post(baseAddress+"php/Show_Before_Leaving_Questions.php", {user_current : user }, function(data){
       if (data.length>0){
          
         jQuery("#advanced").empty();
         
         jQuery("#advanced").html(data);

	jQuery("input[type=checkbox]").uniform();

       }
      })
    };

    /* END OF getNs functions */

// ------------------------------- END, Get before you go info



// ----------------------------- END LINK UPDATE
// -------------------------------------- GET LINKS


function getLinks(user){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK
jQuery('#link-item').fadeIn(2000);
      jQuery.post("http://www.cv-en-anglais.com/php/Show_Links.php", {user_current : user }, function(data){
       if (data.length>0){
           //("getNs: ok to here");
         //$("#search_results").html(data);


//jQuery("#notes-item").empty();
         //$("#search_results").html(data);
        //jQuery("#notes-content").html(data);
         jQuery("#link-item").html(data)

      //jQuery("#notes-item").empty();

      // build and show form
//jQuery("#notes-item").html("<form id='notes-item-form' style='width:180px';><a href='#' id='back'>< Retour</a><br /><br>Name: <input type='textbox' id='' value=''/><br /><br/>Note: <br /><textarea rows='10' cols='30'></textarea> <br /><br /><input type='submit' value='Save' id='notes-save'><br /></form>");

jQuery("#link-item").fadeIn("slow");
    // Animation complete.
jQuery(".link_table").css("border","1px solid #B6B6B5");

// hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});
    //jQuery("#notes-content").fadeIn("slow");
       }
      })

    };

// END GET LINKS
    //--------------------- PRESENTS NOTES IN A FORM --------------------------
    function getNotesFull(user, id){

      //document.write("search_val");
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK
    var id_click;

    //("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php/getNotesFull.php", {user_current : user, id_click : id }, function(data){
       if (data.length>0){
           //("getNs: ok to here");
         //$("#search_results").html(data);
         //jQuery("#notes-content").empty();
         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         jQuery("#note-item").html(data);
         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

       }
      })
    };

    //--------------------- END PRESENTS NOTES IN A FORM --------------------------

    // -------------------- UPDATE NOTE

    function updateNote(user, id, content_up, content_name){

      //document.write("search_val"); , $user, $id, $content, $name
      //LOADS A NEW PAGE search.php, sends search_term and search_term TO SERVER (search_val CONTAINS THE DATE, search_term IS THE KEY)
      //function (data) IS THE CALLBACK FUNCTION CALLED AS SOON AS THE DATA HAS BEEN LOADED PROPERLY
      // THE 4TH ATTRIBUTE, NOT USED HERE, IS THE TYPE OF DATA (HTML, XML ETC..) SENT BACK
    var id_click;

    //("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php/updateNote.php", {user_current : user, id_update : id, content : content_up, name : content_name}, function(data){
       if (data.length>0){
           //("getNs: ok to here");
         //$("#search_results").html(data);
         //jQuery("#notes-content").empty();
         //$("#search_results").html(data);
         //jQuery("#notes-content").html(data);
         jQuery("#notes-item").html(data);
         getNotes(user);

         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});


       }
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

   // ("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php/updateLink.php", {user_current : user, id_update : id, link_address : link_update, name : link_name}, function(data){
       if (data.length>0){
           //("getNs: ok to here");
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








    //("from inside function" + id);

      jQuery.post("http://www.cv-en-anglais.com/php/deleteLink.php", {user_current : user, id_update : id}, function(data){
       if (data.length>0){
           //("getNs: ok to here");
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
				//(uni_value);
    /* GET TEXT VALUE */
          var uni_title=jQuery('#select1 :selected').text();
				//	(uni_title);

      jQuery.post("http://www.cv-en-anglais.com/php/addUni.php", {user_current : user, uni_nb : uni_value, uni_name : uni_title}, function(data){
       if (data.length>0){
         //("addUni: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();

         //("addUni: html cleared");
         //$("#search_results").html(data);
         jQuery("#test2").html(data);
         // show message to confirm choice has been saved
         jQuery("#update").html("Choix enregistre");
         makeActive(user);
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

      //(note_new);

      jQuery.post("http://www.cv-en-anglais.com/php/addNotes.php", {user_current : user, title : new_title, note : note_new}, function(data){
       if (data.length>0){
         //("addUni: data returned");
         //$("#test2").html(data);
         //jQuery("#test2").empty();
         //("insert text has been run");
         //("addUni: html cleared");
         //$("#search_results").html(data);
         //jQuery("#test2").html(data);
         // show message to confirm choice has been saved
         //jQuery("#update").html("Choix enregistre");
         getNotes(user);
         // hack for table border

     jQuery(".link_table").css({'border': '0px'});
     jQuery("table.link_table").css({'border': '0px'});

             }
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

//("entry id:" + id);
    /* GET TEXT VALUE */
      //    var note_new = jQuery('#note-new').val();

  //    ("delete process running");

      jQuery.post("http://www.cv-en-anglais.com/php/deleteNote.php", {user_current : user, entry : id}, function(data){
       if (data.length>0){
         //("addUni: data returned");
         //$("#test2").html(data);
         //jQuery("#test2").empty();
    //     ("insert text has been run");
         //("addUni: html cleared");
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
      })
    }




// end, delete note

    // --------------------------- DELETES UNI FROM DATABASE ----------------------------

    function deleteEntry(user){

    /* GET VALUES OF ENTRY TO DELETE */

    //("deleteEntry: delete entry started");

    var id_val=jQuery('#uni-list2 :selected').attr('id');

    /* GET TEXT VALUE */
    var name_text=jQuery('#uni-list2 :selected').text();

    //("deleteEntry: testing variables");

    //(id_val + name_text);


    /* GET UNI NB TO DELETE S_QUESTIONS */

    //var uni_nb = jQuery('#uni-list2 :selected').attr('name');

    //var uni_nb = jQuery('#uni-list2').attr('name');

    //(uni_nb);
    //(name_text);
    //(user);

    //("deleteEntry: just before ajax call");

      jQuery.post("http://www.cv-en-anglais.com/php/delete.php", {user_current : user, id : id_val, name : name_text}, function(data){
       if (data.length>0){
         //("deleteEntry: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();

         //("deleteEntry: html cleared");
         //$("#search_results").html(data);
         jQuery("#test2").html(data);

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
//("ok to here");
    /* GET VALUE */
          var uni_value=jQuery('#select1').val();

    /* GET TEXT VALUE */
          var uni_title=jQuery('#select1 :selected').text();
//("ok to here");

      jQuery.post("http://www.cv-en-anglais.com/php/GetChoicesInit.php", {user_current : user, uni_nb : uni_value, uni_name : uni_title}, function(data){
       if (data.length>0){
         //("GetChoicesInit: data returned");
         //$("#test2").html(data);
         jQuery("#test2").empty();
         //("ok to here2");
         //("GetChoicesInit: html cleared");
         //$("#search_results").html(data);
         //jQuery("#test2").html(data);
         jQuery("#test2").html(data);
         //("Running in the makeActive function call");
         jQuery('#test2').fadeIn(1500);
         makeActive(user);

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

    //("makeActive: this is the uni number " + id_val);

    /* contains uni name */
    var name_text=jQuery('#uni-list2 :selected').text();

   // ("makeActive: this is the uni name " + name_text);
    //("makeActive: this is the current user " + user);
    //("makeActive: this is the uni ID " + id_val);

      jQuery.post("http://www.cv-en-anglais.com/php/update.php", {user_current : user, id : id_val, name : name_text}, function(data){
       if (data.length>0){
          // ("makeActive: ok to here on UPDATE");
         //$("#search_results").html(data);
         jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         jQuery("#s_questions").html(data);
         getNs(user);
    getUcas(user);
    getEnglish(user);
    getBeforeLeaving(user);
    getSquestions(user);

   }
      })
    };

    // ----------------------- UPDATE NS_QUESTIONS

    function updateSQuestions(user, id_quest, tick_value){

    // GET INFO
    var tick_value = tick_value;
    var id_uni = id_quest;

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.cv-en-anglais.com/php/update_tickbox.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       if (data.length>0){
          // ("updateSQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         jQuery("#s_questions").html(data);

       }
      })
    };

    function addNote(user, id_quest, tick_value){

    // GET INFO
    var tick_value = tick_value;
    var id_uni = id_quest;

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.cv-en-anglais.com/php/update_tickbox.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       if (data.length>0){
          //("updateSQuestions: ok to here on UPDATE");
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

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      //jQuery.post("http://preview.ot2a49z8z4hx5hfrmvtylogdb9ey7gb93l8tnzv7xtakyb9.box.codeanywhere.com/php/update_tickbox_N_questions.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       //if (data.length>0){

// my change
	
		
		jQuery.post(baseAddress+"php/update_tickbox_N_questions.php", {tick_box_val : tick_value, id : id_uni, user1 : user}, function(data){
       if (data.length>0){
		
		   
          // ("updateNQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         jQuery("#trial").empty();
         //$("#search_results").html(data);
         jQuery("#trial").html(data);

       }
      })
    };


    function addLink(user, link_name, link_address){


//("addLink started");
    // GET INFO

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');

      jQuery.post("http://www.cv-en-anglais.com/php/add_link.php", {user1 : user, link_name1 : link_name, link_address1 : link_address}, function(data){
       if (data.length>0){
           //("updateSQuestions: ok to here on UPDATE");
         //$("#search_results").html(data);
         //jQuery("#s_questions").empty();
         //$("#search_results").html(data);
         //jQuery("#s_questions").html(data);
         //getLinks(user);
       }
      //("about to retrieve links");
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

    //("this is the current value of the uni-list " + uniValue)
    //var id_uni = id_quest;

    //var tick_value = jQuery(event.target).attr('checked');
    //var id_uni = jQuery(event.target).attr('id');


    };

// ------------------------ END UNI-LIST CONTENTS



// ------------------------ new changes to keep the right pane open 


// --------------------------- OPEN CORRECT PANE

// ------ check if any windows have been opened

function testCookie (mobVarTest) {

//("testCookie function running");

// (mobVarTest);

testTest = readCookie(mobVarTest);

if(testTest){

    if (testTest == "open"){

        //("pane is already open" + " " + mobVarTest);
        
// open correct pane

jQuery("#"+mobVarTest+" h2:first").addClass('on').removeClass('off');

//jQuery("#"+mobVarTest+" h2:first").siblings('div').show('slow');

jQuery("#"+mobVarTest+" div:first").attr('style', 'display: block');

//jQuery("#"+mobVarTest+" h2:first").siblings('div').show('slow'); 

//jQuery("#"+mobVarTest+" .accordion_content:first").show('slow');

//jQuery("#"+mobVarTest+" .textwidget").show('slow');
	
	//jQuery("#"+mobVarTest+" h2:first").click();

    }
    else{

        //("pane is closed");
        // create cookie for pane
        initialValue = "";
        lifeTime = 7;
        createCookie(mobVarTest,initialValue,lifeTime);

    }

}
else {

//("no cookie set");
initialValue = "";
lifeTime = 7;
createCookie(mobVarTest,initialValue,lifeTime);

}
}


// --------------------------- CLOSE CORRECT PANE







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







//-----------------------------------------------------------

jQuery(".accWidget").live("click", function(event){

//-------------------------

//mobVarTest = jQuery(event.target).closest("div").attr('name');

mobVarTest = jQuery(event.target).closest("li").attr('id');

//("pane clicked");
//(mobVarTest);

//mobVarTest = jQuery('div[name|='+myVar+']').trigger('expand');

//mobVarTest = jQuery(event.target).closest("div").attr('name');

//(mobVarTest);
testTest = readCookie(mobVarTest);

if(testTest){

    if (testTest == "open"){

        //("pane is already open, change value to closed");
        // open correct pane
        //jQuery('div[name|='+mobVarTest+']').trigger('expand');
        //("this is the cookie value(2) " + testTest);
        value_closed ="closed";
        timeLength=7;
        createCookie(mobVarTest,value_closed,timeLength);
    }
    else{

        //("pane is closed, change value to open");
        // create cookie for pane
        value_open="open";
        timeLength=7;
        createCookie(mobVarTest,value_open,timeLength);

    }

}
else {

//("cookie not set, create a new one");
initialValue = "open";
lifeTime = 7;
createCookie(mobVarTest,initialValue,lifeTime);
testTest = readCookie(mobVarTest);
//("this is the cookie value " + testTest);

}

//--------------------------

//var clicktrial;
//.closest("label").attr("for");
//clicktrial = jQuery(event.target).closest("div").attr('name');

//myVar = "notesMobile";

//jQuery('div[name|='+myVar+']').trigger('expand');


//(clicktrial);

// build JS cookies //



// end build JS cookies //

});




// my changes END


    });