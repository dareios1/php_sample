<!-- アンケートの回答をテキストファイルに保存し、回答に不備があればエラーメッセージを表示するページ -->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アンケート結果</title>
  <link rel="stylesheet" href="questionnaire.css">
  <script src="https://kit.fontawesome.com/67ae73f65d.js" crossorigin="anonymous"></script>
</head>

<body class="nohero">

  <header>

    <div class="container">

      <div class="container-small">

        <a href="questionnaire1.php" class="headA">United Dareios</a>

        <button type="button" class="headC"><span class="fa fa-bars" title="MENU"></span></button>

      </div>

    </div>

  </header>

  <main>

    <article class="post">
      <div class="container">
        <h1>アンケート結果</h1>
        <?php
        //入力値に不正なデータがないかなどをチェックする関数
        function checkInput($var)
        {
          if (is_array($var)) {
            //$var が配列の場合、checkInput()関数をそれぞれの要素について呼び出す
            return array_map('checkInput', $var);
          } else {
            //php.iniでmagic_quotes_gpcが「on」の場合の対策
            if (get_magic_quotes_gpc()) {
              $var = stripslashes($var);
            }
            //NULLバイト攻撃対策
            if (preg_match('/\0/', $var)) {
              die('不正な入力（NULLバイト）です。');
            }
            //文字エンコードのチェック
            if (!mb_check_encoding($var, 'UTF-8')) {
              die('不正な文字エンコードです。');
            }
            //数値かどうかのチェック 
            if (!ctype_digit($var)) {
              die('不正な入力です。');
            }
            return (int) $var;
          }
        }

        //POSTされた全てのデータをチェック
        $_POST = checkInput($_POST);

        $error = 0;  //変数の初期化

        //性別の入力の検証
        if (isset($_POST['gender'])) {
          $gender = $_POST['gender'];
          if ($gender == 1) {
            $gendername = '男性';
          } elseif ($gender == 2) {
            $gendername = '女性';
          } else {
            $error = 1;  //入力エラー（値が 1 または 2 以外）
          }
        } else {
          $error = 1;  //入力エラー（値が未定義）
        }

        //年齢の入力の検証
        if (isset($_POST['age'])) {
          $age = $_POST['age'];
          if ($age < 1 || $age > 8) {
            $error = 1;  //入力エラー（値が1-8以外）
          }
        } else {
          $error = 1;  //入力エラー（値が未定義）
        }

        //趣味の入力の検証
        if (isset($_POST['hobby'])) {
          $hobby = $_POST['hobby'];
          if (is_array($hobby)) {
            foreach ($hobby as $value) {
              if ($value < 0 || $value > 7) {
                $error = 1;  //入力エラー（値が0-7以外）
              }
            }
          } else {
            $error = 1;  //入力エラー（値が配列ではない）
          }
        } else {
          $error = 1;  //入力エラー（値が未定義）
        }

        //エラーがない場合の処理（結果の表示）
        if ($error == 0) {
          echo '<dl>';
          echo '<dt>性別：</dt><dd>' . $gendername . '</dd>';

          //年齢の値で分岐
          if ($age != 8) {
            echo '<dt>年齢：</dt><dd>' . $age . '0代</dd>';
          } else {
            echo '<dt>年齢：</dt><dd>80代以上</dd>';
          }

          //foreach で配列の数だけ繰り返し処理
          echo '<dt>趣味：</dt>';
          echo '<dd>';
          foreach ($hobby as $value) {
            switch ($value) {
              case 0:
                echo '音楽<br>';
                break;
              case 1:
                echo 'スポーツ<br>';
                break;
              case 2:
                echo 'プログラミング<br>';
                break;
              case 3:
                echo 'アート<br>';
                break;
              case 4:
                echo '旅行<br>';
                break;
              case 5:
                echo 'カメラ<br>';
                break;
              case 6:
                echo '読書<br>';
                break;
              case 7:
                echo 'お酒<br>';
                break;
            }
          }
          echo '</dd></dl>';

          //アンケート結果を保存するテキストファイルを指定
          $textfile = 'log.txt';

          //読み込み／書き出し用にオープン (r+) 'b' フラグを指定
          $fp = fopen($textfile, 'r+b');
          if (!$fp) {
            exit('ファイルが存在しないか異常があります');
          }
          if (!flock($fp, LOCK_EX)) {
            exit('ファイルをロックできませんでした');
          }
          while (!feof($fp)) {
            $results[] = trim(fgets($fp));
          }

          if ($gender == 1) $results[0]++;
          if ($gender == 2) $results[1]++;

          $results[$age + 1]++;

          foreach ($hobby as $value) {
            $results[$value + 10]++;
          }

          $results[18]++;

          rewind($fp);

          foreach ($results as $value) {
            fwrite($fp, $value . "\n");
          }

          fclose($fp);

          echo '<p class="message sucess">以上の内容を保存しました。<br>アンケートにご協力いただきありがとうございました！</p>';
          echo '<p class="message"><a href="questionnaire3.php">集計結果ページへ</a></p>';
        } else {
          echo '<p class="message error">恐れ入りますが<a href="questionnaire1.php">アンケート入力ページ</a>に戻り、アンケートの項目全てにお答えください。</p>';
        }

        ?>
      </div>
    </article>
    
  </main>

  <footer>

    <div class="container">

      <div class="footA">
        <h2>United Dareios</h2>
        <p>〒810-0041<br>福岡県福岡市中央区大名1-3-41 プリオ大名1F<br>
          <a href="https://gsacademy.tokyo/fukuokalab/">https://gsacademy.tokyo/fukuokalab/</a>
        </p>
        <nav class="footD">
          <ul>
            <li><a href="https://twitter.com/dareios__1"><span class="fa fa-twitter" title="Twitter"></span></a></li>
            <li><a href="https://www.facebook.com/issei.kubo.3"><span class="fa fa-facebook" title="Facebook"></span></a></li>
            <li><a href="#"><span class="fa fa-google-plus" title="Google Plus"></span></a></li>
            <li><a href="https://www.instagram.com/dareios1/?hl=ja"><span class="fa fa-instagram" title="Instagram"></span></a></li>
            <li><a href="#"><span class="fa fa-youtube" title="YouTube"></span></a></li>
          </ul>
        </nav>
      </div>

      <div class="footC">
        ©︎ United Dareios corp. All rights reserved.
      </div>

    </div>

  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>

</html>