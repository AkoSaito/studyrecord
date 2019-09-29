@extends('layouts.default')
@section('title', '学習記録')

@section('content')
<section class="records_list">

    <form action="{{ action('RecordsController@index')}}" method="GET">
        @csrf
        <div class="search-bar">
        <div class="form-group form-inline">
            {{--カテゴリ絞り込み検索--}}
            <label>カテゴリ名</label>
            <select class="form-control" name="category">
                <option value="">選択してください</option>
            @forelse($categories as $category)
                <option value="{{$category->id}}" @if( "{{$category->id}}" === "{{$selectedCategory}}" ) selected @else "" @endif >{{$category->name}}</option>
            @empty
                <p>カテゴリーがありません。</p>
            @endforelse
            </select>

            {{--表示期間絞り込み検索--}}
            <div class="form-check">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="day" {{ $selectedPeriod == 'day' ? 'checked' : '' }}>
                <label class="form-check-label">日</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="week"
                {{ $selectedPeriod == 'week' ? 'checked' : '' }}>
                <label class="form-check-label">週</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="month"
                {{ $selectedPeriod == 'month' ? 'checked' : '' }}>
                <label class="form-check-label">月</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="year"
                {{ $selectedPeriod == 'year' ? 'checked' : '' }}>
                <label class="form-check-label">年</label>
            </div>
            <div class="form-check"><button type="submit" class="btn btn-primary">検索</button></div>
        </div>
        </div>
    </form>

    {{--circleProgressBar--}}
    <div class="wrapper">
      <div class="row">
        <div class="col">
          <div class="counter" data-cp-percentage={{$sumForProgress}} data-cp-color="#00bfeb">
          </div>
          <h4>合計：{{$sum}}時間</h4>
        </div>
      </div>
      </div>

      {{--学習記録リスト--}}
      @forelse ($records as $record)
      <div class="container">
          <div class="row">
              <div class="col">{{ $record->category->name }}</div>
              <div class="col">{{ $record->created_at }}</div>
              <div class="col">{{ $record->time }}時間</div>
              <form action="/records/delete/{{$record->id}}" method="POST">
                  @csrf
                  <div class="col">
                      <button type="submit" class="btn btn-outline-primary" class="del_btn" onclick='return confirm("削除してよろしいですか？");'>削除</button>
                  </div>
              </form>
              <div class="col">
                  <div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style='width:{{$record->time}}%' aria-valuenow="{{$record->time}}" aria-valuemin="0" aria-valuemax="100">{{$record->time}}h</div>
                  </div>
              </div>
          </div>
      </div>

    @empty
        <p class="error">記録がありません。</p>
    @endforelse
</section>



{{-- ページネーションバー--}}
<span class="pagination">{{ $records->appends($selectedCategory)->appends($selectedPeriod)->links() }}</span>

<script src="/js/main.js"></script>
@endsection
