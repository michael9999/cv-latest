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

$this->form = "<html><br><br><div id='error-message'>All fields are required please / Tous les champs sont obligatoires </div><br><div id='support-form-holder'><form>
<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Name:</label>
</div>
<div class='fLt'>
<input id='support_user' class='textfield required missing' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='50' maxlength='50' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Email:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' id='support_email' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>


<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Subject:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' id='support_issue' value='' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>



<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Client:</label>
</div>
<div class='fLt'>
<input class='textfield required missing' id='support_customer_type' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' value='user' test='0' available='0'>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<div class='fld_rw'>
<div class='fLt fld_lbl'>
<label for='txtUserName'>Description:</label>
</div>
<div class='fLt'>
<textarea cols='40' class='textfield required missing' id='support_description' rows='10' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' test='0' available='0'>TEST Enter a description of the problem</textarea>
<div class='bodyTextSmall'>
</div>
</div>
</div>

<input id='support-form-button' class='support-form-field' name='submit' type='submit' value='submit' />

</form></div></html>";

// echo back results

echo $this->form;

}

else {


// SEND EMAIL TO CUSTOMER AND TO CUSTOMER SERVICES
/*public $user;
public $email;
public $issue;
public $customer_type;
public $description;
public $error_support;
public $form;*/

 //$to = $email;
   //  $subject = 'le sujet';
    // $message = 'Bonjour !';
     $headers = 'From: michaelsmuts@gmail.com' . "\r\n" .
     'Reply-To: michaelsmuts@gmail.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();

mail($this->email, $this->issue, $this->description, $headers);


     //mail($to, $subject, $message, $headers);



echo "success";


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
