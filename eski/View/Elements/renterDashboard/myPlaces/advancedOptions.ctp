<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    echo $this->Element('renterDashboard/myPlaces/advancedOptions/elements/tab');
    
    $pageContentElementName = isset($this->passedArgs[2])?$this->passedArgs[2]:'conditions';
    

    echo $this->Element('renterDashboard/myPlaces/advancedOptions/'.$pageContentElementName);
    
?>

