<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="report">
                    <h2>FACULTY MANAGER</h2>
                    <a href="<?php echo SITEURL; ?>admin/index.php?page=add_faculty">
                        <button type="button" class="btn-add">Add Faculty</button>
                    </a>
                    <div>
                        <form method="post" action="">
                              <button type="submit" class="btn-add" name="active">Active All The Faculties</button>
                          <?php 
                             if (isset($_POST['active'])) {
                                    // Retrieve and sanitize the table name and column name
                                    $table = 'tbl_faculty'; // Replace with your actual table name
                                    $column = 'is_active'; // Replace with your actual column name

                                    // Prepare and execute the SQL query to update all faculty to "yes" for the "is_active" column
                                    $query = "UPDATE $table SET $column = 'yes'";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                    $_SESSION['update'] = "<div class='success'>All faculties have been activated.</div>";
                                    header('location:'.SITEURL.'admin/index.php?page=faculties');
                                    exit();
                                    } else {
                                    $_SESSION['update'] = "<div class='error'>Failed to update faculty' activation status.</div>";
                                    header('location:'.SITEURL.'admin/index.php?page=faculties');
                                    exit();
                                    }
                                }
                            ?>
                        </form>
                    </div>
                    <div>
                        <form method="post" action="">
                              <button type="submit" class="btn-delete" name="deactivate">Deactivate All The Faculties</button>
                                <?php 
                                    if (isset($_POST['deactivate'])) {
                                        // Retrieve and sanitize the table name and column name
                                        $table = 'tbl_faculty'; // Replace with your actual table name
                                        $column = 'is_active'; // Replace with your actual column name

                                        // Prepare and execute the SQL query to update all faculties to "no" for the "is_active" column
                                        $query = "UPDATE $table SET $column = 'no'";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                        $_SESSION['update'] = "<div class='success'>All faculties have been deactivated.</div>";
                                        header('location:'.SITEURL.'admin/index.php?page=faculties');
                                        exit();
                                        } else {
                                        $_SESSION['update'] = "<div class='error'>Failed to update faculty' deactivation status.</div>";
                                        header('location:'.SITEURL.'admin/index.php?page=faculties');
                                        exit();
                                        }
                                    }
                                ?>
                        </form>
                    </div>
                    <?php 
                        if(isset($_SESSION['add']))
                        {
                            echo $_SESSION['add'];
                            unset($_SESSION['add']);
                        }
                        if(isset($_SESSION['update']))
                            {
                                echo $_SESSION['update'];
                                unset($_SESSION['update']);
                            }
                        if(isset($_SESSION['delete']))
                            {
                                echo $_SESSION['delete'];
                                unset($_SESSION['delete']);
                            }
                    ?>
                    
                    <table>
                        <tr>
                            <th>S.N.</th>
                            <th>Faculty Title</th>
                            <th>Time Duration</th>
                            <th>Qns Per Exam</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php 
                            //Getting all the faculties from database
                            $tbl_name="tbl_faculty ORDER BY faculty_id DESC";
                            $query=$obj->select_data($tbl_name);
                            $res=$obj->execute_query($conn,$query);
                            $count_rows=$obj->num_rows($res);
                            $sn=1;
                            if($count_rows>0)
                            {
                                while($row=$obj->fetch_data($res))
                                {
                                    $faculty_id=$row['faculty_id'];
                                    $faculty_name=$row['faculty_name'];
                                    $time_duration=$row['time_duration'];
                                    $qns_per_page=$row['qns_per_set'];
                                    $is_active=$row['is_active'];
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $faculty_name; ?></td>
                                        <td><?php echo $time_duration; ?></td>
                                        <td><?php echo $qns_per_page; ?></td>
                                        <td><?php echo $is_active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/index.php?page=update_faculty&id=<?php echo $faculty_id; ?>"><button type="button" class="btn-update">UPDATE</button></a> 
                                            <a href="<?php echo SITEURL; ?>admin/pages/delete.php?id=<?php echo $faculty_id; ?>&page=faculties"><button type="button" class="btn-delete" onclick="return confirm('Are you sure?')">DELETE</button></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "<tr><td colspan='6'><div class='error'>No faculties added.</div></td></tr>";
                            }
                        ?>
                        
                        
                    </table>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->