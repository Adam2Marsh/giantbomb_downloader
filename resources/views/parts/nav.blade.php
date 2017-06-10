<br>
<div class="text-center">
    <h1>Giantbomb Pi Downloader</h1>
    <ul class="nav nav-tabs">
        @if(Request::path() == "videos")
            <li role="presentation" class="active"><a href="/videos">Videos</a></li>
            <li role="presentation"><a href={{ url("/rules") }}>Rules</a></li>
            <li role="presentation"><a href={{ url("/configs") }}>Configs</a></li>
            <li role="presentation"><a href={{ url("/update") }}>Update</a></li>
        @elseif(Request::path() == "rules")
            <li role="presentation"><a href={{ url("/videos") }}>Videos</a></li>
            <li role="presentation" class="active"><a href={{ url("/rules") }}>Rules</a></li>
            <li role="presentation"><a href={{ url("/configs") }}>Configs</a></li>
            <li role="presentation"><a href={{ url("/update") }}>Update</a></li>
        @elseif(Request::path() == "configs")
            <li role="presentation"><a href={{ url("/videos") }}>Videos</a></li>
            <li role="presentation"><a href={{ url("/rules") }}>Rules</a></li>
            <li role="presentation" class="active"><a href={{ url("/configs") }}>Configs</a></li>
            <li role="presentation"><a href={{ url("/update") }}>Update</a></li>
        @elseif(Request::path() == "update")
            <li role="presentation"><a href={{ url("/videos") }}>Videos</a></li>
            <li role="presentation"><a href={{ url("/rules") }}>Rules</a></li>
            <li role="presentation"><a href={{ url("/configs") }}>Configs</a></li>
            <li role="presentation" class="active"><a href={{ url("/update") }}>Update</a></li>
        @endif
    </ul>
</div>
