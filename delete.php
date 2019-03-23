<?php
require_once __DIR__ . '/bootstrap.php';
if (is_post()) {

    $res = $conn->query("DELETE FROM `contacts` WHERE `id` = {$_GET['cid']}");

    if ($res === TRUE) {
        echo json_encode([
            'code' => 0,
        ]);
    } else {
        die('联系人删除失败：' . $conn->error);
    }
}
