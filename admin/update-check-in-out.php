<?php
require_once "validuser.php";

//Required API
require_once  "../api/group-data.php";


if(isset($_POST["submit"]) && isset($_POST['group'])){
    $group = htmlspecialchars($_POST['group'], ENT_QUOTES);

    $check_in_out = checkInOut($group);

    if($check_in_out['check_in'] == "0000-00-00 00:00:00"){
        $query = "UPDATE groups SET check_in = now() WHERE group_name = '".$group."'";

        global $link;
        $result = mysqli_query($link, $query);

        if($result){
            header("location: index.php?action=group-checked-in");
        }
        else{
            header("location: index.php?action=error");
        }
    }
    else{
        $query = "UPDATE groups SET check_out = now() WHERE group_name = '".$group."'";

        global $link;
        $result = mysqli_query($link, $query);

        if($result){
            header("location: index.php?action=group-checked-out");
        }
        else{
            header("location: index.php?action=error");
        }
    }
}
else{
    header("location: index.php?action=error");
}
?>
