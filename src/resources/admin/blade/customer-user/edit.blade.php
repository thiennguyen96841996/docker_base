@extends('main')

@php
    $customerUser = Renderer::get('customerUser');
    $isBack = Renderer::get('isBack');
    $gender = $isBack ? $customerUser->gender : $customerUser->getGender();
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <h3>Customer edit</h3>
    <form method="post" action="{{ route('admin.customer-user.editConfirm', $customerUser->id) }}">
        @csrf
        @method('PUT')
        <label>ID</label>{{ $customerUser->id }}
        <input type="hidden" name="id" value="{{ $customerUser->id }}">
        <label>Name:</label><input type="text" name="name" value="{{ $isBack ? $customerUser->name : $customerUser->getName() }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ $isBack ? $customerUser->tel : $customerUser->getTel() }}">
        <label>Email:</label><input type="text" name="email" value="{{ $isBack ? $customerUser->email : $customerUser->email }}">
        <label>Birthday:</label><input type="text" name="birthday" value="{{ $isBack ? $customerUser->birthday : $customerUser->getBirthday() }}">
        <label>Gender:</label>
        <select name="gender">
            <option value="">--</option>
            @foreach(\App\Common\Database\Definition\Gender::cases() as $status)
                @if (!empty($customerUser) && $gender == $status->value)
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\Gender::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\Gender::getName($status->value)}}</option>
                @endif
            @endforeach
        </select>
        <label>Address:</label><input type="text" name="address" value="{{ $isBack ? $customerUser->address : $customerUser->getAddress() }}">
        <input type="submit" value="submit">
    </form>
@stop
