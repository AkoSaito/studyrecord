<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>検索画面</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>検索画面</h1>
        <section class="sort">
            <ul>
                {!! Form::open() !!}
                {{--カテゴリー:<li>{!! Form::text('categories', $categories) !!}</li>--}}
                <li>言語{!! Form::text('name', $title) !!}</li>
                <li>{!! Form::radio('day', '日') !!}日</li>
                <li>{!! Form::radio('week', '週') !!}週</li>
                <li>{!! Form::radio('month', '月') !!}月</li>
                <li>{!! Form::radio('year', '年') !!}年</li>
                <li>{!! Form::submit('検索') !!}</li>
                {!! Form::close() !!}

                @foreach($records as $record)
                    <div>
                        <a>{{ $record->id }}</a>
                        <a>{{ $record->created_at }}</a>
                    </div>
                @endforeach
            </ul>
    </div>
</body>
</html>
