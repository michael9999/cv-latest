<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * BUILDS QUERY AND THEN PERFORMS IT
 * EACH FUNCTION IS CORRESPONDS TO A PARTICULAR QUERY
 *
 * @author michael
 */

//include("Db_Connect.php");
//or die("can not included db_connect.php");

class Perform_Query {

public $open_db;
public $new_connection;
public $user;
public $password;
public $result;
public $row;
public $name;
public $surname;
public $id;
public $linkarray;
public $link;
public $nbRow;
public $backButton;
public $forwardButton;
public $backButtonStatus;
public $forwardButtonStatus;
public $uniNb;
public $uniName;
public $uniId;
public $string=NULL;

public function Login_Check($user, $password)

{

// SET QUERY ELEMENTS

$this->row = $row;
$this->user = $user;
$this->password = $password;
$this->result = $result;
//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY

            $query = "SELECT* FROM login WHERE Login = sha1('$this->user')
                        AND Password = sha1('$this->password')";
            $result = mysql_query($query)
            or die ("Query did not run");
            $this->row=mysql_fetch_array($result, MYSQL_ASSOC);
            $numrows1 = mysql_num_rows($result);
            //echo $result['Surname'];
            //or die ("row count failed");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            if ($numrows1 =="1") {

                //$this->result = "OK";
                $this->row['result'] = "OK";
                //echo $this->row['Surname'];
            }

            else {

                //$this->result ="NO";

                $this->row['result'] = "NO";

            }

            /*while($row = mysql_fetch_array($result)){


             }*/
             return $this->row;

        }

// ----------------------- DELETE LINK ----------------------------
public function Delete_Link($user, $link1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->link1 = $link1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "DELETE from links WHERE (id = '$this->link1')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

$string = "link deleted";


echo $string;


}

// END DELETE LINK ----------------------------

// -------------------------- DELETE NOTE

public function deleteNote($user, $entry)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
$this->user = $user;
$this->entry = $entry;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "DELETE from notes WHERE (id = '$this->entry')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

$string = "link deleted";


echo $string;


}

// end delete note



// --------------------------- START DELETE ENTRY (UNI) ----------------

public function Delete_Uni_Entry($user, $uniId, $uniName)

