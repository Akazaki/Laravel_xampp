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

		<form action="{{action('ContactController@confirm')}}" method="post" enctype="multipart/form-data">

			{{csrf_field()}}

			<fieldset>
				<p class="form_title">お問い合わせフォーム</p>
				<dl>
					<dt>
						<label>お名前<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="name" value="{{ old('name') ? old('name') : 'ヤマダ タロウ' }}" placeholder="例)ヤマダ タロウ" onfocus="this.placeholder = ''" onblur="this.placeholder = '例)ヤマダ タロウ'">
						<span class="error_text">{{$errors->first('name')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label>メールアドレス<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="email" value="{{ old('email') ? old('email') : 'test@gpol.co.jp' }}" placeholder="例)test@gpol.co.jp" onfocus="this.placeholder = ''" onblur="this.placeholder = '例)test@gpol.co.jp'">
						<span class="error_text">{{$errors->first('email')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label>電話番号<span>必須</span></label>
					</dt>
					<dd >
						<input type="tel" name="tel" value="{{ old('tel') ? old('tel') : '090-0000-0000' }}" placeholder="例)090-0000-0000" onfocus="this.placeholder = ''" onblur="this.placeholder = '例)090-0000-0000'">
						<span class="error_text">{{$errors->first('tel')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label>郵便番号<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="zip" id="zip" value="{{ old('zip') ? old('zip') : '553-0003' }}"　placeholder="例)553-0003" onfocus="this.placeholder = ''" onblur="this.placeholder = '例)553-0003'" style="font-family: ts-unused;">
						<span class="error_text">{{$errors->first('zip')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label>都道府県<span>必須</span></label>
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
						<label>住所<span>必須</span></label>
					</dt>
					<dd >
						<input type="text" name="address" size="60" value="{{ old('address') ? old('address') : '大阪府大阪市北区堂島浜2-2-28 堂島アクシスビル' }}" placeholder="例)大阪府大阪市北区堂島浜2-2-28 堂島アクシスビル" onfocus="this.placeholder = ''" onblur="this.placeholder = '例)大阪府大阪市北区堂島浜2-2-28 堂島アクシスビル'">
						<span class="error_text">{{$errors->first('address')}}</span>
					</dd>
				</dl>
				<dl>
					<dt>
						<label>年齢<span>必須</span></label>
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
						<label>趣味（複数）<span>必須</span></label>
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
						<label>画像</label>
					</dt>
					<dd class="file_box">
@if(old('img_path') || old('upfile'))
	<img src="{{old('img_path')}}" width="200" alt="">
	<input name="img" id="img" type="hidden" value="{{old('img_path')}}" />
	<input name="deletefile" id="deletefile" type="button" value="画像を削除" onclick="swapFileupload('input');" />
@else
	<input type="file" name="upfile" id="upfile" accept="image/*" capture="camera" value="{{old('upfile')}}" />
@endif
						<span class="error_text">{{$errors->first('img')}}</span>
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