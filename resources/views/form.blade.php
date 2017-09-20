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
						<label for="tel">電話番号<span>必須</span></label>
					</dt>
					<dd >
						<input type="tel" name="tel" value="{{old('tel')}}" placeholder="090-0000-0000" onfocus="this.placeholder = ''" onblur="this.placeholder = '090-0000-0000'">
						<span class="error_text">{{$errors->first('tel')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label for="zip">郵便番号<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="zip" id="zip" value="{{old('zip')}}"　placeholder="5530003" onfocus="this.placeholder = ''" onblur="this.placeholder = '5530003'" style="font-family: ts-unused;">
						<span class="error_text">{{$errors->first('zip')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label for="tel">都道府県<span>必須</span></label>
					</dt>
					<dd >
						<select class="select_box" name="prefecture">
							<option value="" selected="selected">選択してください</option>
							@foreach($prefecture_master as $index => $name)
								<option value="{{ $index }}" @if(old('prefecture') == $index) selected @endif>{{$name}}</option>
							@endforeach
					    </select>
						<span class="error_text">{{$errors->first('prefecture')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label for="tel">住所<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="address" size="60" value="{{old('address')}}" placeholder="大阪府大阪市北区堂島浜2-2-28 堂島アクシスビル" onfocus="this.placeholder = ''" onblur="this.placeholder = '大阪府大阪市北区堂島浜2-2-28 堂島アクシスビル'">
						<span class="error_text">{{$errors->first('address')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label for="age">年齢<span>必須</span></label>
					</dt>
					<dd class="radio_box">
			            <input id="age1" type="radio" name="age[]" value="1" @if(is_array(old('age')) && in_array(1, old('age'))) checked @endif>
			            <label for="age1"> 20代 </label>
		                <input id="age2" type="radio" name="age[]" value="2" @if(is_array(old('age')) && in_array(2, old('age'))) checked @endif>
			            <label for="age2"> 30代 </label>
		                <input id="age3" type="radio" name="age[]" value="3" @if(is_array(old('age')) && in_array(3, old('age'))) checked @endif>
			            <label for="age3"> 40代 </label>
						<span class="error_text">{{$errors->first('age')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label for="email">趣味（複数）<span>必須</span></label>
					</dt>
					<dd class="check_box">
			            <input id="hobby1" class="form_check_input" type="checkbox" name="hobby[]" value="1" @if(is_array(old('hobby')) && in_array(1, old('hobby'))) checked @endif>
			            <label for="hobby1" class="form-check-inline"> Football </label>
		                <input id="hobby2" class="form_check_input" type="checkbox" name="hobby[]" value="2" @if(is_array(old('hobby')) && in_array(2, old('hobby'))) checked @endif>
			            <label for="hobby2" class="form-check-inline"> Basketball </label>
		                <input id="hobby3" class="form_check_input" type="checkbox" name="hobby[]" value="3" @if(is_array(old('hobby')) && in_array(3, old('hobby'))) checked @endif>
			            <label for="hobby3" class="form-check-inline"> Swimming </label>
						<span class="error_text">{{ !empty($errors->first('hobby.0')) ? $errors->first('hobby.0') : $errors->first('hobby') }}</span>
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