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
public $message_customer;
public $message_customer_final;
public $admin_email;

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
<input readonly='readonly' value=" . $this->email . "class='textfield required missing' id='support_email' type='text' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' test='0' available='0'>
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
<label for='txtUserName'></label>
</div>
<div class='fLt'>
<input readonly='readonly' class='textfield required missing' id='support_customer_type' type='hidden' title='Veuillez entrer un nom d'utilisateur.' tabindex='1' size='20' maxlength='50' value='user' test='0' available='0'>
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


// 
/*public $user;
public $email;
public $issue;
public $customer_type;
public $description;
public $error_supplort;
public $form;*/

// ---------------------- SENT ADMIN EMAIL

$this->admin_email = "michaelsmuts";

 // --------------------- SEND EMAIL TO CUSTOMER
$this->message_customer='Bonjour ' . "\r\n" . "\r\n" . 'Nous avons bien recu votre demande' . "\r\n" . "\r\n"
. 'Votre demande :' . "\r\n" . "\r\n";

// ---------------------- BUILD MESSAGE

$this->message_customer_final = $this->message_customer . $this->description
. "\r\n" . "\r\n" . "L'equipe Customer Services" . "\r\n" . "CV EN ANGLAIS" . "\r\n" . "\r\n" . "clients@cv-en-anglais.com";

   //  $subject = 'le sujet'; Sender Name <sender@domain.com>
    // $message = 'Bonjour !';
     $headers = 'From: CV en anglais <clients@cv-en-anglais.com>' . "\r\n" .
     'Reply-To: clients@cv-en-anglais.com' . "\r\n" .
     'Cc: michaelsmuts@gmail.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();

if(mail($this->email, $this->issue, $this->message_customer_final, $headers)){

     //mail($to, $subject, $message, $headers);

echo "Votre message a ete bien recu, nous repondrons sous 3hrs du lundi au vendredi pour les messages recus pendant 
    les heures de bureau (CET)" . "<br><br>" . "Parfois nos emails tombent dans les boites spam donc merci verifier la votre regulierement"
. "<br><br>" . "Cordialement," . "<br><br>" . "L'equipe <i>Customer Services</i>, CV EN ANGLAIS<br><br>clients@cv-en-anglais.com";

// send email to Customer services

//$headers = 'From:' . $this->email . "\r\n" .
     //'Reply-To:' . $this->email . "\r\n" .
  //   'Reply-To:' . 'info@cv-en-anglais.com' . "\r\n" .
   //  'X-Mailer: PHP/' . phpversion();
// mail($this->admin_email, $this->issue, $this->description, $headers);

}

else{

echo "Une erreur s'est produite lors de l'envoi de votre message, <br><br>
    Merci de nous contacter en envoyant un email a customer-service@cv-en-anglais.com" .
    "Cordialement," . "<br><br>" . "L'equipe <i>Customer Services</i>, CV EN ANGLAIS";


}


}

}

}
?>
