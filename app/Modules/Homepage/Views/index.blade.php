@extends('layouts.app')

@section('title')
    Hello
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
    <div class="panel panel-default">
        @if ( $total != 0 )
            @foreach ($posts as $p)
                <div class="panel-heading"><a href="{{ url('/post/'.$p['id']) }}">{{ $p['title'] }}</a></div>
                <div class="panel-body"><a href="{{ url('/post/'.$p['id']) }}"><img src="{{asset($p['link_to_image'])}}" width=50%></a></div>
                <div class="panel-footer">
                    <div class="btn-group-sm">
                        <button id="up-{{ $p['id'] }}" type="button" class="btn btn-default like-btn @if($p['is_like']=='1') active @endif" value="1">{{ $p['like'] }} like</button>
                        <button id="down-{{ $p['id'] }}" type="button" class="btn btn-default" value="0" style="display: none">Down</button>
                    </div>
                </div>
            @endforeach
            <!--  $posts->links()  -->
            {{ $links }}
        @else
            <div class="panel-body">Sorry, nothing here</div>
        @endif
    </div>
</div>
@endsection