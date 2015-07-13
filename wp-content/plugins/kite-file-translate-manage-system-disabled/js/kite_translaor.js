var j=jQuery.noConflict();
 
j(document).ready(function() {
j("#crate_automatic_price").click(function(){
    var number_of_page=j("#page_number").val();
    var price_per_word=j("#word_price").val();
    var price=Number(number_of_page)*Number(price_per_word);
    price=price.toFixed(2);
    j("#ord_prc").val(price);
    
})
  
       //j("#txtOrderDate").datepicker({showOn: 'button', buttonImage: '../wp-content/plugins/kite-file-translate-manage-system/images/cal_ico.gif', buttonImageOnly: true, changeMonth: true, changeYear: true,  showOn: 'both', yearRange: '2011:2090'});
       //j("#txtDateSent").datepicker({showOn: 'button', buttonImage: '../wp-content/plugins/kite-file-translate-manage-system/images/cal_ico.gif', buttonImageOnly: true, changeMonth: true, changeYear: true,  showOn: 'both', yearRange: '2011:2090'});
	jQuery('#txtDateSent').datepick({showTrigger: '#date-sent-trigger', dateFormat: 'dd/mm/yyyy' });
	jQuery('#txtOrderDate').datepick({showTrigger: '#order-date-trigger', dateFormat: 'dd/mm/yyyy' });
	
	j('.ktr_delete').click(function(){
             var n = j("input:checked").length;
            if(n==0){
                alert("You have to check a check box value.");
                return false;
            }
            var msg="Are you sure to delete this.";
            if(confirm(msg)){
                return true;
            }else{
                return false;
            }
        })
        j(".chk_validate").click(function(){
            var n = j("input:checked").length;
            if(n==0){
                alert("You have to check a check box value.");
                return false;
            }

        })
        
           j(".add_user").click(function(){
            var n = j(".sp input:checked").length;
            var n2 = j(".lang input:checked").length;
           
            var msg;
            if(n==0){
               msg="You have to check a check box for specialization.\n";
               
            }else{
                 msg="";
               
            }
            if(n2==0){
               msg=msg+"You have to check a check box for language.";
                
            }else{
               msg=msg+"";
               
            }
         
            if(msg!=""){
                alert(msg);
                return false;
            }
           

        })
        
 
        j("#ktr_select_translator").click(function(){
            j(".assign_trns").show();
        })
        j('#ktr_cancel_translator').click(function(){
            j('#txtDateSent').val('');
            j('#txtOrderDate').val('');
            j('#txtSentTo').val('');
            j('#txtComment').val('');
              j('.ajaxUserInfo').hide();
              j('.assign_trns').hide();
              j('.loader').hide();
        })
        j("#ktr-assign-translator-form").submit(function(){
            
            
            if(j.trim(j("#txtDateSent").val())==""){
                alert('Please Select a Sent Date');
                return false;
            }else if(j.trim(j("#txtOrderDate").val())==""){
                alert('Please Select a Due Date');
                return false;
            }else if(j.trim(j("#txtSentTo").val())==""){
                alert('Please enter Sent To');
                return false;
            }else{
                return true;
            }
        })
        
          j("#drp_translator option").click(function(event){
              j('.ajaxUserInfo').hide();
              j('.assign_trns').hide();
              j('.loader').show();
             var user_id=j(this).val();
                  var data = {action: 'widget_r',
                               whatever: user_id,
                               dataType:"json"
                               };

          var ajaxurl=MyAjax.ajaxurl;
               
             j.post(ajaxurl, data, function(response) {
		//alert('Got this from the server: ' + response);
		
		 if(response)
                    j(".wait").hide(); 
                    
                        //alert(response);  
                if(response!=""){
                  j('.loader').hide();
                  var data=response;
                  var nameArray=data.split('%NAME%');
                  var languageArray=nameArray[1].split('%LANGUAGE%');
                  var speCialization=languageArray[1].split("%STATUS%");
                  //alert(nameArray[1]);
                  j("#name").html(nameArray[0]);
                  j("#translatorLanguage").html(languageArray[0]);
                  j("#translatorSpecialization").html(speCialization[0]);
                  j("#translatorSpecialization").html(speCialization[0]);
                  j("#translatorStatus").html(speCialization[1]);
                 
                   if(speCialization[1]=="Not Available"){
                       j('#ktr_select_translator').hide();
                  }else{
                        j('#ktr_select_translator').show();
                  }
                  j('.ajaxUserInfo').show();
                 
                }
                    
          
	});
      

});
});






















 