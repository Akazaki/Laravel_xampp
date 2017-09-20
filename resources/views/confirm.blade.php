@extends('layouts.app')

@section('content')
<div id="Form_box">
	<form action="{{action('ContactController@complete')}}" method="post">
		<dl>
			<dt>
				<label>お名前</label>
			</dt>
			<dd >
				{{$contact['name']}}
			</dd>
		</dl>
		<dl>
			<dt>
				<label>メールアドレス</label>
			</dt>
			<dd >
				{{$contact['email']}}
			</dd>
		</dl>
		<dl>
			<dt>
				<label>電話番号</label>
			</dt>
			<dd >
				{{$contact['tel']}}
			</dd>
		</dl>
		<dl>
			<dt>
				<label>年齢</label>
			</dt>
			<dd >
				{{$contact['age_text']}}代
			</dd>
		</dl>
		<dl>
			<dt>
				<label>趣味</label>
			</dt>
			<dd >
				<ul>
					@foreach($contact['hobby_text'] as $key => $value)
						<li>{{$value}}</li>
					@endforeach
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>
				<label>メッセージ</label>
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
			@if(is_array($value))
				@foreach ($value as $key2 => $value2)
					<input type="hidden" name="{{$key}}[]" value="{{$value2}}">
				@endforeach
			@else
				<input type="hidden" name="{{$key}}" value="{{$value}}">
			@endif
		@endforeach
	</form>
</div>
@endsection