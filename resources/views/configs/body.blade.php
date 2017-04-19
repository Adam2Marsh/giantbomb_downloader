<div class="col-md-offset-2 col-md-8">
    <br>
    <br>
    @include('parts.success')
    @include('parts.errors')
    @foreach($configs as $config)

        @if($config->name == "API_KEY")
            <div class="alert alert-danger">
                <h4 class="text-center">Giantbomb Account Linked</h4>
                <p class="text-center">If you need to unlink me from your giantbomb account then press the button below, <strong>this will stop me from working.</strong></p>
                <br>
                <div class="text-center">
                    {{ Form::open(['route' => ['configs.destroy', $config->id], 'method' => 'delete']) }}
                    <button name="{{ $config->id }}DELETE" type="submit" class="btn btn-danger">Delete</button>
                    {{ Form::close() }}
                </div>
            </div>
        @endif

        @if($config->name == "SLACK_HOOK_URL")
            <div class="alert alert-info">
                <div class="text-center">
                <p>I can notify you via Slack when a new video is ready to download and when I've downloaded a video, for this to work you need to give me a Slack Web Hook URL.</p>
                    {{ Form::open(['action' => ['ConfigController@update', $config->id],
                        'method' => 'PUT']) }}
                        {{ Form::label('slack_hook_text', 'Enter Slack Hook Url - ') }}
                        {{ Form::text('SLACK_HOOK_URL', $config->value, ['style' => 'width:380px']) }}
                        {{ Form::submit('Save') }}
                    {{ Form::close() }}
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <div class="text-center">
                    <p>I can notify you via Slack when a new video is ready to download and when I've downloaded a video, for this to work you need to give me a Slack Web Hook URL.</p>
                    {{ Form::open(['action' => ['ConfigController@update', $config->id],
                        'method' => 'PUT']) }}
                    {{ Form::label('slack_hook_text', 'Enter Slack Hook Url - ') }}
                    {{ Form::text('SLACK_HOOK_URL', $config->value, ['style' => 'width:380px']) }}
                    {{ Form::submit('Save') }}
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    @endforeach
</div>


<script>



</script>