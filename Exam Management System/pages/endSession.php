<?php 
    include('check.php');
    
    // Inserting Summary Result Here
    $totalScore = isset($_SESSION['totalScore']) ? $_SESSION['totalScore'] : 0;

    $tbl_name = "tbl_student";
    $query = $obj->select_data($tbl_name);
    $res = $obj->execute_query($conn, $query);
    $count_rows = $obj->num_rows($res);
    $sn = 1;
    if($count_rows > 0) {
        while($row = $obj->fetch_data($res)) {
            $id_number = $row['id_number'];
        }
    }

    $tbl_name = "tbl_student";
    $username = $_SESSION['student'];
    $student_id = $obj->get_userid($tbl_name, $username, $conn);
    $tbl_name = "tbl_result_summary ORDER BY added_date DESC";
   
    // Add result summary to the database
    $added_date = date('Y-m-d');
    $tbl_name2 = "tbl_result_summary";
    $data = "student_id='$student_id',
             id_number='$id_number',
             marks='$totalScore',
             added_date='$added_date'
            ";
    $query = $obj->insert_data($tbl_name2, $data);
    $res = $obj->execute_query($conn, $query);
?>

<!-- Rewrite in a different way -->
<div class="main">
    <div class="content">
        <div class="welcome">
            <?php 
                if(isset($_SESSION['time_complete'])) {
                    echo $_SESSION['time_complete'];
                }
            ?>
            You have successfully completed the test. Thank You.<br />
            <?php 
                $tbl_name = 'tbl_student';
                $username = $_SESSION['student'];
                // Get Student ID from username
                $userid = $obj->get_userid($tbl_name, $username, $conn);
                // Getting Summary Result from the database
                $tbl_name3 = "tbl_result_summary";
                $where3 = "student_id=$userid ORDER BY summary_id DESC LIMIT 1";
                $query = $obj->select_data($tbl_name3, $where3);
                $res = $obj->execute_query($conn, $query);
                $row = $obj->fetch_data($res);
                $marks = $row['marks'];
                $added_date = date('Y-m-d');

                // Calculate Marks for different faculties
                $obtainedMarks = $_SESSION['totalScore'];
                $full_marks = $_SESSION['full_marks'];
                $obtainedPercent = ($obtainedMarks/$full_marks) * 100;
                
                // Get Student ID
                // Get Faculty ID from Student ID then Show full marks based on the faculty and obtained percentage
                if($_SESSION['facultyName'] == 'GRE') {
                    $marksShown = 260 + round($obtainedPercent * 0.8);
                } elseif($_SESSION['facultyName'] == 'GMAT') {
                    $marksShown = 200 + round($obtainedPercent * 6);
                } else {
                    $marksShown = $obtainedMarks;
                }

                $_SESSION['USERID'] = $userid;
                
                // Round Off Marks
                $lastDigit = substr($marksShown, -1);
                if($lastDigit < 5) {
                    $realMark = $marksShown - $lastDigit;
                } else {
                    $digitToAdd = 10 - $lastDigit;
                    $realMark = $marksShown + $digitToAdd;
                }
            ?>
            
            You got <h2><?php echo $realMark; ?></h2>
            
            <a href="<?php echo SITEURL; ?>index.php?page=detail_result">
                <button type="button" class="btn-exit">View Result</button>
            </a>
            
            <a href="<?php echo SITEURL; ?>index.php?page=logout">
                <button type="button" class="btn-exit">Log Out</button>
            </a>
        </div>
    </div>
</div>