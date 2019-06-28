@php
    $real_host = Config::get('app.url');
@endphp

@extends('layouts.single')

@section('title', $type)

    @section('content')
        <nav class="breadcrumb is-large is-centered" aria-label="breadcrumbs">
            <ul>
                <li><a class="has-text-grey-dark" href="/timeline"><span class="icon"><i class="fas fa-book-open"></i></span><span>Timeline</span></a></li>
                <li class="is-active has-text-weight-semibold"><a class="has-text-grey-dark" href="/seek"><span class="icon"><i class="fas fa-search"></i></span><span>Seek</span></a></li>
            </ul>
        </nav>

        <section class="hero is-medium">

            <div class="hero-body">
                <div class="container">
                    <form method="POST" action="/images" id="seek-form">
                        {{ csrf_field() }}

                        <div class="field has-addons has-addons-centered" >

                            <div class="control has-icons-left">
                                <input id="seek-input" class="input is-large" type="text" placeholder="Bible Word" name="message" required>
                                <span class="icon is-left">
                                    <i class="fas fa-bible"></i>
                                </span>
                            </div>

                            <div class="control">
                                <button id="seek-submit-button" class="button is-large is-info" type="submit">
                                    Seek
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

        </section>

    @endsection