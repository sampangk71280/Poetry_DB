<?php
// check user is logged in 
if (isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];
    echo "Author ID:".$ID;

    // Get Author ID
    $find_sql = "SELECT * FROM `poetry`
    JOIN author ON(`author`.`Author_ID` = `poetry`.`Author_ID`) 
    WHERE `poetry`.`ID` = $ID";

    $find_query= mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);

    $author_ID = $find_rs['author_ID'];
    $author_name = $find_rs['name'];

    
    // get era / type list from database
    $era_sql = "SELECT * FROM `era` ORDER BY `era`.`era` ASC";
    $type_sql = "SELECT * FROM `type` ORDER BY `type` ASC";
    $all_era = autocomplete_list($dbconnect, $era_sql, 'era');
    $all_type = autocomplete_list($dbconnect, $type_sql, 'type');

    // Retrieve data to populate the form...
    $poem = $find_rs['Content'];
    
    // Get era/type to populate tags... 
    $era_ID = $find_rs['Era_ID'];
    $type_ID = $find_rs['Type_ID'];

    // Retrieve era names from era table... 
    $era_rs = get_rs($dbconnect, "SELECT * FROM `era` WHERE era_ID = $era_ID");
    $era = $era_rs['era'];

    // Retrieve type names from type table... 
    $type_rs = get_rs($dbconnect, "SELECT * FROM `type` WHERE type_ID = $type_ID");
    $type = $type_rs['type'];
	 

// initialise tag ID's
$era_ID = $type_ID = 0; 

$has_errors = "no";

// set up error fields / visibility
$poem_error = $era_tag_error = $type_tag_error = "no-error";
$poem_field = "form-ok";
$era_tag_field = "tag-ok";
$type_tag_field = "tag-ok";

// Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get data from form
    $author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);
    $poem = mysqli_real_escape_string($dbconnect, $_POST['poem']);
    $era_tag = mysqli_real_escape_string($dbconnect, $_POST['Era']);
    $type_tag = mysqli_real_escape_string($dbconnect, $_POST['type']);

    // check data is valid

    // check poem is not blank
    if ($poem == "Please type your poem here" || $poem == "" ) {
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
    
	echo "no errors";

    // Get tag ID's via get_ID function... 
    $eraID = get_ID($dbconnect, 'era', 'era_ID', 'era', $era_tag);
    $typeID = get_ID($dbconnect, 'type', 'type_ID', 'type', $type_tag);

    // edit database entry
    $editentry_sql= "UPDATE `poetry` SET `Author_ID` = '$author_ID', `Content` = '$poem', `Era_ID` = '$era_ID', `Type_ID` = '$type_ID', WHERE `poetry`.`ID` = $ID";
    $editentry_query = mysqli_query($dbconnect, $editentry_sql);
	

    // get Poem ID for next page
    $get_poem_sql = "SELECT * FROM `poetry` WHERE `ID` = '$ID' ";
    $get_poem_query = mysqli_query($dbconnect, $get_poem_sql);
    $get_poem_rs = mysqli_fetch_assoc($get_poem_query);

   $poem_ID = $get_poem_rs['ID'];
   $_SESSION['Poem_Success']=$poem_ID;

    // Go to success page... 
    header('Location: index.php?page=editpoem_success&poem_ID='.$poem_ID);

    } // end add entry to database if


} // end submit button if 

} // end if user logged in 

else {

    $login_error = 'Please login to access this page';
    //header("Location: index.php?page=../admin/login&error=$login_error");

} // end user not logged in else

?>

<h1>Edit Poem</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/editpoem&ID=$ID");?>"
enctype="multipart/form-data">

    <b>Poem Author:</b> &nbsp; &nbsp;

    <select name="author">
        <!-- Default option is new author -->
        <option value="<?php echo $author_ID; ?>" selected> 
            <?php echo $author_name; ?>
        </option>
        

        <?php
        
     // get authors from database
     $all_authors_sql = "SELECT * FROM `author` ORDER BY `name` ASC";
     $all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
     $all_authors_rs = mysqli_fetch_assoc($all_authors_query); 

        do {

        $author_ID = $all_authors_rs['Author_ID'];
        $author_name = $all_authors_rs['name'];

        ?>

            <option value="<?php echo $author_ID; ?>">
                <?php echo $author_name; ?>
            </option>  

        <?php
        } // end of the author options 'do'

        while($all_authors_rs=mysqli_fetch_assoc($all_authors_query))
        
        ?>

    </select>
    
    <br /> <br />

    <!-- Quote text area -->
    <div class="<?php echo $poem_error; ?>"> 
        This field can't be blank   
    </div>
    
    <textarea class="add-field<?php echo $poem_field?>" name="poem"
    row="6"><?php echo $poem; ?></textarea>
    <br/><br/>

   <!-- Era  -->    
    <div class="<?php echo $era_tag_error ?>">
        Please enter an era!
    </div>
    
   <div class="autocomplete"> 
       <input class="<?php echo $era_tag_field; ?>" id="era" value="<?php echo $era; ?>"
       type="text" name="Era" placeholder="Era (start typing)...">
    </div>

    <br /><br />

   <!--  Type  -->
   <div class="<?php echo $type_tag_error?>">
        Please enter the type of poem!
    </div>
    
    <div class="autocomplete"> 
       <input class="<?php echo $type_tag_field; ?>" id="type" value="<?php echo $type; ?>"
       type="text" name="type" placeholder="Type (start typing)...">
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