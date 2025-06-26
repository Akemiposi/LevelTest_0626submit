<?php
// テストログ：POSTデータ確認
error_log('POST内容：' . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $school = $_POST['school'];
  $name = $_POST['name']; 
  $year = $_POST['year'];
  $class = $_POST['class'];
  $gender = $_POST['gender'];
  $date = $_POST['date'];
  $lang = $_POST['language'];

  $questions = ['q1','q2','q3','q4','q5','q6','q7'];
  $scores = [];
  $totalScore = 0;

  foreach ($questions as $q) {
    $score = $_POST[$q];
    $scores[] = $score;
    $totalScore += intval($score);
  }

  $line = implode(",", [$date, $school, $year, $class, $name, $gender, $lang, ...$scores, $totalScore]) . "\n";
  file_put_contents("data/data.txt", $line, FILE_APPEND | LOCK_EX);

  $result = file_put_contents('data/data.txt', $line, FILE_APPEND | LOCK_EX);
if ($result === false) {
  echo 'ファイル書き込みに失敗しました。パーミッションまたはパスを確認してください。';
  exit;
}

  header("Location: score.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>にほんごノート（レベルチェックーレベル０）</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header></header>

    <main>
     
      <h1>レベルチェック（レベル０）</h1>

      <form action="score.php" method="POST">
        <fieldset>
          <legend>基本情報</legend>
          <div class="inline-field">
            <label for="name">学校名：</label>
            <input type="text" name="school" id="name" class="long" required />

            <label for="year"></label>
            <input type="text" name="year" id="year" class="short" required />年

            <label for="class"></label>
            <input
              type="text"
              name="class"
              id="class"
              class="short"
              required
            />組
          </div>

          <div class="inline-field">
            <label for="name">名　前：</label>
            <input
              type="text"
              name="name"
              id="name"
              class="long"
              required
            />

            <label for="gender">性別：</label>
            <input
              type="text"
              name="gender"
              id="gender"
              class="short"
              required
            />

            <label for="date">実施日：</label>
            <input type="date" name="date" id="date" class="medium" required />
          </div>
        </fieldset>

        <fieldset>
          <legend>聞いて答える問題</legend>

          <label for="languageSelect">母語を選んでください（
            select your language）：</label>
          <select id="languageSelect" name="language">
            <option value="ja">日本語</option>
        <option value="en">English</option>
        <option value="zh">中文 (Chinese)</option>
        <option value="vi">Tiếng Việt (Vietnamese)</option>
        <option value="tl">Filipino (Tagalog)</option>
        <option value="ne">नेपाली (Nepali)</option>
        <option value="my">မြန်မာစာ (Burmese)</option>
        <option value="mn">Монгол (Mongolian)</option>
        <option value="uz">O‘zbekcha (Uzbek)</option>
          </select>

         <p id="translated-instruction">
            これから日本語で質問をします。聞いて答えてください。もし聞かれている内容がわからない時は、「わからない」と言うか、首を横に振ってください。
          </p>
          <table border="1">
  <thead>
    <tr>
      <th>質問</th>
      <th colspan="2">回答</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1. あなたの名前は？ <button type="button" onclick="speakWithGoogle('あなたの名前は？')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q1">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q1" value="" required />
      </td>
    </tr>

    <tr>
      <td>2. どこから来ましたか？ <button type="button" onclick="speakWithGoogle('どこから来ましたか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q2">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q2" value="" required />
      </td>
    </tr>

    <tr>
      <td>3. 何歳ですか？ <button type="button" onclick="speakWithGoogle('何歳ですか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q3">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q3" value="" required />
      </td>
    </tr>

    <tr>
      <td>4. 今日は、何曜日ですか？ <button type="button" onclick="speakWithGoogle('今日は、何曜日ですか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q4">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q4" value="" required />
      </td>
    </tr>

    <tr>
      <td>5. 明日は、何日ですか？ <button type="button" onclick="speakWithGoogle('明日は、何日ですか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q5">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q5" value="" required />
      </td>
    </tr>

    <tr>
      <td>6. 何時ですか？ <a href="img/watch.png">絵を表示</a> <button type="button" onclick="speakWithGoogle('何時ですか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q6">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q6" value="" required />
      </td>
    </tr>

    <tr>
      <td>7. これは何ですか？ <a href="img/pencil.png">絵を表示</a> <button type="button" onclick="speakWithGoogle('これは何ですか')">🔊</button></td>
      <td colspan="2">
        <div class="buttonGroup" data-question="q7">
          <button type="button" class="answerBtn" data-value="5">言える</button>
          <button type="button" class="answerBtn" data-value="0">言えない</button>
        </div>
        <input type="hidden" name="q7" value="" required />
      </td>
    </tr>
  </tbody>
</table>



        </fieldset>
<br>
        <button type="submit">採点する</button>
      </form>
    </main>

    <footer>@nihongo-note all right reserved.</footer>

    <script src="js/index.js"></script>
  </body>
</html>
