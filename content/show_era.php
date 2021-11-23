    <!--- Era tags go here-->
    <p>
        <?php
        $era_ID = $find_rs['Era_ID'];

        // loop through era ID's and look up the era name

        // Get era name
        $era_sql = "SELECT * FROM `era` WHERE `era_ID` = $era_ID";
        $era_query = mysqli_query($dbconnect, $era_sql);
        $era_rs = mysqli_fetch_assoc($era_query);

        
