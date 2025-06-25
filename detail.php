<?php
// ID取得（GETで渡された行番号）
$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

// ファイル読み込み
$lines = file('data/data.txt', FILE_IGNORE_NEW_LINES);

// 対象行を取得
if ($id >= 0 && $id < count($lines)) {
  $data = explode(',', $lines[$id]);
  list($date, $school, $year, $class, $name, $gender, $score, $q1, $q2, $q3, $q4, $q5, $q6, $q7) = $data;

  // 回答の配列を作成
  $answers = [$q1, $q2, $q3, $q4, $q5, $q6, $q7];
} else {
  die('データが見つかりませんでした。');
}

// 表示用記号に変換
function mark($v) {
  return intval($v) > 0 ? '⚪︎' : '×';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>詳細結果</title>
  <style>
    table { border-collapse: collapse; margin: 20px 0; }
    th, td { border: 1px solid #ccc; padding: 8px 16px; text-align: center; }
    th { background: #f0f0f0; }
  </style>
</head>
<body>
  <h1><?= htmlspecialchars($name) ?> さんの詳細結果</h1>
  <p>日付：<?= htmlspecialchars($date) ?>　学校：<?= htmlspecialchars($school) ?>　学年：<?= htmlspecialchars($year) ?>　組：<?= htmlspecialchars($class) ?>　性別：<?= htmlspecialchars($gender) ?></p>

  <table>
    <tr><th>質問</th><th>回答</th></tr>
    <?php for ($i = 0; $i < 7; $i++): ?>
      <tr>
        <td><?= $i + 1 ?>.</td>
        <td><?= mark($answers[$i]) ?></td>
      </tr>
    <?php endfor; ?>
  </table>

  <p><a href="score.php">← スコア一覧に戻る</a></p>
</body>
</html>
