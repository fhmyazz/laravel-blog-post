@extends('layouts.app')

@section('title', "Edit | $post->title")

@section('content')
    <h1 class="">Edit Post</h1>
    <form method="POST" action="{{ url("edit_post/$post->id") }}" class="form-control mb-3">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" rows="3" name="content">{{ $post->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <form method="POST" action="{{ url("delete_post/$post->id") }}" class="mb-3">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ url("posts") }}">< Back </a>
@endsection