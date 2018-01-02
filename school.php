<?php
    session_start();
    require_once 'appcore/getinfo.php';

    include 'template/header.php';
    include 'template/navbar.php';

    $TownID   = $_GET['town'];
    $TownInfo = null;
    if( is_numeric($TownID) && $TownID > 0 ){
        $TownInfo = get_town($TownID);
    }

    if( is_null($TownInfo) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown Town <a href="city.php">Try Choose Again</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron" style="background-image:url('<?php echo $TownInfo['CoverUrl'];?>');">
    <div class="container">
        <h1><?php echo $TownInfo['CityName'].', '.$TownInfo['Name'];?></h1>
        <br/><br/><br/>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Choose School</h1>
            </div>
        </div>
    </div>
    <?php $schools = list_schools($TownID); ?>
    <div class="row">
        <?php if( !is_array($schools) || count($schools) <= 0 ): ?>
            <div class="col-md-12">
                <div class="alert alert-warning">No Found Schools ...</div>
            </div>
        <?php else:?>
            <?php foreach ( $schools as $index => $schoolInfo ): ?>
                <div class="col-md-4">
                    <div class="thumbnail" style="height:140px;">
                        <div class="caption">
                            <h4>
                                <a href="registration.php?school=<?php echo $schoolInfo['ID'];?>">
                                    <?php echo $schoolInfo['Name'];?>
                                </a>
                            </h4>
                            <p><?php echo $schoolInfo['Address'];?></p>
                            <p><i class="glyphicon glyphicon-phone"></i> <?php echo $schoolInfo['Phone'];?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
<?php endif;?>
<?php include 'template/footer.php'; ?>