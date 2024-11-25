<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ダッシュボード - ケア記録システム</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>今日のスケジュール</h1>
    <table border="1">
        <thead>
            <tr>
                <th>利用者名</th>
                <th>担当スタッフ</th>
                <th>タスク</th>
                <th>日付</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($schedules)): ?>
                <tr><td colspan="4">本日のスケジュールはありません。</td></tr>
            <?php else: ?>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?= htmlspecialchars($schedule['client_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($schedule['staff_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($schedule['task'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($schedule['date'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
