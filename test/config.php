<?php
// データベース接続設定
$host = 'localhost';  // サーバー名
$dbname = 'test';  // データベース名
$username = 'root';  // データベースユーザー名
$password = '';  // データベースパスワード

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}
?>