{

//$uniNb=NULL;
//$string=NULL;

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
$this->uniId = $uniId;
$this->uniName = $uniName;
$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: DELETES UNI FROM LIST OF CHOICES
// note, had to use pass uni_nb through as uni_ID as jquery had error

            //$query = "DELETE from choices WHERE (id = '$this->uniId') AND (user = '$this->user')";
            $query = "DELETE from choices WHERE (uni_nb = '$this->uniId') AND (user = '$this->user')";
            $result = mysql_query($query)
            or die ("Error: delete uni entrym, sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// end delete uni

// DELETE SPECIFIC QUESTIONS

            $query = "DELETE from s_questions WHERE (uni_nb = '$this->uniId') AND (user = '$this->user')";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

$string = $this->uniName . " deleted";


echo $string;


}


// END DELETE UNI ENTRY


// --------------------------- UPDATE UNI ENTRY, CHANGE TO ACTIVE AND DEACTIVATE OTHERS
// $this->user, $this->uniId, $this->uniName
public function Update_Uni_Entry($user, $uniId, $uniName)

{


$uniNb=NULL;
// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
$this->uniId = $uniId;
$this->uniName = $uniName;
$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// START: set all entries to inactive

// PERFORM QUERY: DELETES UNI FROM LIST OF CHOICES
// note, had to use pass uni_nb through as uni_ID as jquery had error

            //$query = "DELETE from choices WHERE (id = '$this->uniId') AND (user = '$this->user')";
            $query = "UPDATE choices SET status = 'inactive'";
            $result = mysql_query($query)
            or die ("Error1: update active uni choice. Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");


// PERFORM QUERY: SETS CHOSEN UNI AS ACTIVE
// note, had to use pass uni_nb through as uni_ID as jquery had error

            //$query = "DELETE from choices WHERE (id = '$this->uniId') AND (user = '$this->user')";
            $query = "UPDATE choices SET status = 'active' WHERE (uni_nb = '$this->uniId') AND (user = '$this->user')";
            $result = mysql_query($query)
            or die ("Error2: update active uni choice. Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// end delete uni

// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from s_questions WHERE (uni_nb = '$this->uniId') AND (user = '$this->user') AND (link_section = 'finance') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/


$response = "<form id='specific_questions' >";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST
//$response .= "<option id=" . $obj['id'] . ">" . $obj['uni_name'] . "</option>";

//$response .= "<option id=" . $obj['id'] . " name=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";
//$response .= "<input type='checkbox' id=" . $obj['id'] . " checked=" . $obj['response'] . "><a href=" . $obj['link'] . " id=" . $obj['link_section'] . ">" . $obj['link_name'] . "</a><br />";

//$response .= "<input type='checkbox' id=" . $obj['id'] . " " . $obj['response'] . "><a href=" . $obj['link'] . " id=" . $obj['link_section'] . ">" . $obj['link_name'] . "</a><br />";

$response .= "<input type='checkbox' id=" . $obj['id'] . " " . $obj['response'] . "><label for=". $obj['id'] . " " . $obj['response'] .">". $obj['link_name'] . "</label>";
$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";


//$response .= "<option id=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";

        //<option selected="true">Medium
  //<option>Large
  //<option>X-Large$categories[$i] = $obj['id'];
        //$categories[$i]['uni_name'] = $obj['uni_name'];
        //$categories[$i]['user'] = $obj['user'];
        //$categories[$i]['uni_nb'] = $obj['uni_nb'];
        //$categories[$i]['link'] = $obj['link'];
        //$categories[$i]['msg'] = "Your choice has been added";
        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;

// end build string


//$string = $this->uniName . " updated";


//echo $string;


}

// END UPDATE UNI ENTRY

// ----------------------------- UPDATE NOTES

public function Update_Notes($user, $id, $content, $name)

{

// SET QUERY ELEMENTS, $this->user, $this->id, $this->content, $this->name
//$this->uniNb

$this->user = $user;
$this->id = $id;
$this->content = $content;
$this->name = $name;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

echo "This is the note name: " . $this->name . "<br><br>";
echo "This is the content: " . $this->content . "<br><br>";
echo "This is the id: " . $this->id . "<br><br>";
echo "This is the user: " . $this->user . "<br><br>";

//$query = "UPDATE notes SET name = '$this->name', content = '$this->content',  WHERE (id = '$this->id') AND (user = '$this->user')";

$query = "UPDATE notes SET name = '$this->name', content = '$this->content'  WHERE (id = '$this->id')";

            $result = mysql_query($query)
            or die ("Error1: update active uni choice. Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
//echo "update complete";
}

// end update notes

//----------------------------- UPDATE LINK

public function Update_Link($user, $id, $link_address, $link_name)

{

// SET QUERY ELEMENTS, $this->user, $this->id, $this->content, $this->name
//$this->uniNb

$this->user = $user;
$this->id = $id;
$this->link_address = $link_address;
$this->link_name = $link_name;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//echo "This is the note name: " . $this->link_name . "<br><br>";
//echo "This is the content: " . $this->link_address . "<br><br>";
//echo "This is the id: " . $this->id . "<br><br>";
//echo "This is the user: " . $this->user . "<br><br>";

//$query = "UPDATE notes SET name = '$this->name', content = '$this->content',  WHERE (id = '$this->id') AND (user = '$this->user')";

$query = "UPDATE links SET name = '$this->link_name', link = '$this->link_address'  WHERE (id = '$this->id') AND (user = '$this->user')";

            $result = mysql_query($query)
            or die ("Error: unable to update link .");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

}




//-- end update link

//------------------------------ GET SPECIFIC QUESTIONS


public function Get_S_Questions($user)

{

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
//$this->uniId = $uniId;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section='contenu') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/


$response = "<form id='specific_questions'>";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST

$test_structure = utf8_encode($obj['link_name']);

//$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' id='hello' checked=" . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " checked=" . $obj['response'] . ">". $obj['link_name'] . "</label>";

$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' class='testnew' id=" . $obj['id'] . " " . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " height=" . $obj['response'] . ">". $test_structure . "</label>";


//$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";
$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>&nbsp;Visiter &nbsp; : &nbsp;</span><span>" . $test_structure . "</span></a>";


$response .="</div>";

        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}


//------------------------------ END SPECIFIC QUESTIONS

//------------------------------ SHOW NON SPECIFIC QUESTIONS


public function Get_NS_Questions($user)

{

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
//$this->uniId = $uniId;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section='prelim') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/


$response = "<form id='non_specific_questions'>";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST
//$response .= "<option id=" . $obj['id'] . ">" . $obj['uni_name'] . "</option>";

//$response .= "<option id=" . $obj['id'] . " name=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";
//$response .= "<input type='checkbox' id=" . $obj['id'] . " checked=" . $obj['response'] . "><a href=" . $obj['link'] . " id=" . $obj['link_section'] . ">" . $obj['link_name'] . "</a><br />";

$response .= "<input type='checkbox' id=" . $obj['id'] . " " . $obj['response'] . "><label for=". $obj['id'] . " " . $obj['response'] .">". $obj['link_name'] . "</label>";
$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";

        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}
// END, SHOW NON SPECIFIC QUESTIONS


//------------------------------ SHOW UCAS SPECIFIC QUESTIONS


public function Get_Ucas_Questions($user)

{

$this->user = $user;


$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS
// $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section='start') ORDER BY quest_nb";

            $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section = 'start') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");


// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*


*/


$response = "<form id='non_specific_questions'>";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST

$test_structure = utf8_encode($obj['link_name']);

$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' class='testnew' id=" . $obj['id'] . " " . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " height=" . $obj['response'] . ">". $test_structure . "</label>";

$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>&nbsp;Visiter &nbsp; : &nbsp;</span><span>" . $test_structure . "</span></a>";


$response .="</div>";

        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}
// END, SHOW NON SPECIFIC QUESTIONS


//------------------------------ SHOW ENGLISH QUESTIONS


public function Get_English_Questions($user)

{

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
//$this->uniId = $uniId;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section = 'advanced') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/


$response = "<form id='non_specific_questions'>";

while ($obj = mysql_fetch_array($result))
{

$test_structure = utf8_encode($obj['link_name']);

//$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' id='hello' checked=" . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " checked=" . $obj['response'] . ">". $obj['link_name'] . "</label>";

$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' class='testnew' id=" . $obj['id'] . " " . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " height=" . $obj['response'] . ">". $test_structure . "</label>";


//$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";
$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>&nbsp;Visiter &nbsp; : &nbsp;</span><span>" . $test_structure . "</span></a>";


$response .="</div>";



//$response .= "<input type='checkbox' id=" . $obj['id'] . " " . $obj['response'] . "><label for=". $obj['id'] . " " . $obj['response'] .">". $obj['link_name'] . "</label>";
//$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";


        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}
// END, SHOW ENGLISH QUESTIONS

//------------------------------ SHOW ENGLISH QUESTIONS

//Get_Before_You_Leave
public function Get_Before_You_Leave($user)

{

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
//$this->uniId = $uniId;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from ns_questions WHERE (user = '$this->user') AND (link_section = 'structure') ORDER BY quest_nb";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/


$response = "<form id='non_specific_questions'>";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST
//$response .= "<option id=" . $obj['id'] . ">" . $obj['uni_name'] . "</option>";
$test_structure = utf8_encode($obj['link_name']);
//$response .= "<option id=" . $obj['id'] . " name=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";
//$response .= "<input type='checkbox' id=" . $obj['id'] . " checked=" . $obj['response'] . "><a href=" . $obj['link'] . " id=" . $obj['link_section'] . ">" . $obj['link_name'] . "</a><br />";

//$response .= "<input type='checkbox' id=" . $obj['id'] . " " . $obj['response'] . "><label for=". $obj['id'] . " " . $obj['response'] .">". $obj['link_name'] . "</label>";

$response .= "<div class='test222' id=" . $obj['id'] . " for=". $obj['response'] ."><input type='checkbox' class='testnew' id=" . $obj['id'] . " " . $obj['response'] . "><label class='ui-btn ui-btn-icon-left ui-btn-corner-all ui-btn-up-c ui-checkbox-off' for=". $obj['id'] . " height=" . $obj['response'] . ">". $test_structure . "</label>";


//$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";
$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>&nbsp;Visiter &nbsp; : &nbsp;</span><span>" . $test_structure . "</span></a>";


$response .="</div>";


//$response .="<a href=" . $obj['link'] . " data-role='button' class='checkBoxLink'><span class='checkBoxLinkVisit'>Visit &nbsp; : &nbsp;</span><span>" . $obj['link_name'] . "</span></a>";


        $i++;
}

$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}
// END, SHOW BEFORE YOU LEAVE QUESTIONS








public function Get_Notes($user)

{

$string=NULL;

// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
//$this->uniId = $uniId;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from notes WHERE (user = '$this->user') ORDER BY id";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/

//$response ="<h3>Notes <a href='#' id='notes-add'>+ Add</a></h3>";

//$response .= "<div id='notes-item2' style='width:180px';>";

//$response .= "<table class='note_table' width='200px'><tr><th></th><th></th></tr>";

while ($obj = mysql_fetch_array($result))
{

$string .= "<tr class='test_link_delete' id='". $obj['id'] ."'><td width='80%'><div id='". $obj['id'] ."' style='". $obj['id'] ."'><a data-role='button' href='". $obj['id'] ."' id='notes-each' style='". $obj['id'] ."' target='_blank'>". $obj['name'] ."</a></div></td>";


$string .= "<td width='15%'><div id='id' style='". $obj['id'] ."'><a data-role='button' class='". $obj['id'] ."' id='delete-button' style='". $obj['id'] ."'>x</a></td></tr></div>";


        $i++;
}

//$response .= "</table></div>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $string;

}
// END, SHOW NON SPECIFIC QUESTIONS


//




public function Get_Full_Notes($user, $id)

{



// SET QUERY ELEMENTS
//$this->uniNb

$this->user = $user;
$this->id = $id;
//$this->uniName = $uniName;
//$this->uniNb = $uniNb;
//Get_Full_Notes($this->user, $this->id);
//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();


// SELECT SPECIFIC QUESTIONS

            $query = "SELECT* from notes WHERE (user = '$this->user') AND (id = '$this->id') ORDER BY id";
            $result = mysql_query($query)
            or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// end delete specific questions

// BUILD LIST OF TICK BOXES WITH LINKS

$i = "1";

/*

<form>
<input type="checkbox" name="vehicle" value="Bike" /> I have a bike<br />
<input type="checkbox" name="vehicle" value="Car" /> I have a car
</form>
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb


*/

$response = "<td id='update_note_full'>";
//$response .= "<a href='#' id='note-back'>< Retour</a><br /><br />";
            

$response .= "<form id='notes-item2'>";

while ($obj = mysql_fetch_array($result))
{
     // BUILD COMBO LIST
//$response .= "<option id=" . $obj['id'] . ">" . $obj['uni_name'] . "</option>";
$response .= "<a href='#' id='back' data-role='button'>< Retour</a><br /><br />";
//$response .= "<option id=" . $obj['id'] . " name=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";
$response .= "Name: <input type='textbox' style=" . $obj['id'] . " class='link_add_address ui-input-text ui-body-c ui-corner-all ui-shadow-inset' id='name-update' value=" . $obj['name'] . "><br /><br />";
$response .= "Note: <br /><textarea id='update-content' rows='7' cols='20'>" . $obj['content'] . " </textarea> <br /><br />";
$response .= "<input type='submit' style=" . $obj['id'] . " value='Update' id='update-save' class=" . $obj['id'] . "><br />";


        $i++;
}

$response .= "</form>";
$response .= "</td>";


//$response .= "</form>";
//$response .= "<a href='#' id='delete'>Supprimer</a>";

            //return $response;
            echo $response;



}
// END, SHOW NON SPECIFIC QUESTIONS

// ----------------------------- GET FULL LINK FOR UPDATE

public function Get_Full_Link($user1, $id)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
$this->id = $id;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from links WHERE (user = '$this->user1') AND (id = '$this->id') ";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND
$string = "<td id='update_link_full'>";
$string .= "<a href='#' id='link-back' data-role='button'>< Retour</a><br /><br />";
            $string .= "<form id='link'>";

if (mysql_num_rows($result) > 0){
  while($row = mysql_fetch_object($result)){

    //echo $row->id;
    //echo $row->user;
    //echo $row->link;

    $string .= "Name:<br> <input type='textbox' class='link_add_address ui-input-text ui-body-c ui-corner-all ui-shadow-inset' id='link_name' value='".$row->name."'><br><br>";

    $string .= "Address:<br> <input type='textbox' class='link_add_address ui-input-text ui-body-c ui-corner-all ui-shadow-inset' id='link_link' value='".$row->link."'><br><br>";

    $string .= "<input type = 'submit' id='link_submit' style='".$row->id."' class='".$row->id."' value ='update'>";
    //$string .= "<tr><td><div id='test2'><a href='#' id='id'>".$row->id."</a></div></td>";

    //$string .= $row->phone."</a>";
    //$string .= "<br/>\n";



  }

$string .= "</form>";
$string .= "</td>";

}

//echo $string;

return $string;

}

// END GET FULL LINK FOR UPDATE

// ------------------------------ UPDATE S_QUESTION

public function Update_S_Question($user, $questionId, $tickBoxValue)

{

// SET QUERY ELEMENTS
//$this->user, $this->questionId, $this->tickBoxValue

$this->user = $user;
$this->questionId = $questionId;
$this->tickBoxValue = $tickBoxValue;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//------------------- CLEAN DATA ----------------------------

// end clean data


// UPDATE QUERY: UPDATES SPECIFIC QUESTIONS
// note, had to use pass uni_nb through as uni_ID as jquery had error

            //$query = "DELETE from choices WHERE (id = '$this->uniId') AND (user = '$this->user')";
            $query = "UPDATE ns_questions SET response = '$this->tickBoxValue' WHERE (id = '$this->questionId') AND (user = '$this->user')";
            $result = mysql_query($query)
            or die ("Error2: update active uni choice. Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// SELECT SPECIFIC QUESTIONS

           // $query = "SELECT* from s_questions WHERE (uni_nb = '$this->uniId') AND (user = '$this->user') ORDER BY quest_nb";
           // $result = mysql_query($query)
           // or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// BUILD LIST OF TICK BOXES WITH LINKS


            //return $response;
            //echo $response;

// end build string


//$string = $this->uniName . " updated";


//echo $string;


}

// END S_QUESTION

//----------------------------- UPDATE TICKBOX NON SPECIFIC QUESTIONS

public function Update_NS_Question($user, $questionId, $tickBoxValue)

{

// SET QUERY ELEMENTS
//$this->user, $this->questionId, $this->tickBoxValue

$this->user = $user;
$this->questionId = $questionId;
$this->tickBoxValue = $tickBoxValue;
//$this->uniNb = $uniNb;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//------------------- CLEAN DATA ----------------------------

// end clean data


// UPDATE QUERY: UPDATES SPECIFIC QUESTIONS
// note, had to use pass uni_nb through as uni_ID as jquery had error

            //$query = "DELETE from choices WHERE (id = '$this->uniId') AND (user = '$this->user')";
            $query = "UPDATE ns_questions SET response = '$this->tickBoxValue' WHERE (id = '$this->questionId') AND (user = '$this->user')";
            $result = mysql_query($query)
            or die ("Error2: update active uni choice. Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// SELECT SPECIFIC QUESTIONS

           // $query = "SELECT* from s_questions WHERE (uni_nb = '$this->uniId') AND (user = '$this->user') ORDER BY quest_nb";
           // $result = mysql_query($query)
           // or die ("Error: delete s_questions, sorry, an error has occurred, please try again later.");

// BUILD LIST OF TICK BOXES WITH LINKS


            //return $response;
            //echo $response;

// end build string


//$string = $this->uniName . " updated";


//echo $string;


}

// END NON-SPECIFIC QUESTIONS



// ---------------------------- START SESSION ---------------------

public function Session_Start($name, $surname)

{

// SET QUERY ELEMENTS

$this->name = $name;
$this->surname = $surname;
$this->user = $user;
$this->password = $password;
$this->result = $result;
//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "INSERT into session (Name, Surname, Status) values ('$this->name', '$this->surname', 'in')";
            $result = mysql_query($query)
            or die ("Query did not run");
            //$numrows1 = mysql_num_rows($result);
            //or die ("row count failed");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            /*if ($numrows1 =="1") {

                $this->result = "OK";

            }

            else {

                $this->result ="NO";

            }

            /*while($row = mysql_fetch_array($result)){


             }
             return $this->result;*/

        }



public function Add_Link($user1, $link_name, $link_address)

{

// SET QUERY ELEMENTS

$this->link_name = $link_name;
$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "INSERT into links (user, name, link) values ('$this->user1', '$this->link_name', '$this->link_address')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            $this->result2 = "Your link has been added";
            echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            /*if ($numrows1 =="1") {

                $this->result2 = "Link added successfully";
                return $this->result2;
            }

            else {

                $this->result2 = "NO";
                return $this->result2;
            }


             return $this->result2;

        }*/







}

// SELECTS NON SPECIFIC QUESTIONS

public function Select_All_Entries_Ns($user1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from ns_questions WHERE (user = '$this->user1') LIMIT 0 , 30";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

if (mysql_num_rows($result) > 0){

$categories = array();

$i = "1";

while ($obj = mysql_fetch_array($result))
{
        //$categories[$i] = $obj['id'];

        // ADD MESSAGE TO CONFIRM THAT ENTRIES ARE PRESENT
        $categories[$i]['entries_present'] = "ok";
        $categories[$i]['id'] = $obj['id'];
        $categories[$i]['user'] = $obj['user'];
        $categories[$i]['name'] = $obj['name'];
        $categories[$i]['link'] = $obj['link'];
        $categories[$i]['link_name'] = $obj['link_name'];
        $categories[$i]['link_section'] = $obj['link_section'];
        $categories[$i]['question'] = $obj['question'];
        $categories[$i]['quest_nb'] = $obj['quest_nb'];
        $categories[$i]['response'] = $obj['response'];;
        //$categories[$i]['textG'] = "textG";

        //ADD INDICATOR OF NUMBER OF ROWS TO ARRAY

        //$categories[$i]['nbRow'] = $this->nbRow;

        // FORWARD BUTTON

        //$categories[$i]['forwardButton'] = $this->forwardButton;
        //$categories[$i]['forwardButtonStatus'] = $this->forwardButtonStatus;

        // BACKWARD BUTTON

        //$categories[$i]['backButton'] = $this->backButton;
        //$categories[$i]['backButtonStatus'] = $this->backButtonStatus;

        //$categories[$i]['textG'] = "textG";

        $i++;
}

}


else {

        // ADD MESSAGE TO CONFIRM THAT ENTRIES ARE PRESENT
        $categories[1]['entries_present'] = "no";

}




//echo $string;

//return $string;
return $categories;



}

public function Select_All_Link($user1)

{

$string=NULL;

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            //$string = "<table class='link_table' width='220px'><tr><th></th><th></th><th></th></tr>";

if (mysql_num_rows($result) > 0){

  while($row = mysql_fetch_object($result)){


    $string .= "<tr height='20px' 	class='test_link_delete' id='".$row->id."'><td  width='45%'><div id='".$row->id."'><a data-role='button' href='http://". $row->link ."' id='".$row->id."' target='_blank'>".$row->name."</a></div></td>";

     $string .= "<td  width='15%'><div id='delete_link' style='".$row->id."'><a data-role='button' style='".$row->id."' href='#' class='".$row->id."' id='delete_link'>x</a></td></div>";


   // PRINTS OUT UPDATE BUTTON

   $string .="<td  width='25%'><div id='id-update' style='".$row->id."'><a data-role='button' style='".$row->id."' href='#' id='update_link' class='".$row->id."'>Update</a></div></td></tr>";

  }

//$string .= "</table>";

}

//echo $string;

return $string;




}






public function retrieveLinks($user1, $nbRow)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;
$this->nbRow = $nbRow;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// if $this->nbRow is not set give it a value of 0

if (!isset($this->nbRow)) {$this->nbRow = 0;};

// CHECK IF THERE ARE ENOUGH ROWS FOR BACK BUTTON

$query3 = "SELECT * from links WHERE (user = '$this->user1')";
            $result3 = mysql_query($query3)
            or die ("Sorry, an error has occurred, please try again later.");

// CHECK IF NUMBER OF ROW IS NULL

//if($result3==null){

if(mysql_num_rows($result3) == null){

            $errorMessage = array();

            $errorMessage['error'] = "no rows";

            //return $errorMessage;
            $categories = array();

            $categories['1']['error'] = $errorMessage['error'];
            //echo "this is an error";

            return $categories;

            }

else{
$numrows3 = mysql_num_rows($result3)
or die ("CHECK1 could not count rows");

if ($this->nbRow >= $numrows3){

$this->nbRow = $this->nbRow - 10;

}


//---------------------- END



//CHECK IF THERE IS A START COUNTER

//$this->nbRowstart = $_POST['id'];

//if ($this->nbRow < 0) {$this->nbRow = 10;}

//if (!isset($this->nbRow)) {$this->nbRow = 0;}



//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

//LIMIT " . $start . ", 10";

           // $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
//
// THIS QUERY ONLY SELECTS THE NUMBER OF ROWS DEFINED BY nbRow

            //$query = "SELECT * from links WHERE (user = '$this->user1') ORDER BY name asc LIMIT " . $this->nbRow . ", 10";
            $query = "SELECT * from links WHERE (user = '$this->user1') ORDER BY id desc LIMIT " . $this->nbRow . ", 10";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// 2ND QUERY SELECTS THE TOTAL NUMBER OF ROWS, needed for forward and back buttons

            $query2 = "SELECT * from links WHERE (user = '$this->user1')";
            $result2 = mysql_query($query2)
            or die ("Sorry, an error has occurred, please try again later.");

// CHECK IF NO ROWS WERE RETURNED

            if($result2==null){

            $errorMessage = array();

            $errorMessage['error'] = "no rows";

            //return $errorMessage;
            $categories = array();

            $categories['1']['error'] = $errorMessage['error'];
            //echo "this is an error";

            return $categories;


            }

            else{

            $numrows = mysql_num_rows($result2)
            or die ("CHECK2 could not count rows");

// SET UP "BACK" AND "FORWARD" BUTTONS TO SEE RESULTS
// 1ST IF SETS UP BACK BUTTON
            if ($this->nbRow > 0)
            {

           // $this->nbRow = $this->nbRow - 10;

// BUILD BACK BUTTON VALUE FOR ARRAY

            $this->backButton = $this->nbRow - 10;
            $this->backButtonStatus = "live";

            }

            else{

            $this->backButtonStatus = "inactive";


            }


// IF THERE ARE TEN ROWS MORE THAN THE NUMBER ALREADY IN nbRows then increment by 10

            if($numrows > ($this->nbRow + 10))
            {

            //$this->nbRow = $this->nbRow + 10;

// BUILD FORWARD BUTTON VALUE FOR ARRAY

            //$this->forwardButton = ($this->nbRow + 10) - $this->backButton;
            $this->forwardButton = $this->nbRow + 10;
            //$this->forwardButton = $this->nbRow;

            $this->forwardButtonStatus = "live";
//$string .="<div id='arrow'><a href='' id='" . ($start +10) . "'>Next</a><BR>\n</div>";

            }

            else{

            $this->forwardButtonStatus = "inactive";


            }



            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND



// WORKS BUT ONLY RETURNS ONE ROW TO FLASH
/*$categories = array();

while ($obj = mysql_fetch_array($result))
{
        $categories['id'] = $obj['id'];
        $categories['user'] = $obj['user'];
        $categories['name'] = $obj['name'];
        $categories['link'] = $obj['link'];
}*/

// END WORKS

// NEW TRIAL WITH COUNTER

$categories = array();

$i = "1";

while ($obj = mysql_fetch_array($result))
{
        //$categories[$i] = $obj['id'];

        $categories[$i]['id'] = $obj['id'];
        $categories[$i]['user'] = $obj['user'];
        $categories[$i]['name'] = $obj['name'];
        $categories[$i]['link'] = $obj['link'];
        $categories[$i]['saveBtn'] = "saveBtn";
        $categories[$i]['editBtn'] = "editBtn";
        $categories[$i]['textF'] = "textF";
        $categories[$i]['textG'] = "textG";

        //ADD INDICATOR OF NUMBER OF ROWS TO ARRAY

        $categories[$i]['nbRow'] = $this->nbRow;

        // FORWARD BUTTON

        $categories[$i]['forwardButton'] = $this->forwardButton;
        $categories[$i]['forwardButtonStatus'] = $this->forwardButtonStatus;

        // BACKWARD BUTTON

        $categories[$i]['backButton'] = $this->backButton;
        $categories[$i]['backButtonStatus'] = $this->backButtonStatus;

        //$categories[$i]['textG'] = "textG";

        $i++;
}


// END NEW TRIAL






/*$categories = array();
while ($obj = mysql_fetch_array($result))
{*/

/*$transport(array(id=> $obj['id'],
                 user=> $obj['user'],
                 name=> $obj['name'],
                 link=> $obj['link']
*/
/*$num=mysql_numrows($result);

 for ($i = 0; $i < $obj; $i++){

 $categories[$i]['id'] = $obj['id'];
 $categories[$i]['username'] = $obj['user'];
 $categories[$i]['name1'] = $obj['name'];
 $categories[$i]['link1'] = $obj['link'];
               //  )
           //);
 }*/
//}








/*            $string = "<table class='link_table'><tr><th>Link</th><th>Delete</th><th>Update</th></tr>";

if (mysql_num_rows($result) > 0){
  while($row = mysql_fetch_object($result)){

    //echo $row->id;
    //echo $row->user;
    //echo $row->link;

    $string .= "<tr class='test' id='".$row->id."'><td><div id='".$row->id."'><a href=".$row->link." id='".$row->id."'>".$row->name."</a></div></td>";
  //  $string .= "<td><a href='.$row->link_address' id='".$row->id."'>".$row->link_name."</a></td>";
    //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->comments."</a></td>";
     //$string .= "<td><a href='#' id='".$row->entry_id."'>".$row->total."</a></td>";

    //$string .= "<td>".$row->Name."</td>";
    //$string .= "<td>".$row->Description."</td>";
   // $string .= "<tr><td><div id='id'><a href='form.html?id=".$row->id."' id='id_target'>".$row->name."</a></div></td>";


   // Delete

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic' id='".$row->id."'>".$row->name."</a></div></td>";

   $string .= "<td><div id='id'><form name='form-delete' id='form-delete' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='hidden' name='id2' id='id2' value='".$row->id."'><input type='submit' class='link_button_delete' id='delete' value='delete'></form></td></div>";

   // PRINTS OUT UPDATE BUTTON

   $string .="<td><div id='id-update'><form name='form-update' id='form-update' action='http://wpc4000.amenworld.com/iduk2/joomla-overview/delete.html' method='post'><input type='submit' id='update' class='link_button' value='Update'></form></div></td></tr>";

   //$string .= "<td><div id='".$row->entry_id."'><a href='#' name='".$row->date."' id='".$row->task_number."' class ='update_button' value='".$row->entry_id."'> Update </a></div></td></tr>";

   //$string .= "<tr><td><div id='id'><a href='javascript:void(0);' class ='dynamic".$row->id."' id='".$row->id."'>".$row->name."</a></div></td>";


   // $string .= "<tr><td><div id ='form'><form action ='Search2.php' method='post' id='form2'>

             //   <input type = 'hidden' name='id' id='id' value =".$row->id.">

               // <input type = 'submit' name='submit' id='submit1' value ='select'></form></div></td>";
    //$string .= "<tr><td><div id='test2'><a href='#' id='id'>".$row->id."</a></div></td>";

    //$string .= $row->phone."</a>";
    //$string .= "<br/>\n";







  }

$string .= "</table>";

}*/

//echo $string;

//return $string;

//return $result;
return $categories;
            }


//return $categories;

//return $transport;

//return $this->user1;
}
}

//-------------------------------------------------

public function saveAllLinks($id, $name, $link)

{

// ---------------------- CLEAN DATA ------------------------------
// USER
$id = stripslashes($id);
$id = strip_tags($id);
$id = mysql_real_escape_string($id);

// NAME

$name = stripslashes($name);
$name = strip_tags($name);
$name = mysql_real_escape_string($name);

// LINK

$link = stripslashes($link);
$link = strip_tags($link);
$link = mysql_real_escape_string($link);

//----------------------- END CLEAN DATA ---------------------------





// SET QUERY ELEMENTS

$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "UPDATE links SET name = '$this->name', link = '$this->link'
                      WHERE id = '$this->id'";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "complete";

return $response;



}


//---------------------------------- Update university task list

public function updateAppsNsNow($user1, $question, $resp_question, $id)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;
$this->question = $question;
$this->resp_question = $resp_question;
$this->id = $id;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$query = "UPDATE links SET name = '$this->name', link = '$this->link'
  //                    WHERE id = '$this->id'";

            $query = "UPDATE ns_questions SET response = '$this->resp_question' WHERE (user = '$this->user1')
AND (id = '$this->id')";

//AND (question = '$this->resp_question')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND
$string = "update complete";
//echo $string;

return $string;
//return $categories;



}











