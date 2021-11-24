<?php
// cehck user is logged in 
if (isset($_SESSION['admin'])) {

    $author_ID = $_SESSION['Add_Poem'];
    echo "AuthorID: ".$author_ID;

    // get era / type list from database
    $era_sql = "SELECT * FROM `era` ORDER BY `era`.`era` ASC";
    $type_sql = "SELECT * FROM `type` ORDER BY `type` ASC";
    $all_era = autocomplete_list($dbconnect, $era_sql, 'era');
    $all_type = autocomplete_list($dbconnect, $type_sql, 'type');
    
    // initialise form variables for poem
    $poem = "Please type your poem here";
    $title = "";
    $era_tag = "";
    $type_tag = "";

// initialise tag ID's
$era_tag = $type_tag = 0; 

$has_errors = "no";

// set up error fields / visibility
$poem_error = $era_tag_error = $type_tag_error = "no-error";
$poem_field = "form-ok";
$era_tag_field = "tag-ok";
$type_tag_field = "tag-ok";


// Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get data from form
    $poem = mysqli_real_escape_string($dbconnect, $_POST['poem']);
    $title = mysqli_real_escape_string($dbconnect, $_POST['title']);
    $era_tag = mysqli_real_escape_string($dbconnect, $_POST['Era']);
    $type_tag = mysqli_real_escape_string($dbconnect, $_POST['Type']);
    


    // check data is valid

    // check poem is not blank
    if ($poem == "Please type your poem here" || $poem == " " ) {
        $has_errors = "yes";
        $poem_error = "error-text";
        $poem_field = "form-error";
    }

    // check that era has been filled in
    if($era_tag == ""){
        $has_errors = "yes";
        $era_tag_error = "error-text";
        $era_tag_field = "tag-error";
    }

    // check that type has been filled in
    if($type_tag == ""){
        $has_errors = "yes";
        $type_tag_error = "error-text";
        $type_tag_field = "tag-error";
    }

if($has_errors != "yes") {

    // Get tag ID's via get_ID function... 
    $eraID = get_ID($dbconnect, 'era', 'era_ID', 'era', $era_tag);
    $typeID = get_ID($dbconnect, 'type', 'type_ID', 'type', $type_tag);
    

    // add entry to the database
    $addentry_sql = "INSERT INTO `poetry` (`ID`, `Author_ID`, `Content`, `Title`, `Era_ID`, `Type_ID`) 
    VALUES (NULL, '$author_ID', '$poem', '$title', '$eraID', '$typeID');";
    $addentry_query = mysqli_query($dbconnect, $addentry_sql);

    // get Poem ID for next page
    $get_poem_sql = "SELECT * FROM `poetry` WHERE `Content` = '$poem'";
    $get_poem_query = mysqli_query($dbconnect, $get_poem_sql);
    $get_poem_rs = mysqli_fetch_assoc($get_poem_query);

   $poem_ID = $get_poem_rs['ID'];
   $_SESSION['Poem_Success']=$poem_ID;

    // Go to success page... 
    header('Location: index.php?page=poem_success');

} // end add entry to database if


} // end submit button if 

} // end if user logged in 

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

} // end user not logged in else

?>

<h1>Add Poem...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>"
enctype="multipart/form-data">

    <!-- Title  -->
    <input class="add-field <?php echo $title; ?>" type="text"
        name="title" value="<?php echo $title; ?>" placeholder="Title (optional).."/>

    <br/><br/>

    <!-- Poem text area -->
    <div class="<?php echo $poem_error; ?>"> 
        This field can't be blank   
    </div>
    
    <textarea class="add-field <?php echo $poem_field?>" name="poem"
    row="6"><?php echo $poem; ?></textarea>
    <br/><br/>


    <!-- Era  -->    
    <div class="<?php echo $era_tag_error ?>">
        Please enter an era!
    </div>
    
   <div class="autocomplete"> 
       <input class="<?php echo $era_tag_field; ?>" id="era"
       type="text" name="Era" placeholder="Era (start typing)...">
    </div>

    <br /><br />

    <!--  Type  -->
    <div class="<?php echo $type_tag_error?>">
        Please enter the type of poem!
    </div>
    
    <div class="autocomplete">
        <input id="type" type="text" name="Type"
        placeholder="Type (start typing)">
    </div>

    <br /><br />

    <!-- Submit Button -->
    <p>
        <input type="submit" value="Submit" />
    </p>

</form>

<!-- script to make autocomplete work -->
<script>
<?php include("autocomplete.php"); ?>

/* Array containing lists */
var all_era = <?php print("$all_era"); ?>;
var all_type = <?php print("$all_type"); ?>;
autocomplete(document.getElementById("era"), all_era);
autocomplete(document.getElementById("type"), all_type);
</script>
