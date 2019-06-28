@php
    $real_host = Config::get('app.url');
@endphp

@extends('layouts.single')

@section('content')

    <nav class="breadcrumb is-large is-centered" aria-label="breadcrumbs">
        <ul>
            <li class="is-active has-text-weight-semibold"><a class="has-text-grey-dark" href="/timeline"><span class="icon"><i class="fas fa-book-open"></i></span><span>Timeline</span></a></li>
            <li><a class="has-text-grey-dark" href="/seek"><span class="icon"><i class="fas fa-search"></i></span><span>Seek</span></a></li>
        </ul>
    </nav>

    @foreach ($images as $image)
        @include('partials.image')
        <div class="column"></div>
        <div class="column"></div>
    @endforeach


@endsection