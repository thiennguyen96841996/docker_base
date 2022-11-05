@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('CONTENTS')
    @include('include.msg.status-msg')
    <div class="page-title">
        <h3>
            Agency Show
        </h3>
    </div>
    <div class="box">
        <table class="table table-bordered">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{ $agency->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Tel</th>
                    <td>{{ $agency->tel }}</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>{{ $agency->address }}</td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <div class="m-2">
                <form method="POST" name="delete_form" action="{{ route('admin.agency.destroy', $agency->id) }}" onClick="delete_agency('{{ $agency->id }}', '{{ $agency->name }}'); return false;" class="d-table-cell">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            <div class="m-2">
                <a href="{{ route('admin.agency.edit', $agency->id) }}" class="btn btn-info">Edit</a>
            </div>
        </div>    
    </div>
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
            confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin agency dưới không?\n\n';
            confirm_txt += agency_id + ' : ' + agency_name;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop
