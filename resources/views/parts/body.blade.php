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
								<th>Video Date</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($videos as $video)
							<tr>
								<td>{{ $video->id }}</td>
								<td>{{ $video->name }}</td>
								<td> <a href="{{ $video->url }}"> {{ $video->url }} </a> </td>
								<td>{{ $video->published_date }}</td>
								<td>
									{{ Form::open(['route' => ['Videos.destroy', $video->id], 'method' => 'delete']) }}
										<button type="submit" class="btn btn-danger">Delete</button>
									{{ Form::close() }}

{{-- 									<form class="POST" action="/Videos/{{ $video->id }}">
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-danger">Delete</button>
									</form> --}}
								</td>
							</tr>
						@endforeach
					</tbody>
					</table>
			</div>
		<hr>
	</div>




</body>