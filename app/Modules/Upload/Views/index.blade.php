@extends('layouts.app')

@section('title')
    Upload
@endsection

@section('category')
    @foreach ($category as $c)
        <li><a href="{{ url('/'.$c) }}">{{ ucfirst($c) }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <p>Upload your file here:</p>
    <form method="POST" action="/upload" enctype="multipart/form-data">
		<label>Title: </label><input type="text" name="title">
    	<input type="file" name="image_upload" accept="image/*">
    	<input type="submit" name="submit_image" value="OK">
    	{{ csrf_field() }}
    </form>
</div>
@endsection