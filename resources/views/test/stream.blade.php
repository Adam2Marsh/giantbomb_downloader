<script type="text/javascript">

    if (!!window.EventSource) {
        var source = new EventSource('http://giantbomb-downloader/stream');
    } else {

    }

    source.addEventListener('message',
            function (e) {
                console.log(e.data);
            }, false);

</script>