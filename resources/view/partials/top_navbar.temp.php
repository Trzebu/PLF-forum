<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('/') }}">Forum</a>
        <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
                @if (Libs\User::check()):
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Your profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Options</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
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