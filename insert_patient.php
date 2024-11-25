<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続設定
$servername = "localhost";
$username = "root";  // データベースのユーザー名
$password = "";  // パスワード
$dbname = "care_support";  // データベース名

// MySQL接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続チェック
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// フォームからのデータを受け取る
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 必須項目が送信されているか確認
    if (isset($_POST['patient_name'], $_POST['patient_birthday'], $_POST['gender'])) {
        $patient_name = $conn->real_escape_string($_POST['patient_name']);
        $patient_birthday = $conn->real_escape_string($_POST['patient_birthday']);
        $gender = $conn->real_escape_string($_POST['gender']);

        // 入力チェック: 必須項目が空でないか確認
        if (empty($patient_name) || empty($patient_birthday) || empty($gender)) {
            echo "すべての項目を入力してください。";
        } else {
            // 患者情報をデータベースに挿入
            $sql = $conn->prepare("INSERT INTO 患者 (patient_name, patient_birthday, gender) VALUES (?, ?, ?)");
            $sql->bind_param("sss", $patient_name, $patient_birthday, $gender); // "sss" は文字列型を示す

            if ($sql->execute()) {
                echo "新しい患者情報が追加されました。";
            } else {
                echo "エラー: " . $sql->error;
            }

            $sql->close();
        }
    } else {
        echo "フォームデータが正しく送信されていません。";
    }
} else {
    // フォームが表示される
    ?>
    <h2>患者情報の追加</h2>
    <form method="POST" action="insert_patient.php">
        <label for="patient_name">患者の名前:</label><br>
        <input type="text" id="patient_name" name="patient_name" required><br><br>

        <label for="patient_birthday">生年月日:</label><br>
        <input type="date" id="patient_birthday" name="patient_birthday" required><br><br>

        <label for="gender">性別:</label><br>
        <select id="gender" name="gender" required>
            <option value="男性">男性</option>
            <option value="女性">女性</option>
            <option value="その他">その他</option>
        </select><br><br>

        <input type="submit" value="患者情報を追加する">
    </form>
    <?php
}

echo '<p><a href="index.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">トップページに戻る</a></p>';

$conn->close();
?>
