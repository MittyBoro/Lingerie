<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" type="image/x-icon" href="{{ mix('admin/images/favicon.svg', 'assets') }}">

		<title>TheAdmin</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap">

		<!-- Styles -->
        @vite(['resources/admin/js/app.js'])

		@inertiaHead
		@routes
	</head>
	<body class="font-sans antialiased">
		@inertia
	</body>
</html>
