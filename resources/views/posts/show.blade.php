@extends('layouts.app')

@section('title',"Blog | $post->title")

@section('content')
    <article class="blog-post">
        <h2 class="display-5 link-body-emphasis mb-1">{{ $post->title }}</h2>
        <p class="blog-post-meta">Updated at {{ date('d M Y H:i', strtotime($post->updated_at)) }} by <a href="#">Admin</a></p>
        <p>{{ $post->content }}.</p>

        <p class="text-muted"> {{ $total_comments }} Comments</p>
        @foreach($comments as $comment)
            {{-- @php(dd($comment)) --}}
            <div class="card mb-2">
                <div class="card-body">
                    <p> {{ $comment->comment }} </p>
                </div>
            </div>
        @endforeach
    </article>
    <a href="{{ url("posts") }}">< Kembali</a>
@endsection