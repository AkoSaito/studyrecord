<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チリツモ</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>カテゴリーメンテナンス（一覧）</h1>
        <section class="header_menu">
            <a href="{{url('/')}}">戻る</a>
            <a href="{{ action('CategoriesController@create' )}}">登録</a>
        </section>
        <section class="category_list">
            @forelse($categories as $category)
                <ul>
                    <li class="title">
                        <span class="name">{{$category->name}}</span>
                    </li>

                    <form method="POST" action="/categories/delete/{{$category->id}}" >
                        {{ csrf_field() }}

                        <input type="submit" value="削除" name="del_btn" onclick='return confirm("削除してよろしいですか？");'>
                    </form>
                </ul>
            @empty
                <p class="error">カテゴリー名がありません。</p>
            @endforelse
        </section>
    </div>
</body>
</html>
