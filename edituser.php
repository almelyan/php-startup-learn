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

    $userId      = $_GET['id'];
    $studentUser = null;
    $message     = '';
    if( is_numeric($userId) && $userId > 0 ){
        $studentUser = get_details('Users', $userId);
        if( !is_null($studentUser) ){
            if( isset($_POST['submit']) ){
                $password = isset($_POST['password']) ? $_POST['password'] : '';
                $retype   = isset($_POST['retype'])   ? $_POST['retype']   : '';

                if( $password == $retype && strlen($password) >= 4 ){
                    $update  = ['Password' => $password];
                    $execute = mysql_update('Users', $update, 'ID='.$userId);
                    if( $execute ){
                        $message = '<div class="alert alert-success">successfully updated account password</div>';
                    }else{
                        $message = '<div class="alert alert-danger">error update account password</div>';
                    }
                }else{
                    $message = '<div class="alert alert-danger">error account passwords</div>';
                }
            }
        }
    }

    if( is_null($studentUser) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown Student Account <a href="users.php">Back</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container" style="width:750px;">
    <div class="page-header">
        <h3 style="color:#1b809e;">
            <i class="glyphicon glyphicon-user"></i>
            Update Account Password
        </h3>
    </div>
    <?php if( strpos($message, 'success') > -1 ){ echo $message; }else{ ?>
    <form id="edit_user" action="edituser.php?id=<?php echo $userId;?>" method="post">
        <input type="hidden" value="submit" name="submit" />
        <div class="list-group">
            <div class="list-group-item">
                <h4>
                    <i class="glyphicon glyphicon-user"></i>
                    <?php echo $studentUser['UserName'];?>
                </h4>
                <p>
                    <i class="glyphicon glyphicon-star"></i> Account : Student User
                    - <i class="glyphicon glyphicon-envelope"></i> Email : <?php echo $studentUser['Email'];?>
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
                <i class="glyphicon glyphicon-ok"></i> Update Account Password
            </button>
        </p>
    </form>
    <?php } ?>
    <a href="users.php" class="btn btn-default btn-block">Return to Accounts List</a>
</div>
<?php
    include 'template/footer.php';
    endif;
?>
