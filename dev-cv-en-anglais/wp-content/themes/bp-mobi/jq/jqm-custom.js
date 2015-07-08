// JavaScript Document

$(document).ready(function() {
  // disable ajax nav
  //$.mobile.ajaxLinksEnabled = false;
  
 /* $(document).bind("mobileinit", function(){
  $.extend(  $.mobile , {
    ajaxFormsEnabled: false,
ajaxLinksEnabled: false
  });
});*/
 
 $(document).bind("mobileinit", function() {
  $.mobile.ajaxLinksEnabled = false;
});

  
  
 });