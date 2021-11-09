
<?php 

$quick_find = mysqli_real_escape_string($dbconnect, $_POST['quick_search']);

// Find subject ID
$content_sql = "SELECT * FROM `poetry` WHERE `Content` LIKE '%$quick_find%'";
$content_query = mysqli_query($dbconnect, $content_sql);
$content_rs = mysqli_fetch_assoc($content_query);

$content_count = mysqli_num_rows($content_query);

if ($content_count > 0 ) {
    $content_ID = $content_rs['Content'];
}

else{
    // If this is not set query below breaks
    // If it is set to zero, any poem which has less than three subjects will be displayed
    $content_ID = "-1";
}

$find_sql = "SELECT * FROM `poetry`
JOIN author ON(`author`.`Author_ID` = `Content`.`Author_ID`)
WHERE `name` LIKE '%$quick_find%'
OR `Content` = $content_ID
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

    // get author name
    include("get_author.php");

    ?>
    
<div class="results">
    <p>
        <?php echo $content; ?><br />
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];
        ?>">
            <?php echo $author_name; ?>
        </a>
    </p>

    <?php include("show_era.php"); ?>
    <?php include("show_type.php"); ?>


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