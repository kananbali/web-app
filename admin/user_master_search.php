<?php
require_once './pdo.php';
$myInput = $_GET['myInput'];
    $stmt = $pdo->query(
        "SELECT  `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
           FROM user_master
           WHERE name LIKE '%$myInput%'
           ORDER BY name ASC"
    );
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($users);
?>

<?php
    if(strlen($users)==0){
        echo "NO RECORDS AVAILABLE.";
    }
?>
<?php foreach ($users as $user) : ?>

<?php
if (isset($user['effective_end_dt'])) {
    $active = "disabled";
} else {
    $active = "";
}
?>
<tr>
    <th scope="row"><input type="checkbox" class="form-control-xs" name='delete[]' id="user_id<?= $user['user_id'] ?>" value='<?= $user['user_id'] ?>' <?= $active ?>></td>
    <td>
        <select class="form-select form-select-sm" name="role_preference<?= $user['user_id'] ?>" onchange="check('user_id<?= $user['user_id'] ?>')" aria-label="Default select example" <?= $active ?>>
            <option value="1" <?= $user['role_preference'] == "1" ? ' selected="selected"' : '';  ?>>User</option>
            <option value="2" <?= $user['role_preference'] == "2" ? ' selected="selected"' : '';  ?>>Event Manager</option>
            <option value="3" <?= $user['role_preference'] == "3" ? ' selected="selected"' : '';  ?>>Admin</option>
        </select>
    </td>
    <td>
        <input type="hidden" name="assigned_roles<?= $user['user_id'] ?>" value='<?= $user['assigned_roles'] ?>'>

        <span hidden class="fw-normal"><?= $user['name'] ?></span>
        <input class="form-control form-control-sm" type="text" onchange="check('user_id<?= $user['user_id'] ?>')" value="<?= $user['name'] ?>" name="name<?= $user['user_id'] ?>" <?= $active ?>>
    </td>
    <td>
        <span hidden class="fw-normal"><?= $user['email_id'] ?></span>
        <input class="form-control form-control-sm" type="text" onchange="check('user_id<?= $user['user_id'] ?>')" value="<?= $user['email_id'] ?>" name="email_id<?= $user['user_id'] ?>" <?= $active ?>>
    </td>
    <td>
        <span hidden class="fw-normal"><?= $user['mobile_no'] ?></span>
        <input class="form-control form-control-sm" type="text" onchange="check('user_id<?= $user['user_id'] ?>')" value="<?= $user['mobile_no'] ?>" name="mobile_no<?= $user['user_id'] ?>" <?= $active ?>>
    </td>
    <td>
        <select class="form-select form-select-sm" name="signup_method<?= $user['user_id'] ?>" onchange="check('user_id<?= $user['user_id'] ?>')" aria-label="Default select example" <?= $active ?>>
            <option value="email" <?= $user['signup_method'] == "email" ? ' selected="selected"' : '';  ?>>Email</option>
            <option value="facebook" <?= $user['signup_method'] == "facebook" ? ' selected="selected"' : '';  ?>>Facebook</option>
            <option value="github" <?= $user['signup_method'] == "github" ? ' selected="selected"' : '';  ?>>GitHub</option>
            <option value="google" <?= $user['signup_method'] == "google" ? ' selected="selected"' : '';  ?>>Google</option>
        </select>
    </td>
    <!-- <td>
<?= $user['effective_from_dt'] ?>
</td>
<td>
<?= $user['effective_end_dt'] ?>
</td> -->
</tr>
<?php endforeach; ?>