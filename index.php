<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("html/meta.html"); ?>
    <title>ケア管理システム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        h1 {
            color: #007BFF;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        a:hover {
            background-color: #0056b3;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>ケア管理システム</h1>

    <!-- 患者情報の追加 -->
    <h2>患者情報の追加</h2>
    <a href="insert_patient.php">患者情報を追加する</a>

    <hr>

    <!-- 職員情報の追加 -->
    <h2>職員情報の追加</h2>
    <a href="insert_staff.php">職員情報を追加する</a>

    <hr>

    <!-- ケア管理情報の追加 -->
    <h2>ケア管理情報の追加</h2>
    <a href="add_care.php">ケア管理情報を追加する</a>

    <hr>

    <!-- スケジュール管理 -->
    <h2>スケジュール管理</h2>
    <a href="add_schedule.php">スケジュールを追加する</a>

    <hr>

    <!-- 患者のスケジュール一覧ページへのリンク -->
    <h2>患者のスケジュール一覧</h2>
    <a href="view_patient_schedule.php">患者のスケジュールを表示</a>

    <hr>

    <!-- ケア管理情報表示ページへのリンク -->
    <h2>ケア管理情報を表示</h2>
    <a href="view_care.php">ケア管理情報を表示</a>

    <hr>

</body>
</html>
