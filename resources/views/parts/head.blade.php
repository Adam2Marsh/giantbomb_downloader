<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maxium-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <script src="//giantbomb-downloader:3001/socket.io/socket.io.js"></script>
    <!-- <script src="https://cdn.socket.io/socket.io-1.0.0.js"></script> -->

	<!-- Using the Gulp Copy of files -->
	<script type="text/javascript" src="js/all.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
	<link rel="stylesheet" type="text/css" href="css/all.css"/>

	<br>
	<div class="text-center">
		<h1>GB_Downloads</h1>
		<!-- <a href="/videos">Videos</a>
		<a href="/rules">Rules</a> -->
		<ul class="nav nav-tabs">
			@if(Request::path() == "videos")
				<li role="presentation" class="active"><a href="/videos">Videos</a></li>
				<li role="presentation"><a href="/rules">Rules</a></li>
			@else
				<li role="presentation"><a href="/videos">Videos</a></li>
				<li role="presentation" class="active"><a href="/rules">Rules</a></li>
			@endif
		</ul>
	</div>

</head>
