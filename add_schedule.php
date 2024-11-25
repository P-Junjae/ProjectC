<?php
require 'config.php';

// 患者情報を取得
$query_patients = "SELECT patient_id, patient_name FROM 患者"; // 患者テーブルを使用
$stmt_patients = $pdo->query($query_patients);
$patients = $stmt_patients->fetchAll(PDO::FETCH_ASSOC);

// 職員情報を取得
$query_staff = "SELECT staff_id, staff_name FROM 職員"; // 職員テーブルを使用
$stmt_staff = $pdo->query($query_staff);
$staffs = $stmt_staff->fetchAll(PDO::FETCH_ASSOC);

// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    $date = $_POST['date'];
    $task = $_POST['task'];

    // スケジュール情報をデータベースに保存
    $sql = "INSERT INTO schedules (staff_id, patient_id, date, task) VALUES (:staff_id, :patient_id, :date, :task)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':task', $task);

    if ($stmt->execute()) {
        echo "<p>スケジュールが正常に追加されました。</p>";
    } else {
        echo "<p>スケジュールの追加に失敗しました。</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スケジュール追加</title>
</head>
<body>
    <h1>スケジュールを追加</h1>

    <form action="add_schedule.php" method="POST">
        <label for="patient_id">患者:</label>
        <select name="patient_id" id="patient_id" required>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['patient_id'] ?>"><?= htmlspecialchars($patient['patient_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="staff_id">職員:</label>
        <select name="staff_id" id="staff_id" required>
            <?php foreach ($staffs as $staff): ?>
                <option value="<?= $staff['staff_id'] ?>"><?= htmlspecialchars($staff['staff_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date">日付:</label>
        <input type="date" name="date" id="date" required><br><br>

        <label for="task">タスク:</label><br>
        <textarea name="task" id="task" rows="4" required></textarea><br><br>

        <button type="submit">スケジュールを追加</button>
    </form>

    <br>
    <a href="index.php">戻る</a>
</body>
</html>
