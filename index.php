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
<h2>ケア管理情報の追加</h2>
<form action="insert_care.php" method="post">
    <label for="patient_id">患者名: </label>
    <select id="patient_id" name="patient_id" required>
        <option value="" disabled selected>選択してください</option>
        <?php
        // 患者情報をデータベースから取得
        $patients_result = $conn->query("SELECT patient_id, patient_name FROM 患者");

        // エラーチェック
        if ($patients_result === false) {
            echo "SQLエラー: " . $conn->error;
        } else {
            if ($patients_result->num_rows > 0) {
                while ($row = $patients_result->fetch_assoc()) {
                    echo "<option value='{$row['patient_id']}'>{$row['patient_name']}</option>";
                }
            } else {
                echo "<option value='' disabled>患者情報が見つかりません</option>";
            }
        }
        ?>
    </select><br><br>

    <label for="staff_id">職員名: </label>
    <select id="staff_id" name="staff_id" required>
        <option value="" disabled selected>選択してください</option>
        <?php
        // 職員情報をデータベースから取得
        $staff_result = $conn->query("SELECT staff_id, staff_name FROM 職員");

        // エラーチェック
        if ($staff_result === false) {
            echo "SQLエラー: " . $conn->error;
        } else {
            if ($staff_result->num_rows > 0) {
                while ($row = $staff_result->fetch_assoc()) {
                    echo "<option value='{$row['staff_id']}'>{$row['staff_name']}</option>";
                }
            } else {
                echo "<option value='' disabled>職員情報が見つかりません</option>";
            }
        }
        ?>
    </select><br><br>

    <label for="care_date">ケア日: </label>
    <input type="date" id="care_date" name="care_date" required><br><br>

    <label for="care_type">ケアの種類: </label>
    <input type="text" id="care_type" name="care_type" required><br><br>

    <label for="notes">メモ: </label>
    <textarea id="notes" name="notes"></textarea><br><br>

    <button type="submit">ケア情報を追加</button>
</form>
</body>
</html>
