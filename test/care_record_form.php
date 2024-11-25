<?php
require 'config.php';

// 利用者リストを取得
$clients = $pdo->query("SELECT id, name FROM clients")->fetchAll(PDO::FETCH_ASSOC);

// スタッフリストを取得
$staffs = $pdo->query("SELECT id, name FROM users WHERE role = 'staff'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ケア記録の入力</title>
</head>
<body>
    <h1>ケア記録の入力</h1>
    <form action="process_care_record.php" method="POST">
        <label for="client_id">利用者:</label>
        <select name="client_id" id="client_id" required>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="staff_id">担当スタッフ:</label>
        <select name="staff_id" id="staff_id" required>
            <?php foreach ($staffs as $staff): ?>
                <option value="<?= $staff['id'] ?>"><?= htmlspecialchars($staff['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date">日付:</label>
        <input type="date" name="date" id="date" required><br><br>

        <label for="details">ケア内容:</label><br>
        <textarea name="details" id="details" rows="5" required></textarea><br><br>

        <h3>バイタルサイン</h3>
        <label for="temperature">体温 (°C):</label>
        <input type="number" name="temperature" id="temperature" step="0.1" placeholder="例: 36.5"><br><br>

        <label for="pulse">脈拍 (回/分):</label>
        <input type="number" name="pulse" id="pulse" placeholder="例: 75"><br><br>

        <label for="systolic_bp">収縮期血圧（上）:</label>
        <input type="number" name="systolic_bp" id="systolic_bp" placeholder="例: 120"><br><br>

        <label for="diastolic_bp">拡張期血圧（下）:</label>
        <input type="number" name="diastolic_bp" id="diastolic_bp" placeholder="例: 80"><br><br>

        <button type="submit">記録を保存</button>
    </form>
</body>
</html>
