@extends('layouts.app')

@section('title')
    Config
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><h4>Cấu hình chung</h4></div>
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
                    <input type="number" name="new_min_trending_like" class="form-control" min="0" value="{{$min_trending_like}}"></input>
                    <br>
                    <label>Số like để vào hot tag (lớn hơn số like của trending): </label>
                    <input type="number" name="new_min_hot_like" class="form-control" min="0" value="{{$min_hot_like}}">
                    <br>
                    <button type="submit" name="config_submit" value="OK" class="btn btn-primary">Save</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Category Manager</h4></div>
        <div class="panel-body">
            <dl>
                <dt>Các tag hiện có</dt>
                @foreach ($tags as $t)
                    <dd>{{ $t }} </dd>
                @endforeach
            </dl>
            <form method="POST">
                <div class="form-group">
                    <label>Thêm tag</label>
                    <input type="text" name="new_tag" class="form-control"> <br>
                    <button type="submit" name="submit_new_tag" value="Add" class="btn btn-primary">Add</button>
                </div>
                <div class="form-group">
                    <label>Xóa tag</label>
                    <select class="form-control" name="delete_tag">
                        <option selected></option>
                        @foreach ($tags as $t)
                            <option value="{{$t}}">{{$t}}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" name="submit_delete_tag" value="Delete" class="btn btn-danger">Delete</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection