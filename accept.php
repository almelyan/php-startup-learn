<?php session_start();
    require_once 'appcore/users.php';
    require_once 'appcore/students.php';
    require_once 'template/register.php';

    if( !is_login() || $_SESSION['account'] == 'U' ){
        header('Location:login.php');
        exit;
    }

    include 'template/header.php';
    include 'template/navbar.php';

    $registerId = $_GET['id'];
    $register   = null;
    if( is_numeric($registerId) && $registerId > 0 ){
        $register = get_registration($registerId);
    }

    if( is_null($register) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown Registration <a href="profile.php">Back</a>
            </div>
        </div>
    </div>
</div>
<?php else:
    $schoolInfo  = $register['School'];
    $studentInfo = $register['Student'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>
                    <i class="glyphicon glyphicon-file"></i> Registration Accept / Reject
                    <span class="pull-right"><a href="profile.php" class="btn btn-default">Return to Registrations List</a></span>
                </h3>
            </div>
        </div>
        <?php
            $update = false;
            if( isset($_POST['register_id']) ){
                if( isset($_POST['accept']) ){
                    $_POST['state'] = 'A';
                }elseif( isset($_POST['reject']) ){
                    $_POST['state'] = 'R';
                }
                $update = update_register_state($_POST);
            }
            if( $update ):
        ?>
        <div class="col-md-12">
            <div class="alert alert-success">
                Successfully Update State Registration <a href="profile.php">Back to List</a>
            </div>
        </div>
        <?php else: ?>
        <div class="col-md-12">
            <form action="accept.php?id=<?php echo $registerId;?>" method="post">
                <input name="register_id" type="hidden" value="<?php echo $registerId;?>">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom:10px;">
                        <label>Accept / Reject Note :</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <input type="submit" name="accept" value="Accept Registration" class="btn btn-success btn-block" />
                    </div>
                    <div class="col-md-6">
                        <input type="submit" name="reject" value="Reject Registration" class="btn btn-danger btn-block" />
                    </div>
                    <hr class="col-md-12"/>
                </div>
            </form>
        </div>
        <?php endif; ?>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="<?php echo $schoolInfo['ThumbnailUrl'];?>" alt="<?php echo $schoolInfo['CityName'];?>">
                <div class="caption">
                    <h3><?php echo $schoolInfo['CityName'].', '.$schoolInfo['TownName'];?></h3>
                    <h4><?php echo $schoolInfo['Name'];?></h4>
                    <p><?php echo $schoolInfo['Address'];?></p>
                    <p><i class="glyphicon glyphicon-phone"></i> <?php echo $schoolInfo['Phone'];?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="list-group">
                <div class="list-group-item">
                    <?php student_details($studentInfo, '', true); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<?php include 'template/footer.php'; ?>