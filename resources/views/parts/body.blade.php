<body>
	<div class="container">
		<hr>
		<div class="panel panel-default">
			<div class="panel-heading"><h4>All Videos Known</h4></div>
			<div class="table-responsive">
				<table class="table table-condensed text-center">
					<thead>
						<tr>
							<th class="text-center">Video Name</th>
							<th class="text-center">Video Status</th>
							<th class="text-center">Video Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($videos as $video)
						<tr>
							<td> <a href="{{ $video->url }}"> {{ $video->name }} </a> </td>
							<td>{{ $video->status }}</td>
							<td>{{ $video->published_date->format('d/m/Y') }}</td>
							<td>
								@if ($video->status == 'NEW')
								{{ Form::open(['route' => 'Videos.store', 'method' => 'post']) }}
								{{ Form::hidden('id',$video->id) }}	
								<button type="submit" class="btn btn-success">Download</button>
								{{ Form::close() }}
								@endif

								@if ($video->status == 'DOWNLOADED')
								{{ Form::open(['route' => ['Videos.destroy', $video->id], 'method' => 'get']) }}
								<button type="submit" class="btn btn-success">View</button>
								{{ Form::close() }}
								@endif

								{{ Form::open(['route' => ['Videos.destroy', $video->id], 'method' => 'delete']) }}
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