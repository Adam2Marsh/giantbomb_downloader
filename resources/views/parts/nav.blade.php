<br>
<div class="text-center">
    <h1>GB_Downloads</h1>
    <!-- <a href="/videos">Videos</a>
    <a href="/rules">Rules</a> -->
    <ul class="nav nav-tabs">
        @if(Request::path() == "videos")
            <li role="presentation" class="active"><a href="/videos">Videos</a></li>
            <li role="presentation"><a href="/rules">Rules</a></li>
            <li role="presentation"><a href="/configs">Configs</a></li>
        @elseif(Request::path() == "rules")
            <li role="presentation"><a href="/videos">Videos</a></li>
            <li role="presentation" class="active"><a href="/rules">Rules</a></li>
            <li role="presentation"><a href="/configs">Configs</a></li>
        @else
            <li role="presentation"><a href="/videos">Videos</a></li>
            <li role="presentation"><a href="/rules">Rules</a></li>
            <li role="presentation" class="active"><a href="/configs">Configs</a></li>
        @endif
    </ul>
</div>
