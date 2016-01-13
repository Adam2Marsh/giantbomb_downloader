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
								<td>{{ $video->name }}</td>
								<td> <a href="{{ $video->url }}"> {{ $video->url }} </a> </td>
								<td>{{ $video->published_date }}</td>
							</tr>
						@endforeach
					</tbody>
					</table>
			</div>
		<hr>
	</div>
</body>