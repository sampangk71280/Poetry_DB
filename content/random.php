<h2>Random</h2>

<?php 

$find_sql = "SELECT * FROM `poetry` JOIN `author` ON(`author`.`Author_ID` = `poetry`.`Author_ID`) ORDER BY RAND() LIMIT 5";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// loop through results and display them... 
do {

    $title = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Title']);
    $content = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Content']);

    // get author name
    include("get_author.php");
    // get era
    include("show_era.php");

    ?>
<div class="results">
    <!-- show title -->
    <h5>
        <?php echo $title; ?>
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
    </p>

    <!-- show era tag -->
    <span class="tag">
        <a href="index.php?page=era&eraID=<?php echo $find_rs['Era_ID'];?>">
        <?php echo $era_rs['era']; ?>
        </a>
        </span>

    <?php include("show_type.php"); ?>

  
       

</div>

<br />

<?php

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))

?>