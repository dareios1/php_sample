<!-- ユーザーがアンケートの項目を選択して送信するためのページ -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>趣味アンケート</title>
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
                <h1>趣味アンケート</h1>
                <!-- form 要素のaction属性には完了ページ（questionnaire2.php）を指定 -->
                <form action="questionnaire2.php" method="post">
                    <!-- 「性別」はラジオボタンで作成 -->
                    <div>
                        <p>性別</p>
                        <input type="radio" name="gender" id="male" value="1">
                        <label for="male"> 男性 </label>
                        <input type="radio" name="gender" id="female" value="2">
                        <label for="female"> 女性 </label>
                    </div>
                    <!-- 「年齢」はセレクトメニューで作成 -->
                    <div>
                        <p><label for="age">年齢</label></p>
                        <select name="age" id="age">
                            <!-- 最初と最後のoption要素はHTMLで記述・最初の「選択してください。」のvalue属性の値は「0」として検証の際に利用 -->
                            <option value="0" selected>選択してください。</option>
                            <!-- その他はfor文を使って出力 -->
                            <?php
                            for ($num = 1; $num <= 7; $num++) {
                                echo '<option value="' . $num . '">' . $num . '0代</option>' . "\n";
                            }
                            ?>
                            <option value="8">80代以上</option>
                        </select>
                    </div>
                    <!-- 「趣味」はチェックボックスで作成 -->
                    <div>
                        <p>趣味</p>
                        <!-- 配列「$hobby」はチェックボックス（input要素）の value属性（$hobbyの$key）と表示する値（$hobbyの$value）に利用 -->
                        <?php
                        $hobby = array(
                            0 => "音楽",
                            1 => "スポーツ",
                            2 => "プログラミング",
                            3 => "アート",
                            4 => "旅行",
                            5 => "カメラ",
                            6 => "読書",
                            7 => "お酒"
                        );
                        $ids = array('music', 'sport', 'programing', 'art', 'travel', 'camera', 'book', 'alcohol');
                        foreach ($hobby as $key => $value) {
                            echo '<label for="' . $ids[$key] . '"><input type="checkbox" name="hobby[]" value="'
                                . $key . '" id="' . $ids[$key] . '">' . $value . '</label>' . "\n";
                        }

                        ?>
                    </div>
                    <div class="button">
                        <input type="submit">
                    </div>
                </form>
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