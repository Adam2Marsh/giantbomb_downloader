<div class="container">

    <div class="text-center">
        <h1>Welcome to the Giantbomb Pi Downloader</h1>
        <img src="/gb-logo.png" alt="giantbomb logo" class="img-responsive center-block">
        <p>If your reading this then our situations could be similar, you love GiantBomb and your internet is just not that great...</p>
        <p>I developed this tool to download my favourite Giantbomb videos ready for my morning commute, while my power hungry PC and I sleep. To use this tool follow the instructions below and let's get you set up.</p>
        <div class="alert alert-info" role="alert">
            <h3>Follow these 3 quick steps</h3>
            <ol>
                <li>Get your Link code from <a href="https://www.giantbomb.com/app/giantbomb%20pi%20downloader/" target="_blank">https://www.giantbomb.com/app/giantbomb pi downloader/</a></li>
                <li>Enter it below</li>
                <li>If the code is valid click the continue button</li>
            </ol>
            <form class="form-inline ajaxForm" method="POST" name="addAPIKey" action="{{ url("FirstTime") }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group" id="responseStatus">
                    <input type="text" class="form-control" name="linkCode"
                           placeholder="Giantbomb Link Code" value="{{ old('linkCode') }}" required>
                    <span id="linkSuccess" class="glyphicon glyphicon-ok form-control-feedback hidden" aria-hidden="true"></span>
                    <span id="linkError" class="glyphicon glyphicon-remove form-control-feedback hidden" aria-hidden="true"></span>
                </div>
                <button type="submit" class="btn btn-default">Link</button>
            </form>
        </div>
    </div>

</div>

<script type="text/javascript">

$(document).ready(function() {

    $('.ajaxForm').submit(function(e){

        e.preventDefault();

        var form = $(this);
        var curSubmit = $(form.closest('form').get(0).elements).filter(':submit');
        var formText = $(form.closest('form').get(0).elements).filter('.form-control');
        var formGroup = $('#responseStatus');
        var successIcon = $('#linkSuccess');
        var errorIcon = $('#linkError');

        $.ajax({
            url:form.attr('action'),
            type:form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            beforeSend:function() {
                curSubmit.prop('disabled', true);
                formText.prop('readonly', true);
                successIcon.addClass("hidden");
                errorIcon.addClass("hidden");
                formGroup.removeClass("has-error has-feedback");
            },
            success: function(data, textStatus, xhr) {
                location.reload(true);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr);
                curSubmit.prop('disabled', false);
                formText.prop('readonly', false);
                formGroup.addClass("has-error has-feedback");
                errorIcon.removeClass("hidden");
            }
        });
    });
});

</script>
