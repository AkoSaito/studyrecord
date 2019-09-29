@extends('layouts.default')
@section('title', '学習記録')

@section('content')
    <section class="category_list">
          <div class="maintenance-container">
              @forelse($categories as $category)
                  <div class="row">
                      <div class="col">
                            {{$category->name}}
                      </div>

                      <form action="/categories/delete/{{$category->id}}" method="POST">
                          @csrf
                          <div class="col">
                                <button type="submit" class="btn btn-primary" value="削除" name="del_btn" onclick='return confirm("削除してよろしいですか？");'>削除</button>
                          </div>
                      </form>
                 </div>
              @empty
                  <p class="error">カテゴリー名がありません。</p>
              @endforelse
          </div>
    </section>
@endsection
