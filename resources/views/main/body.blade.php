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
								@if ($video->status == 'NEW')
								{{ Form::open(['route' => 'videos.store', 'method' => 'post']) }}
								{{ Form::hidden('id',$video->id) }}
								<button type="submit" class="btn btn-success">Download</button>
								{{ Form::close() }}
								@endif

								@if ($video->status == 'DOWNLOADED')
								{{ Form::open(['route' => ['videos.destroy', $video->id], 'method' => 'get']) }}
								<button type="submit" class="btn btn-success">View</button>
								{{ Form::close() }}
								@endif

								{{ Form::open(['route' => ['videos.destroy', $video->id], 'method' => 'delete']) }}
								<button type="submit" class="btn btn-danger">Delete</button>
								{{ Form::close() }}
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