//------------------------------------------------



public function Select_All_Link2($user1)

{

// SET QUERY ELEMENTS

//$this->link_name = $link_name;
//$this->link_address = $link_address;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

//echo "ok to here 3";

$this->new_connection = new Db_Connect();

//echo "ok to here4";

$this->open_db = $this->new_connection->initDB();

//echo "ok to here5";

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "SELECT * from links WHERE (user = '$this->user1') LIMIT 0 , 30";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND

            $body = "";
	//$sql = mysql_query("SELECT id, firstname, sign_up_date FROM myMembers WHERE email_activated='1' ORDER BY id ASC LIMIT 10");

	while($row = mysql_fetch_array($result)){

		$id = $row["id"];
		$linkname = $row["name"];
		$link = $row["link"];
		//$sign_up_date = strftime("%b %d, %y", strtotime($sign_up_date));
		$body .= '<u><font color="#0000CC"><a href="' . $link . '" target="_blank">' . $linkname . '</a></font></u>    |    <font color="#FF0000">' . $id . '</font>      |      <font color="#9B9B9B">' . $sign_up_date . '</font><br /><br />';

    }
    //echo "returnBody=$body";

//echo $body;

//echo "ok to here5";

//echo $body;

    //echo "returnBody=$body";

    echo "returnBody=" . $body;

    mysql_close();
    exit();






}


public function deleteThisLink($id, $name, $link)

{

// SET QUERY ELEMENTS

$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE
//Delete from customer_info where customer_id=’1’;

            $query = "DELETE from links
                      WHERE id = '$this->id'";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "entry deleted";

return $response;



}


// ADD LINKS

public function addLinkNow($user, $name, $link)

{

// ---------------------- CLEAN DATA ------------------------------
// USER
$user = stripslashes($user);
$user = strip_tags($user);
$user = mysql_real_escape_string($user);

// NAME

$name = stripslashes($name);
$name = strip_tags($name);
$name = mysql_real_escape_string($name);

// LINK

$link = stripslashes($link);
$link = strip_tags($link);
$link = mysql_real_escape_string($link);

//----------------------- END CLEAN DATA ---------------------------




// SET QUERY ELEMENTS

$this->user = $user;
//$this->id = $id;
$this->name = $name;
$this->link = $link;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

//SELECT *
//FROM `links`
//WHERE `user` = 'michael'
//LIMIT 0 , 30
// PERFORM QUERY: UPDATES SESSION TABLE
//Delete from customer_info where customer_id=’1’;

            $query = "INSERT into links (user, name, link)
                      VALUES ('$this->user', '$this->name', '$this->link')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");

// END QUERY


//$response['message'] = "Update completed successfully";
//$response = array();

$response = "entry deleted";

return $response;



}

