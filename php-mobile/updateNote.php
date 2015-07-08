<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database

	 */

$Go = new updateNotes();

$Go->Update_Notes_Now($_POST["user_current"], $_POST["id_update"], $_POST["content"], $_POST["name"]);

//user_current : user, id_update : id, content : content_up, name : content_name
//user_current : user, id : id_val, name : name_text

//defined( '_JEXEC' ) or die( 'Restricted access' );

class updateNotes {

//var $reference = array(); $user, $id, $content, $name

//public $uniId;
public $user;
public $id;
public $content;
public $name;

function Update_Notes_Now ($user, $id, $content, $name){

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

$this->id = $id;
$this->user = $user;
$this->name = $name;
$this->content = $content;
//$this->uniNb = $uniNb;
//$this->link = $link;

// show all chosen unis in drop down list
//user_current : user, id : id_val, name : name_text

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]
//$user, $uniId, $uniName $user, $id, $content, $name

//--------------------------- CLEAN DATA

//$_POST["user_current"], $_POST["id_update"], $_POST["content"], $_POST["name"]

$this->user = strip_tags($_POST["user_current"]);
$this->user = stripslashes($this->user);
$this->user = htmlspecialchars($this->user, ENT_QUOTES);
$this->user = trim($this->user);

$this->id = strip_tags($_POST["id_update"]);
$this->id = stripslashes($this->id);
$this->id = htmlspecialchars($this->id, ENT_QUOTES);
$this->id = trim($this->id);

$this->content = strip_tags($_POST["content"]);
$this->content = stripslashes($this->content);
$this->content = htmlspecialchars($this->content, ENT_QUOTES);
$this->content = trim($this->content);

$this->name = strip_tags($_POST["name"]);
$this->name = stripslashes($this->name);
$this->name = htmlspecialchars($this->name, ENT_QUOTES);
$this->name = trim($this->name);

// END CLEAN

$go_query4 = $connection2->Update_Notes($this->user, $this->id, $this->content, $this->name);


//$go_query4 = $connection2->Update_Notes($this->user, $this->id, $this->content, $this->name);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;


}

// if less than 10 choices, perform select query


};

?>
