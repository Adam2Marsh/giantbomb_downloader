<br>
<div class="col-md-offset-2 col-md-8">
    @include('parts.success')
    @include('parts.errors')

    <div class="text-center" id="updateCheck">
        <h3>Checking For Updates</h3>
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <script type="text/javascript">
            $.ajax({
                type: 'GET',
                url: 'update/check',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(data) {
                    if (data == 1) {
                        $("#updateAvailable").show();
                    } else {
                        $("#updateNotAvailable").show();
                    }
                    $("#updateCheck").hide();
                },
                error: function(data) {
                    alert(data);
                }
            });
        </script>
    </div>
    <div class="text-center" id="updateNotAvailable" style="display: none">
        <h3>No Updates Available</h3>
    </div>
    <div class="text-center" id="updateAvailable" style="display: none">
        <h3>Updates Available</h3>
        <p>If you would like to update press the button below</p>
        <form method="post" action=" {{ url('update') }}">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

</div>