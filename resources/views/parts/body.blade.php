<body>
	<div class="container">
		<hr>
			<div class="panel panel-default">
				<div class="panel-heading">All Videos Known</div>
					<table class="table">
						<thead>
							<tr>
								<th>Video Name</th>
								<th>Video URL</th>
								<th>Video Status</th>
								<th>Video Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($videos as $video)
							<tr>
								<td>{{ $video->name }}</td>
								<td> <a href="{{ $video->url }}"> {{ $video->url }} </a> </td>
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
		<hr>
	</div>




</body>