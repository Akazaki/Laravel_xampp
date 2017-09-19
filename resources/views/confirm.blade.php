@extends('layouts.app')

@section('content')
<div id="Form_box">
	<form action="{{action('ContactController@complete')}}" method="post">
		<dl>
			<dt>
				<label for="name">お名前</label>
			</dt>
			<dd >
				{{$contact['name']}}
			</dd>
		</dl>
		<dl>
			<dt>
				<label for="name">メールアドレス</label>
			</dt>
			<dd >
				{{$contact['email']}}
			</dd>
		</dl>
		<dl>
			<dt>
				<label for="name">メッセージ</label>
			</dt>
			<dd >
				{{$contact['message']}}
			</dd>
		</dl>

		<div class="submit_btn">
			<input type="submit" name="action" value="back">
		</div>

		<div class="submit_btn">
			<input type="submit" name="action" value="submit">
		</div>

		@foreach($contact as $key => $value)
		<input type="hidden" name="{{$key}}" value="{{$value}}">
		@endforeach
	</form>
</div>
@endsection