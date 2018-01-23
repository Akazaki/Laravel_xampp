<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Vue CMS</title>

		<link rel="stylesheet" href="/public/css/app.css">
		<link rel="stylesheet" href="/public/css/style.css">

		<script>
			window.Laravel = {};
			window.Laravel.csrfToken = "{{ csrf_token() }}";
		</script>
	</head>
	<body>
		<div id="app">
			<div>
			   <router-view></router-view>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>
		<script src="/public/js/app.js"></script>
	</body>
</html>
