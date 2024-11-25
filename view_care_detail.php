<?php
// エラー表示（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続
include("db_connect.php");

// 患者IDを取得
$patient_id = $_GET['patient_id'] ?? null;

if (!$patient_id) {
    die("患者IDが指定されていません。");
}

// 患者情報を取得
$patient_query = "SELECT patient_name FROM 患者 WHERE patient_id = ?";
$stmt = $conn->prepare($patient_query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("患者が見つかりません。");
}

// 患者のケア記録と職員名を取得
$care_query = "
    SELECT c.record_id, c.care_date, c.care_type, c.notes, st.staff_name
    FROM ケア管理 c
    JOIN 職員 st ON c.staff_id = st.staff_id
    WHERE c.patient_id = ?
    ORDER BY c.care_date ASC";
$stmt = $conn->prepare($care_query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$care_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($patient['patient_name']); ?>さんのケア記録</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($patient['patient_name']); ?>さんのケア記録</h1>
    <p><a href="view_care.php">ケア記録一覧に戻る</a></p>

    <?php if ($care_result->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ケア日</th>
                    <th>ケアの種類</th>
                    <th>メモ</th>
                    <th>担当職員</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $care_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['care_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['care_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['notes']); ?></td>
                        <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>この患者のケア記録はまだ登録されていません。</p>
    <?php endif; ?>
</body>
</html>