// END ADD LINKS

// ------------------------------- CHECK IF CHOICE ALREADY EXISTS -------------------

public function Check_Choice_Exist($user1, $uniNb, $nameUni)

{

// SET QUERY ELEMENTS
$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------

// --------------------- CHECK IF MORE THAN 10 UNIS ARE ALREADY IN LIST ----------

$query = "SELECT * from choices WHERE (user = '$this->user1') AND (uni_name = '$this->nameUni')";
            $result = mysql_query($query)
            or die ("Error 1 Sorry, an error has occurred, please try again later.");

$num_rows = mysql_num_rows($result);

if($num_rows>=1){

$message_count = "no";
return $message_count;

}

else {

$message_count = "ok";
//echo $message_count;


}
}



// END CHOICE ALREADY EXISTS


// ------------------------------- CHECK NUMBER OF UNIS CHOSEN ----------------------

public function Check_Nb_Unis($user1, $uniNb, $nameUni)

{

// SET QUERY ELEMENTS
$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------

// --------------------- CHECK IF MORE THAN 10 UNIS ARE ALREADY IN LIST ----------

$query = "SELECT * from choices WHERE (user = '$this->user1')";
            $result = mysql_query($query)
            or die ("Error 1 Sorry, an error has occurred, please try again later.");

$num_rows = mysql_num_rows($result);

if($num_rows>=10){

$message_count = "no";
return $message_count;

}

else {

$message_count = "ok";
//echo $message_count;


}
}

