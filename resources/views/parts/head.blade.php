<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maxium-scale=1, user-scalable=no">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
	<div class="page-header">
		<h1 class="text-center">GB_Downloads</h1>
	</div>
	<div class="col-md-8 col-md-offset-2">
		<div class="row text-center">
			<h3>Video's Downloaded Size:</h3>
		</div>
		<div class="row">
			<div class="progress">
				<div class="progress-bar progress-bar-success" aria-valuenow="{{ $dirSize }}" aria-valuemax="21474836480" style="width: {{ ($dirSize / 1024 / 1024)/20000 * 100 }}%;">
					{{ human_filesize($dirSize) }}
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>

</head>