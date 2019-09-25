<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チリツモ</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>今日の記録</h1>
        <section class="header_menu">
            <a href="{{url('/')}}" class="header-menu">戻る</a>
        </section>

        <form method="POST" action="{{ url('/records') }}">
              {{ csrf_field() }}
              <p>言語<select name="category">
                    @forelse ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option></p>
                    @empty
                        <li>カテゴリーデータがありません。</li>
                    @endforelse
              </select>
              <p><input type="text" name="time" placeholder="2">時間</p>
              <p><input type="submit" value="登録" name="submit_btn"></p>
        </form>
    </div>
</body>
</html>
