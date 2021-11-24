<?php 

if(!isset($_REQUEST['authorID']))
{
    header('Location: index.php');
}

$author_to_find = $_REQUEST['authorID'];

$find_sql = "SELECT * FROM `poetry`
JOIN author ON(`author`.`Author_ID` = `poetry`.`Author_ID`) 
WHERE `poetry`.`Author_ID` = $author_to_find
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// get author name
include("get_author.php");
?> 

<br /> <br />
<div class="about">
    <h2>
        <?php echo $author_name, " - all poems";?>
    </h2>
</div> <!-- / about the author div --> 

<?php
// loop through titles and display
do {
    $title = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Title']);
     
    // get era 
     include("show_era_type.php");
    

?>

<br />


<br />

<?php

    $content = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Content']);


    ?>
<div class="results">
    <h5>
        <?php echo $title; ?>
     </h5>   

    <p>
        <?php echo  $content; ?><br /><br />
    
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


<?php

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))

?>