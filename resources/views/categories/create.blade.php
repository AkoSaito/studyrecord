<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チリツモ</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>カテゴリーメンテナンス（登録）</h1>

        <section class="header_menu">
            <a href="{{url('/')}}" class="header-menu">戻る</a>
        </section>

        <form method="POST" action="{{ url('/categories') }}">
              {{ csrf_field() }}

              <p>カテゴリー名(言語)：<input type="text" name="name" placeholder="PHP"></p>
              <p><input type="submit" value="登録" name="submit_btn"></p>
        </form>
    </div>
</body>
</html>
