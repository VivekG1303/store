<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner carousel-image">
        <?php 
        $carousel = new carousel();
        $rows = $carousel->detailsCarousel($id = '');
        $i = 0;
        foreach($rows as $row) {
            if($i == 0) {
        ?>    
        <div class="carousel-item active">
        <a href="<?php echo $row['carousel_link']; ?>"><img src="upload/carousel_image/<?php echo $row['carousel_image'] ?>" class="d-block w-100" alt="..."></a>
        </div>
        <?php $i++; } else { ?>
        <div class="carousel-item">
        <a href="<?php echo $row['carousel_link']; ?>"><img src="upload/carousel_image/<?php echo $row['carousel_image'] ?>" class="d-block w-100" alt="..."></a>
        </div>
    <?php $i++; } 
    }?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>