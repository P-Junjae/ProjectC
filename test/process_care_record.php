<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $staff_id = $_POST['staff_id'];
    $date = $_POST['date'];
    $details = $_POST['details'];
    $temperature = !empty($_POST['temperature']) ? (float)$_POST['temperature'] : null;
    $pulse = !empty($_POST['pulse']) ? (int)$_POST['pulse'] : null;
    $systolic_bp = !empty($_POST['systolic_bp']) ? (int)$_POST['systolic_bp'] : null;
    $diastolic_bp = !empty($_POST['diastolic_bp']) ? (int)$_POST['diastolic_bp'] : null;

    // データベースに記録を追加
    $query = "INSERT INTO care_records (client_id, staff_id, date, details, temperature, pulse, systolic_bp, diastolic_bp) 
              VALUES (:client_id, :staff_id, :date, :details, :temperature, :pulse, :systolic_bp, :diastolic_bp)";
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([
            ':client_id' => $client_id,
            ':staff_id' => $staff_id,
            ':date' => $date,
            ':details' => $details,
            ':temperature' => $temperature,
            ':pulse' => $pulse,
            ':systolic_bp' => $systolic_bp,
            ':diastolic_bp' => $diastolic_bp,
        ]);

        // 正常にデータが保存された場合、メインページにリダイレクト
        header('Location: main_page.php');  // メインページのURLを指定
        exit();
    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>
