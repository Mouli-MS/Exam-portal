<?php
require_once 'admin/config/apply.php';

function validateAndUploadImage($questionId, $previousImage)
{
    if (!isset($_FILES['image']['name']) || $_FILES['image']['name'] === '') {
        return $previousImage;
    }

    $file = $_FILES['image'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array(strtolower($ext), $validExtensions)) {
        $_SESSION['invalid'] = "<div class='error'>Invalid Image type. Please use JPG, PNG, or GIF file type.</div>";
        header('location:' . SITEURL . 'admin/index.php?page=update_question&id=' . $questionId);
        exit;
    }

    $newImageName = 'Beyond_Boundaries_Question_' . uniqid() . '.' . $ext;
    $destination = '../images/questions/' . $newImageName;
    $uploadResult = move_uploaded_file($file['tmp_name'], $destination);

    if (!$uploadResult) {
        $_SESSION['upload'] = "<div class='error'>Failed to upload question image. Try again.</div>";
        header('location:' . SITEURL . 'admin/index.php?page=update_question&id=' . $questionId);
        exit;
    }

    if ($previousImage !== '') {
        $previousImagePath = "../images/questions/$previousImage";
        if (!unlink($previousImagePath)) {
            $_SESSION['remove_book'] = "Failed to remove previous Image. Try again.";
            header('location:' . SITEURL . 'admin/index.php?page=update_question&id=' . $questionId);
            exit;
        }
    }

    return $newImageName;
}

function updateQuestion($questionId, $questionData)
{
    global $conn;
    $questionId = $questionData['question_id'];

    $question = $obj->sanitize($conn, $questionData['question']);
    $firstAnswer = $obj->sanitize($conn, $questionData['first_answer']);
    $secondAnswer = $obj->sanitize($conn, $questionData['second_answer']);
    $thirdAnswer = $obj->sanitize($conn, $questionData['third_answer']);
    $fourthAnswer = $obj->sanitize($conn, $questionData['fourth_answer']);
    $fifthAnswer = $obj->sanitize($conn, $questionData['fifth_answer']);
    $answer = $obj->sanitize($conn, $questionData['answer']);
    $reason = $obj->sanitize($conn, $questionData['reason']);
    $marks = $obj->sanitize($conn, $questionData['marks']);
    $category = $obj->sanitize($conn, $questionData['category']);
    $faculty = $obj->sanitize($conn, $questionData['faculty']);
    $is_active = isset($questionData['is_active']) ? $questionData['is_active'] : 'yes';
    $updatedDate = date('Y-m-d');
    $previousImage = $questionData['image_name'];

    $image_name = validateAndUploadImage($questionId, $previousImage);

    $tbl_name = "tbl_question";
    $data = "
        question='$question',
        first_answer='$firstAnswer',
        second_answer='$secondAnswer',
        third_answer='$thirdAnswer',
        fourth_answer='$fourthAnswer',
        fifth_answer='$fifthAnswer',
        answer='$answer',
        reason='$reason',
        marks='$marks',
        category='$category',
        faculty='$faculty',
        is_active='$is_active',
        updated_date='$updatedDate',
        image_name='$image_name'
    ";
    $where = "question_id='$questionId'";
    $query = $obj->update_data($tbl_name, $data, $where);
    $res = $obj->execute_query($conn, $query);

    if ($res === true) {
        $_SESSION['update'] = "<div class='success'>Question successfully updated.</div>";
        header('location:' . SITEURL . 'admin/index.php?page=questions');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update question.</div>";
        header('location:' . SITEURL . 'admin/index.php?page=update_question&id=' . $questionId);
    }
}

