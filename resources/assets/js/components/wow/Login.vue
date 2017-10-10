<template>
	<div>
		<div id="login">
			<div class="scroll"></div>
			<table>
				<tr>
					<td id="cellHeader">
						<div id="header">
							<div id="topBox">
								<h1><img src="/public/wow/img/header_logo.gif" alt="ようこそ Contents Management Flamework WOW" width="251" height="12"></h1>
								<div id="gpol"></div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td id="wrapper">
						<div id="loginInner" class="loginWidth">
							<div class="alice clr">
								<p class="wowLogo"><img src="/public/wow/img/logo_wow.png" alt="WOW" width="84" height="84"></p>
								<h3><img src="/public/wow/img/logo.png" alt="ロゴ" width="171" height="79" class="png"></h3>
								
								<div class="form clr">
									<div class="idPass">
										<p>
											<img src="/public/wow/img/id_img.png" alt="" width="21" height="20" class="icon png">
											<input name="email_text" type="text" value="" v-model="email_text" required autofocus>
										</p>
										<p>
											<img src="/public/wow/img/pass_img.png" alt="" width="21" height="20" class="icon png">
											<input type="password" value="" name="password" id="password" v-model="password" required autofocus>
										</p>
									</div>
									<input @click="wowLogin" type="image" src="/public/wow/img/login_btn.png" name="doneConfirmLogin" class="tremble doneConfirmLogin" style="width:187px; height:61px;" onmouseover="this.src='/public/wow/img/login_btn_o.png'" onmouseout="this.src='/public/wow/img/login_btn.png'" />
								</div>

								<p class="err">
									<!-- <span>{{ alertMessage }}</span> -->
								</p>

								<div class="check"></div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>
<!--css-->
<!-- <link rel="stylesheet" href="/public/wow/common/css/import.css" type="text/css" media="all">
<link rel="stylesheet" href="/public/wow/common/css/style.css" type="text/css" media="all"> -->
<!--js-->
<!-- <script type="text/javascript" src="/public/wow/common/js/jquery.js"></script>
<script type="text/javascript" src="/public/wow/common/js/page-scroller.js"></script>
<script type="text/javascript" src="/public/wow/common/js/iepngfix.js"></script>
<script type="text/javascript" src="/public/wow/common/js/iepngrollover.js"></script>
<script type="text/javascript" src="/public/wow/common/js/form_txt.js"></script>
<script type="text/javascript" src="/public/wow/common/js/jquery.montage.min.js"></script> -->

<script>
    export default {
		data() {
			return {
				email_text : '',
				password : '',
				showAlert: false,
				alertMessage: '',
			}
		},
		methods: {
			wowLogin() {
				var login_param = {email_text: this.email_text, password: this.password}
				axios.post('/api/wow/signin', login_param)
				.then(res =>  {
					this.state.user = res.data.user
					this.state.authenticated = true
					console.log(res.data);
				}, error => {
					console.log(error.data);
					this.showAlert = true
					this.alertMessage = 'Wrong email or password.'
				})
			},
		}
	}
</script>