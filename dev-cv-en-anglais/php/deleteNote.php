<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database
**/

$deleteNote = new deleteNote();

$deleteNote->deleteNoteNow($_POST["user_current"], $_POST["entry"]);

//defined( '_JEXEC' ) or die( 'Restricted access' );

class deleteNote {

//var $reference = array();

public $id;
public $user;
public $entry;
public $link;
public $uniNb;

function deleteNoteNow ($user, $entry){
    
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

$this->user = $user;
$this->entry = $entry;

// --------------- CHECK NB OF LINKS USER HAS ----------------------

$connection2 = new Perform_Query()
or die("connection3 failed");

$go_query3 = $connection2->deleteNote($this->user, $this->entry);

}

 
};

?>