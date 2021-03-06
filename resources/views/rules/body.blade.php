<br>
<body>
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      @include('parts.success')
      @include('parts.errors')
      <div class="panel panel-default">
        <div class="panel-heading">Create new Rules Here</div>
        <div class="panel-body">

          <form class="form-horizontal" method="POST" name="addRegex" action={{ url("rules") }}>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-sm-2 control-label">Video Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="regex"
                  placeholder="Video Name" value="{{ old('regex') }}">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Enabled</label>
              <div class="col-sm-10">
                @if (old('enabled'))
                  <input type="checkbox" class="form-control" name="enabled"
                    placeholder="Rule Enabled" value=1 checked>
                @else
                  <input type="checkbox" class="form-control" name="enabled"
                    placeholder="Rule Enabled" value=1>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">List of Current Rules</div>
        <div class="panel-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">Rule</th>
                <th class="text-center">Enabled</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rules as $rule)
              <tr>
                <td class="text-center"> {{ $rule->regex }} </td>
                  <td class="text-center">
                    @if ($rule->enabled == 1)
                      <input type="checkbox" class="form-control"
                        name="{{ $rule->id }}" value=1 onclick="ajaxForm(this.name, this)" checked>
                    @else
                      <input type="checkbox" class="form-control"
                        name="{{ $rule->id }}" value=1 onclick="ajaxForm(this.name, this)">
                    @endif
                </td>
                <td class="text-center">
                  {{ Form::open(['route' => ['rules.destroy', $rule->id],
                    'method' => 'delete']) }}
                  <button name="{{ $rule->id }}DELETE" type="submit" class="btn btn-danger">Delete</button>
                  {{ Form::close() }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-2">
    </div>
</body>

<script type="text/javascript">


  function ajaxForm(id, checkbox)
  {

    var checkboxValue = 0;

    if (checkbox.checked) {
      checkboxValue = 1;
    }

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
  }

</script>
