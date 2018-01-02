<?php session_start();
require_once 'appcore/users.php';
require_once 'appcore/students.php';

if( !is_login() ){
    logout_user();
    header('Location:login.php');
    exit;
}else{
    $account = $_SESSION['account'];
    if( $account == 'U' ){
        $student = get_student($_SESSION['sid']);
        student_profile($student);
    }else {
        $list = list_registrations();
        admin_profile($list);
    }
}

function student_profile( $studentInfo ) {
    include 'template/header.php';
    include 'template/navbar.php';
?>
<div class="container">
    <div class="page-header">
        <h3 style="color:#1b809e;">
            <i class="glyphicon glyphicon-user"></i>
            <?php echo $studentInfo['FirstName'].' '.$studentInfo['LastName'].' | TC No. '.$studentInfo['TCNo'];?>
        </h3>
    </div>
    <div class="list-group">
        <div class="list-group-item">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h4><i class="glyphicon glyphicon-file"></i> Details</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <i class="glyphicon glyphicon-phone"></i> Phone Number : <?php echo $studentInfo['Phone'];?>
                </div>
                <div class="col-md-4">
                    <i class="glyphicon glyphicon-map-marker"></i> Address : <?php echo $studentInfo['Address'];?>
                </div>
                <div class="col-md-4">
                    <i class="glyphicon glyphicon-envelope"></i> Email : <?php echo $studentInfo['Email'];?>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group">
    <?php foreach ( $studentInfo['Schools'] as $schoolInfo ): ?>
        <?php $location = $schoolInfo['Location'];?>
        <div class="list-group-item">
            <div class="thumbnail pull-left" style="max-width:200px;margin:0 20px 0 0;">
                <img src="<?php echo $location['ThumbnailUrl'];?>" alt="<?php echo $location['CityName'];?>">
            </div>
            <div class="caption pull-right" style="width:250px;">
                <p style="margin:5px 0;"><a style="font-size:10px;" class="btn btn-default" href="cancel.php?id=<?php echo $schoolInfo['RID'];?>">
                        <i class="glyphicon glyphicon-remove"></i> Cancel Registration</a></p>
                <?php
                if($schoolInfo['Accept'] == 'A'){
                    $state = '<label style="font-weight:normal;" class="label label-success"><i class="glyphicon glyphicon-ok"></i> Accepted</label>';
                }elseif($schoolInfo['Accept'] == 'R'){
                    $state = '<label style="font-weight:normal;" class="label label-danger"><i class="glyphicon glyphicon-remove"></i> Rejected</label>';
                }else{
                    $state = '<label style="font-weight:normal;" class="label label-primary"><i class="glyphicon glyphicon-cogs"></i> In-Process</label>';
                }
                echo $state;
                if( !empty($schoolInfo['AcceptDate']) ){
                    echo '<p style="margin:5px 0;color:#777;"><small><i class="glyphicon glyphicon-calendar"></i> Process-Date: '.$schoolInfo['AcceptDate'].'</small></p>';
                }
                if( !empty($schoolInfo['Notes']) ){
                    echo '<p style="margin:5px 0;color:#777;"><small><i class="glyphicon glyphicon-bell"></i> '.$schoolInfo['Notes'].'</small></p>';
                }
                ?>
            </div>
            <div class="caption">
                <h3><?php echo $location['CityName'].', '.$location['Name'];?></h3>
                <h4><?php echo $schoolInfo['Name'];?></h4>
                <p><?php echo $schoolInfo['Address'];?></p>
                <p>
                    <i class="glyphicon glyphicon-phone"></i> <?php echo $schoolInfo['Phone'];?> |
                    <i class="glyphicon glyphicon-calendar"></i> Register Date <?php echo $schoolInfo['RegistDate'];?>
                </p>
            </div>

            <div style="clear:both"></div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<?php
    include 'template/footer.php';
}

