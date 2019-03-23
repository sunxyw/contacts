<?php
require_once __DIR__ . '/bootstrap.php';
if (is_post()) {
    $name = $_POST['name'];
    $age = $_POST['age'] ?: 13;
    $phone = $_POST['phone'];
    $landline = $_POST['landline'];
    $email = $_POST['email'];
    $avatar = 'https://api.adorable.io/avatars/400/' . $email;

    $res = $conn->query("UPDATE `contacts` SET `name` = '{$name}', `age` = '{$age}', `phone` = '{$phone}', `landline` = '{$landline}', `email` = '{$email}' WHERE `id` = {$_GET['cid']}");

    if ($res === TRUE) {
        header('Location: /index.php');
    } else {
        die('联系人更新失败：' . $conn->error);
    }
} else {
    $contact = $conn->query("SELECT * FROM `contacts` WHERE `id` = {$_GET['cid']} LIMIT 1")->fetch_array();
}
?>
<div class="modal fade" id="editContact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">编辑联系人</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ef" action="edit.php?cid=<?= $_GET['cid'] ?>" method="POST">
                    <div class="form-group">
                        <label for="name" class="col-form-label">姓名</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $contact['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">手机</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="<?= $contact['phone'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="landline" class="col-form-label">固话</label>
                        <input type="text" class="form-control" id="landline" name="landline"
                               value="<?= $contact['landline'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">邮箱</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?= $contact['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="age" class="col-form-label">年龄</label>
                        <input type="number" class="form-control" id="age" name="age"
                               value="<?= $contact['age'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="col-form-label">头像</label>
                        <input type="text" class="form-control-plaintext" id="avatar" value="根据邮箱生成" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button type="submit" form="ef" class="btn btn-primary">更新</button>
            </div>
        </div>
    </div>
</div>
