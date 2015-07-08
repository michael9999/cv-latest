<?php

$Go = new processForm();

$Go->Process_Form_Now($_POST["user"], $_POST["email"], $_POST["issue"], $_POST["customer_type"], $_POST["description"]);

//user_current : user, id_update : id, content : content_up, name : content_name
//user_current : user, id : id_val, name : name_text
//user : support_user, email : support_email, issue : support_issue, customer_type : support_customer_type, description
//defined( '_JEXEC' ) or die( 'Restricted access' );

class processForm {

//var $reference = array(); $user, $id, $content, $name

//public $uniId;
public $user;
public $email;
public $issue;
public $customer_type;
public $description;
public $error_support;
public $form;

public $ticket_id;
public $request;
public $headers;
public $ch;
public $error;
public $http_code;
public $http_result;
public $matches;

public $message;

function Process_Form_Now ($user, $email, $issue, $customer_type, $description){


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

//$this->uniNb = $uniNb;
//$this->link = $link;


//--------------------------- CHECK DATA for errors

if (empty($this->email)){

$this->error_support = 1;
//$this->email = "Email field is required";
$this->email = "";
if(substr($this->email, -1) == '/') {
    $this->email = substr($this->email, 0, -1);
}


}

if (empty($this->user)){

$this->error_support = 1;
//$this->user = "Name field is required";
$this->user = "";

}

if (empty($this->issue)){

$this->error_support = 1;
//$this->issue = "Subject field is required";
$this->issue = "";

}

if (empty($this->description)){

$this->error_support = 1;
//$this->description = "Description field is required";
$this->description = "";

}

// ------------------------------ IF THERE IS AN ERROR, SEND FORM BACK WITH VALUES ------------------

if ($this->error_support == 1){

$this->form = "<div id='error-message'>All fields are required</div><br><br><div id='support-form-holder'><form>
<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Name:</label>
</div>
<div class='fLt'>
<input id='support_user' class='textfield required missing' type='text' title='Please enter your user name.' tabindex='1' size='50' maxlength='50' value='" . $this->user . "' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Email:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' id='support_email' type='text' title='Please enter your email address.' tabindex='1' size='20' maxlength='50' value='" . $this->email . "' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Subject:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' type='text' id='support_issue' value='" . $this->issue . "' title='Please enter a subject.' tabindex='1' size='20' maxlength='50' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>



<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Client:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' readonly='readonly' value='" . $this->customer_type . "' id='support_customer_type' type='text' tabindex='1' size='20' maxlength='50' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Description:</label>
</div>
<div class='fLt'>
<textarea cols='40' class='textfield required missing' id='support_description' rows='10' type='text' title='Please enter a description here.' tabindex='1' size='20' maxlength='50' test='0' available='0'>" . $this->description . "</textarea>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<input id='support-form-button' class='support-form-field' name='submit' type='submit' value='submit' />

</form></div>";

// echo back results

echo $this->form;

}

else {

//echo "about to echo out values";
//echo $issue . $descript . $email . $customer_type;

$this->url = "http://iduk.zendesk.com/tickets.xml";

$this->customer_type = "priority customer";

$this->request = "<ticket><subject>$this->issue</subject><description>$this->description</description><requester_email>$this->email</requester_email><fields><20016371>$this->customer_type</20016371></fields><set-tags>$this->priority-customer</set-tags></ticket>";

$this->headers = array('Content-type: application/xml','Content-Length: ' . strlen($this->request));

$this->ch = curl_init();

curl_setopt($this->ch, CURLOPT_USERPWD, 'michaelsmuts@gmail.com:Appletree__22');

curl_setopt($this->ch, CURLOPT_URL, $this->url);

curl_setopt($this->ch, CURLOPT_POST, 1);

curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);

curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->request);

curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, false);

curl_setopt($this->ch, CURLOPT_HEADER, true);

$this->http_result = curl_exec($this->ch);

$this->error = curl_error($this->ch);

$this->http_code = curl_getinfo($this->ch ,CURLINFO_HTTP_CODE);

curl_close($this->ch);

if ($this->error) {


echo $this->error;

} else {

if (preg_match("/Location: .*\/tickets\/(\d*).xml/", $this->http_result, $this->matches)) {

$this->ticket_id = $this->matches[1];

$this->message = "Ticket submitted:" . $this->ticket_id ."<br><br>";

//print "Ticket submitted: $this->ticket_id\n";

$this->message.= "You can review and manage your requests here:<br><br> <a class='link-zendesk' href='http://iduk.zendesk.com/home' target='blank'> Helpdesk</a><br><br>";

$this->message.= "<a id='new-form' href='#' class='link-zendesk'>Ask another question</a>";

$this->message.= "<div id='support-form-current-type' class='" . $this->customer_type ."'></div>";
$this->message.= "<div id='support-form-current-email' class='" . $this->email ."'></div>";
$this->message.= "<div id='support-form-current-user' class='" . $this->user ."'></div>";


//$this->customer_type, $this->email, $this->user
echo $this->message;

}

else

{

 $this->message = "Location header not found";
echo $this->messsage;

}

}

}

// --------------------------------- END CURL

//$_POST["user_current"], $_POST["id_update"], $_POST["content"], $_POST["name"]

//$this->user = strip_tags($_POST["user_current"]);
//$this->user = stripslashes($this->user);
//$this->user = htmlspecialchars($this->user, ENT_QUOTES);
//$this->user = trim($this->user);

}


};

?>
