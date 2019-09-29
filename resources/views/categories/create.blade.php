@extends('layouts.default')
@section('title', '学習記録')

@section('content')
    <form method="POST" action="{{ url('/categories') }}">
          @csrf
          <div class="form-group">
              <label>
                  {{--カテゴリ名テキストボックス--}}
                  <input type="text" name="category_name" placeholder="カテゴリ名" class="create-category-name">
                  @if($errors->has('category_name'))
                      <p class="error">カテゴリ名を入力してください。</p>
                  @endif
              </label>
          <div class="form-group">
              <label>
                    <span class="register-btn"><button type="submit" class="btn btn-primary">登録</button></span>
              </label>
          </div>
    </form>
@endsection
