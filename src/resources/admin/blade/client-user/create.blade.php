@extends('main')

@php 
    $agencies = Renderer::get('agencies');
    $clientUser = Renderer::get('clientUser');
@endphp

@section('CONTENTS')
    @include('include.msg.error-msg')

    <h3>Client create</h3>
    <form method="POST" action="{{ route('admin.client-user.createConfirm') }}">
        @csrf
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', $clientUser) }}"></br>
        <label>Email:</label><input type="text" name="email" value="{{ Renderer::oldOrElse('email', $clientUser) }}"></br>
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', $clientUser) }}"></br>
        <label>Status:</label>
        <select name="is_available">
            @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                @if (!empty($clientUser) && $clientUser['is_available'] == $status->value)
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @endif
            @endforeach
        </select></br>
        <label>Agency:
        <select name="agency_id">
            @foreach($agencies as $agency)
                @if (!empty($clientUser) && $clientUser['agency_id'] == $agency->id)
                    <option value="{{$agency->id}}" selected>{{$agency->name}}</option>
                @else
                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                @endif
            @endforeach
        </select></br>
        <input type="submit" value="submit">
    </form>
@stop
