@extends('layouts.app')

@section('title')
    @if(isset($post))
        {{ $post['title'] }}
    @else
        Not Found
    @endif
@endsection

@section('head')
<meta property="og:url" content="{{ url('/post/'.$post['id']) }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$post['title']}} -  9gag clone" />
<meta property="og:description" content="By {{ $author }}" />
<meta property="og:image" content="{{asset($post['link_to_image'])}}">
<script type="text/javascript">
$(document).ready(function(){
    connectingDialog();
    $("button.like-btn").click(function(){
        $(this).toggleClass("active");
        var value = $(this).hasClass("active") ? 1:-1;
        var post = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: "/like",
            data: { isLike: value, post: post },
            success: function(result) {$("#"+post).text(result + " like");}
        });
    });
    @if (Auth::check())
        $("button#cmt-btn").click(function(){
            var post = "{{ $post['id'] }}";
            var cmt = $("#cmt-content").val();
            if (cmt != "") {
                $("textarea#cmt-content").val("");
                $("div#alert-empty-comment").remove();
                $.ajax({
                    type: "POST",
                    url: "/comment",
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                    data: { "cmt": cmt, "post": post},
                    success: function(result) {
                        var html =
                            "<blockquote>"+
                                "<p>"+cmt+"</p>"+
                                "<footer>{{ Auth::user()->name }}</footer>"+
                            "</blockquote>";
                        console.log(html);
                        $('#comments').prepend(html);
                        $('#be-the-first').remove();
                    }
                });
            } else {
                var html =
                    "<br><div id='alert-empty-comment' class='alert alert-danger'>"+
                        "<strong>It can not be empty</strong>"+
                    "</div>";
                $(html).insertAfter("textarea#cmt-content").delay(3000).fadeOut();
            }
        });
    @endif
});
</script>
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
@if(!empty(env('FB_APPID')))
<div id="fb-root"></div>
<script>
    fbInit(document, 'script', 'facebook-jssdk','{{env("FB_APPID")}}');
</script>
@endif
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">{{ $post['title'] }} by {{ $author }}</div>
        <div class="panel-body"><img src="{{asset($post['link_to_image'])}}" width=50%></div>
        <div class="panel-footer">
            <button id="up-{{ $post['id'] }}" type="button" class="btn btn-default btn-sm like-btn @if($post['is_like']=='1') active @endif" value="1">{{ $post['like'] }} like</button>
            @if(!empty(env('FB_APPID')))
                <div class="fb-share-button btn" data-href="{{ url('/post/'.$post['id']) }}" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url('/post/'.$post['id']) }}%2F&amp;src=sdkpreparse">Share</a></div>
            @endif
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Comments</div>
        <div id="comments" class="panel-body">
            @if (empty($comments))
                <p id="be-the-first">Be the first to leave a comment here</p>
            @else
                @foreach($comments as $c)
                <blockquote>
                    <p>{{ $c["content"] }}</p>
                    <footer>{{ $c["author"] }}</footer>
                </blockquote>
                @endforeach
            @endif
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <label>Leave your comment:</label>
                <textarea id="cmt-content" class="form-control" placeholder="Enter your comment here..."></textarea> <br>
                @if (Auth::check())
                    <button id="cmt-btn" class="btn btn-primary cmt-btn">Submit</button>
                @else
                    <a href="{{ url('/login') }}" class="btn btn-info">Please sign in</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection