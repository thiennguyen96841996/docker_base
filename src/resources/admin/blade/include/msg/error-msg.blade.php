@if (!empty($errors->getMessages()))
    <div class="alert alert-danger mt-2" role="alert">
        @foreach (Arr::collapse($errors->getMessages()) as $msg)
            @if (!$loop->first)<br>{{ $msg }}@else{{ $msg }}@endif
        @endforeach
    </div>
@endif
