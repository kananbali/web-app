<?php
require_once './pdo.php';
session_start();

$offset = 5 * ($_GET['limit'] - 1);
$filter_pref = $_GET['filter_pref'] ? $_GET['filter_pref'] : $_SESSION['filter_pref'];


// SELECT COMMAND
if ($filter_pref == 1) {
    $_SESSION['filter_pref'] = 1;
    $stmt = $pdo->query(
        "SELECT count(*) AS count FROM user_master WHERE effective_end_dt IS NULL AND role_preference = 1"
    );
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
} else if ($filter_pref == 2) {
    $_SESSION['filter_pref'] = 2;
    $stmt = $pdo->query(
        "SELECT count(*) AS count 
          FROM user_master
           WHERE effective_end_dt IS NULL AND role_preference = 2
           ORDER BY name ASC LIMIT $offset,5"
    );
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
    // echo $count . '<br>';
} else if ($filter_pref == 3) {
    $_SESSION['filter_pref'] = 3;
    $stmt = $pdo->query(
        "SELECT count(*) AS count
          FROM user_master
           WHERE effective_end_dt IS NULL AND role_preference = 3
           ORDER BY name ASC LIMIT $offset,5"
    );
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
    // echo json_encode($users);

}
//show all users by default
else if ($filter_pref == 4) {
    $_SESSION['filter_pref'] = 4;
    $stmt = $pdo->query(
        "SELECT count(*) AS count 
          FROM user_master
           WHERE effective_end_dt IS NULL
           ORDER BY name ASC LIMIT $offset,5"
    );
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
    // echo json_encode($users);
} else {
    $_SESSION['filter_pref'] = 5;
    $stmt = $pdo->query("SELECT count(*) AS count 
                         FROM user_master
                         ORDER BY effective_end_dt DESC LIMIT $offset,5");
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
}

$final_count = ceil($count / 5);
// echo $final_count;
$_SESSION['final_count'] = $final_count;
?>
<nav aria-label="Page navigation example">
    <ul class="pagination mb-1" >
        <?php for ($a = 1; $a <= $final_count; $a++) { ?>
            <li id="count<?= $a ?>" class="page-item">
                <a class="page-link" onclick="getmore(<?= $a ?>)"><?= $a ?></a>
            </li>
        <?php } ?>
    </ul>
</nav>
<script>
    
</script>