<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("html/meta.html"); ?>
    <title>ケア管理システム</title>
</head>
<body>
    <h1>ケア管理システム</h1>

    <!-- 患者情報の追加 -->
    <h2>患者情報の追加</h2>
    <form action="insert_patient.php" method="post">
        <label for="patient_name">患者名: </label>
        <input type="text" id="patient_name" name="patient_name" required><br><br>
        <label for="patient_birthday">生年月日: </label>
        <input type="date" id="patient_birthday" name="patient_birthday" required><br><br>
        <label for="gender">性別: </label>
        <select name="gender" id="gender">
            <option value="M">男性</option>
            <option value="F">女性</option>
        </select><br><br>
        <button type="submit">患者情報を追加</button>
    </form>

    <hr>

    <!-- 職員情報の追加 -->
    <h2>職員情報の追加</h2>
    <form action="insert_staff.php" method="post">
        <label for="staff_name">職員名: </label>
        <input type="text" id="staff_name" name="staff_name" required><br><br>
        <label for="staff_type">職位: </label>
        <input type="text" id="staff_type" name="staff_type" required><br><br>
        <button type="submit">職員情報を追加</button>
    </form>

    <hr>

    <!-- ケア管理情報の追加 -->
    <h2>ケア管理情報</h2>
    <a href="add_care.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">ケア管理情報を追加する</a>

    <hr>

    <!-- 患者のスケジュール -->
<h2>患者のスケジュール</h2>
<?php
// データベース接続
include("db_connect.php");

// 患者情報を取得
$patients_result = $conn->query("SELECT patient_id, patient_name FROM 患者");

if ($patients_result->num_rows > 0) {
    while ($row = $patients_result->fetch_assoc()) {
        echo '<p>';
        echo '<a href="view_patient_schedule.php?patient_id=' . $row['patient_id'] . '" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">';
        echo $row['patient_name'] . 'さんのスケジュールを表示</a>';
        echo '</p>';
    }
} else {
    echo "<p>患者が登録されていません。</p>";
}
?>

<hr>

<!-- 編集リンク -->
<h2>スケジュール編集</h2>
<?php
$schedules_result = $conn->query("SELECT * FROM スケジュール");

if ($schedules_result->num_rows > 0) {
    while ($schedule = $schedules_result->fetch_assoc()) {
        echo '<p>';
        echo '<a href="edit_schedule.php?schedule_id=' . $schedule['schedule_id'] . '" style="display: inline-block; padding: 10px 20px; background-color: #ffc107; color: white; text-decoration: none; border-radius: 5px;">';
        echo 'スケジュール編集（' . $schedule['schedule_id'] . '）</a>';
        echo '</p>';
    }
} else {
    echo "<p>スケジュールが登録されていません。</p>";
}
?>

</body>
</html>
