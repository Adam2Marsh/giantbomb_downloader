<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maxium-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    @if ( preg_match('/gb.pi/', url()->current()) )
    <script src="//gb.pi:3001/socket.io/socket.io.js"></script>
    @endif
    <!-- <script src="https://cdn.socket.io/socket.io-1.0.0.js"></script> -->

	<!-- Using the Gulp Copy of files -->
	<script type="text/javascript" src="js/all.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
	<link rel="stylesheet" type="text/css" href="css/all.css"/>
</head>
