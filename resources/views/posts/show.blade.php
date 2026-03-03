<article>

    <h1>{{ $post->title }}</h1>

@if($post->cover_image)
    <img src="{{ asset('storage/' . $post->cover_image) }}" width="600">
@endif

    <div>
        {!! $post->content !!}
    </div>

    <small>
        Publicado em 
    </small>

</article>