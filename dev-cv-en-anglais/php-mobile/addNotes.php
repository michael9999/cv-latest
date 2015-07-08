<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database

	 */

// CLEAN DATA

//include ("Cleanse.php");
//include ("Cleanse_int.php");

//$to_clean = array("michael1" =>"O''reilly", "Michael2" =>"mi<html><br>");
//$cleansed = array();

// ATTEMPT TO CLEAN VIA OOP, DIDN'T WORK

//echo "ok to here CLEANSE 1";

//$new_obj = new Cleanse_int();

//$to_clean = $_POST;

//echo "ok to here CLEANSE 2";

//echo"<br>Check contents of TO_CLEAN VARIABLE:";

//echo"<br>Title:";
//echo $to_clean["title"];

//echo"<br>Note:";
//echo $to_clean["note"];
//echo"<br>";

//$clean_data = array();

//$clean_data = $new_obj->send_cleanse($to_clean);


//echo "Check contents of returned data";

//echo $clean_data["Michael2"];
//echo"<br>Title:";
//echo $clean_data["title"];
//echo"<br>Note:";
//echo $clean_data["note"];
// END CLEAN DATA

$Go = new addNote();

//$Go->Add_Notes_Now($_POST["user_current"], $_POST["title"], $_POST["note"]);

// ---------------------- CLEAN DATA ------------------------

$clean_data = array();

$clean_data["title"] = strip_tags($_POST["title"]);
$clean_data["title"] = stripslashes($clean_data["title"]);
$clean_data["title"] = htmlspecialchars($clean_data["title"], ENT_QUOTES);
$clean_data["title"] = trim($clean_data["title"]);
//$clean_data["title"] = mysql_real_escape_string($clean_data["title"]);

$clean_data["note"] = strip_tags($_POST["note"]);
$clean_data["note"] = stripslashes($clean_data["note"]);
$clean_data["note"] = htmlspecialchars($clean_data["note"], ENT_QUOTES);
$clean_data["note"] = trim($clean_data["note"]);
//$clean_data["note"] = mysql_real_escape_string($clean_data["note"]);


$clean_data["user_current"] = strip_tags($_POST["user_current"]);
$clean_data["user_current"] = stripslashes($clean_data["user_current"]);
$clean_data["user_current"] = htmlspecialchars($clean_data["user_current"], ENT_QUOTES);
$clean_data["user_current"] = trim($clean_data["user_current"]);
//$clean_data["user_current"] = mysql_real_escape_string($clean_data["user_current"]);


//echo $clean_data["title"];
//echo $clean_data["note"];

//strip_tags($value);
            //$value = stripslashes($value);
            //$value = htmlspecialchars($value);
            //$value = mysql_real_escape_string($value);
            //$value = trim($value);
   // SHOULD BE $cleaned_data instead of $value

            //$cleansed[$key] = $value;
            //$cleansed[$key] = $value;
            //echo "<br><br>echo out array(in Loop):";
            //echo $cleansed[$key];

  //      }

//return $cleansed;

//};


//$clean_data = Clean($_POST);

//echo

// END FOREACH

// -------------- END CLEAN
$Go->Add_Notes_Now($clean_data["user_current"], $clean_data["title"], $clean_data["note"]);


//user_current : user, id : id_val, name : name_text
//user_current : user, id : id_val, name : name_text

//defined( '_JEXEC' ) or die( 'Restricted access' );

class addNote {

//var $reference = array();

//public $uniId;
public $user;
public $title;
public $note;
//public $uniNb;

function Add_Notes_Now ($user, $title, $note){

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
$this->title = $title;
$this->note = $note;
//$this->uniNb = $uniNb;
//$this->link = $link;

// show all chosen unis in drop down list
//user_current : user, id : id_val, name : name_text

$connection2 = new Perform_Query()
or die("connection4 failed");

//$_POST["user_current"]
//$user, $uniId, $uniName

$go_query4 = $connection2->Add_Notes($this->user, $this->title, $this->note);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;


}

// if less than 10 choices, perform select query


};

?>
