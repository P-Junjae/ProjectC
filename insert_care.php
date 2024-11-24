<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続設定
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_support";

// MySQL接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// フォームからのデータを受け取る
$patient_id = $conn->real_escape_string($_POST['patient_id']);
$staff_id = $conn->real_escape_string($_POST['staff_id']);
$care_date = $conn->real_escape_string($_POST['care_date']);
$care_type = $conn->real_escape_string($_POST['care_type']);
$notes = $conn->real_escape_string($_POST['notes']);

// ケア管理情報をデータベースに挿入
$sql = "INSERT INTO ケア管理 (patient_id, staff_id, care_date, care_type, notes) 
        VALUES ('$patient_id', '$staff_id', '$care_date', '$care_type', '$notes')";

// SQL文の確認用出力（デバッグ時のみ使用）
echo "実行されたSQL: " . $sql . "<br>";

if ($conn->query($sql) === TRUE) {
    echo "新しいケア情報が追加されました。";
} else {
    echo "エラー: " . $conn->error;
}

echo '<p><a href="testhtml.html" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">トップページに戻る</a></p>';

$conn->close();
?>
