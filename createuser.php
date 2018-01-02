<?php
    session_start();
    require_once 'appcore/users.php';
    require_once 'appcore/students.php';

    if( !is_login() || $_SESSION['account'] == 'U' ){
        header('Location:login.php');
        exit;
    }

    include 'template/header.php';
    include 'template/navbar.php';

    $studentId   = $_GET['id'];
    $studentInfo = null;
    $studentUser = null;
    $message     = '';
    if( is_numeric($studentId) && $studentId > 0 ){
        $studentInfo = get_student($studentId);
        if( !is_null($studentInfo) ){
            $studentUser = get_details('Users', $studentInfo['ID'], 'StudentID');
            if( isset($_POST['submit']) ){
                $password = isset($_POST['password']) ? $_POST['password'] : '';
                $retype   = isset($_POST['retype'])   ? $_POST['retype']  : '';
                if( $password == $retype && strlen($password) >= 4 ){
                    $message = create_user($studentId, $password);
                }else{
                    $message = '<div class="alert alert-danger">error account passwords</div>';
                }
            }
        }
    }

    if( is_null($studentInfo) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown Student Info. <a href="profile.php">Back</a>
            </div>
        </div>
    </div>
</div>
<?php elseif( !is_null($studentUser) ): ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Student T.C. Number
                <?php echo $studentInfo['TCNo'].' '.$studentInfo['FirstName'].' '.$studentInfo['LastName']?>
                Has Account <a href="profile.php">Back</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container" style="width:750px;">
    <div class="page-header">
        <h3 style="color:#1b809e;">
            <i class="glyphicon glyphicon-user"></i>
            Create Student Account
        </h3>
    </div>
    <?php if( strpos($message, 'success') > -1 ){ echo $message; }else{ ?>
    <form id="create_user" action="createuser.php?id=<?php echo $studentId;?>" method="post">
        <input type="hidden" value="submit" name="submit" />
        <div class="list-group">
            <div class="list-group-item">
                <h4>
                    <i class="glyphicon glyphicon-user"></i>
                    <?php echo $studentInfo['FirstName'].' '.$studentInfo['LastName'];?>
                </h4>
                <p>
                    <i class="glyphicon glyphicon-star"></i> Account : Student User
                    - <i class="glyphicon glyphicon-envelope"></i> Email : <?php echo $studentInfo['Email'];?>
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" />
                    </div>
                    <div class="col-md-6">
                        <label>Retype Password</label>
                        <input type="password" name="retype" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <p>
            <?php if( !empty($message) ){ echo $message; } ?>
            <button class="btn btn-primary btn-block">
                <i class="glyphicon glyphicon-ok"></i> Create Student Account
            </button>
        </p>
    </form>
    <?php } ?>
    <a href="profile.php" class="btn btn-default btn-block">Return to Registrations List</a>
</div>
<?php include 'template/footer.php'; ?>
<?php endif; ?>
