@php
    $real_host = Config::get('app.url');
@endphp

@extends('layouts.single')

@section('title', $image->reference)

    @section('opengraph')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{$real_host}}/{{$image->imageid}}" />
    <meta property="og:title" content="{{$image->reference}}" />
    <meta property="og:description" content="{{$image->passage_text}}">
    <meta property="og:image" content="{{$real_host}}/images/{{$image->imageid}}.jpg" />
    <meta property="og:image:secure_url" content="{{$real_host}}/images/{{$image->imageid}}.jpg" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1080" />
    <meta property="og:image:height" content="720" />
    @endsection

    @section('twitter')
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@versesee" />
    <meta name="twitter:creator" content="@versesee" />
    @endsection

    @section('facebook')
    <meta property="fb:app_id" content="278708046262155" />
    @endsection

    @section('content')
        <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
            <ul>
                <li><a class="has-text-grey-dark" href="/timeline"><span class="icon"><i class="fas fa-book-open"></i></span><span>Timeline</span></a></li>
                <li class="is-active has-text-weight-semibold"><a href="#" aria-current="page">@section('title') @show</a></li>
            </ul>
        </nav>

        @include('partials.image')
    @endsection