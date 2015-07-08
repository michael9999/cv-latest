

<script> alert(" <?php echo $_POST["user_current"]; ?> "); </script>
<?php
$addUniGo = new addUni();

$addUniGo->addUniNow($_POST["user_current"], $_POST["uni_name"], $_POST["uni_nb"]);



//defined( '_JEXEC' ) or die( 'Restricted access' );

class addUni {

//var $reference = array();

public $id;
public $user;
public $name;
public $link;
public $uniNb;

function addUniNow ($user, $nameUni, $uniNb){
   
 // Database connection

// include ("classes/Cleanse/Cleanse_int.php");
 //include ("classes/Session_Start/Session_Start.php");
//ABSPATH.

$path = "http://localhost/wp";

 //require_once($path . "php/Db_Connect/Perform_Query.php");
 //or die("cannot connect to db ");
 
//require_once(ABSPATH. "php/Db_Connect/Perform_Query.php");

include("Perform_Query.php");
include("Db_Connect.php");
include("Db_info.php");

//include("trial.html");

// SET VARIABLES

//$this->id = $id;
$this->user = $user;
$this->nameUni = $nameUni;
$this->uniNb = $uniNb;
//$this->link = $link;

// --------------- CHECK NB OF LINKS USER HAS ----------------------

$connection2 = new Perform_Query()
or die("connection3 failed");

$go_query3 = $connection2->Check_Nb_Unis($this->user, $this->uniNb, $this->nameUni);

// if there are more than 10, send back error msg to main program

if($go_query3=="no"){

$go_query2 = "Vous avez atteint votre limite de choix (10), merci d'en supprimer";
$go_query2 .= "<br><br>";
echo $go_query2;

// show all chosen unis in drop down list

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]

$go_query4 = $connection2->Select_All_Unis($this->user, $this->uniNb, $this->nameUni);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;


}
// END, CHECK NB OF LINKS

// if less than 10 choices, perform select query

else {

// --------------------------- CHECK IF USER HAS ALREADY CHOSEN THIS UNIVERSITY ----------------

$connection2 = new Perform_Query()
or die("connection3 failed");

$go_query6 = $connection2->Check_Choice_Exist($this->user, $this->uniNb, $this->nameUni);


// if the university has already been chosen, send back error msg to main program

if($go_query6=="no"){

$go_query5 = "Vous avez deja selectionne cet etablissement";
$go_query5 .= "<br><br>";
echo $go_query5;

// show all chosen unis in drop down list

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]

$go_query4 = $connection2->Select_All_Unis($this->user, $this->uniNb, $this->nameUni);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;

// END CHECK IF CHOICE ALREADY EXISTS

}

// END, CHECK NB OF LINKS

// if less than 10 choices, perform select query

else {

// ---------------------------- ADD NON SPECIFIC QUESTIONS TO ns_questions table ------------------

$connection_ns_questions = new Perform_Query()
or die("connection_ns_questions failed");

//PASSES USER NAME INTO FUNCTION
//$go_query2 = $connection2->Select_All_Link($clean_data['user1']);
$query_ns_questions = $connection_ns_questions->Add_Ns_Questions($this->user, $this->uniNb, $this->nameUni);
//or die ("problem calling query1");

// RETURNS RESULT

//return $reference1;
//return $go_query2;
//echo $query_ns_questions;


// END ADD NON SPECIFIC QUESTIONS

// -------------------------------------- ADD CHOSEN UNIVERSITY TO LIST ------------------------

$connection2 = new Perform_Query()
or die("connection3 failed");

//PASSES USER NAME INTO FUNCTION
//$go_query2 = $connection2->Select_All_Link($clean_data['user1']);
$go_query2 = $connection2->Add_Uni($this->user, $this->uniNb, $this->nameUni);
//or die ("problem calling query1");

// RETURNS RESULT

//return $reference1;
//return $go_query2;
echo $go_query2;


// END ADD CHOSEN UNI

// ------------------------------ SPECIFIC QUESTIONS TO DATABASE -------------------

$connection2 = new Perform_Query()
or die("connection3 failed");

//PASSES USER NAME INTO FUNCTION

$go_query2 = $connection2->Add_Specific_Questions($this->user, $this->uniNb, $this->nameUni);
//or die ("problem calling query1");

// RETURNS RESULT

//return $reference1;
//return $go_query2;
//echo $go_query2;


// END, ADD UNIVERSITY








// END, ADD UNI-SPECIFIC QUESTIONS
}

}

}






 
};

?>