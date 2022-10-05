@extends('main')

@section('CONTENTS')
    @include('include.status-msg')

    <h3>Agency</h3>
    <form method="GET" action="{{ route('admin.agency.index') }}">
        <label>Id:</label><input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldWithRequest('tel') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}">
        <input type="submit" value="search">
    </form>
    <a href="{{ route('admin.agency.create') }}">Create</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Address</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('admin.agency.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->name }}</td>
                <td>{{ $val->tel }}</td>
                <td>{{ $val->address }}</td>
                <td><a href="{{ route('admin.agency.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" name="delete_form"  action="{{ route('admin.agency.destroy', $val->id) }}" onClick="delete_agency('{{ $val->id }}', '{{ $val->name }}'); return false;" >
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>データがありません</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {!! Renderer::renderPaginator('include.pager') !!}
@stop

@section ('JAVASCRIPT')
    <script>
        /**
         * agency delete
         * @param {String} agency_id
         * @param {String} agency_name
         */
        function delete_agency(agency_id, agency_name) {
            // 確認ダイアログ用テキスト
            var confirm_txt = '';
            confirm_txt  = '以下のAgencyを削除します。よろしいですか?\n\n';
            confirm_txt += agency_id + ' : ' + agency_name;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop
