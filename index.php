<?php

require_once __DIR__ . '/bootstrap.php';

if (isset($_GET['keyword'])) {
    $k = '%' . $_GET['keyword'] . '%';
    $contacts = $conn->query("SELECT * FROM `contacts` WHERE `name` LIKE '{$k}' OR `phone` LIKE '{$k}' OR `landline` LIKE '{$k}' OR `email` LIKE '{$k}'");
} else {
    $contacts = $conn->query('SELECT * FROM `contacts`');
}

?>
<!DOCTYPE html>
<html lang="zh-cmn">
<head>
    <meta charset="UTF-8">

    <title>列表 | 通讯录</title>

    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">
<div style="min-width: 40vw;">
    <div class="mb-3">
        <form action="index.php" method="get">
            <div class="input-group input-group-seamless w-25 ml-auto">
                <span class="input-group-prepend">
                    <button class="input-group-text" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </span>
                <input type="search" class="form-control" name="keyword" placeholder="请输入关键词"
                       value="<?= $_GET['keyword'] ?? '' ?>">
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item mr-auto">
                    <a class="nav-link active" href="#">联系人</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#createContact">
                        <i class="fas fa-user-plus mr-1"></i>
                        添加
                    </a>
                </li>
            </ul>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">联系人</th>
                <th scope="col">手机</th>
                <th scope="col">固话</th>
                <th scope="col">邮箱</th>
                <th scope="col">年龄</th>
                <th scope="col">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($contact = $contacts->fetch_assoc()) {
                echo <<<HTML
            <tr data-cid="{$contact['id']}">
                <th scope="row">{$contact['id']}</th>
                <td><img class="rounded-circle" src="{$contact['avatar']}" style="height: 30px;position: relative;left: -5px;top: -2px;">{$contact['name']}</td>
                <td><a href="tel:{$contact['phone']}">{$contact['phone']}</a></td>
                <td><a href="tel:{$contact['landline']}">{$contact['landline']}</a></td>
                <td><a href="mailto:{$contact['email']}">{$contact['email']}</a></td>
                <td>{$contact['age']}</td>
                <td>
                <a class="badge badge-warning text-white edit" href="javascript:;"><i class="fas fa-user-edit"></i></a>
                <a class="badge badge-danger delete" href="javascript:;"><i class="fas fa-user-times"></i></a>
                </td>
            </tr>
HTML;

            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/create.php'; ?>

<script src="js/app.js"></script>
<script>
    $('.edit').click(function () {
        let cid = $(this).parent().parent().data('cid');
        $.get('edit.php?cid=' + cid, function (res) {
            $(res).modal('show');
        });
    });

    $('.delete').click(function () {
        let cid = $(this).parent().parent().data('cid');
        $.confirm('确认删除？', '删除后无法还原')
            .then(res => {
                if (res.value) {
                    axios.post('/delete.php?cid=' + cid)
                        .then(res => {
                            if (res.data.code === 0) {
                                location.reload();
                            } else {
                                alert('删除失败');
                                location.reload();
                            }
                        });
                }
            });
    });
</script>
</body>
</html>
