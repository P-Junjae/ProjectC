<?php
require 'config.php';

// ケア記録を取得
$care_records = $pdo->query("SELECT care_records.id, clients.name AS client_name, users.name AS staff_name, care_records.date, care_records.details 
                             FROM care_records
                             JOIN clients ON care_records.client_id = clients.id
                             JOIN users ON care_records.staff_id = users.id
                             ORDER BY care_records.date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ケア記録一覧</title>
</head>
<body>
    <h1>ケア記録一覧</h1>
    <table border="1">
        <thead>
            <tr>
                <th>利用者名</th>
                <th>担当スタッフ</th>
                <th>日付</th>
                <th>ケア内容</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($care_records as $record): ?>
                <tr>
                    <td><?= htmlspecialchars($record['client_name']) ?></td>
                    <td><?= htmlspecialchars($record['staff_name']) ?></td>
                    <td><?= htmlspecialchars($record['date']) ?></td>
                    <td><?= htmlspecialchars($record['details']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="care_record_form.php">新しいケア記録を追加</a>
</body>
</html>
