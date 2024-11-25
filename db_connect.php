<?php
// データベース接続設定
$servername = "localhost"; // サーバー名
$username = "root";        // データベースのユーザー名
$password = "";            // データベースのパスワード（XAMPPでは通常空白）
$dbname = "care_support";  // 使用するデータベース名

// MySQL接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
}

// 文字コード設定（日本語対応）
$conn->set_charset("utf8mb4");
?>
