<?php


$Go = new addLink();


$Go->Add_Link_Now($_POST["user1"], $_POST["link_name1"], $_POST["link_address1"]);




class addLink {

//var $reference = array();

//public $uniId;
public $user;
public $link_name;
public $link_address;
//public $uniNb;

function Add_Link_Now ($user, $link_name, $link_address){

$path = "http://wpc4000.amenworld.com/word2/";

include("Perform_Query.php");
include("Db_Connect.php");
include("Db_info.php");

// SET VARIABLES

//$this->id = $id;
$this->user = $user;
$this->link_name = $link_name;
$this->link_address = $link_address;

// ---------------------- CLEAN DATA ------------------------

$this->user = strip_tags($this->user);
$this->user = stripslashes($this->user);
$this->user = htmlspecialchars($this->user, ENT_QUOTES);
$this->user = trim($this->user);
//$clean_data["title"] = mysql_real_escape_string($clean_data["title"]);

$this->link_name = strip_tags($this->link_name);
$this->link_name = stripslashes($this->link_name);
$this->link_name = htmlspecialchars($this->link_name, ENT_QUOTES);
$this->link_name = trim($this->link_name);
//$clean_data["note"] = mysql_real_escape_string($clean_data["note"]);

$this->link_address = strip_tags($this->link_address);
$this->link_address = stripslashes($this->link_address);
$this->link_address = htmlspecialchars($this->link_address, ENT_QUOTES);
$this->link_address = trim($this->link_address);


// -------------- END CLEAN


$connection2 = new Perform_Query()
or die("connection4 failed");


$go_query4 = $connection2->Add_Link($this->user, $this->link_name, $this->link_address);

//$go_query4 = $connection4->Select_All_Unis($_POST["user_current"], $this->uniNb, $this->nameUni);

echo $go_query4;


}

// if less than 10 choices, perform select query


};

?>
