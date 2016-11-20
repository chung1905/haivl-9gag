@extends('layouts.app')

@section('title')
    {{ $path }}
@endsection

@section('head')
<script type="text/javascript">
"use strict";
var currentPage = 1;
var end = false;
var loading = false;
$(document).ready(function(){
    $("div#main").on("click","button.like-btn",function(){
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
    activeNavbar("{{ $path }}");
    $(document).scroll(function() {
        if (!end) {
            if(getScrollPercent()>0.5){
                var nextPage = currentPage + 1;
                var ajaxLoadpage = function() {
                    if (loading) {return;}
                    loading = true;
                    $.ajax({
                        type: "GET",
                        url: "/loadpage",
                        data: { tag: "{{ $path }}", page: nextPage },
                        success: function (result) {
                            currentPage = currentPage + 1;
                            if (result.length>0) {
                                for (var i=0; i<result.length; i++) {
                                    $("div#main").append('<div class="panel panel-default" id="'+result[i].id+'"><div class="panel-heading"><a href="{{ url('/post/') }}/'+result[i].id+'"><strong>'+result[i].title+'</strong></a> by '+result[i].author+'</div><div class="panel-body"><a href="{{ url('/post/') }}/'+result[i].id+'"><img src="{{asset("/")}}'+result[i].link_to_image+'" width=50%></a></div><div class="panel-footer"><div class="btn-group-sm"><button id="up-'+result[i].id+'" type="button" class="btn btn-default like-btn" value="1">'+result[i].like+' like</button></div></div></div>');
                                    if (result[i].is_like=='1') {$("button#up-"+result[i].id).addClass("active");}
                                }
                            } else {
                                end = true;
                            }
                        }
                    }).always(function() {loading = false;});
                };
                ajaxLoadpage();
            }
        }
    });
});
</script>
@endsection

@section('category')
    @foreach ($tags as $t)
        <li id="navbar-{{ $t }}"><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container" id="main">
    @if ( $total != 0 )
        @foreach ($posts as $p)
            <div class="panel panel-default" id="{{ $p['id'] }}">
                <div class="panel-heading"><a href="{{ url('/post/'.$p['id']) }}"><strong>{{ $p['title'] }}</strong></a> by {{ $p['author'] }}</div>
                <div class="panel-body"><a href="{{ url('/post/'.$p['id']) }}"><img src="{{asset($p['link_to_image'])}}" width=50%></a></div>
                <div class="panel-footer">
                    <div class="btn-group-sm">
                        <button id="up-{{ $p['id'] }}" type="button" class="btn btn-default like-btn @if($p['is_like']=='1') active @endif" value="1">{{ $p['like'] }} like</button>
                        <button id="down-{{ $p['id'] }}" type="button" class="btn btn-default" value="0" style="display: none">Down</button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="panel panel-default">
            <div class="panel-body">Sorry, nothing here</div>
        </div>
    @endif
    </div>
</div>
@endsection