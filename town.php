<?php
    session_start();
    require_once 'appcore/getinfo.php';

    include 'template/header.php';
    include 'template/navbar.php';

    $CityID   = $_GET['city'];
    $CityInfo = null;
    if( is_numeric($CityID) && $CityID > 0 ){
        $CityInfo = get_city($CityID);
    }

    if( is_null($CityInfo) ):
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Unknown City <a href="city.php">Try Choose Again</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron" style="background-image:url('<?php echo $CityInfo['CoverUrl'];?>');">
    <div class="container">
        <h1><?php echo $CityInfo['Name'];?></h1>
        <br/><br/><br/>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Choose Town</h1>
            </div>
        </div>
    </div>
    <?php $towns = list_towns($CityID); ?>
    <div class="row">
        <?php if( !is_array($towns) || count($towns) <= 0 ): ?>
            <div class="col-md-12">
                <div class="alert alert-warning">No Found Towns ...</div>
            </div>
        <?php else:?>
            <div class="col-md-12">
                <div class="list-group">
                <?php foreach ( $towns as $index => $townInfo ): ?>
                    <a href="school.php?town=<?php echo $townInfo['ID'];?>" class="list-group-item">
                        <?php echo $townInfo['Name']; ?></a>
            <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>
<?php endif; ?>
<?php include 'template/footer.php'; ?>