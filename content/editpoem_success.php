<h2>Edit Success!</h2>

<p>You have edited the following poem</p>

<?php 

$poem_ID = $_REQUEST['poem_ID'];   

$find_sql = "SELECT * FROM `poetry`
JOIN author ON(`author`.`Author_ID` = `poetry`.`Author_ID`) 
WHERE `poetry`.`ID` = $poem_ID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);


// loop through results and display them... 
do {

    $title = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Title']);
    $content = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Content']);

    // get author name
    include("get_author.php");
    
    ?>

<div class="results">
    
    <!-- show title -->
    <h5>
        <?php echo $title; ?>
        <?php
            // get era 
            include("show_era_type.php");
        ?>
    </h5>

    <!-- show content  -->
    <p>   
        <?php echo $content; ?><br /> <br />

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

while($find_rs = mysqli_fetch_assoc($find_query))

?>