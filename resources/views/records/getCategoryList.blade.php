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

        <section class="sort">
            <form action="{{url('/')}}" method="POST">
                <ul>

                    <li><a href="">今日の記録</li>

                    <select name="category">
                         @forelse ($categories as $category)
                                <li><option value="{{$category->id}}">{{$category->name}}</option</li>
                         @empty
                                <li>カテゴリがありません。</li>
                         @endforelse
                    </select>
                </ul>
        </form>

        <ul>
            @forelse ($records as $record)
                <li>{{ $record->name }}</a></li>
                <li>{{ $record->time }}時間</a></li>
            @empty
                <li>記録がありません。</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
