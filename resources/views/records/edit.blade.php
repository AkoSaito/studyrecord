<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チリツモ</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>編集
            <a href="{{url('/')}}" class="header_menu">戻る</a>
        </h1>

        <form method="POST" action="{{ url('/records', $record->id) }}">
              {{ csrf_field() }}
              {{ method_field('patch') }}
              言語<select name="category">
                    @forelse ($categories as $category)
                        <option value="{{old('category', $record->category_id )}}" >{{ $category->name }}</option>
                    @empty
                        <li>カテゴリーデータがありません。</li>
                    @endforelse
              </select>
              <p><input type="text" name="time" placeholder="2" value="{{ old('time'), $record->time }}">時間</p>
              <p><input type="submit" value="更新" name="submit_btn"></p>
        </form>
    </div>
</body>
</html>
