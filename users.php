<?php
    session_start();
    require_once 'appcore/users.php';

    if( !is_login() || $_SESSION['account'] == 'U' ){
        header('Location:login.php');
        exit;
    }

    include 'template/header.php';
    include 'template/navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3><i class="glyphicon glyphicon-list"></i> Student Accounts</h3>
            </div>
        </div>
    </div>
    <?php $accounts = list_users('U'); ?>
    <div class="row">
        <div class="col-md-12">
        <?php if( !is_array($accounts) || count($accounts) <= 0 ): ?>
            <div class="alert alert-warning">No Found Accounts ...</div>
        <?php else:?>
            <div class="list-group">
            <?php foreach ( $accounts as $index => $user ): ?>
                <div class="list-group-item">
                    <h4>
                        <i class="glyphicon glyphicon-user"></i> <?php echo $user['UserName'];?>
                        <span class="btn-group pull-right">
                            <a style="font-size:12px;" class="btn btn-default" href="edituser.php?id=<?php echo $user['ID'];?>">
                                <i class="glyphicon glyphicon-file"></i> Update</a>
                            <a style="font-size:12px;" class="btn btn-default" href="removeuser.php?id=<?php echo $user['ID'];?>">
                                <i class="glyphicon glyphicon-remove"></i> Remove</a>
                        </span>
                    </h4>
                    <p>
                        <small>
                            <i class="glyphicon glyphicon-star"></i>
                            Account : <?php echo $user['Account'] == 'A' ? 'Admin User' : 'Student User';?>
                        </small>
                        <small>
                            - <i class="glyphicon glyphicon-envelope"></i>
                            Email : <?php echo $user['Email'];?>
                        </small>
                    </p>
                </div>
            <?php endforeach;?>
            </div>
        <?php endif;?>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>