// ------------------- SELECT ALL UNIS, PUT IN DROPDOWN LIST -----------

public function Select_All_Unis($user1, $uniNb, $nameUni)

{

$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;


$this->new_connection2 = new Db_Connect();
$this->open_db2 = $this->new_connection2->initDB();

            $query2 = "SELECT* from choices WHERE user = '$this->user1' ORDER BY status asc";
            $result3 = mysql_query($query2)
            or die ("Sorry, an error has occurred, please try again later.");
            //$this->result3 = "Your choice has been added";

// PUT UNIS INTO ARRAY

//$categories = array();

$i = "1";

$response = "<select id='uni-list2' data-role='none'>";

while ($obj = mysql_fetch_array($result3))
{
     // BUILD COMBO LIST
//$response .= "<option id=" . $obj['id'] . ">" . $obj['uni_name'] . "</option>";

//$response .= "<option id=" . $obj['id'] . " name=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";

$response .= "<option id=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";

        //<option selected="true">Medium
  //<option>Large
  //<option>X-Large$categories[$i] = $obj['id'];
        //$categories[$i]['uni_name'] = $obj['uni_name'];
        //$categories[$i]['user'] = $obj['user'];
        //$categories[$i]['uni_nb'] = $obj['uni_nb'];
        //$categories[$i]['link'] = $obj['link'];
        //$categories[$i]['msg'] = "Your choice has been added";
        $i++;
}

$response .= "</select>";
$response .= "<div id='uniDelete'><a href='#' id='delete' data-role='button'>Supprimer</a></div>";

            //return $response;
            echo $response;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
}


// END SELECT ALL UNIS
// END NB UNIS CHOSEN

// -----------------------------------  ADD NON SPECIFIC QUESTIONS ---------------------

public function Add_Ns_Questions($user1, $uniNb, $nameUni)

