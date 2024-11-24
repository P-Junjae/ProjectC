<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続設定
$servername = "localhost";
$username = "root";  // データベースのユーザー名
$password = "";  // パスワード
$dbname = "care_support";  // データベース名

// MySQL接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// フォームからのデータを受け取る
$patient_name = $conn->real_escape_string($_POST['patient_name']);
$patient_birthday = $conn->real_escape_string($_POST['patient_birthday']);
$gender = $conn->real_escape_string($_POST['gender']);

// 患者情報をデータベースに挿入
$sql = "INSERT INTO 患者 (patient_name, patient_birthday, gender) VALUES ('$patient_name', '$patient_birthday', '$gender')";

// SQL文の確認用出力（デバッグ時のみ使用）
echo "実行されたSQL: " . $sql . "<br>";

if ($conn->query($sql) === TRUE) {
    echo "新しい患者情報が追加されました。";
} else {
    echo "エラー: " . $conn->error;
}

echo '<p><a href="index.html" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">トップページに戻る</a></p>';


$conn->close();
?>
