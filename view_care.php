<?php
// エラー表示（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続
include("db_connect.php");

// 患者情報を取得
$patients_result = $conn->query("SELECT patient_id, patient_name FROM 患者");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ケア記録一覧</title>
</head>
<body>
    <h1>ケア記録一覧</h1>
    <p><a href="index.php">トップページに戻る</a></p>

    <?php if ($patients_result->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>患者名</th>
                    <th>ケア記録詳細</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $patients_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                        <td>
                            <a href="view_care_detail.php?patient_id=<?php echo $row['patient_id']; ?>"
                               style="display: inline-block; padding: 5px 10px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">
                               詳細を見る
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>患者が登録されていません。</p>
    <?php endif; ?>
</body>
</html>
