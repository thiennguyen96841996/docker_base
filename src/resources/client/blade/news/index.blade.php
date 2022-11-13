@extends('main')

@section('CONTENTS')
  @include('include.status-msg')
  
  <h3>News</h3>
  <form method="GET" action="{{ route('client.news.index') }}">
    <label>Id:</label><input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}">
    <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}">
    <label>Content:</label><input type="text" name="content" value="{{ Renderer::oldWithRequest('content') }}">
    <input type="submit" value="search">
  </form>
  <a href="{{ route('client.news.create') }}">Create</a>
  <table>
    <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Status</th>
      <th>Avatar</th>
      <th>Content</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
      @forelse(Renderer::getPaginator() ?? [] as $val)
        <tr>
          <td><a href="{{ route('client.news.show', $val->id) }}">{{ $val->id }}</a></td>
          <td>{{ $val->title }}</td>
          <td>{{ $val->status }}</td>
          <td>{{ $val->avatar }}</td>
          <td>{{ $val->content }}</td>
          <td><a href="{{ route('client.news.edit', $val->id) }}">Edit</a></td>
          <td>
            <form method="POST" name="delete_form" action="{{ route('client.news.destroy', $val->id) }}" onClick="delete_news('{{ $val->id }}', '{{ $val->title }}'); return false;">
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
@endsection
@section ('JAVASCRIPT')
  <script>
    /**
     * news delete
     * @param {String} news_id
     * @param {String} news_title
     */
    function delete_news(news_id, news_title) {
        // 確認ダイアログ用テキスト
        var confirm_txt = '';
        confirm_txt  = '以下のNewsを削除します。よろしいですか?\n\n';
        confirm_txt += news_id + ' : ' + news_title;
        // 論理削除処理
        if(confirm(confirm_txt)) {
            document.delete_form.submit();
        }
    }
  </script>
@endsection
