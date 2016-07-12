<div class="col-md-2">
</div>
<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">Creatre new Rules Here</div>
    <div class="panel-body">

      <form class="form-horizontal" method="POST" name="addRegex" action="/rules">
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
                placeholder="Rule Enabled" value="1" checked>
            @else
              <input type="checkbox" class="form-control" name="enabled"
                placeholder="Rule Enabled" value="1">
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
          </tr>
        </thead>
        <tbody>
          @foreach ($rules as $rule)
          <tr>
            <td class="text-center"> {{ $rule->regex }} </td>
            <td class="text-center"> {{ $rule->enabled }} </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-md-2">
</div>