function renderQuestionForm($questionData)
{
    ?>
    <div class="main">
        <div class="content">
            <div class="report">
                <form method="post" action="" class="forms" enctype="multipart/form-data">
                    <h2>Update Question</h2>
                    <?php
                    if (isset($_SESSION['validation'])) {
                        echo $_SESSION['validation'];
                        unset($_SESSION['validation']);
                    }
                    if (isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    ?>
                    <span class="name">Question</span>
                    <textarea name="question" required="true"><?php echo $questionData['question']; ?></textarea> <br />
                    <script>
                        CKEDITOR.replace('question');
                    </script>
                    <?php if ($questionData['previous_image'] !== "") : ?>
                        <span class="name">Previous Image</span>
                        <img src="<?php echo SITEURL; ?>images/questions/<?php echo $questionData['previous_image']; ?>" /><br />
                    <?php endif; ?>
                    <input type="hidden" name="previous_image" value="<?php echo $questionData['previous_image']; ?>" />
                    <span class="name">New Image</span>
                    <input type="file" name="image" /><br />
                    <span class="name">First Answer</span>
                    <input type="text" name="first_answer" value="<?php echo $questionData['first_answer']; ?>" required="true" /><br />
                    <span class="name">Second Answer</span>
                    <input type="text" name="second_answer" value="<?php echo $questionData['second_answer']; ?>" required="true" /><br />
                    <span class="name">Third Answer</span>
                    <input type="text" name="third_answer" value="<?php echo $questionData['third_answer']; ?>" required="true" /><br />
                    <span class="name">Fourth Answer</span>
                    <input type="text" name="fourth_answer" value="<?php echo $questionData['fourth_answer']; ?>" required="true" /><br />
                    <span class="name">Fifth Answer</span>
                    <input type="text" name="fifth_answer" value="<?php echo $questionData['fifth_answer']; ?>" required="true" /><br />
                    <span class="name">Answer</span>
                    <select name="answer">
                        <option <?php if ($questionData['answer'] == 1) {
                                    echo "selected='selected'";
                                } ?> value="1">First Answer</option>
                        <option <?php if ($questionData['answer'] == 2) {
                                    echo "selected='selected'";
                                } ?> value="2">Second Answer</option>
                        <option <?php if ($questionData['answer'] == 3) {
                                    echo "selected='selected'";
                                } ?> value="3">Third Answer</option>
                        <option <?php if ($questionData['answer'] == 4) {
                                    echo "selected='selected'";
                                } ?> value="4">Fourth Answer</option>
                        <option <?php if ($questionData['answer'] == 5) {
                                    echo "selected='selected'";
                                } ?> value="5">Fifth Answer</option>
                    </select>
                    <br />
                    <span class="name">Reason</span>
                    <textarea name="reason"><?php echo $questionData['reason']; ?></textarea>
                    <br />
                    <span class="name">Marks</span>
                    <input type="text" name="marks" value="<?php echo $questionData['marks']; ?>" />
                    <br />
                    <span class="name">Category</span>
                    <select name="category">
                        <option <?php if ($questionData['category'] == "English") {
                                    echo "selected='selected'";
                                } ?> value="English">English</option>
                        <option <?php if ($questionData['category'] == "Math") {
                                    echo "selected='selected'";
                                } ?> value="Math">Math</option>
                    </select>
                    <br />
                    <span class="name">Faculty</span>
                    <select name="faculty">
                        <?php
                        $tbl_name = "tbl_faculty";
                        $query = $obj->select_data($tbl_name);
                        $res = $obj->execute_query($conn, $query);
                        $count_rows = $obj->num_rows($res);

                        if ($count_rows > 0) {
                            while ($row = $obj->fetch_data($res)) {
                                $facultyId = $row['faculty_id'];
                                $facultyName = $row['faculty_name'];
                                $selected = $questionData['faculty'] == $facultyId ? "selected='selected'" : "";
                                echo "<option $selected value='$facultyId'>$facultyName</option>";
                            }
                        } else {
                            echo "<option value='0'>Uncategorized</option>";
                        }
                        ?>
                    </select>
                    <br />
                    <span class="name">Is Active?</span>
                    <input type="radio" name="is_active" value="yes" <?php if ($questionData['is_active'] === 'yes') {
                                                                            echo "checked='checked'";
                                                                        } ?>> Yes
                    <input type="radio" name="is_active" value="no" <?php if ($questionData['is_active'] === 'no') {
                                                                            echo "checked='checked'";
                                                                        } ?>> No
                    <br />
                    <input type="submit" name="submit" value="Update Question" class="btn-update" style="margin-left: 15%;" />
                    <a href="<?php echo SITEURL; ?>admin/index.php?page=questions"><button type="button" class="btn-delete">Cancel</button></a>
                </form>
            </div>
        </div>
    </div>
<?php
}

function getQuestionData($questionId)
{
    global $obj, $conn;

    $tbl_name = 'tbl_question';
    $where = "question_id = $questionId";
    $query = $obj->select_data($tbl_name, $where);
    $res = $obj->execute_query($conn, $query);
    $count_rows = $obj->num_rows($res);

    if ($count_rows === 1) {
        return $obj->fetch_data($res);
    }

    header('location:' . SITEURL . 'admin/index.php?page=questions');
    exit;
}

function handleFormSubmission($questionId)
{
    if (isset($_POST['submit'])) {
        $questionData = $_POST;
        updateQuestion($questionId, $questionData);
    }
}

function main()
{
    if (!isset($_GET['id'])) {
        header('location:' . SITEURL . 'admin/index.php?page=questions');
        exit;
    }

    $questionId = $_GET['id'];
    $questionData = getQuestionData($questionId);

    if (!empty($_SESSION['validation'])) {
        echo $_SESSION['validation'];
        unset($_SESSION['validation']);
    }
    if (!empty($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }

    renderQuestionForm($questionData);
    handleFormSubmission($questionId);
}

include('box/header.php');
main();
include('box/footer.php');
?>
<!--Body Ends Here-->
