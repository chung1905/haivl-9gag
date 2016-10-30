@extends('layouts.app')

@section('title')
    Upload
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Upload your image</div>
        <div class="panel-body">
            <div class="form-group">
                <form method="POST" enctype="multipart/form-data">
                    <label>Title: </label>
                    <input type="text" name="title" class="form-control"> <br>
                    <input type="file" name="image_upload" accept="image/*"> <br>
                    <label>Tag:</label>
                    <select class="form-control" name="image_tag">
                        <option selected></option>
                        @foreach ($tags as $t)
                            <option value="{{$t}}">{{$t}}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" name="submit_image" value="OK" class="btn btn-primary">Upload</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection