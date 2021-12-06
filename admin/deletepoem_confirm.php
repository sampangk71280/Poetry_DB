<?php
// cehck user is logged in 
if (isset($_SESSION['admin'])) {
    
    $poem_ID = $_REQUEST['ID'];

    $deletepoem_sql = "SELECT * FROM `poetry` WHERE `ID` =".$_REQUEST['ID'];
    $deletepoem_query = mysqli_query($dbconnect, $deletepoem_sql);
    $deletepoem_rs = mysqli_fetch_assoc($deletepoem_query);

    ?>

<h2>Delete Poem - Confirm</h2>

<p>Do you really want to delete the following poem...<br />
<i><?php echo $deletepoem_rs['Content']; ?></i></p>

<p>
    <a href="index.php?page=../admin/deletepoem&ID=<?php echo $_REQUEST['ID']; ?>">
    <span class="deletetag"> Yes, delete it!</a></span>
    | <a href="index.php"><span class="deletetagno"> No, take me home</a></span>
</p>

<?php
} // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

} // end user not logged in else

?>