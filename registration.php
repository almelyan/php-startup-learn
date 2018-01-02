<?php
    session_start();
    require_once 'appcore/users.php';
    require_once 'appcore/students.php';
    require_once 'template/register.php';

    include 'template/header.php';
    include 'template/navbar.php';

    $schoolID   = $_GET['school'];
    $schoolInfo = null;
    if( is_numeric($schoolID) && $schoolID > 0 ){
        $schoolInfo = get_school($schoolID);
    }

    if( is_null($schoolInfo) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown School <a href="city.php">Try Choose Again</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Registration</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="<?php echo $schoolInfo['ThumbnailUrl'];?>" alt="<?php echo $schoolInfo['CityName'];?>">
                <div class="caption">
                    <h3>
                        <a href="town.php?city=<?php echo $schoolInfo['TownID'];?>">
                            <?php echo $schoolInfo['CityName'].', '.$schoolInfo['TownName'];?>
                        </a>
                    </h3>
                    <h4><?php echo $schoolInfo['Name'];?></h4>
                    <p><?php echo $schoolInfo['Address'];?></p>
                    <p><i class="glyphicon glyphicon-phone"></i> <?php echo $schoolInfo['Phone'];?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="list-group">
                <div class="list-group-item">
                    <?php
                        $user_login = (is_login() && $_SESSION['account'] == 'U');
                        if( $user_login && !$_POST['submit_register'] ){
                            $studentInfo = get_student($_SESSION['sid']);
                            $_SESSION['tc_number'] = $studentInfo['TCNo'];
                            student_details($studentInfo, '', true);
                            register_form($studentInfo['TCNo'], $schoolInfo['ID'], $schoolInfo['Name']);
                        }

                        if( $_POST['submit_search'] && !$user_login ){
                            $tcn = $_POST['tc_number'];
                            if( is_numeric($tcn) && strlen($tcn) == 6 && $tcn > 0 ){
                                $studentInfo = get_student_tcn($tcn);
                                $_SESSION['tc_number'] = $tcn;
                                if( is_array($studentInfo) && count($studentInfo) > 0 ){
                                    student_details($studentInfo);
                                    register_form($tcn, $schoolInfo['ID'], $schoolInfo['Name']);
                                }else{
                                    register_form_details($schoolInfo['ID'],'', $schoolInfo['Name']);
                                }
                            }else{
                                $message = '<div class="alert alert-danger">invalid value of T.C.Number</div>';
                                search_form($message);
                            }
                        }elseif( $_POST['submit_register'] ){
                            $tcn = $_SESSION['tc_number'];
                            if( is_numeric($tcn) && strlen($tcn) == 6 && $tcn > 0 ){
                                $message     = add_registration($_POST);
                                if( strpos($message, 'alert-danger') > -1 ){
                                    $studentInfo = get_student_tcn($tcn);
                                    if( is_array($studentInfo) && count($studentInfo) > 0 ){
                                        student_details($studentInfo, $message);
                                        register_form($tcn, $schoolInfo['ID'], $schoolInfo['Name']);
                                    }else{
                                        register_form_details($schoolInfo['ID'], $message, $schoolInfo['Name']);
                                    }
                                }else{
                                    echo '<div class="row">
                                        <div class="col-md-12">
                                            <div class="page-header">
                                                <h3 style="color:#2b542c"><i class="glyphicon glyphicon-ok"></i> Successfully Sent Student Info.</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-12">'.$message.'</div>
                                    </div>';
                                }
                            }else{
                                $message = '<div class="alert alert-danger">invalid value of T.C.Number</div>';
                                search_form($message);
                            }
                        }elseif( !$user_login ){
                            search_form();
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
<?php include 'template/footer.php'; ?>
