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
<!-- ケア管理情報 -->
<h2>ケア管理情報</h2>
    <a href="add_care.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">ケア管理情報を追加する</a>

</body>
</html>
