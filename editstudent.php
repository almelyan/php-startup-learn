<?php
    session_start();
    require_once 'appcore/users.php';
    require_once 'appcore/students.php';
    require_once 'template/register.php';

    if( !is_login() || $_SESSION['account'] == 'U' ){
        header('Location:login.php');
        exit;
    }

    $student_tcn = '';
    $first_name  = '';
    $last_name   = '';
    $birth_date  = '';
    $address     = '';
    $phone       = '';
    $email       = '';

    $studentId   = $_GET['id'];
    $studentInfo = null;
    if( is_numeric($studentId) && $studentId > 0 ){
        $studentInfo = get_student($studentId);

        if( !is_null($studentInfo) ){
            $student_tcn = $studentInfo['TCNo'];
            $first_name  = $studentInfo['FirstName'];
            $last_name   = $studentInfo['LastName'];
            $birth_date  = $studentInfo['BirthDate'];
            $address     = $studentInfo['Address'];
            $phone       = $studentInfo['Phone'];
            $email       = $studentInfo['Email'];

            if( isset($_POST['submit']) ){
                $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
                $last_name  = isset($_POST['last_name'])  ? $_POST['last_name']  : '';
                $birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : '';
                $address    = isset($_POST['address'])    ? $_POST['address']    : '';
                $phone      = isset($_POST['phone'])      ? $_POST['phone']      : '';
                $email      = isset($_POST['email'])      ? $_POST['email']      : '';

                $message    = edit_student($_POST);
            }
        }
    }

    include 'template/header.php';
    include 'template/navbar.php';

    if( is_null($studentInfo) ):
?>
<div class="container" style="width:750px;">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown Student Profile <a href="profile.php">Try Again</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container" style="width:750px;">
    <div class="page-header">
        <h3 style="color:#1b809e;">
            <i class="glyphicon glyphicon-file"></i>
            Update Student T.C. No <?php echo $student_tcn;?>
        </h3>
    </div>
    <form id="update_student" action="editstudent.php?id=<?php echo $studentId;?>" method="post">
        <input type="hidden" value="submit" name="submit" />
        <input type="hidden" value="<?php echo $studentId;?>" name="student_id" id="tc-number-valid" />
        <div class="row">
            <?php if( !empty($message) ): ?>
            <div class="col-md-12"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-tc">T.C. Number</span>
                    <p class="form-control" id="tc-number" aria-describedby="addon-tc"><?php echo $student_tcn;?></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-fname">First Name</span>
                    <input value="<?php echo $first_name; ?>" name="first_name" class="form-control" id="first-name" aria-describedby="addon-fname" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-lname">Last Name</span>
                    <input value="<?php echo $last_name; ?>" name="last_name" class="form-control" id="last-name" aria-describedby="addon-lname" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-dbirth">Birth-Date</span>
                    <input value="<?php echo $birth_date; ?>" name="birth_date" class="form-control" id="birthdate" aria-describedby="addon-dbirth" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-phone">Phone Number</span>
                    <input value="<?php echo $phone; ?>"  name="phone" class="form-control" id="phone" aria-describedby="addon-phone" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-address">Address</span>
                    <input value="<?php echo $address; ?>" name="address" class="form-control" id="address" aria-describedby="addon-address" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon" id="addon-email">Email Address</span>
                    <input value="<?php echo $email; ?>" name="email" class="form-control" id="email" aria-describedby="addon-email" />
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">
                    <i class="glyphicon glyphicon-ok"></i> Update Student Details
                </button>
                <a href="profile.php" class="btn btn-default btn-block">Return to Registrations List</a>
            </div>
        </div>
    </form>
</div>
<?php
    endif;
    include 'template/footer.php';
?>