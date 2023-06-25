<?php
require_once "pdo.php";
require_once 'checkaccess.php';
// session_start();

$q = intval($_GET['q']);

$stmt = $pdo->prepare(
  "SELECT event_name,event_description,category_name,event_date,event_start_time,discounted_price,event_end_time,event_mode,event_venue,event_link,event_price,total_seats,event_image_url,approval_message
  FROM event_master 
  INNER JOIN category_master
  ON category_master.category_id = event_master.category_id
  WHERE event_id = :event_id"
);
$stmt->execute(array(
  ':event_id' => $q
));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($rows as $row) : ?>
  <input type="hidden" name="event_id" value="<?= $q ?>">
  <p>
    <img src="../eventManager/<?= $row['event_image_url'] ?>">
  </p>
  <p><b>Event Name: </b> <?= $row['event_name'] ?></p>
  <p><b>Description: </b> <?= $row['event_description'] ?></p>
  <p><b>Category: </b> <?= $row['category_name'] ?></p>
  <p><b>Event Date: </b> <?= $row['event_date'] ?></p>
  <p><b>Start Time: </b> <?= $row['event_start_time'] ?></p>
  <p><b>End Time: </b> <?= $row['event_end_time'] ?></p>
  <p><b>Event Mode: </b> <?= $row['event_mode'] == 0?"Online":"Offline" ?></p>
  <p><b>Event Platform: </b> <?= $row['event_venue'] ?></p>
  <p><b>Event Link: </b> <?= $row['event_link'] ?></p>
  <p><b>Event Price: </b> ₹<?= $row['event_price'] ?></p>
  <p><b>Discounted Price: </b> ₹<?= $row['discounted_price'] ?></p>
  <p><b>Total Seats: </b> <?= $row['total_seats'] ?></p>
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Additional Comments</label>
    <textarea class="form-control" name="approval_message" id="exampleFormControlTextarea1" rows="3"><?= $row['approval_message'] ?></textarea>
  <?php endforeach; ?>