<?php
require_once "config.php";
require_once "functions.php";
// require_once 'checkaccess.php';

$row = intval($_GET['row']);
// $row = 0;
$rowperpage = 5;

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = 0;
}
$category_id = intval($_GET['c_id']);
$mode = intval($_GET['mode']);
$order = intval($_GET['order']);

if ($order >= 1 && $order <= 5) {
    //all the order by queries go here
    //1 = event_name asc
    //2 = like_count desc
    //3 = event_price asc
    //4 = event_name desc
    //5 = event_price desc
    if ($order == 1) {
        $orderBy = "event_name ASC";
    } else if ($order == 4) {
        $orderBy = "event_name DESC";
    } else if ($order == 2) {
        $orderBy = "like_count DESC";
    } else if ($order == 3) {
        $orderBy = "discounted_price ASC";
    } else if ($order == 5) {
        $orderBy = "discounted_price DESC";
    }

    if ($mode != 2) {
        //either online or offline
        $sql =
            "SELECT
            *,
            (SELECT COUNT(*)
                    FROM event_likes
                    WHERE event_likes.event_id = event_master.event_id) like_count
            FROM event_master
            WHERE
            filled_seats < total_seats AND
            event_approved = 1 AND
            event_status IS NULL AND
            category_id = $category_id AND
            event_mode = $mode AND
            effective_end_date IS NULL
            ORDER BY $orderBy
            LIMIT $row,$rowperpage";
    } else if ($mode == 2) {
        //both online and offline(all)
        $sql =
            "SELECT
        *,
        (SELECT COUNT(*)
                FROM event_likes
                WHERE event_likes.event_id = event_master.event_id) like_count
        FROM event_master
        WHERE
        filled_seats < total_seats AND
        event_approved = 1 AND
        event_status IS NULL AND
        category_id = $category_id AND
        effective_end_date IS NULL
        ORDER BY $orderBy
        LIMIT $row,$rowperpage";
    }
} else {
    //all the non ordering (ie) order == 0 queries go here
    $sql = 
    "SELECT * 
    FROM event_master 
    WHERE filled_seats < total_seats AND event_approved = 1 AND event_status IS NULL AND category_id = $category_id AND effective_end_date IS NULL 
    ORDER BY subscription_status DESC
    LIMIT $row,$rowperpage";
}

$result = $mysqli->query($sql);
?>
<?php
$count  = mysqli_num_rows($result);
if ($count == 0) {
    echo '<h2>No events found</h2>';
}
while ($obj = $result->fetch_object()) {
    $result_event_id = $mysqli->query("SELECT * FROM event_likes WHERE user_id = $user_id AND event_id = $obj->event_id");
    $rowcount  = mysqli_num_rows($result_event_id);
    if ($rowcount > 0) {
        $is_liked = 1;
        $color = "red";
    } else {
        $is_liked = 0;
        $color = "grey";
    }
    $sql = "SELECT * FROM cart WHERE user_id = $user_id AND event_id = $obj->event_id AND no_of_tickets > 0";
    $res = $mysqli->query($sql);
    $cart_count  = mysqli_num_rows($res);

    if ($cart_count == 0) {
        $cart_status = "hidden";
    }
    else{
      $cart_status = "";
    }
?>
    <article class="postcard" style="border-radius: 2px;">
        <a class="postcard__img_link" href="#">
            <img class="postcard__img" style="max-height: calc(230px + 9vw);" src="eventManager/<?php echo $obj->event_image_url ?>" alt="Image Title" />
        </a>

        <div class="postcard__text t-dark">
            <input type="hidden" id="event_id<?= $obj->event_id ?>" value="<?php echo $obj->event_id ?>">
            <h1 class="postcard__title blue">
                <a href="#"><?php echo $obj->event_name ?>
                </a>
                <span id="itag<?= $obj->event_id ?>">
                    <i class="bi bi-heart-fill" style="float: right; top:0; color: <?= $color ?>;cursor:pointer;" onclick="like(<?= $user_id ?>, <?= $obj->event_id ?>, <?= $is_liked ?>);">
                        <sub style="font-size: small;color: black;"><?= getLikeCount($mysqli, $obj->event_id) ?></sub>
                    </i>
                </span>
            </h1>
            <div class="postcard__subtitle git a">
            <i class="bi bi-calendar">
                <?php  echo date_format(date_create($obj->event_date), 'M d, Y') ?>
            </i>
                <i class="bi bi-dot"></i>

                <i class="bi bi-clock">
                <?= date('h:i a', strtotime($obj->event_start_time)) ?>
                </i>

                <i class="bi bi-dot"></i>

                </i>
                <i class="bi bi-geo-alt">
                    <?php if ($obj->event_mode == 0) {
                                echo 'Platform: ' . $obj->event_venue;
                            } else {
                                echo 'City: ' . $obj->event_venue;
                            }
                            ?>
                </i>
                <!-- <i class="bi bi-dot"></i> -->
                

            </div>


            <!-- <div class="postcard__subtitle git a">Online</div> -->
            <div class="postcard__bar"></div>
            <div class="postcard__preview-txt"><?php echo $obj->event_description ?></div>
            <ul class="postcard__tagbox">
                <!-- <li class="tag__item"><i class="fas fa-tag mr-2"></i>Event Price: <?php echo $obj->event_price ?></li>
                <?php $time1 = strtotime($obj->event_start_time);
                $time2 = strtotime($obj->event_end_time);
                $duration = abs($time2 - $time1) / 3600; ?>
                <li class="tag__item"><i class="fas fa-clock mr-2"></i><?php echo $duration ?></li> -->
                <li class="tag__item play blue" style="padding-left: 0;">
                    <a class="btn btn-secondary" style="border-radius: 2px; background: #012970; color: white;" href="event/index.php?eventid=<?= $obj->event_id ?>"><i class="bi bi-film"></i> More Details</a>
                </li>
                <li class="tag__item play blue" style="padding-left: 0;">
                    <a <?=$cart_status?> class="btn btn-primary" style="border-radius: 2px;" href="cart_items.php"><i class="bi bi-cart"></i> In Cart</a>
                </li>
                <span class="discount_span" style="color:green; font-size:1.5rem;">
                    <!-- <i class="bi bi-wallet2">  -->
                        <b>₹<?= $obj->discounted_price ?></b>
                        <strike style="color: grey; font-size: 20px;">₹<?php echo $obj->event_price ?></strike>
                    <!-- </i> -->
                </span>
            </ul>
            <!-- <a class="btn btn-secondary" href="event/index.php?eventid=<?= $obj->event_id ?>"><i class="fas fa-play mr-2"></i>Register Now</a> -->
        </div>
    </article>
<?php }; ?>
