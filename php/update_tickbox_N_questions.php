<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database

	 */

$deleteGo = new updateEntry();

$deleteGo->updateEntryNow($_POST["tick_box_val"], $_POST["id"], $_POST["user1"]);

//tick_box_val : tick_value, id : id_uni, user1 : user

class updateEntry {

//var $reference = array();

public $questionId;
public $user;
public $tickBoxValue;
public $link;
public $uniNb;

function updateEntryNow ($tickBoxValue, $questionId, $user){

 // Database connection
 //uni_num : uni_nb

// include ("classes/Cleanse/Cleanse_int.php");
 //include ("classes/Session_Start/Session_Start.php");
//ABSPATH.

$path = "http://wpc4000.amenworld.com/word2/";

 //require_once($path . "php/Db_Connect/Perform_Query.php");
 //or die("cannot connect to db ");

//require_once(ABSPATH. "php/Db_Connect/Perform_Query.php");

include("Perform_Query.php");
include("Db_Connect.php");
include("Db_info.php");

//include("trial.html");

// SET VARIABLES
//$tickBoxValue, $questionId, $user

//$this->id = $id;
$this->user = $user;
$this->questionId = $questionId;
$this->tickBoxValue = $tickBoxValue;
//$this->uniNb = $uniNb;
//$this->link = $link;

// show all chosen unis in drop down list
//user_current : user, id : id_val, name : name_text

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]
//$user, $uniId, $uniName

$go_query4 = $connection2->Update_NS_Question($this->user, $this->questionId, $this->tickBoxValue);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

//echo $go_query4;


}

// if less than 10 choices, perform select query











};

?>