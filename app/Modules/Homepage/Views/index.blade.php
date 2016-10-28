@extends('layouts.app')

@section('title')
    Hello
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    @if (!empty($posts))
        @foreach ($posts as $p)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $p['title'] }}</div>
                <div class="panel-body"><img src="{{asset($p['link_to_image'])}}" width=50%></div>
            </div>
        @endforeach
        {{ $posts->links() }}
    @endif
</div>
@endsection