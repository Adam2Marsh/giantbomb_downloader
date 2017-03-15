<div class="col-md-offset-2 col-md-8">
    <br>
    <br>
    <div class="alert alert-danger">
    @include('parts.success')
    @include('parts.errors')
    @foreach($configs as $config)

        @if($config->name == "API_KEY")
            <h4>Giantbomb Account Linked</h4>
            <p>If you need to unlink me from your giantbomb account then press the button below, this will stop me from working.</p>
            {{ Form::open(['route' => ['configs.destroy', $config->id],
  'method' => 'delete']) }}
            <button name="{{ $config->id }}DELETE" type="submit" class="btn btn-danger">Delete</button>
            {{ Form::close() }}
        @endif

        @if($config->name == "SLACK_HOOK_URL")
            {{ Form::open(['route' => ['configs.store', $config->id]]) }}
                
            {{ Form::close() }}
        @endif
    @endforeach
    </div>
</div>