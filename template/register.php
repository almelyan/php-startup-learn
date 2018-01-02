<?php
function search_form( $message = '' ){
$school_id = isset($_GET['school']) ? $_GET['school'] : '';
$tc_number = isset($_POST['tc_number']) ? $_POST['tc_number'] : '';
?>
<form id="search_student" action="registration.php?school=<?php echo $school_id;?>" method="post">
    <input type="hidden" value="submit" name="submit_search" id="submit_search"  />
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3><i class="glyphicon glyphicon-file"></i> Student Info.</h3>
            </div>
        </div>
        <?php if( !empty($message) ): ?>
            <div class="col-md-12">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon" id="addon-tc">T.C. Number</span>
                <input value="<?php echo $tc_number;?>" name="tc_number" class="form-control" id="tc-number" aria-describedby="addon-tc" />
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary btn-block">
                <i class="glyphicon glyphicon-search"></i> Valid Student T.C. Number
            </button>
        </div>
    </div>
</form>
<?php
}

function student_details( $studentInfo, $message = '', $hide_reset = false ){
    if( !is_array($studentInfo) || count($studentInfo) <= 0 ){ return ''; }
    $school_id  = isset($_GET['school']) ? $_GET['school'] : '';
    $tc_number  = isset($studentInfo['TCNo'])  ? $studentInfo['TCNo']  : '';
    $first_name = isset($studentInfo['FirstName']) ? $studentInfo['FirstName'] : '';
    $last_name  = isset($studentInfo['LastName'])  ? $studentInfo['LastName']  : '';
    $birth_date = isset($studentInfo['BirthDate']) ? $studentInfo['BirthDate'] : '';
    $address    = isset($studentInfo['Address'])   ? $studentInfo['Address']    : '';
    $phone      = isset($studentInfo['Phone'])     ? $studentInfo['Phone']      : '';
    $email      = isset($studentInfo['Email'])     ? $studentInfo['Email']      : '';
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3><i class="glyphicon glyphicon-user"></i> Student Info.</h3>
        </div>
    </div>
    <?php if( !empty($message) ): ?>
        <div class="col-md-12">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-tc">T.C. Number</span>
            <p class="form-control" id="tc-number" aria-describedby="addon-tc"><?php echo $tc_number; ?></p>
            <?php if( !$hide_reset ): ?>
            <span class="input-group-btn">
                <a href="registration.php?school=<?php echo $school_id;?>" class="btn btn-primary" type="button">Reset T.C. No.</a>
            </span>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-fname">First Name</span>
            <p class="form-control" id="first-name" aria-describedby="addon-fname">
                <?php echo $first_name; ?>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-lname">Last Name</span>
            <p class="form-control" id="last-name" aria-describedby="addon-lname">
                <?php echo $last_name; ?>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-dbirth">Birth-Date</span>
            <p class="form-control" id="birth-date" aria-describedby="addon-dbirth">
                <?php echo $birth_date; ?>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-phone">Phone Number</span>
            <p class="form-control" id="phone" aria-describedby="addon-phone">
                <?php echo $phone; ?>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-address">Address</span>
            <p class="form-control" id="address" aria-describedby="addon-address">
                <?php echo $address; ?>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-addon" id="addon-email">Email Address</span>
            <p class="form-control" id="email" aria-describedby="addon-email">
                <?php echo $email; ?>
            </p>
        </div>
    </div>
</div>
<?php
}

function register_form( $student_tcn, $school_id, $school_name = '' ){
?>
<form id="register_student" action="registration.php?school=<?php echo $school_id;?>" method="post">
    <input type="hidden" value="submit" name="submit_register" id="submit_register"  />
    <div class="row">
        <input type="hidden" value="<?php echo $student_tcn;?>" name="tc_number" id="tc-number-valid" />
        <input type="hidden" value="<?php echo $school_id;?>"   name="school_id"       id="school-id"  />
        <div class="col-md-12">
            <button class="btn btn-primary btn-block">
                <?php $school_name = empty($school_name) ? '' : 'In School '.$school_name; ?>
                <i class="glyphicon glyphicon-ok"></i> Send Registration <?php echo $school_name;?>
            </button>
        </div>
    </div>
</form>
<?php
}

function register_form_details( $school_id, $message = '', $school_name = '' ){
    $student_tcn = $_SESSION['tc_number'];
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name  = isset($_POST['last_name'])  ? $_POST['last_name']  : '';
    $birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : '';
    $address    = isset($_POST['address'])    ? $_POST['address']    : '';
    $phone      = isset($_POST['phone'])      ? $_POST['phone']      : '';
    $email      = isset($_POST['email'])      ? $_POST['email']      : '';
?>
<form id="register_student" action="registration.php?school=<?php echo $school_id;?>" method="post">
    <input type="hidden" value="submit" name="submit_register" id="submit_register"  />
    <input type="hidden" value="<?php echo $student_tcn;?>" name="tc_number" id="tc-number-valid" />
    <input type="hidden" value="<?php echo $school_id;?>" name="school_id" id="school-id"  />
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3><i class="glyphicon glyphicon-file"></i> Student Info.</h3>
            </div>
        </div>
        <?php if( !empty($message) ): ?>
        <div class="col-md-12">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon" id="addon-tc">T.C. Number</span>
                <p class="form-control" id="tc-number" aria-describedby="addon-tc"><?php echo $student_tcn;?></p>
                <span class="input-group-btn">
                    <a href="registration.php?school=<?php echo $school_id;?>" class="btn btn-primary" type="button">Reset T.C. No.</a>
                </span>
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
                <?php $school_name = empty($school_name) ? '' : 'In School '.$school_name; ?>
                <i class="glyphicon glyphicon-ok"></i> Send Registration <?php echo $school_name;?>
            </button>
        </div>
    </div>
</form>
<?php } ?>