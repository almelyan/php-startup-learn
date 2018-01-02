<?php
    session_start();
    require_once 'appcore/users.php';
    require_once 'appcore/students.php';
    require_once 'template/register.php';

    if( !is_login() || $_SESSION['account'] == 'U' ){
        header('Location:login.php');
        exit;
    }

    $studentId   = $_GET['id'];
    $studentInfo = null;
    $message     = '';
    if( is_numeric($studentId) && $studentId > 0 ) {
        $studentInfo = get_student($studentId);

        if( !is_null($studentInfo) && isset($_POST['submit'])  ){
            $message = remove_student($studentId);
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
            Remove Student T.C. No <?php echo $studentInfo['TCNo'];?>
        </h3>
    </div>
    <?php if( strpos($message, 'success') > -1 ){ echo $message; }else{ ?>
    <form id="update_student" action="removestudent.php?id=<?php echo $studentInfo['ID'];?>" method="post">
        <input type="hidden" value="submit" name="submit" />
        <?php student_details($studentInfo, $message, true); ?>
        <p><button class="btn btn-danger btn-block">
            <i class="glyphicon glyphicon-remove"></i> Remove Student Details
        </button></p>
    </form>
    <?php } ?>
    <a href="profile.php" class="btn btn-default btn-block">Return to Registrations List</a>
</div>
<?php endif; ?>
