@extends('main')

@php
    $post = Renderer::get('post');
@endphp

@section('CONTENTS')
    @include('include.error-msg')
    <h3>Post edit</h3>
    <form method="post" action="{{ route('client.post.updateConfirm', ['post' => $post->id]) }}" enctype="multipart/form-data">
        @csrf
        <label>ID</label>{{ $post->id }}
        <input type="hidden" name="id" value="{{ $post->id }}">
        <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldOrElse('title', $post) }}">
        <label>Status:
            <select name="status">
                @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                    @if ($status->value === $post->status)
                        <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                    @else
                        <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                    @endif
                @endforeach
            </select>
        </label>
        <label>Content:</label><textarea type="text" name="content" >{{ Renderer::oldOrElse('content', $post) }}</textarea>
        <label>City:</label><input type="text" name="city" value="{{ Renderer::oldOrElse('city', $post) }}">
        <label>District:</label><input type="text" name="district" value="{{ Renderer::oldOrElse('district', $post) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $post) }}">
        <label>Price:</label><input type="text" name="price" value="{{ Renderer::oldOrElse('price', $post) }}">
        <label>Area:</label><input type="text" name="area" value="{{ Renderer::oldOrElse('area', $post) }}">
        <label>Avatar:</label>
        <p>
            @if (url()->previous() != route('client.post.updateConfirm', ['post' => $post->id]))
                <img class="image" style="width: 192px; height: 130px;" src="{{ $post->avatar != null ? \App\Common\AWS\S3Service::display(\App\Common\Post\Definition\PostAvatar::POST_AVATAR_FOLDER, $post->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Post\Definition\PostAvatar::POST_IMAGE_FOLDER  . '/'  . Renderer::oldOrElse('avatar', $post)) : asset(\App\Common\Post\Definition\PostAvatar::CLIENT_POST_DEFAULT_AVATAR) }}" alt="{{ $post->avatar }}" />
            @endif
                <input type="file" name="avatar" value="{{ Renderer::oldOrElse('avatar', $post) }}"/>
        </p>
        <input type="hidden" name ="timestamp" value="{{ \Carbon\Carbon::parse(now())->timestamp }}" />
        <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
        <input type="submit" value="submit">
    </form>
@stop
