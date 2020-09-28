@extends('layout')

@section('article')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-8 my-5">
            <h1>{{ $article->header }}</h1>
        </div>
    </div>
    @if ($article->overview !== '')
        <div class="row justify-content-center">
            <div class="col-8 mt-3">
                <p class="h5"><strong>{{ $article->overview }}</strong></p>
            </div>
        </div>
    @endif
    @if ($article->image_link !== '')
        <div class="row justify-content-center">
            <div class="col-8 mt-3">
                <img src="{{ $article->image_link }}" alt="{{ $article->image_title }}" class="img-fluid">
                @if ($article->image_title !== '')
                    <span class="text-muted">{{ $article->image_title }}</span>
                @endif
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-8 my-3">
            <div>{!! $article->content !!}</div>
        </div>
    </div>
    @if ($article->content_authors !== '')
        <div class="row justify-content-center">
            <div class="col-8 my-3">
                <p><i>{{ $article->content_authors }}</i><p>
            </div>
        </div>
    @endif
    @if (Str::contains($article->link, 'pro.rbc.ru'))
        <div class="row justify-content-center">
            <div class="col-8 my-3">
                <div class="alert alert-info" role="alert">
                    Данный материал находится в разделе Pro сайта <a href="https://www.rbc.ru/" class="alert-link">РБК</a> и является лишь фрагментом статьи.
                    Полную версию можно прочитать <a href="{{ $article->link }}" class="alert-link" target="_blank">здесь</a>.
                </div>
            </div>
        </div>
    @endif
    <div class="row justify-content-center mb-5">
            <p class="text-muted col-4">Новостной источник: © АО «РБК»</p>
            <p class="text-muted col-4">Cсылка на <a href="{{ $article->link }}" target="_blank" >статью</a> на сайте www.rbc.ru.</p>
    </div>

</div>
@endsection