function admin_profile( $registrations ) {
    include 'template/header.php';
    include 'template/navbar.php';
?>
<div class="container">
    <div class="page-header">
        <h3 style="color:#1b809e;"><i class="glyphicon glyphicon-bell"></i> Management Registrations</h3>
    </div>
    <?php if( is_array($registrations) && count($registrations) > 0 ): ?>
        <?php foreach ( $registrations as $studentInfo ):
                $has_account = get_details('Users', $studentInfo['ID'], 'StudentID'); ?>
        <div class="list-group-item">
            <h4>
                <i class="glyphicon glyphicon-user"></i>
                <?php echo $studentInfo['FirstName'].' '.$studentInfo['LastName'].' | TC No. '.$studentInfo['TCNo'];?>
                <span class="btn-group pull-right">
                    <?php if( is_null($has_account) ): ?>
                    <a style="font-size:12px;" class="btn btn-default" href="createuser.php?id=<?php echo $studentInfo['ID'];?>">
                        <i class="glyphicon glyphicon-user"></i> Create Account</a>
                    <?php endif; ?>
                    <a style="font-size:12px;" class="btn btn-default" href="editstudent.php?id=<?php echo $studentInfo['ID'];?>">
                        <i class="glyphicon glyphicon-file"></i> Update</a>
                    <a style="font-size:12px;" class="btn btn-default" href="removestudent.php?id=<?php echo $studentInfo['ID'];?>">
                        <i class="glyphicon glyphicon-remove"></i> Remove</a>
                </span>
            </h4>
            <small><i class="glyphicon glyphicon-phone"></i> Phone Number : <?php echo $studentInfo['Phone'];?></small>
            <small>- <i class="glyphicon glyphicon-map-marker"></i> Address : <?php echo $studentInfo['Address'];?></small>
            <small>- <i class="glyphicon glyphicon-envelope"></i> Email : <?php echo $studentInfo['Email'];?></small>
            <?php if( is_array($studentInfo['Schools']) && count($studentInfo['Schools']) > 0 ): ?>
            <hr/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>RG-ID</th>
                        <th>City, Town</th>
                        <th>School Name</th>
                        <th>Register Date</th>
                        <th>A/R Date</th>
                        <th style="width:80px;">State</th>
                        <th style="width:220px;"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ( $studentInfo['Schools'] as $schoolInfo ): ?>
                    <?php
                        $town = get_town($schoolInfo['TownID']);
                        $cityTown = is_array($town) ? $town['CityName'].', '.$town['Name'] : '';
                    ?>
                    <tr>
                        <td>RG-<?php echo $schoolInfo['RID'];?></td>
                        <td><?php echo $cityTown; ?></td>
                        <td><?php echo $schoolInfo['Name'];?></td>
                        <td><?php echo $schoolInfo['RegistDate'];?></td>
                        <td><?php echo $schoolInfo['AcceptDate'];?></td>
                        <td>
                        <?php
                            if($schoolInfo['Accept'] == 'A'){
                                $state = '<label style="font-weight:normal;" class="label label-success"><i class="glyphicon glyphicon-ok"></i> Accepted</label>';
                            }elseif($schoolInfo['Accept'] == 'R'){
                                $state = '<label style="font-weight:normal;" class="label label-danger"><i class="glyphicon glyphicon-remove"></i> Rejected</label>';
                            }else{
                                $state = '<label style="font-weight:normal;" class="label label-default">Not Set</label>';
                            }
                            echo $state;
                        ?>
                        </td>
                        <td>
                            <a href="accept.php?id=<?php echo $schoolInfo['RID'];?>" class="btn btn-primary" style="font-size:10px;padding:5px;">
                                <i class="glyphicon glyphicon-cog"></i> Process Accept</a>
                            <a href="cancel.php?id=<?php echo $schoolInfo['RID'];?>" class="btn btn-danger" style="font-size:10px;padding:5px;">
                                <i class="glyphicon glyphicon-trash"></i> Cancel
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
    <div class="alert alert-info">No Registrations Found !</div>
    <?php endif; ?>
</div>
<?php
    include 'template/footer.php';
}
?>