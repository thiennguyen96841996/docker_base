@extends('main')

@php 
    $clientUser = Renderer::get('clientUser');
    $isBack = Renderer::get('isBack');
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')


    <h3>Client edit</h3>
    <form method="post" action="{{ route('admin.client-user.updateConfirm', $clientUser->id) }}">
        @csrf
        @method('PUT')
        <label>ID</label>{{ $clientUser->id }}
        <input type="hidden" name="id" value="{{ $clientUser->id }}">
        <label>Name:</label><input type="text" name="name" value="{{ $isBack ? $clientUser->name : $clientUser->getName() }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ $isBack ? $clientUser->tel : $clientUser->getTel() }}">
        <label>Status:
        <select name="is_available">
            @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                @if ($status->value === Renderer::oldOrElse('is_available', $clientUser))
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @endif
            @endforeach
        </select>
        <label>Agency:
        <select name="agency_id">
            @foreach(Renderer::get('agencies') as $agency)
                @if ($agency->id == Renderer::oldOrElse('agency_id', $clientUser))
                    <option value="{{$agency->id}}" selected>{{$agency->name}}</option>
                @else
                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                @endif
            @endforeach
        </select>
        <input type="submit" value="submit">
    </form>
@stop
