<?php
    foreach($houseHolders as $houseHolder)
    {
        $userId = $houseHolder['userId'];
        $userDetails = $houseHolder['userDetails'];
            $uname = $userDetails['uname'];
            $name = $userDetails['name'];
            $email = $userDetails['email'];
            $phone = $userDetails['phone'];
        echo '<span class="eventTarget" id="'.$userId.'"><b>'.$uname.'</b><br/> '.$name.' '.$email.' <h2>'.$phone.'</h2></span>';
        
    }
?>
<script>
    $("#liveSearchResults").change();
</script>    

