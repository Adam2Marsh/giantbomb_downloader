<div class="container-fluid">


<img src="/gb-logo.png" alt="giantbomb logo" class="img-responsive center-block">
<div class="text-center">
    <h1>Welcome to the Giantbomb Downloader</h1>
    <p>If your reading this then our situations could be similar, you love GiantBomb and your internet is just not that great...</p>
    <p>I developed this tool to download my favourite Giantbomb videos ready for my morning commute, while my power hungry PC and I sleep.</p>
    <p>To use this tool you need to be a premium user, and enter your API key in below:</p>
    <form class="form-horizontal" method="POST" name="addAPIKey" action="/NewUsers">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
        <label class="col-sm-offset-2 col-sm-2 control-label">Giantbomb API Key</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="apikey"
            placeholder="Giantbomb API Key" value="{{ old('apikey') }}">
        </div>
        <div class="col-sm-1">
          <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>
  </form>

  <div class="col-sm-offset-2 col-sm-8">
    <div class="alert alert-info" role="alert">
          <h3>Why do you need my Api Key?</h3>
          <p>It's used to verify your a GiantBomb Premium User, and when retrieving videos. <strong>It does not allow me to get your Username or Password.</strong></p>
    </div>
  </div>
</div>

</div>

</div>

<script type="text/javascript">

    $.ajax({
        type: 'POST',
        url: 'rules/' + id,
        data: {'_method':'PUT', '_token':'{{ csrf_token() }}', 'enabled':
          checkboxValue },
        beforeSend: function() {
          $('#success').append(
            '<div class="alert alert-warning alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            'Updating Rule' +
            '</div>'
          );
        },
        success: function(data) {
          // alert(JSON.stringify(data));
          $('#success').append(
            '<div class="alert alert-success alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            'Rule Updated' +
            '</div>'
          );
        },
        error: function(data) {
          // alert('Error');
        }
      });

</script>
