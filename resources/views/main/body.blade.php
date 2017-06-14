<script type="text/javascript">
    //    Echo.channel('VideoDownloaded')
    //    .listen('VideoDownloadedEvent', (e) => {
    //        console.log('Video Finished Downloading, Refreshing Screen');
    //        location.reload();
    //    });

    function checkForNewVideos() {

        $('#refreshIcon').addClass('fa-spin');
        $('#refreshButton').prop('disabled', true);

        $.ajax({
            type: 'GET',
            url: 'NewVideos/60',
            data: {'_method':'PUT', '_token':'{{ csrf_token() }}'},
            success: function(data) {
                location.reload();
            },
            error: function(data) {
                alert(data);
            }
        });
    }

    if (!!window.EventSource) {
        var source = new EventSource('{{ url('stream') }}');
    } else {

    }

    source.addEventListener('message',
        function (e) {
            // console.log(e.data);
            var response = JSON.parse(e.data);
            // console.log(response);
            $('#storageSize').css('width', response.percentage).attr('aria-valuenow', response.rawSize).html(response.humanSize);

            for(var i = 0; i < response.downloading.length; i++) {
                var video = response.downloading[i];
                // console.log(video.id);
                // console.log(video.percentage);

                $("#" + video.id).html("SAVING " + video.percentage);
            }
        }, false);
</script>

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

<style type="text/css">
	.pagination {
		margin: 0px !important;
	}
</style>

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
					<div class="col-md-6">
						<div class="btn-group pull-left">
							<button id="refreshButton" type="button" class="btn btn-success" onclick="checkForNewVideos()">
								Refresh
								<i id="refreshIcon" class="fa fa-refresh fa-1x" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="btn-group pull-right">
							{!! $videos->links() !!}
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive video-list">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">Video Image</th>
							<th class="text-center">Video Name</th>
							<th class="text-center">Video Size</th>
							<th class="text-center">Video Status</th>
							<th class="text-center">Video Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
					@if(count($videos))
						@foreach ($videos as $video)
							<tr>
								@if($video->videoDetail->local_image_path != "")
									<td><img class="img-thumbnail" src="{{ $video->videoDetail->local_image_path }}"></td>
								@else
									<td><img class="img-thumbnail" src="{{ $video->videoDetail->remote_image_path }}"></td>
								@endif
								<td style="vertical-align: middle;"><a href="{{ $video->url }}"> {{ $video->name }} </a> </td>
								@if($video->videoDetail->file_size != null)
									<td style="vertical-align: middle;">{{ human_filesize($video->videoDetail->file_size) }}</td>
								@else
									<td style="vertical-align: middle;">??</td>
								@endif
								<td id="{{ $video->id }}" style="vertical-align: middle;">{{ $video->status }}</td>
								<td style="vertical-align: middle;">{{ $video->published_date->format('d/m/Y') }}</td>
								<td style="vertical-align: middle;">
									@if ($video->status == 'NEW' || $video->status == 'WATCHED')
									{{ Form::open(['action' => 'VideoController@saveVideo', 'method' => 'post']) }}
									{{ Form::hidden('id',$video->id) }}
									<button type="submit" class="btn btn-info">Save</button>
									{{ Form::close() }}
									@endif

									@if ($video->status == 'DOWNLOADED')
									{{ Form::open(['action' => ['VideoController@download', $video->id], 'method' => 'get']) }}
									<button type="submit" class="btn btn-success">Download</button>
									{{ Form::close() }}

									{{ Form::open(['action' => ['VideoController@watched', $video->id], 'method' => 'delete']) }}
									<button type="submit" class="btn btn-danger">Watched</button>
									{{ Form::close() }}
									@endif

									@if ($video->status == 'FAILED')
										{{ Form::open(['action' => 'VideoController@saveVideo', 'method' => 'post']) }}
										{{ Form::hidden('id',$video->id) }}
											<button type="submit" class="btn btn-success">Retry Download</button>
										{{ Form::close() }}
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					@else
						<tr>
							<td colspan="6">
								<h3>Please don't refresh page grabbing latest videos, will refresh automatically (unless something breaks)</h3>
								<script type="text/javascript">
                                    $('#refreshButton').click();
								</script>
							</td>
						</tr>
					@endif
				</table>
			</div>
		</div>
		<hr>
	</div>
</body>
