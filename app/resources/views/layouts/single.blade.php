<!DOCTYPE html>
<html lang="en" class="route-documentation">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>versesee 📖 @section('title') @show</title>

    @section('opengraph') @show
    @section('twitter') @show
    @section('facebook') @show

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142184246-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-142184246-1');
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
    <link rel="stylesheet" href="/css/single.css" />
</head>

<body>
<section class="hero is-light is-fullheight">
    <!-- Hero head: will stick at the top -->
    <div class="hero-head has-text-centered">
        <header class="navbar">
            <!--
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="/timeline">
                        versesee
                    </a>
                </div>
            </div>
            -->
            <h4 class="title is-5" style="margin: auto;"><a class="navbar-item" href="/timeline">versesee</a></h4>
        </header>
    </div>

    <!-- Hero content: will be in the middle -->
    <div class="hero-body is-paddingless is-block" style="margin-top: 0px;">
        <div class="container has-text-centered">
            @yield('content')
        </div>
    </div>
</section>


<footer class="footer">
    <div class="content has-text-centered">
        <p>
            <strong>Verse See</strong> by <a href="https://justinjenkins.net">Justin Jenkins</a>
        </p>
        <p style="max-width: 800px; margin: auto;">
            <small class="is-size-7 has-text-grey-light has-text-centered">Scripture quotations marked "ESV" are
                from the ESV® Bible (The Holy Bible, English Standard Version®), copyright © 2001 by Crossway, a
                publishing ministry of Good News Publishers. Used by permission. All rights reserved.
            </small>
        </p>
    </div>
</footer>

</body>
</html>