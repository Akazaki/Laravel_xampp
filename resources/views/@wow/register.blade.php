@extends('layouts.wowmaster')

@section('content')

		<td id="main" class="mainColTop user"><!-- main start -->
		<form action="{{action('WowController@signup')}}" method="post">
		  <input type="hidden" name="id" value="0" />
          <input type="hidden" name="sort" value="" />
		  <input type="hidden" name="type" value="" />
		  <input type="hidden" name="p" value="0" />
		  {{ csrf_field() }}

		  <div id="contribute">
			<div id="midashi">
			  <div id="midashiR">
				<div id="midashiL">
				  <h2>記事投稿</h2>
				</div>
				<div id="midashiL2">
				  <h3>ユーザー</h3>
				</div>
				<p class="arrow"><strong>編集</strong></p>
			  </div>
			</div>
			<div id="inputBox">
			  <div class="btnBox02">
				<input type="image" name="btnCancelEdit" src="/public/wow/common/img/cancel_btn.gif" alt="キャンセル" onmouseover="this.src='/public/wow/common/img/cancel_btn_o.gif'" onmouseout="this.src='/public/wow/common/img/cancel_btn.gif'" /><input type="image" name="btnDoneEdit" src="/public/wow/common/img/save_btn.gif" alt="保存" onmouseover="this.src='/public/wow/common/img/save_btn_o.gif'" onmouseout="this.src='/public/wow/common/img/save_btn.gif'" />
			  </div>
			  <div id="inputInner">
				<div class="necessary clr">
				  <p class="check"><img src="/public/wow/common/img/necessary.gif" alt="必須項目" /><span>印は入力必須項目です。</span></p>
				</div>
				<div id="mainFormBox" class="clr">
				  <div id="label_text-div" class="clr item-div" >
					<div class="midashi"><strong>ユーザー名</strong></div>
					<div class="check"><img src="/public/wow/common/img/necessary.gif" alt="必須項目" /><span>&nbsp;</span></div>
					@if ($errors->first('label_text'))
						<div class="error">
							<img src="/public/wow/common/img/error.gif" alt="" width="21" height="21"><span class="red">{{$errors->first('label_text')}}</span>
						</div>
					@endif
					<div class="inputBox clear"><input type="text" class="w640" id="label_text" name="label_text" value="" /></div>
				  </div>
				  <div id="email_text-div" class="clr item-div" >
					<div class="midashi"><strong>メールアドレス</strong></div>
					<div class="check"></div>
					@if ($errors->first('email_text'))
						<div class="error">
							<img src="/public/wow/common/img/error.gif" alt="" width="21" height="21"><span class="red">{{$errors->first('email_text')}}</span>
						</div>
					@endif
					<div class="inputBox clear"><input type="text" class="w640" id="email_text" name="email_text" value="" /></div>
				  </div>
				  <div id="password_password-div" class="clr item-div" >
					<div class="midashi"><strong>パスワード</strong></div>
					<div class="check"><span>パスワード／パスワード（確認用）。変更する場合のみ入力</span></div>
					@if ($errors->first('password'))
						<div class="error">
							<img src="/public/wow/common/img/error.gif" alt="" width="21" height="21"><span class="red">{{$errors->first('password')}}</span>
						</div>
					@endif
					<div class="inputBox clear"><input type="password" class="w160" id="password_password_confirm0" name="password" value="" /><br /><input type="password" class="w160" id="password_password_confirm1" name="password_confirm" value="" /></div>
				  </div>
				  <!-- <div id="group_check-div" class="clr item-div" >
					<div class="midashi"><strong>グループ</strong></div>
					<div class="check"></div>
					<div class="error"></div>
					<div class="inputBox clear"><input type="checkbox" id="group_check1" name="group_check[]" value="1" />
			<label for="group_check1" class=""><span class="w30">システム管理者</span></label><input type="checkbox" id="group_check2" name="group_check[]" value="2" />
			<label for="group_check2" class=""><span class="w30">ページ管理者</span></label><input type="checkbox" id="group_check3" name="group_check[]" value="3" />
			<label for="group_check3" class=""><span class="w30">記事作成者</span></label></div>
				  </div>
				  <div id="ip_text-div" class="clr item-div" >
					<div class="midashi"><strong>許可IPアドレス</strong></div>
					<div class="check"><img src="/public/wow/common/img/necessary.gif" alt="必須項目" /><span>特定のIPのみ許可する場合はxxx.xxx.xxx.xxx/32。全て許可する場合は0.0.0.0/0&nbsp;</span></div>
					<div class="error"></div>
					<div class="inputBox clear"><input type="text" class="w640" id="ip_text" name="ip_text" value="" /></div>
				  </div>
				  <div id="acknowledge-div" class="clr item-div" >
					<div class="midashi"><strong>公開</strong></div>
					<div class="check"></div>
					<div class="error"></div>
					<div class="inputBox clear"><input type="radio" id="acknowledge1" name="acknowledge" value="1" />
			<label for="acknowledge1" class="">
			<span class="w30">非公開</span></label><input type="radio" id="acknowledge3" name="acknowledge" value="3" checked="checked" />
			<label for="acknowledge3" class="">
			<span class="w30">公開</span></label></div>
				  </div>
				  <div id="description_textarea-div" class="clr item-div" >
					<div class="midashi"><strong>説明</strong></div>
					<div class="check"></div>
					<div class="error"></div>
					<div class="inputBox clear"><textarea id="description_textarea" name="description_textarea" rows="4" cols="60" class="w640h200"></textarea></div>
				  </div> -->
				</div>
				<div class="necessary clr">
				</div>
			  </div>
			  <div class="btnBox02">
				<input type="image" name="btnCancelEdit" src="/public/wow/common/img/cancel_btn.gif" alt="キャンセル" onmouseover="this.src='/public/wow/common/img/cancel_btn_o.gif'" onmouseout="this.src='/public/wow/common/img/cancel_btn.gif'" /><input type="image" name="btnDoneEdit" src="/public/wow/common/img/save_btn.gif" alt="保存" onmouseover="this.src='/public/wow/common/img/save_btn_o.gif'" onmouseout="this.src='/public/wow/common/img/save_btn.gif'" />
			  </div>
			</div>
		  </div>
		</form>
		</td>
@endsection