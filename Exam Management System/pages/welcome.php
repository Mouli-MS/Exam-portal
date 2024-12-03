<?php 
    include('check.php');
?>
<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="welcome">
                    <?php 
                        if(isset($_SESSION['login']))
                        {
                            echo $_SESSION['login'];
                            unset($_SESSION['login']);
                        }
                        //Setting Time Limit Here
                        if(!isset($_SESSION['start_time']))
                        {
                            //$_SESSION['start_time']=
                        }
                    ?>
                    Hello <span class="heavy"><?php echo $_SESSION['student']; ?></span>. Welcome to RGUKT EXAM GAURDIAN.<br />
                    
                    <div class="success">
                        <p style="text-align: left;">
                            Here are some of the rules and regulations of this app.<br />
                            1. This test is automated and you won't be able to return to previous question.<br />
                            2. Once you successfully login, you can't log back in unless the permission of system administrator.<br />
                            3. After you click on "Take a Test", the timer will start and it can't be paused or stopped.<br />
                            4. All questions will appear one by one  and  you have to attempt those.<br /> 
                            5. If you refresh your browser question will be changed.<br />
                        </p>
                    </div>
                    
                    <a href="<?php echo SITEURL; ?>index.php?page=question">
                        <button type="button" class="btn-go">Take a Test</button>
                    </a>
                    <a href="<?php echo SITEURL; ?>index.php?page=logout">
                        <button type="button" class="btn-exit">&nbsp; Quit &nbsp;</button>
                    </a>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->