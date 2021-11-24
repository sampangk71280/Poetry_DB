<?php
// cehck user is logged in 
if (isset($_SESSION['admin'])) {

    // get authors from database
    $all_authors_sql = "SELECT * FROM `author` ORDER BY `name` ASC";
    $all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
    $all_authors_rs = mysqli_fetch_assoc($all_authors_query); 

    // initialise author form 
    $authorname = "";
    
    // Code below executes when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

// Get values from form... 
$author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);
$_SESSION['Add_Poem']=$author_ID;
header('Location: index.php?page=../admin/add_entry');

} // end submit button pushed if 

} // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

} // end user not logged in else

?>

<h1>Add a Poem</h1>
<p><i>
    To add a poem, first select the author, then press the 'next' button.
    Unfortunately, new authors cannot be added. The author names are listed
    alphabetically by
    <b>first</b> name.
</i></p>

<form method="post" enctype="multipart/form-data" 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/new_poem");?>">

    <div>
        <b>Poem Author:</b> &nbsp;

        <select name="author">
            <!-- Default option is select author -->
            <option value="unknown" selected>Select Author</option>

            <?php
            
            do {

                // get authors full name 
                $author_full = $all_authors_rs['name'];
            ?>

                <option value="<?php echo $all_authors_rs['author_ID']; ?>">
                    <?php echo $author_full; ?>
                </option>  

            <?php
            } // end of the author options 'do'

            while($all_authors_rs=mysqli_fetch_assoc($all_authors_query))
            
            ?>

        </select>
            &nbsp;
        
        <input class="short" type="submit" name="quote_author"
        value="Next..."/>

    </div
    >
</form>

&nbsp;