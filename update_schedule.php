<?php
// エラー表示（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続
include("db_connect.php");

// フォームから送信されたデータを受け取る
$schedule_id = $_POST['schedule_id'];
$patient_id = $_POST['patient_id'];
$staff_id = $_POST['staff_id'];
$date = $_POST['date'];
$task = $_POST['task'];

// スケジュール情報を更新
$update_query = "
    UPDATE スケジュール 
    SET patient_id = ?, staff_id = ?, date = ?, task = ? 
    WHERE schedule_id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("iissi", $patient_id, $staff_id, $date, $task, $schedule_id);

if ($stmt->execute()) {
    echo "スケジュールが更新されました。<br>";
    echo '<a href="view_patient_schedule.php?patient_id=' . $patient_id . '">患者のスケジュールページに戻る</a>';
} else {
    echo "エラー: " . $conn->error;
}

$conn->close();
?>
