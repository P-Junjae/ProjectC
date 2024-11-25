<?php
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
$staff_name = $_POST['staff_name'];
$staff_type = $_POST['staff_type'];

// 職員情報をデータベースに挿入
$sql = "INSERT INTO 職員 (staff_name, staff_type) VALUES ('$staff_name', '$staff_type')";

// デバッグ用: 実行するSQLを表示
echo "実行SQL: " . $sql . "<br>";

if ($conn->query($sql) === TRUE) {
    echo "新しい職員情報が追加されました。";
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

echo '<p><a href="testhtml.html" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">トップページに戻る</a></p>';


$conn->close();
?>
