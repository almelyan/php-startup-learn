<?php session_start();
require_once 'appcore/users.php';

if( is_login() ){
    header('Location:profile.php');
    exit;
}else{
    $message = '';
    $email   = '';
    if( $_POST['submit'] ){
        $password = $_POST['password'];
        $email    = $_POST['email'];
        $login = login_user($email, $password);
        if( $login ){
            header('Location:profile.php');
            exit;
        }else{
            $message = '<div class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i> error user name or password</div>';
        }
    }
    login_form($email, $message);
}

function login_form( $email = '', $message = '' ){
    include 'template/header.php';
    include 'template/navbar.php';
?>
<div class="container" style="width:500px;">
    <div class="list-group">
        <div class="list-group-item">
            <form action="login.php" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 style="text-align:center;"><i class="glyphicon glyphicon-user"></i> Login Member</h2>
                        <h2 style="text-align:center;margin:0"><small>Nearby School Application</small></h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" class="form-control" value="<?php echo $email;?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login" />
                </div>
                <?php if( !empty($message) ): ?>
                <div class="col-md-12" style="margin-top:15px;"><?php echo $message; ?></div>
                <?php endif; ?>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
    include 'template/footer.php';
    }
?>
