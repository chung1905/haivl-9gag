@extends('layouts.app')

@section('title')
    @if(isset($post))
        {{ $post['title'] }}
    @else
        Not Found
    @endif
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
    $("button.like-btn").click(function(){
        $(this).toggleClass("active");
        var value = $(this).hasClass("active") ? 1:-1;
        var post = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: "/like",
            data: { isLike: value, post: post },
            success: function(result) {$("#"+post).text(result + " like");}
        })
    });
});
</script>
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">{{ $post['title'] }}</div>
        <div class="panel-body"><img src="{{asset($post['link_to_image'])}}" width=50%></div>
        <div class="panel-footer">
            <button id="up-{{ $post['id'] }}" type="button" class="btn btn-default btn-sm like-btn @if($post['is_like']=='1') active @endif" value="1">{{ $post['like'] }} like</button>
        </div>
    </div>
</div>
@endsection