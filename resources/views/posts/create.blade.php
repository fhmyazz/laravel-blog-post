@extends('layouts.app')

@section('title','Blog | Create a New Post')

@section('content')
    <h1>Create a New Post</h1>
    <form method="POST" action="{{ url("new_posts") }}" class="form-control mb-3">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" rows="3" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="{{ url("posts") }}">< Kembali </a>
@endsection