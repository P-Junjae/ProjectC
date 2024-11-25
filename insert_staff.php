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
    if (isset($_POST['staff_name'], $_POST['staff_type'])) {
        $staff_name = $conn->real_escape_string($_POST['staff_name']);
        $staff_type = $conn->real_escape_string($_POST['staff_type']);

        // 入力チェック: 必須項目が空でないか確認
        if (empty($staff_name) || empty($staff_type)) {
            echo "すべての項目を入力してください。";
        } else {
            // 職員情報をデータベースに挿入
            $sql = $conn->prepare("INSERT INTO 職員 (staff_name, staff_type) VALUES (?, ?)");
            $sql->bind_param("ss", $staff_name, $staff_type); // "ss" は文字列型を示す

            if ($sql->execute()) {
                echo "新しい職員情報が追加されました。";
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
    <h2>職員情報の追加</h2>
    <form method="POST" action="insert_staff.php">
        <label for="staff_name">職員の名前:</label><br>
        <input type="text" id="staff_name" name="staff_name" required><br><br>

        <label for="staff_type">職員の役職:</label><br>
        <input type="text" id="staff_type" name="staff_type" required><br><br>

        <input type="submit" value="職員情報を追加する">
    </form>
    <?php
}

echo '<p><a href="index.php" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">トップページに戻る</a></p>';

$conn->close();
?>
