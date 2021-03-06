<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('/') }}">Forum</a>
        <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
                @if (!Libs\Config::get("page/general_options/hidden")):
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('forum_general_options.view') }}">Forum options</a>
                    </li>
                @endif
                @if (Auth()->check()):
                    @if (Auth()->permissions("moderator")):
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('report.view') }}">View reports</a>
                        </li>
                    @endif
                    @if (Auth()->permissions("admin")):
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.general_settings') }}">Administration CP</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.index_by_id', ['id' => Auth()->data()->id]) }}">Your profile ({{ Auth()->data()->username }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.options') }}">Options</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('message.view') }}">Messages {{ Auth()->getterToUnreadedMessages() > 0 ? '<font color="red">(' . Auth()->getterToUnreadedMessages() . ')</font>' : '' }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
                    </li>
                    <li class="nav-item">
                        <div class="media">
                            <img class="media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ Auth()->avatar(50) }}" alt="{{ strip_tags(Auth()->data()->username) }}">
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>