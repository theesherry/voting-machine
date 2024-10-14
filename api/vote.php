<?php
session_start();
include("connect.php");
$votes=$_POST['gid'];
$totalvotes=$votes+1;
$gss=$_POST['gss'];
$userid=$_SESSION['userdata']['id'];

$updatevotes=mysqli_query($connect,"UPDATE user SET votes='$totalvotes' WHERE id='$gss'");
$updateuserstatus=mysqli_query($connect,"UPDATE user SET status=1 WHERE id='$userid'");
 
if($updatevotes and $updateuserstatus){
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Store user and groups data in session

    $_SESSION['userdata']['status'] = 1;
    $_SESSION['groupsdata'] = $groupsdata;
   
}
    else{
         echo '
    <script>
        alert("some error occured");
        window.location = "../routes/dashboard.php";
    </script>';
}



?>