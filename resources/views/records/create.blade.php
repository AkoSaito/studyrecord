@extends('layouts.default')
@section('title', '学習記録')

@section('content')
    <form method="POST" action="{{ url('/records') }}">
          @csrf
            {{--カテゴリ検索--}}
            <div class="create-container">
                <div class="row">
                    <div class="col-xs-12">
                        <select class="form-control" name="category">
                          @forelse ($categories as $category)
                              <option value="{{$category->id}}" >{{$category->name}}</option>
                          @empty
                              <p>カテゴリデータがありません。</p>
                          @endforelse
                        </select>
                    </div>
                </div>
                {{--時間テキストボックス--}}
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="form-control" name="time" placeholder="2h" value="{{old('time')}}">

                    @if($errors->has('time'))
                        <p class="error">学習時間を正しく入力してください。</p>
                    @endif
                    </div>
                </div>
          </div>
              <span class="register-btn"><button type="submit" class="btn btn-primary">登録</button></span>
    </form>
@endsection