{

// SET QUERY ELEMENTS
$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;

// CHECK IF NS_QUESTIONS ALREADY EXIST

$this->new_connection_Add_Uni2 = new Db_Connect();
$this->open_db2 = $this->new_connection_Add_Uni2->initDB();

$query = "SELECT * from ns_questions WHERE (user = '$this->user1')";
            $result = mysql_query($query)
            or die ("Error 1 Sorry, an error has occurred, please try again later.");

$num_rows = mysql_num_rows($result);

// IF ALREADY HAS NS QUESTIONS, DO NOT ADD ANY MORE

if($num_rows>=1){

$message_count = "no";
return $message_count;

}

else {

$message_count = "ok";
//echo $message_count;

// END CHECK NS_QUESTIONS

//$this->new_connection = $new_connection;

$this->new_connection_Add_Uni = new Db_Connect();
$this->open_db = $this->new_connection_Add_Uni->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------

// for query trial

/*id
user
question
quest_nb
response
link
link_name
link_section */

// ---------------------- INSERT NS QUESTIONS INTO DATABASE ---------------------

$ns["0"]["user"] = $this->user1;
$ns["0"]["question"] = "Owner";
$ns["0"]["question_nb"] = "$60,000";
$ns["0"]["response"] = "$60,000";
$ns["0"]["link"] = "$60,000";
$ns["0"]["link_name"] = "$60,000";
$ns["0"]["link_section"] = "prelim";

$ns["1"]["user"] = $this->user1;
$ns["1"]["question"] = "Owner";
$ns["1"]["question_nb"] = "$60,000";
$ns["1"]["response"] = "$60,000";
$ns["1"]["link"] = "$60,000";
$ns["1"]["link_name"] = "$60,000";
$ns["1"]["link_section"] = "prelim";

$ns["2"]["user"] = $this->user1;
$ns["2"]["question"] = "Owner";
$ns["2"]["question_nb"] = "$60,000";
$ns["2"]["response"] = "$60,000";
$ns["2"]["link"] = "$60,000";
$ns["2"]["link_name"] = "$60,000";
$ns["2"]["link_section"] = "prelim";

$ns["3"]["user"] = $this->user1;
$ns["3"]["question"] = "Owner";
$ns["3"]["question_nb"] = "$60,000";
$ns["3"]["response"] = "$60,000";
$ns["3"]["link"] = "$60,000";
$ns["3"]["link_name"] = "$60,000";
$ns["3"]["link_section"] = "prelim";

$ns["4"]["user"] = $this->user1;
$ns["4"]["question"] = "Owner";
$ns["4"]["question_nb"] = "$60,000";
$ns["4"]["response"] = "$60,000";
$ns["4"]["link"] = "$60,000";
$ns["4"]["link_name"] = "$60,000";
$ns["4"]["link_section"] = "prelim";

$ns["5"]["user"] = $this->user1;
$ns["5"]["question"] = "Owner";
$ns["5"]["question_nb"] = "$60,000";
$ns["5"]["response"] = "$60,000";
$ns["5"]["link"] = "$60,000";
$ns["5"]["link_name"] = "$60,000";
$ns["5"]["link_section"] = "english";

$ns["6"]["user"] = $this->user1;
$ns["6"]["question"] = "Owner";
$ns["6"]["question_nb"] = "$60,000";
$ns["6"]["response"] = "$60,000";
$ns["6"]["link"] = "$60,000";
$ns["6"]["link_name"] = "$60,000";
$ns["6"]["link_section"] = "before";

$ns["7"]["user"] = $this->user1;
$ns["7"]["question"] = "Specific question7";
$ns["7"]["question_nb"] = "$60,000";
$ns["7"]["response"] = "$60,000";
$ns["7"]["uni"] = $this->nameUni;
$ns["7"]["link"] = "http://www.yahoo.com";
$ns["7"]["link_name"] = "Accommodation";
$ns["7"]["link_section"] = "ucas";
$ns["7"]["uni_nb"] = $this->uniNb;

/*
$user_ns_insert = "michael";
$question_ns_insert = "michael";
$question_nb_ns_insert = "michael";
$response_ns_insert = "michael";
$link_ns_insert = "michael";
$link_name_ns_insert = "michael";
$link_section_ns_insert = "michael";
*/

// PERFORM QUERY

for($i=0;$i<count($ns[$i]);$i++){
    //echo $abc['category'][$i];
    //echo $abc['article'][$i];
        //insert it here.

$ns_user = $ns[$i]["user"];
$ns_question = $ns[$i]["question"];
$ns_quest_nb = $ns[$i]["question_nb"];
$ns_response = $ns[$i]["response"];
$ns_link = $ns[$i]["link"];
$ns_link_name = $ns[$i]["link_name"];
$ns_link_section = $ns[$i]["link_section"];
/*
id
user
question
quest_nb
response
link
link_name
link_section
*/
            //$query_new = "INSERT into ns_questions (user) values ('$ns_user')";
            $query_new = "INSERT into ns_questions (user, question, quest_nb, response, link, link_name, link_section) values ('$ns_user',
'$ns_question', '$ns_quest_nb', '$ns_response', '$ns_link', '$ns_link_name', '$ns_link_section')";
            $result_Add_Uni = mysql_query($query_new)
            or die ("Error Insert: Multi-dimensional array insert, sorry, an error has occurred, please try again later.");
            //$this->result2 = "Your choice has been added";
            //return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
}

}
}

// END NON SPECIFIC QUESTIONS (ADD)


// ---------------------------- ADD UNIVERSITY SPECIFIC QUESTIONS -----------------------------------

public function Add_Specific_Questions($user1, $uniNb, $nameUni)

{

// SET QUERY ELEMENTS
$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;

$ns;
$i;

$this->new_connection_Add_Uni = new Db_Connect();
$this->open_db = $this->new_connection_Add_Uni->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------

// for query trial

/*id
user
question
quest_nb
response
link
link_name
link_section

$this->uniNb = $uniNb;
$this->nameUni = $nameUni;

 */

// ---------------------- INSERT NS QUESTIONS INTO DATABASE ---------------------

$ns["0"]["user"] = $this->user1;
$ns["0"]["question"] = "Specific question1";
$ns["0"]["question_nb"] = "1";
$ns["0"]["response"] = "no";
$ns["0"]["uni"] = $this->nameUni;
$ns["0"]["link"] = "http://wpc4000.amenworld.com/word2/support-system/";
$ns["0"]["link_name"] = "Support centre";
$ns["0"]["link_section"] = "finance";
$ns["0"]["uni_nb"] = $this->uniNb;

$ns["1"]["user"] = $this->user1;
$ns["1"]["question"] = "Specific question2";
$ns["1"]["question_nb"] = "2";
$ns["1"]["response"] = "no";
$ns["1"]["uni"] = $this->nameUni;
$ns["1"]["link"] = "http://wpc4000.amenworld.com/word2/page-1/";
$ns["1"]["link_name"] = "Page 1";
$ns["1"]["link_section"] = "finance";
$ns["1"]["uni_nb"] = $this->uniNb;

$ns["2"]["user"] = $this->user1;
$ns["2"]["question"] = "Specific question3";
$ns["2"]["question_nb"] = "3";
$ns["2"]["response"] = "no";
$ns["2"]["uni"] = $this->nameUni;
$ns["2"]["link"] = "http://www.fco.gov.uk";
$ns["2"]["link_name"] = "Foreign Office";
$ns["2"]["link_section"] = "finance";
$ns["2"]["uni_nb"] = $this->uniNb;

$ns["3"]["user"] = $this->user1;
$ns["3"]["question"] = "Specific question4";
$ns["3"]["question_nb"] = "$60,000";
$ns["3"]["response"] = "no";
$ns["3"]["uni"] = $this->nameUni;
$ns["3"]["link"] = "http://www.hotmail.com";
$ns["3"]["link_name"] = "Hotmail";
$ns["3"]["link_section"] = "accommodation";
$ns["3"]["uni_nb"] = $this->uniNb;

$ns["4"]["user"] = $this->user1;
$ns["4"]["question"] = "Specific question5";
$ns["4"]["question_nb"] = "$60,000";
$ns["4"]["response"] = "no";
$ns["4"]["uni"] = $this->nameUni;
$ns["4"]["link"] = "http://www.foris-scientia.com";
$ns["4"]["link_name"] = "Foris Scientia";
$ns["4"]["link_section"] = "accommodation";
$ns["4"]["uni_nb"] = $this->uniNb;


$ns["5"]["user"] = $this->user1;
$ns["5"]["question"] = "Specific question6";
$ns["5"]["question_nb"] = "$60,000";
$ns["5"]["response"] = "no";
$ns["5"]["uni"] = $this->nameUni;
$ns["5"]["link"] = "http://www.gmail.com";
$ns["5"]["link_name"] = "Accommodation";
$ns["5"]["link_section"] = "accommodation";
$ns["5"]["uni_nb"] = $this->uniNb;



/*
$user_ns_insert = "michael";
$question_ns_insert = "michael";
$question_nb_ns_insert = "michael";
$response_ns_insert = "michael";
$link_ns_insert = "michael";
$link_name_ns_insert = "michael";
$link_section_ns_insert = "michael";
*/

// PERFORM QUERY

for($i=0;$i<count($ns[$i]);$i++){
    //echo $abc['category'][$i];
    //echo $abc['article'][$i];
        //insert it here.

$ns_user = $ns[$i]["user"];
$ns_question = $ns[$i]["question"];
$ns_quest_nb = $ns[$i]["question_nb"];
$ns_response = $ns[$i]["response"];
$ns_uni = $ns[$i]["uni"];
$ns_link = $ns[$i]["link"];
$ns_link_name = $ns[$i]["link_name"];
$ns_link_section = $ns[$i]["link_section"];
$ns_uni_nb = $ns[$i]["uni_nb"];
/*
id
user
question
quest_nb
response
uni
link
link_name
link_section
uni_nb

CHOICES

id
uni_me
user
status
uni_nb
*/
            //$query_new = "INSERT into ns_questions (user) values ('$ns_user')";
            $query_new = "INSERT into s_questions (user, question, quest_nb, response, uni, link, link_name, link_section, uni_nb) values ('$ns_user',
'$ns_question', '$ns_quest_nb', '$ns_response', '$ns_uni', '$ns_link', '$ns_link_name', '$ns_link_section', '$ns_uni_nb')";
            $result_Add_Uni = mysql_query($query_new)
            or die ("Error Insert, specific questions: Multi-dimensional array insert, sorry, an error has occurred, please try again later.".mysql_error());
            //$this->result2 = "Your choice has been added";
            //return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
}


}





