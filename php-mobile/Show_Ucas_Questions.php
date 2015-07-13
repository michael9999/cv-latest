<?php
//print "<pre>".print_r($_POST, true)."</pre>";

/**
	 * This fetches, updates and deletes links from the database

	 */

$Go = new Show_Ucas_Questions();

$Go->Show_Ucas_Questions_Now($_POST["user_current"]);

//user_current : user, id : id_val, name : name_text
//user_current : user, id : id_val, name : name_text

//defined( '_JEXEC' ) or die( 'Restricted access' );

class Show_Ucas_Questions {


public $user;


function Show_Ucas_Questions_Now ($user){

include("Perform_Query.php");
include("Db_Connect.php");
include("Db_info.php");

// SET VARIABLES


$this->user = $user;

$connection2 = new Perform_Query()
or die("connection4 failed");

$go_query4 = $connection2->Get_Ucas_Questions($this->user);

//Get_Ucas_Questions

echo $go_query4;


}

// if less than 10 choices, perform select query


};

?>
