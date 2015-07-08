<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cleanse_int
 *
 * @author michael
 */
include("Cleanse.php");
class Cleanse_int {
    //put your code here

    public $to_clean;
    public $clean_obj;
    public $cleansed_data;

    public function send_cleanse ($to_clean){

    $this->to_clean = $to_clean;
    $this->clean_obj = new Cleanse();
    $this->cleansed_data = $this->clean_obj->Cleanse_Data($this->to_clean);
    return $this->cleansed_data;

}
}



?>
