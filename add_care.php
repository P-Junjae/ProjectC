<?php
// エラーレポートの有効化（開発時のみ）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続ファイルを読み込む
include("db_connect.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ケア管理情報の追加</title>
</head>
<body>
    <h1>ケア管理情報の追加</h1>
    <form action="insert_care.php" method="post">
        <!-- 患者選択 -->
        <label for="patient_id">患者名: </label>
        <select id="patient_id" name="patient_id" required>
            <option value="" disabled selected>選択してください</option>
            <?php
            // データベースから患者情報を取得
            $patients_result = $conn->query("SELECT patient_id, patient_name FROM 患者");
            
            // 患者情報をオプションとして出力
            if ($patients_result->num_rows > 0) {
                while ($row = $patients_result->fetch_assoc()) {
                    echo "<option value='{$row['patient_id']}'>{$row['patient_name']}</option>";
                }
            } else {
                echo "<option value='' disabled>患者情報が見つかりません</option>";
            }
            ?>
        </select><br><br>

        <!-- 職員選択 -->
        <label for="staff_id">職員名: </label>
        <select id="staff_id" name="staff_id" required>
            <option value="" disabled selected>選択してください</option>
            <?php
            // データベースから職員情報を取得
            $staff_result = $conn->query("SELECT staff_id, staff_name FROM 職員");
            
            if ($staff_result->num_rows > 0) {
                while ($row = $staff_result->fetch_assoc()) {
                    echo "<option value='{$row['staff_id']}'>{$row['staff_name']}</option>";
                }
            } else {
                echo "<option value='' disabled>職員情報が見つかりません</option>";
            }
            ?>
        </select><br><br>

        <!-- 入力フィールド -->
        <label for="care_date">ケア日: </label>
        <input type="date" id="care_date" name="care_date" required><br><br>

        <label for="care_type">ケアの種類: </label>
        <input type="text" id="care_type" name="care_type" required><br><br>

        <label for="notes">メモ: </label>
        <textarea id="notes" name="notes"></textarea><br><br>

        <button type="submit">ケア情報を追加</button>
    </form>
</body>
</html>
