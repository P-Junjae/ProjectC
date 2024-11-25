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
    
    <a href="insert_patient.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">患者情報を追加する</a>

    <hr>

    <!-- 職員情報の追加 -->
    <h2>職員情報の追加</h2>
    <a href="insert_staff.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">職員情報を追加する</a>

    <hr>

    <!-- ケア管理情報の追加 -->
    <h2>ケア管理情報の追加</h2>
    <a href="add_care.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">ケア管理情報を追加する</a>

    <hr>

    <!-- スケジュール管理 -->
    <h2>スケジュール管理</h2>
    <a href="add_schedule.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">スケジュールを追加する</a>

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

</body>
</html>
