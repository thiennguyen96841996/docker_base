@extends('main')

@php 
$clientUser = Renderer::get('clientUser');
$isBack = Renderer::get('isBack');
@endphp

@section('CONTENTS')
    @include('include.error-msg')


    <h3>Client edit</h3>
    <form method="post" action="{{ route('admin.clientUser.editConfirm', $clientUser->id) }}">
        @csrf
        @method('PUT')
        <label>ID</label>{{ $clientUser->id }}
        <input type="hidden" name="id" value="{{ $clientUser->id }}">
        <label>Name:</label><input type="text" name="name" value="{{ $isBack ? $clientUser->name : $clientUser->getName() }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ $isBack ? $clientUser->tel : $clientUser->getTel() }}">
        <label>Status:
        <select name="is_available">
            @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                @if ($status->value === $clientUser->is_available)
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @endif
            @endforeach
        </select>
        <label>Agency:
        <select name="agency_id">
            @foreach(Renderer::get('agencies') as $agency)
                @if ($agency->id == $clientUser->agency_id)
                    <option value="{{$agency->id}}" selected>{{$agency->name}}</option>
                @else
                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                @endif
            @endforeach
        </select>
        <input type="submit" value="submit">
    </form>
@stop
