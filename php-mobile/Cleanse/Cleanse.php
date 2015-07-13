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
   public $cleaned_data;

   // ARRAY IS PASSED IN AS $to_clean //

    public function Cleanse_Data ($to_clean){

        $this->to_clean = $to_clean;
        $this->cleaned_data = $cleaned_data;

   // WALKS THROUGH ARRAY TO CLEAN DATA //

        foreach ($this->to_clean as $key=> $value)

        {
            $cleaned_data = stripslashes($value);
            $cleaned_data = strip_tags($value);
            $cleaned_data = mysql_real_escape_string($value);

   // SHOULD BE $cleaned_data instead of $value
   
            $cleansed[$key] = $value;
        }

   // CLEANED DATA RETURNED TO MAIN PROGRAM
   
        return $cleansed;

    }




}
?>
