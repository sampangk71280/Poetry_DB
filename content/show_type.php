    <!--- Type tags go here-->
    <p>
        <?php
        $type_ID = $find_rs['Type_ID'];

        // loop through Type ID's and look up the era name

        // Get Type name
        $type_sql = "SELECT * FROM `type` WHERE `Type_ID` = $type_ID";
        $type_query = mysqli_query($dbconnect, $type_sql);
        $type_rs = mysqli_fetch_assoc($type_query);

        if($type_ID !=0) 
        {
        ?>

        <!--- Show Type tags -->
        <span class="tag">
            <a href="index.php?page=type&typeID=<?php ?>"></a>
            <?php echo $type_rs['type'];?>
        </span> &nbsp;

        <?php
        } // end type exists if

       

