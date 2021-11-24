        <?php
        $era_ID = $find_rs['Era_ID'];

        // loop through era ID's and look up the era name

        // Get era name
        $era_sql = "SELECT * FROM `era` WHERE `era_ID` = $era_ID";
        $era_query = mysqli_query($dbconnect, $era_sql);
        $era_rs = mysqli_fetch_assoc($era_query);

        $type_ID = $find_rs['Type_ID'];

        // loop through Type ID's and look up the era name

        // Get Type name
        $type_sql = "SELECT * FROM `type` WHERE `Type_ID` = $type_ID";
        $type_query = mysqli_query($dbconnect, $type_sql);
        $type_rs = mysqli_fetch_assoc($type_query);


        // if logged in, show edit / delete options... 
        if(isset($_SESSION['admin'])) {
                
                ?>

            <div class="edit-tools">
            <a href="index.php?page=../admin/editquote&ID=<?php echo 
            $find_rs['ID'];?>" title="Edit Quote">
            <i class="fa fa-edit fa-2x"></i></a>

            &nbsp; &nbsp; 
            <a href="index.php?page=../admin/deletequote_confirm&ID=<?php echo
            $find_rs['ID']; ?>" title="Delete Quote">
            <i class="fa fa-trash fa-2x"></i></a>

            </div> <!-- / edit tools div --> 
        
            <?php
            }

        ?>