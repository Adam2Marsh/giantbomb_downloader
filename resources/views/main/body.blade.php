<div class="col-md-8 col-md-offset-2">
	<div class="row text-center">
		<h3>Video's Downloaded Size:</h3>
	</div>
	<div class="row">
		<div class="progress">
			<div id="storageSize" class="progress-bar progress-bar-success progress-bar-striped active"
                 aria-valuenow="{{ $rawSize }}" aria-valuemax="21474836480"
                 style="width: {{ $dirPercentage }};">
				{{ $humanSize }}
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    if (!!window.EventSource) {
        var source = new EventSource('http://giantbomb-downloader/stream');
    } else {

    }

    source.addEventListener('message',
            function (e) {
                var response = JSON.parse(e.data);
                console.log(response.rawSize);
                console.log(response.humanSize);
                console.log(response.percentage);
                $('#storageSize').css('width', response.percentage).attr('aria-valuenow', response.rawSize).html(response.humanSize);
            }, false);

</script>

<br>
<br>
<br>
<br>
<body>
	<div class="container">
		<hr>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4">
						<h4 class="text-center">All Videos Known</h4>
					</div>
					<div class="col-md-8">
						<div class="btn-group pull-right">
							{!! $videos->links() !!}
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">Video Image</th>
							<th class="text-center">Video Name</th>
							<th class="text-center">Video Status</th>
							<th class="text-center">Video Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($videos as $video)
						<tr>
							<td><img class="img-thumbnail" src="{{ $video->videoDetail->image_path }}"></td>
							<td style="vertical-align: middle;"><a href="{{ $video->url }}"> {{ $video->name }} </a> </td>
							<td style="vertical-align: middle;">{{ $video->status }}</td>
							<td style="vertical-align: middle;">{{ $video->published_date->format('d/m/Y') }}</td>
							<td style="vertical-align: middle;">
								@if ($video->status == 'NEW' || $video->status == 'WATCHED')
								{{ Form::open(['action' => 'VideoController@saveVideo', 'method' => 'post']) }}
								{{ Form::hidden('id',$video->id) }}
								<button type="submit" class="btn btn-info">Save</button>
								{{ Form::close() }}
								@endif

								@if ($video->status == 'SAVED')
								{{ Form::open(['action' => ['VideoController@download', $video->id], 'method' => 'get']) }}
								<button type="submit" class="btn btn-success">Download</button>
								{{ Form::close() }}

								{{ Form::open(['action' => ['VideoController@watched', $video->id], 'method' => 'delete']) }}
								<button type="submit" class="btn btn-danger">Watched</button>
								{{ Form::close() }}
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<hr>
	</div>
</body>
