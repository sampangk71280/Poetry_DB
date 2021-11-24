
<?php 

$quick_find = mysqli_real_escape_string($dbconnect, $_POST['quick_search']);

// Find Eype ID
$type_sql = "SELECT * FROM `type` WHERE `type` LIKE '%$quick_find%'";
$type_query = mysqli_query($dbconnect, $type_sql);
$type_rs = mysqli_fetch_assoc($type_query);

$type_count = mysqli_num_rows($type_query);

if ($type_count > 0 ) {
    $type_ID = $type_rs['type_ID'];
    
}

else{
    // If this is not set query below breaks
    // If it is set to zero, any poem which has less than three subjects will be displayed
    $type_ID = "-1";
}


// Find Era ID
// Find Eype ID
$era_sql = "SELECT * FROM `era` WHERE `era` LIKE '%$quick_find%'";
$era_query = mysqli_query($dbconnect, $era_sql);
$era_rs = mysqli_fetch_assoc($era_query);

$era_count = mysqli_num_rows($era_query);

if ($era_count > 0 ) {
    $era_ID = $era_rs['era_ID'];
    
}

else{
    // If this is not set query below breaks
    // If it is set to zero, any poem which has less than three subjects will be displayed
    $era_ID = "-1";
}

$find_sql = "SELECT * FROM `poetry`
JOIN author ON(`author`.`Author_ID` = `poetry`.`Author_ID`)
WHERE `name` LIKE '%$quick_find%'
OR `Type_ID` = $type_ID
OR `Era_ID` = $era_ID
";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

?>

<h2>Quick Search Results (Search Term: <?php echo $quick_find ?>) </h2>

<?php

if($count > 0) {

// loop through results and display them... 
do {

    $content = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Content']);
    $title = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Title']);

    // get author name
    include("get_author.php");

    ?>
    
<div class="results">
    <!-- show title -->
    <h5>
        <?php echo $title; ?>
        <!-- get era -->
        <?php include("show_era_type.php");?>
    </h5>

    <p>
        <?php echo $content; ?><br /><br />

         <!-- show author name -->
         <span class= "authortag">
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];?>">    
        <?php echo $author_name; ?>
        
        </a>
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
    </p>

</div>

<br />

<?php

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query));
    } // end if results exist if 

else {
    // no results - display error
?>

<h2>Oops!</h2>

    <div class="error">
        Sorry - there are no poems that match the search term <i><b>
        <?php echo $quick_find?></b></i>. Please try again.
    </div>

<p>&nbsp;</p>

<?php
}

?> 