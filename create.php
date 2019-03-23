<?php
require_once __DIR__ . '/bootstrap.php';
if (is_post()) {
    $name = $_POST['name'];
    $age = $_POST['age'] ?: 13;
    $phone = $_POST['phone'];
    $landline = $_POST['landline'];
    $email = $_POST['email'];
    $avatar = 'https://api.adorable.io/avatars/400/' . $email;

    $res = $conn->query("INSERT INTO contacts(name, age, phone, landline, email, avatar) VALUES ('{$name}', {$age}, '{$phone}', '{$landline}', '{$email}', '{$avatar}')");

    if ($res === TRUE) {
        header('Location: /index.php');
    } else {
        die('联系人添加失败：' . $conn->error);
    }
}
?>
<div class="modal fade" id="createContact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">添加联系人</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cf" action="create.php" method="POST">
                    <div class="form-group">
                        <label for="name" class="col-form-label">姓名</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">手机</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="landline" class="col-form-label">固话</label>
                        <input type="text" class="form-control" id="landline" name="landline">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">邮箱</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="age" class="col-form-label">年龄</label>
                        <input type="number" class="form-control" id="age" name="age">
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="col-form-label">头像</label>
                        <input type="text" class="form-control-plaintext" id="avatar" value="根据邮箱生成" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button type="submit" form="cf" class="btn btn-primary">添加</button>
            </div>
        </div>
    </div>
</div>
