<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cleanse
 *
 * @author michael
 */
class Cleanse {
    //put your code here

   public $cleansed = array();
   public $to_clean = array();
   public $cleaned_data = array() ;

   // ARRAY IS PASSED IN AS $to_clean //

    public function Cleanse_Data ($to_clean){

        $this->to_clean = $to_clean;
        $this->cleaned_data = $cleaned_data;

echo "<br><br>";
echo"CHECK DATA at TOP of CLEANSE FUNCTION";
   echo"<br>variables:";
   echo $this->to_clean["title"];
   echo"<br>note:";
   echo $this->to_clean["note"];
   echo"<br><br>END";

   // WALKS THROUGH ARRAY TO CLEAN DATA //

        foreach ($this->to_clean as $key=> $value)

        {

            $cleaned_data = strip_tags($value);

            echo"<br><br>inside FOREACH";

            $cleaned_data = stripslashes($value);
            
            echo"<br><br>after STRIPLASHES";
            echo"<br><br>print variable:";
            echo $cleaned_data;

            $cleaned_data = htmlspecialchars($value, ENT_QUOTES);
            //$cleaned_data = htmlentities($cleaned_data);
            $cleaned_data = trim($value);
            $cleaned_data = mysql_real_escape_string($value);

   // SHOULD BE $cleaned_data instead of $value
            echo"<br><br>Just before CONSTRUCTION OF RESULTS ARRAY";
            echo "check key value:";
            echo $key . " " . "FULL VARIABLE: " . $cleaned_data;
            echo "END key check<br>";

            //$cleansed[$key] = $cleaned_data[$key];
            $cleansed = $cleaned_data[$value];
            echo "<br><br>echo out cleaned value: end of loop";
            echo $cleansed[$key];
            echo "<br><br>echo out cleaned value<br><br>";
        }

   // CLEANED DATA RETURNED TO MAIN PROGRAM
   echo"CHECK DATA FROM WITHIN CLEANSE FUNCTION";
   echo"<br>variables:";
   echo $cleansed["title"];
   echo"<br>note:";
   echo $cleansed["note"];
   echo"<br><br>END";
        return $cleansed;

    }








}
?>
