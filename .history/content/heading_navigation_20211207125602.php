
        <div class="box banner">
            
    
            <h1><a class="heading" href = "index.php?page=home">Quick Poetry</a></h1>
        </div>    <!-- / banner -->

        <!-- Navigation goes here.  Edit BOTH the file name and the link name -->
        <div class="box nav">
            
            <div class="linkwrapper">
                <div class="commonsearches"> 
                    <a href="index.php?page=recent">Recent</a> | 
                    <a href="index.php?page=random">Random</a> 
                </div>  <!-- / common searches -->
            
                <div class="topsearch">
                    
                    <!-- Quick Search -->           
                    <form method="post" action="index.php?page=quick_search" 
                    enctype="multipart/form-data">

                        <input class="search quicksearch" type="text" 
                        name="quick_search" size="10" value="" required placeholder="Quick Search..." />

                        <input class="submit" type="submit" name="find_quick" value="&#xf002;" />
                    
                </div>  <!-- / top search -->
                
                <div class="topadmin">

                <?php 

                    if (isset($_SESSION['admin'])) {

                    ?> 

                    <a href="index.php?page=../admin/new_poem" title="Add a quote"><i class="fa fa-plus fa-2x"></i></a>

                    &nbsp; &nbsp;

                    <a href="index.php?page=../admin/logout" title="Log Out"> 
                        <i class="fa fa-sign-out fa-2x"></i>
                    </a>

                    <?php
                    } // end user if logged in if   

                    else {
                        ?>

                    <a href="index.php?page=../admin/login" title="Log In">
                        <i class="fa fa-sign-in fa-2x"></i>
                    </a>

                    <?php // end of login else
                    }

                    ?>

                    
                </div>  <!-- / top admin -->
                
            </div>  <!--- / link wrapper -->
            
        </div>    <!-- / nav -->        
        