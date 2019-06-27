<div class="card" style="max-width: 1080px; margin: auto;">
    <div class="card-image">
        <figure class="image">
            <a href="/{{$image->imageid}}"><img class="image image-card-hero" width="1080" height="720" src="/images/{{$image->imageid}}.jpg" /></a>
        </figure>
    </div>

    <div class="card-content">
        <nav class="level is-mobile is-marginless">
            <div class="level-left">
                <!--
                <a class="level-item has-text-grey-dark" aria-label="like">
                        <span class="icon is-small">
                        <i class="fas fa-heart" aria-hidden="true"></i>
                        </span>
                </a>
                -->
                <a class="level-item has-text-grey-dark" aria-label="facebook" target="_blank"
                   href="https://www.facebook.com/dialog/share?app_id=278708046262155&display=popup&href={{urlencode($real_host . "/{$image->imageid}")}}">
                        <span class="icon is-small">
                        <i class="fab fa-facebook" aria-hidden="true"></i>
                        </span>
                </a>
                <a class="level-item has-text-grey-dark" aria-label="tweet" target="_blank"
                   href="https://twitter.com/intent/tweet?text={{urlencode($real_host . "/{$image->imageid}")}}">
                        <span class="icon is-small">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                        </span>
                </a>
            </div>
            <p class="subtitle is-6 has-text-grey is-pulled-right">
                {{$image->reference}}
            </p>
        </nav>

        <div class="column is-hidden-mobile"></div>

        <p class="title is-4 has-text-grey-light is-hidden-mobile">
            {{$image->passage_text}}
        </p>
    </div>

    <footer class="card-footer">
        @if (!isset($photo_url))

            <p class="card-footer-item">
                <span>
                    <a class="has-text-grey-dark" href="/{{$image->imageid}}"><i class="fas fa-eye"></i></i> View</a>
                </span>
            </p>

        @endif
        @if (isset($photo_url))
        <p class="card-footer-item">
                <span>
                    <a class="has-text-grey-dark" href="{{$photo_url}}" target="_blank"><i class="fas fa-camera has-text-grey-dark"></i> Source</a>
                </span>
        </p>
        @endif
        <p class="card-footer-item">
            <span>
                <a class="has-text-grey-dark" href="https://www.esv.org/{{str_replace(" ", "+",$image->reference)}}/" target="_blank"><i class="fas fa-bible has-text-grey-dark" aria-hidden="true"></i> Read</a>
            </span>
        </p>
    </footer>

</div>