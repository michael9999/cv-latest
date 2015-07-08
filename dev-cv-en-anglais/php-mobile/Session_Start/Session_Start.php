<?php Session_start();
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session_Start
 *
 * @author michael
 */
 

class Session_Start {
    //put your code here

/*public $user;
public $password; */

public $name;
public $surname;
public $query;
public $go_query;

public $logged_in;
public $employee;
public $email;


public function Start_Session($name, $surname){

$this->name = $name;
$this->surname = $surname;
$this->query = $query;
$this->go_query= $go_query;

// CREATES NEW QUERY OBJECT

$this->query = new Perform_Query();

// SENDS DATA TO MESSAGE FUNCTION WITH Perform_Query

$this->go_query = $this->query->Session_Start($name, $surname);

}


public function Register_Session_Variables($name, $surname, $employee, $email){

$this->name = $name;
$this->surname = $surname;
$this->logged_in = $logged_in;

// Employee number

$this->employee  = $surname;


$this->email = $email;


// STARTS SESSION AND SETS SESSION VARIABLES

$_SESSION['logged_in'] = "yes";
$_SESSION['name']=$this->name;
$_SESSION['surname']=$this->surname;
$_SESSION['employee']=$this->employee;
$_SESSION['email']=$this->email;

//echo $_SESSION['email'];
//echo $_SESSION['surname'];
}




}
?>
