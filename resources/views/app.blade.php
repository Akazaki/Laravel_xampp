<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Vue TODO</title>

		<link rel="stylesheet" href="/public/css/app.css">

		<script>
			window.Laravel = {};
			window.Laravel.csrfToken = "{{ csrf_token() }}";
		</script>
	</head>
	<body>
		<navbar></navbar>
		<div id="app">
			<navbar></navbar>
			<div class="container">
				<router-view></router-view>
			</div>
		</div>
		<script src="/public/js/app.js"></script>
	</body>
</html>
