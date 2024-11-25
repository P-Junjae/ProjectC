<?php
// エラー表示（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続
include("db_connect.php");

// 編集対象のスケジュールIDを取得
$schedule_id = $_GET['schedule_id'] ?? null;

if ($schedule_id) {
    // スケジュール情報を取得
    $schedule_query = "SELECT * FROM スケジュール WHERE schedule_id = ?";
    $stmt = $conn->prepare($schedule_query);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $schedule = $result->fetch_assoc();
    } else {
        die("指定されたスケジュールが見つかりません。");
    }
} else {
    die("スケジュールIDが指定されていません。");
}

// 職員情報を取得
$staff_result = $conn->query("SELECT staff_id, staff_name FROM 職員");

// 患者情報を取得
$patients_result = $conn->query("SELECT patient_id, patient_name FROM 患者");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スケジュール編集</title>
</head>
<body>
    <h1>スケジュール編集</h1>

    <form action="update_schedule.php" method="post">
        <input type="hidden" name="schedule_id" value="<?php echo $schedule['schedule_id']; ?>">

        <label for="patient_id">患者名: </label>
        <select id="patient_id" name="patient_id" required>
            <?php
            while ($patient = $patients_result->fetch_assoc()) {
                $selected = ($patient['patient_id'] == $schedule['patient_id']) ? "selected" : "";
                echo "<option value='{$patient['patient_id']}' $selected>{$patient['patient_name']}</option>";
            }
            ?>
        </select><br><br>

        <label for="staff_id">担当職員: </label>
        <select id="staff_id" name="staff_id" required>
            <?php
            while ($staff = $staff_result->fetch_assoc()) {
                $selected = ($staff['staff_id'] == $schedule['staff_id']) ? "selected" : "";
                echo "<option value='{$staff['staff_id']}' $selected>{$staff['staff_name']}</option>";
            }
            ?>
        </select><br><br>

        <label for="date">日時: </label>
        <input type="datetime-local" id="date" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($schedule['date'])); ?>" required><br><br>

        <label for="task">メモ: </label>
        <textarea id="task" name="task" required><?php echo htmlspecialchars($schedule['task']); ?></textarea><br><br>

        <button type="submit">スケジュールを更新</button>
    </form>

    <p><a href="view_patient_schedule.php?patient_id=<?php echo $schedule['patient_id']; ?>">この患者のスケジュールに戻る</a></p>

</body>
</html>
