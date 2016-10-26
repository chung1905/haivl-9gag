@extends('layouts.app')

@section('title')
    Config
@endsection

@section('category')
    @foreach ($category as $c)
        <li><a href="{{ url('/'.$c) }}">{{ ucfirst($c) }}</a></li>
    @endforeach
@endsection

@section('content')
<div class="container">
    <p>Cấu hình hiện tại:</p>
    <table border=0px>
        <tr>
            <td>Dung lượng tối đa mỗi ảnh</td>
            <td>:</td>
            <td>{{ $max_size }}</td>
        </tr>
        <tr>
            <td>Số lượng post mỗi trang</td>
            <td>:</td>
            <td>{{ $posts_per_page }}</td>
        </tr>
        <tr>
            <td>Category</td>
            <td>:</td>
            <td>
                @foreach($category as $c)
                    {{ $c }}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </td>
        </tr>
    </table>
<hr>
    <p>Sửa cấu hình</p>
        <form method="POST">
            <table border=0px>
            <tr>
                <td>Dung lượng tối đa mỗi ảnh</td>
                <td>:</td>
                <td><input type="text" name="new_max_size"></td>
            </tr>
            <tr>
                <td>Số lượng post mỗi trang</td>
                <td>:</td>
                <td><input type="text" name="new_ppp"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="OK"></td>
            </tr>
            {{ csrf_field() }}
            </table>
        </form>
</div>
@endsection