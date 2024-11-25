<?php
$servername = "localhost";
$username = "root";  // 必要に応じて変更
$password = "";      // 必要に応じて変更
$dbname = "care_support"; // データベース名を修正

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}
?>
