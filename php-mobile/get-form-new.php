<?php

$Go = new createForm();
//customer_type : support_customer_type, type1 : type, user : support_user, email : support_email
//customer_type : support_customer_type, type1 : type, user : support_user, email : support_email
$Go->Create_Form_Now($_POST["type1"], $_POST["customer_type"], $_POST["user"], $_POST["email"]);

class createForm {

public $user;
public $email;
public $issue;
public $customer_type;
public $description;
public $error_support;
public $form;
public $type;
public $return_data;
public $ticket_id;
public $request;
public $headers;
public $ch;
public $error;
public $http_code;
public $http_result;
public $matches;
public $current_user;


public $message;
//$_POST["type1"], $_POST["support_customer_type"], $_POST["user"], $_POST["email"]
//customer_type : support_customer_type, type1 : type, user : support_user, email : support_email
function Create_Form_Now ($type, $customer_type, $user, $email){


//include("Perform_Query.php");
//include("Db_Connect.php");
//include("Db_info.php");

//include("trial.html");

// SET VARIABLES
//$user, $email, $issue, $customer_type, $description

$this->email = $email;
$this->user = $user;
$this->issue = $issue;
$this->customer_type = $customer_type;
$this->description = $description;
$this->error_support = 0;
$this->type = $type;

//$this->uniNb = $uniNb;
//$this->link = $link;


//--------------------------- Check if new form has been requested

if ($this->type == "new-form"){


    //
if ($this->customer_type == "priority-customer"){
    
    $this->customer_type = "priority-customer";
    
}

else {

    $this->customer_type = "user";

}

}

// create form with email, user, customer-type info added in

$this->return_data ="<form>
<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Name:</label>
</div>
<div class='fLt'>
<input id='support_user' class='textfield required missing' type='text' title='Please enter your user name.' tabindex='1' size='50' maxlength='50' value=" . $this->user . " name='Wc_Form_Join' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Email:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' id='support_email' type='text' title='Please enter your email address.' tabindex='1' size='20' maxlength='50' name='Wc_Form_Join' value=" . $this->email . " test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Subject:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' type='text' id='support_issue' value='" . $this->issue . "' title='Please enter a subject.' tabindex='1' size='20' maxlength='50' name='Wc_Form_Join' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>



<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Client:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' readonly='readonly' value=" . $this->customer_type . " id='support_customer_type' type='text' tabindex='1' size='20' maxlength='50' name='Wc_Form_Join' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Description:</label>
</div>
<div class='fLt'>
<textarea cols='40' class='textfield required missing' id='support_description' rows='10' type='text' title='Please enter a description here.' tabindex='1' size='20' maxlength='50' name='Wc_Form_Join' test='0' available='0'>" . $this->description . "</textarea>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<input id='support-form-button' class='support-form-field' name='submit' type='submit' value='submit' />

</form>";

// return to WP

echo $this->return_data;







}
}


?>