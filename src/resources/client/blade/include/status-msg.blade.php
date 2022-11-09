@if (!empty(Session::has('status')))
    <div class="alert alert-success mt-2" role="alert">
        {{ Session::get('status') }}
    </div>
@endif
