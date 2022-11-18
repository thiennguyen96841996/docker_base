@extends('main')

@php $post = Renderer::get('post') @endphp

@section('CONTENTS')
    @include('include.error-msg')
    <h3>Post create</h3>
    <form method="POST" action="{{ route('client.post.createConfirm') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar">
        <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldOrElse('title', $post) }}">
        <label>Status:</label>
        <select name="status">
            @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                @if (!empty($post) && $post['status'] == $status->value)
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @endif
            @endforeach
        </select>
        <label>Content:</label><textarea type="text" name="content">{{ Renderer::oldOrElse('content', $post) }}</textarea>
        <label>City:</label><input type="text" name="city" value="{{ Renderer::oldOrElse('city', $post) }}">
        <label>District:</label><input type="text" name="district" value="{{ Renderer::oldOrElse('district', $post) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $post) }}">
        <label>Price:</label><input type="text" name="price" value="{{ Renderer::oldOrElse('price', $post) }}">
        <label>Area:</label><input type="text" name="area" value="{{ Renderer::oldOrElse('area', $post) }}">
        <input type="hidden" name ="timestamp" value="{{ \Carbon\Carbon::parse(now())->timestamp }}" />
        <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
        <input type="submit" value="submit">
    </form>
@stop