// END UNIVERSITY SPECIFIC QUESTIONS

public function Add_Uni($user1, $uniNb, $nameUni)

{

// SET QUERY ELEMENTS
$this->uniNb = $uniNb;
$this->nameUni = $nameUni;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection_Add_Uni = new Db_Connect();
$this->open_db = $this->new_connection_Add_Uni->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------


// PERFORM QUERY

            $query_new = "INSERT into choices (uni_name, user, uni_nb) values ('$this->nameUni', '$this->user1', '$this->uniNb')";
            $result_Add_Uni = mysql_query($query_new)
            or die ("Error Insert: Sorry, an error has occurred, please try again later.".mysql_error());
            //$this->result2 = "Your choice has been added";
            //return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// FETCH LIST OF UNIS BELONGING TO USER

$this->new_connection2 = new Db_Connect();
$this->open_db2 = $this->new_connection2->initDB();

            $query2 = "SELECT* from choices WHERE user = '$this->user1' ORDER BY status asc";
            $result3 = mysql_query($query2)
            or die ("Sorry, an error has occurred, please try again later.");
            //$this->result3 = "Your choice has been added";

// PUT UNIS INTO ARRAY

//$categories = array();

$i = "1";

$response = "<select id='uni-list2' data-role='none'>";

while ($obj = mysql_fetch_array($result3))
{
     // BUILD COMBO LIST
$response .= "<option id=" . $obj['uni_nb'] . ">" . $obj['uni_name'] . "</option>";

        //<option selected="true">Medium
  //<option>Large
  //<option>X-Large$categories[$i] = $obj['id'];
        //$categories[$i]['uni_name'] = $obj['uni_name'];
        //$categories[$i]['user'] = $obj['user'];
        //$categories[$i]['uni_nb'] = $obj['uni_nb'];
        //$categories[$i]['link'] = $obj['link'];
        //$categories[$i]['msg'] = "Your choice has been added";
        $i++;
}

$response .= "</select>";
$response .= "<div id='uniDelete'><a href='#' id='delete' data-role='button'>Supprimer</a></div>";

            //return $response;
            echo $response;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
}

// -------------------------- ADD NOTES TO DB

public function Add_Notes($user1, $title, $notes)

{

// SET QUERY ELEMENTS
$this->notes = $notes;
$this->title = $title;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection_Add_Uni = new Db_Connect();
$this->open_db = $this->new_connection_Add_Uni->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);

// --------------------- REMEMBER TO CLEAN DATA ---------------------------------

// --------------------- FINISH CLEAN DATA --------------------------------------


// PERFORM QUERY

            $query_new = "INSERT into notes (name, user, content) values ('$this->title', '$this->user1', '$this->notes')";
            $result_Add_Uni = mysql_query($query_new)
            or die ("Error Insert: Sorry, an error has occurred, please try again later.");
            $this->result2 = "Your choice has been added";
            return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// FETCH LIST OF UNIS BELONGING TO USER

            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");
}




//---------------------------- END ADD TO DB


//--------------------------- GET ALL UNIS FOR USER -----------------------


public function get_Uni($user1)

{

// SET QUERY ELEMENTS
//$this->uniNb = $uniNb;
//$this->nameUni = $nameUni;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

//$this->new_connection = new Db_Connect();
//$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

//            $query = "INSERT into choices (uni_name, user, uni_nb) values ('$this->nameUni', '$this->user1', '$this->uniNb')";
//            $result = mysql_query($query)
 //           or die ("Sorry, an error has occurred, please try again later.");
            //$this->result2 = "Your choice has been added";
            //return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// FETCH LIST OF UNIS BELONGING TO USER

$this->new_connection2 = new Db_Connect();
$this->open_db2 = $this->new_connection2->initDB();

            $query2 = "SELECT* from choices WHERE user = '$this->user1' ORDER BY uni_name asc";
            $result3 = mysql_query($query2)
            or die ("Sorry, an error has occurred, please try again later.");
            //$this->result3 = "Your choice has been added";


//----------------------------- CHECK IF THERE ARE ANY CHOICES, CREATE ERROR MESSAGE IF NECESSARY

if(mysql_num_rows($result3) == null){

$error_msg = array();

$error_msg[1]['msg'] = "0 choices listed";

return $error_msg;

}
//----------------------------- END "CHECK CHOICES" ------------------------------



// PUT UNIS INTO ARRAY

$categories = array();

$i = "1";

while ($obj = mysql_fetch_array($result3))
{
        //$categories[$i] = $obj['id'];
        $categories[$i]['uni_name'] = $obj['uni_name'];
        $categories[$i]['user'] = $obj['user'];
        $categories[$i]['uni_nb'] = $obj['uni_nb'];
        $categories[$i]['link'] = $obj['link'];
        $categories[$i]['id'] = $obj['id'];
        $categories[$i]['msg'] = "Your choice has been added";
        $i++;
}


            return $categories;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

}



//---------------------------- END GET ALL UNIS NOW ----------------------

// --------------------------- NOT USED AT PRESENT -----------------------

public function get_All_Unis($user1)

{

// SET QUERY ELEMENTS

$this->nameUni = $nameUni;
$this->user1 = $user1;

//$this->new_connection = $new_connection;

$this->new_connection = new Db_Connect();
$this->open_db = $this->new_connection->initDB();

//$this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);


// PERFORM QUERY: UPDATES SESSION TABLE

            $query = "INSERT into choices (uni_name, user) values ('$this->nameUni', '$this->user1')";
            $result = mysql_query($query)
            or die ("Sorry, an error has occurred, please try again later.");
            $this->result2 = "Your university has been added";
            return $this->result2;
            //echo $this->result2;
            //$numrows1 = mysql_num_rows($result)
            //or die ("problem in perform-query - stage 2");

// CHECK TO SEE IF LOGIN AND PASSWORD DETAILS WHERE FOUND


}




}



?>
