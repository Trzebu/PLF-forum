@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>User administration :: {{ $this->user->username($this->data->id) }}</h1>
    <p class="grey-text">Here you can change your users information and certain specific options.</p>

    <form method="post" action="">

        <div class="fieldset">

            <div class="legend">
                Overview
            </div>

            <dl>
                <dt>
                    <label for="userID">Username:</label>
                    @if ($this->errors->has("username")):
                        <br><span class="error">
                            {{ $this->errors->get("username")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="userID" type="text" name="username" value="{{ $this->data->username }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">Registered at:</label>
                </dt>
                <dd>
                    {{ $this->user->dateTimeAlphaMonth($this->data->created_at) }}
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">Last active:</label>
                </dt>
                <dd>
                    {{ $this->user->dateTimeAlphaMonth($this->data->updated_at) }}
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">Registered from IP:</label>
                </dt>
                <dd>
                    {{ $this->data->ip }}
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">Posts:</label>
                </dt>
                <dd>
                    {{ $this->user->calcPosts($this->data->id) }}
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">Reputation:</label>
                </dt>
                <dd>
                    {{ $this->user->calcReputation($this->data->id) }}
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="">He voted for</label>
                </dt>
                <dd>
                    {{ $this->user->calcGivenVotes($this->data->id) }} posts
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="email">E-mail:</label>
                    @if ($this->errors->has("email")):
                        <br><span class="error">
                            {{ $this->errors->get("email")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="email" type="email" name="email" value="{{ $this->data->email }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="password">New password:</label>
                    @if ($this->errors->has("password")):
                        <br><span class="error">
                            {{ $this->errors->get("password")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="password" type="password" name="password">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="password_again">Confirm password:</label>
                    @if ($this->errors->has("password_again")):
                        <br><span class="error">
                            {{ $this->errors->get("password_again")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="password_again" type="password" name="password_again">
                </dd>
            </dl>

        </div>

    </form>
</div>

@include admin/partials/bot