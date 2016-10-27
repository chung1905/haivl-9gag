@extends('layouts.app')

@section('title')
    Config
@endsection

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Cấu hình chung</div>
        <div class="panel-body">
            <div class="form-group">
                <form method="POST">
                    <label>Dung lượng tối đa mỗi ảnh: </label>
                    <select class="form-control" name="new_max_size">
                        <option value="1024" @if($max_size==1024) selected @endif >1 MB</option>
                        <option value="2048" @if($max_size==2048) selected @endif >2 MB</option>
                        <option value="5120" @if($max_size==5120) selected @endif >5 MB</option>
                        <option value="10240" @if($max_size==10240) selected @endif >10 MB</option>
                    </select>
                    <br>
                    <label>Số lượng post mỗi trang: </label>
                    <select class="form-control" name="new_ppp">
                        <option value="5" @if($posts_per_page==5) selected @endif>5</option>
                        <option value="10" @if($posts_per_page==10) selected @endif>10</option>
                        <option value="15" @if($posts_per_page==15) selected @endif>15</option>
                        <option value="20" @if($posts_per_page==20) selected @endif>20</option>
                    </select>
                    <br>
                    <label>Số like để vào trending tag: </label>
                    <input type="number" name="new_min_trending_like" class="form-control" min="0" max="{{$min_hot_like}}" value="{{$min_trending_like}}"></input>
                    <br>
                    <label>Số like để vào hot tag (lớn hơn số like của trending): </label>
                    <input type="number" name="new_min_hot_like" class="form-control" min="{{$min_trending_like}}" value="{{$min_hot_like}}">
                    <br>
                    <button type="submit" name="config_submit" value="OK" class="btn btn-primary">Save</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">Category Manager</div>
        <div class="panel-body">
            <div class="form-group">
                <form method="POST"></form>
            </div>
        </div>
    </div>
</div>
@endsection