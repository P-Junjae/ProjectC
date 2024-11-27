<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("html/meta.html"); ?>
    <title>介護サポートページ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.6;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include("html/header.html"); ?>
    <p>トップページ</p>
    <p>各種機能ページ</p>
    <h1>ページ移動ボタンの例</h1>
    <button onclick="location.href='https://www.example.com';">別のページに移動</button>

    <ul>
        <li><a href="https://www.google.com" target="_blank">ここをボタンとほかのページに行けるように</a></li>
        <li><a href="https://www.wikipedia.org" target="_blank">ここをボタンとほかのページに行けるように</a></li>
    </ul>
    <p>画面設計に合わせてホームページに手を加えましょう。</p>
</body>
</html>
