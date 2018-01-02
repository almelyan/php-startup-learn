<?php
    session_start();
    require_once 'appcore/getinfo.php';

    include 'template/header.php';
    include 'template/navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Choose City</h1>
            </div>
        </div>
    </div>
    <?php $cites = list_cities(); ?>
    <div class="row">
    <?php if( !is_array($cites) || count($cites) <= 0 ): ?>
        <div class="col-md-12">
            <div class="alert alert-warning">No Found Cities ...</div>
        </div>
    <?php else:?>
        <?php foreach ( $cites as $index => $cityInfo ): ?>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="<?php echo $cityInfo['ThumbnailUrl'];?>" alt="<?php echo $cityInfo['Name'];?>">
                <div class="caption">
                    <h3><a href="town.php?city=<?php echo $cityInfo['ID'];?>"><?php echo $cityInfo['Name'];?></a></h3>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    <?php endif;?>
    </div>
</div>

<?php include 'template/footer.php'; ?>