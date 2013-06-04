<?php
    foreach($users as $user)
    {
        $userId = $user['userId'];
        $userDetails = $user['userDetails'];
            $uname = $userDetails['uname'];
            $name = $userDetails['name'];
            $email = $userDetails['email'];
            $phone = $userDetails['phone'];
        echo '<span class="eventTarget" id="'.$userId.'"><b>'.$uname.'</b><br/> '.$name.' '.$email.' <h5>'.$phone.'</h5></span></hr>';
    }
?>
<script>
    $("#liveSearchResults").change();
</script>    

