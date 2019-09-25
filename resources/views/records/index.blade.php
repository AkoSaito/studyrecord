<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チリツモ</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>チリツモ</h1>
        <section class="header_menu">
            <a href="{{ action('RecordsController@create') }}">今日の記録</a>
            <a href="{{ action('CategoriesController@maintenance') }}">カテゴリ一覧</a>
        </section>

        <section class="records_list">
            @forelse ($records as $record)
                <ul>
                    <li>{{ $record->category->name }}</li>
                    <li>{{ $record->time }}時間</li>
                    <li>{{ $record->created_at }}</li>
                    <form method="POST" action="/records/delete/{{$record->id}}" >
                        {{ csrf_field() }}

                        <input type="submit" value="削除" name="del_btn" onclick='return confirm("削除してよろしいですか？");'>
                    </form>
                </ul>
            @empty
                <p class="error">記録がありません。</p>
            @endforelse
        </section>
        {{-- ページネーションバー--}}
        <span class="pagination">{{ $records->links() }}</span>
    </div>
    <script src="/js/main.js"></script>
</body>
</html>
