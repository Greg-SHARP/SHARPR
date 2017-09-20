<!doctype html>
<html>
	<head>
		<title>SHRPR</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  		<meta charset="utf-8" />

  		<link href="css/style.css" rel="stylesheet" />

  		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>
  		<script src="js/hammer.min.js"></script>
  		<script src="js/hammer-time.min.js"></script>
  		<script src="js/script.js"></script>
	</head>

	<body>
		@include('layouts.header')

			@yield('content')

		@include('layouts.footer')
	</body>
</html>