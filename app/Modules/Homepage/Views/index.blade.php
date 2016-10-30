@extends('layouts.app')

@section('title')
    Hello
@endsection

@section('script')
@endsection

@section('category')
    @foreach ($tags as $t)
        <li><a href="{{ url('/tag/'.$t) }}">{{ $t }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <div class="panel panel-default">
        @if ($posts->total() != 0)
            @foreach ($posts as $p)
                <div class="panel-heading">{{ $p['title'] }}</div>
                <div class="panel-body"><img src="{{asset($p['link_to_image'])}}" width=50%></div>
                <div class="panel-footer">
                    <div class="btn-group-sm">
                        <button type="button" class="btn btn-default" onclick="like()">Up</button>
                        <button type="button" class="btn btn-default">Down</button>
                    </div>
                </div>
            @endforeach
            {{ $posts->links() }}
        @else
            <div class="panel-body">Sorry, nothing here</div>
        @endif
     </div>
</div>
@endsection