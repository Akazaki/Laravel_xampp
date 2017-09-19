@extends('layouts.app')

@section('content')
	<div id="Form_box">
		<!-- @if ($errors->any())
		        <ul id="Error_box">
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		@endif -->


		<form action="{{action('ContactController@confirm')}}" method="post">

			{{csrf_field()}}

			<fieldset>
				<p class="form_title">お問い合わせフォーム</p>
					<dl>
						<dt>
							<label for="name">お名前<span>必須</span></label>
						</dt>
						<dd >
							<input type="text" name="name" value="{{old('name')}}" placeholder="ヤマダ タロウ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ヤマダ タロウ'">
							<span class="error_text">{{$errors->first('name')}}</span>
						</dd>
					</dl>
					<dl>
						<dt>
							<label for="email">メールアドレス<span>必須</span></label>
						</dt>
						<dd >
							<input type="text" name="email" value="{{old('email')}}" placeholder="test@gpol.co.jp" onfocus="this.placeholder = ''" onblur="this.placeholder = 'test@gpol.co.jp'">
							<span class="error_text">{{$errors->first('email')}}</span>
						</dd>
					</dl>
					<dl>
						<dt>
							<label for="message">メッセージ</label>
						</dt>
						<dd >
							<textarea name="message">{{old('message')}}</textarea>
							<span class="error_text">{{$errors->first('message')}}</span>
						</dd>
					</dl>
			</fieldset>

			<div class="submit_btn">
				<input type="submit" value="Confirm">
			</div>
		</form>
	</div>
@endsection