<?php 

if(!isset($_REQUEST['eraID']))
{
    header('Location: index.php');
}

$era_to_find = $_REQUEST['eraID'];

    // get era heading... 
    $era_sql = "SELECT * FROM `era` WHERE `era_ID` = $era_to_find";
    $era_query = mysqli_query($dbconnect, $era_sql);
    $era_rs = mysqli_fetch_assoc($era_query);
?>

<h2>Era Results (<?php echo $era_rs['era'] ?>)</h2>

<?php 

// get poems
$find_sql = "SELECT * FROM `poetry` JOIN `author` 
ON(`author`.`Author_ID` = `poetry`.`Author_ID`)
WHERE `era_ID` = $era_to_find
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);


if($count > 0) {

// loop through results and display them... 
do {

    $poem = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Content']);
    $title = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Title']);

    // get author name
    include("get_author.php");
?>


<!-- shows result  -->
<div class="results">
    
    <!-- show title -->
    <h5>
        <?php echo $title; ?>
        <!-- get era -->
        <?php include("show_era_type.php");?>
    </h5>

    <p>
        <!-- show poem  -->
        <?php echo $poem; ?><br /><br />

        <!-- show author name  -->
        <span class="authortag"> 
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];?>">
        <?php echo $author_name; ?></a>
        </span>   

        &ensp;
        <!-- show era  -->
        <span class="tag">
        <a href="index.php?page=era&eraID=<?php echo $find_rs['Era_ID'];?>">
        <?php echo $era_rs['era']; ?></a></span>
        
        &ensp;

        <!-- show type  -->
        <span class="tag">
        <a href="index.php?page=type&typeID=<?php echo $find_rs['Type_ID'];?>">
        <?php echo $type_rs['type'];?></a></span>


</div>

<br />

<?php

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query));
    } // end if results exist if 

else {
    // no results - display error
?>

<p>&nbsp;</p>

<?php
}

?> 