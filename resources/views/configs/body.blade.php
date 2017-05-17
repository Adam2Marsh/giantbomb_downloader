<div class="col-md-offset-2 col-md-8">
    <br>
    <br>
    @include('parts.success')
    @include('parts.errors')

    <div class="alert alert-info">
        <div class="text-center">
            <p>I can notify you via Slack when a new video is ready to download and when I've downloaded a video, for this to work you need to give me a Slack Web Hook URL.</p>
            <form class="form" method="post" action="{{ url('configs') }}">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input name="name" value="SLACK_HOOK_URL" type="hidden">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input  class="form-control" type="text" name="SLACK_HOOK_URLvalue" value="{{$slackHookUrl["value"]}}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
            <br>
            <p>Change the Storage Location for your Videos</p>
            <form class="form" method="post" action="{{ url('configs') }}">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input name="name" value="STORAGE_LOCATION" type="hidden">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input  class="form-control" type="text" name="STORAGE_LOCATIONvalue" value="{{$storageLocation["value"]}}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-danger">
        <h4 class="text-center">Giantbomb Account Linked</h4>
        <p class="text-center">If you need to unlink me from your giantbomb account then press the button below, <strong>this will stop me from working.</strong></p>
        <br>
        <div class="text-center">
            <form class="form" method="post" action="{{ url('configs') . '/' . $apiKey->id }}">
                <input name="_method" value="DELETE" type="hidden">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <button type="submit" class="btn btn-default">Delete</button>
            </form>
        </div>
    </div>
</div>


<script>



</script>