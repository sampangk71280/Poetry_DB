<?php
// cehck user is logged in 
if (isset($_SESSION['admin'])) {
    
    // delete quote!
    $deletepoem_sql = "DELETE FROM `poetry` WHERE `poetry`.`ID`=".$_REQUEST['ID'];
    $deletepoem_query = mysqli_query($dbconnect, $deletepoem_sql);

?>

<h1>Delete Success</h1>

<p>The poem has been deleted</p>

<?php

} // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

} // end user not logged in else

?>