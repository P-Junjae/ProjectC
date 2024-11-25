<?php
// エラー表示（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続
include("db_connect.php");

// 患者IDを取得
$patient_id = $_GET['patient_id'] ?? null;

// 患者情報を取得
if ($patient_id) {
    $patient_query = "SELECT patient_name FROM 患者 WHERE patient_id = ?";
    $stmt = $conn->prepare($patient_query);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    if (!$patient) {
        die("患者が見つかりません。");
    }
} else {
    die("患者IDが指定されていません。");
}

// 患者のスケジュールを取得
$schedule_query = "
    SELECT s.schedule_id, s.date, s.task, st.staff_name 
    FROM スケジュール s 
    JOIN 職員 st ON s.staff_id = st.staff_id
    WHERE s.patient_id = ?
    ORDER BY s.date ASC";
$stmt = $conn->prepare($schedule_query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$schedule_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($patient['patient_name']); ?>さんのスケジュール</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($patient['patient_name']); ?>さんのスケジュール</h1>
    <p><a href="index.php">トップページに戻る</a></p>

    <?php if ($schedule_result->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>日時</th>
                    <th>メモ</th>
                    <th>担当職員</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $schedule_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['task']); ?></td>
                        <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
                        <td>
                            <a href="edit_schedule.php?schedule_id=<?php echo $row['schedule_id']; ?>">編集</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>この患者のスケジュールはまだ登録されていません。</p>
    <?php endif; ?>
</body>
</html>
