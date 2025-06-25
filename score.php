<?php
// POSTデータ取得
$name   = $_POST['name'];
$school = $_POST['school'];
$year   = $_POST['year'];
$class  = $_POST['class'];
$gender = $_POST['gender'];
$date   = $_POST['date'];

$questions = ['q1','q2','q3','q4','q5','q6','q7'];
$total = 0;
$answers = [];

foreach ($questions as $q) {
  $val = isset($_POST[$q]) ? intval($_POST[$q]) : 0;
  $total += $val;
  $answers[] = $val;
}

// 保存形式に整形
$line = implode(",", [$date, $school, $year, $class, $name, $gender, $total, ...$answers]) . "\n";

// 書き込み処理
file_put_contents('data/data.txt', $line, FILE_APPEND | LOCK_EX);

// 一覧表示処理
$lines = file('data/data.txt', FILE_IGNORE_NEW_LINES);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>スコア一覧</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px; border: 1px solid #ccc; text-align: center; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h1>テスト結果一覧</h1>
  <table>
    <tr>
      <th>日付</th><th>学校</th><th>年</th><th>組</th><th>名前</th><th>性別</th><th>合計</th><th>詳細</th>
    </tr>
    <?php foreach ($lines as $i => $line): ?>
      <?php
        $data = explode(',', $line);
        list($d, $s, $y, $c, $n, $g, $score) = $data;
      ?>
      <tr>
        <td><?= htmlspecialchars($d) ?></td>
        <td><?= htmlspecialchars($s) ?></td>
        <td><?= htmlspecialchars($y) ?></td>
        <td><?= htmlspecialchars($c) ?></td>
        <td><?= htmlspecialchars($n) ?></td>
        <td><?= htmlspecialchars($g) ?></td>
        <td><?= htmlspecialchars($score) ?></td>
        <td><a href="detail.php?id=<?= $i ?>">⚪︎×</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <p><a href="index.php">← 戻る</a></p>
</body>
</html>
