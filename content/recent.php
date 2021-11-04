<h2>Recent</h2>

<?php 

$find_sql = "SELECT * FROM `poetry` JOIN `author` ON(`author`.`Author_ID` = `poetry`.`Author_ID`) ORDER BY `ID` DESC";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// loop through results and display them... 
do {

    $quote = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['context']);

    // get author name
    include("get_author.php");

    ?>
<div class="results">
    <p>
        <?php echo $quote; ?><br />
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];
        ?>">
            <?php echo $full_name; ?>
        </a>
    </p>

</div>

<br />

<?php

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))

?>