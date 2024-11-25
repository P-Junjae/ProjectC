<?php
require 'config.php';

// スケジュールを取得するクエリ
$query = "
    SELECT schedules.id, clients.name AS client_name, users.name AS staff_name, schedules.task, schedules.date
    FROM schedules
    JOIN clients ON schedules.client_id = clients.id
    JOIN users ON schedules.staff_id = users.id
    WHERE schedules.date = CURDATE();
";
$stmt = $pdo->query($query);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ビューを読み込む
require 'views/dashboard.php';
?>
