@extends('layout')

@section('news')
<div class="container mt-5">
    
    <h1 class="mb-4">Новостная лента сайта «РБК»</h1>
    <div class="row mb-3">
        <div class="col-3">
            <form action="{{ route('getrbcnews.index') }}" method="POST" class="form-inline" id="loadNews">
                @csrf
                <button type="submit" class="btn btn-primary mb-2">Загрузить новости</button>
            </form>
        </div>
        @if (count($news) > 0)
            <div class="col-4">
                <span class="text-muted" style="font-size: 12px">
                    Последнее обновление новостей {{ $news->first()->updated_at->timezone('Europe/Prague')->format('H:i d.m.Y') }} (GMT+2)
                </span>
            </div>
        @endif
    </div>
    <hr>
    @if(count($news) > 0)
        @foreach($news as $article)
        <div class="py-3">
            <h2>
                <a href="/{{ $article->feed_id }}">{{ $article->header }}</a>
            </h2>
            <p>
                @if (Str::of(strip_tags($article->content))->isEmpty())
                    {{ Str::limit(strip_tags($article->overview), 200, ' ( ... ) ') }}
                @else
                    {{ Str::limit(strip_tags($article->content), 200, ' ( ... ) ') }}
                @endif
            </p>
            <div class="row">
                <div class="col-md-2">
                    <a class="btn btn-outline-info btn-sm" href="/{{ $article->feed_id }}" role="button">Читать далее</a>
                </div>
                <div class="col-md-8">
                    <p class="text-muted" style="font-size: 13px">Опубликовано в {{ Carbon\Carbon::parse($article->date_modified)->format('H:i d.m.Y') }} (GMT+3)</p>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection