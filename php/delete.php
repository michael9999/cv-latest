<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database

	 */

$deleteGo = new deleteEntry();

$deleteGo->deleteEntryNow($_POST["user_current"], $_POST["id"], $_POST["name"]);

//user_current : user, id : id_val, name : name_text

//defined( '_JEXEC' ) or die( 'Restricted access' );

class deleteEntry {

//var $reference = array();

public $uniId;
public $user;
public $uniName;
public $link;
public $uniNb;

function deleteEntryNow ($user, $uniId, $uniName){

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

//$this->id = $id;
$this->user = $user;
$this->uniId = $uniId;
$this->uniName = $uniName;
//$this->uniNb = $uniNb;
//$this->link = $link;

// show all chosen unis in drop down list

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]

$go_query4 = $connection2->Delete_Uni_Entry($this->user, $this->uniId, $this->uniName);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;


}

// if less than 10 choices, perform select query











};

?>