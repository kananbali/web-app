<?php
require_once './config.php';
$sql4 = "SELECT * FROM event_master WHERE subscription_status = 1 AND event_approved = 1 AND effective_end_date IS NULL";
$sponsored_events1 = mysqli_query($conn, $sql4);
$sponsored_events2 = mysqli_query($conn, $sql4);
?>    
    <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $act = "active";
            while ($event = $sponsored_events2->fetch_assoc()) {
            ?>
                <div class="carousel-item <?= $act ?>">
                    <img src="eventManager/<?= $event['event_image_url'] ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= $event['event_name'] ?></h5>
                        <p><?= $event['event_description'] ?></p>
                    </div>
                </div>

            <?php
                $act = "";
            } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
   
    <script>
        document.getElementById('carouselExampleCaptions').className = 'carousel slide mx-8';
        window.addEventListener('resize', function() {
            if(window.innerWidth > 768){
            document.getElementById('carouselExampleCaptions').className = 'carousel slide mx-8';
        }else{
            document.getElementById('carouselExampleCaptions').className = 'carousel slide ';
        }
        });
    </script>