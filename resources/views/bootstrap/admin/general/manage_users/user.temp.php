@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>User administration :: {{ $this->user->username($this->data->id) }}</h1>
    <p class="grey-text">Here you can change your users information and certain specific options.</p>

    <form method="post" action="{{ route('admin.general_settings.manage_users.edit.base', ['id' => $this->data->id]) }}">

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
                    <label for="">Rank:</label>
                </dt>
                <dd>
                    {{ $this->user->permissions($this->data->id)->name }}
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
                    <label for="">Warnings:</label>
                </dt>
                <dd>
                    {{ $this->data->warnings }}
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

            <p class="buttons">
                <input type="hidden" name="edit_base_user_settins_token" value="{{ token('edit_base_user_settins_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.change') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>

    </form>

    <form method="post" action="{{ route('admin.general_settings.manage_users.edit.new_password', ['id' => $this->data->id]) }}">
        <div class="fieldset">
            <div class="legend">
                New password
            </div>

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
            <p class="buttons">
                <input type="hidden" name="new_user_password_token" value="{{ token('new_user_password_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.save') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>

    <div class="fieldset">
        <div class="legend">Basic tools</div>

        <form method="post" action="{{ route('admin.general_settings.manage_users.manage.move_threads', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="move_threads">Move threads</label>
                    <br>
                    <span>Here you can move all user threads to other category.</span>
                    @if ($this->errors->has("move_threads")):
                        <br><span class="error">
                            {{ $this->errors->get("move_threads")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="move_threads" name="move_threads">
                        @foreach ($this->section->getAllCategories() as $category):
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </dd>
                <dd>
                    <input type="hidden" name="move_user_threads_token" value="{{ token('move_user_threads_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.move') }}">
                </dd>
            </dl>
        </form>

        <form method="post" action="{{ route('admin.general_settings.manage_users.manage.change_rank', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="change_rank">Change rank:</label>
                    <br>
                    <span>Here you can move all user posts to other category.</span>
                    @if ($this->errors->has("change_rank")):
                        <br><span class="error">
                            {{ $this->errors->get("change_rank")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="change_rank" name="change_rank">
                        @foreach ($this->userOptions->getRanks() as $rank):
                            <option value="{{ $rank->id }}" {{ $rank->id == $this->data->permissions ? "selected" : "" }}>{{ $rank->name }}</option>
                        @endforeach
                    </select>
                </dd>
                <dd>
                    <input type="hidden" name="change_user_rank_token" value="{{ token('change_user_rank_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.change') }}">
                </dd>
            </dl>
        </form>

        <form method="post" action="{{ route('admin.general_settings.manage_users.manage.add_warnings', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="add_warning_points">Add warning points:</label>
                    <br>
                    <span>Here you can add or remove some warning points for this user.</span>
                    @if ($this->errors->has("quantity")):
                        <br><span class="error">
                            {{ $this->errors->get("quantity")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="add_warning_points" type="number" name="quantity">
                </dd>
                <dd>
                    <input type="hidden" name="add_warning_points_token" value="{{ token('add_warning_points_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.add') }}">
                </dd>
            </dl>
        </form>

        <form method="post" action="{{ route('admin.general_settings.manage_users.manage.ban_ip', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="ban_ip">Ban IP:</label>
                    <br>
                    <span>This option ban IP used by this user. If user is baned per IP re-clicking this option unban user IP.</span>
                    @if ($this->errors->has("reason")):
                        <br><span class="error">
                            {{ $this->errors->get("reason")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="ban_ip" type="text" name="reason" placeholder="Reason">
                </dd>
                <dd>
                    <input type="hidden" name="ban_ip_token" value="{{ token('ban_ip_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.lock') }}">
                </dd>
            </dl>
        </form>

        <dl>
            <dt>
                <label for="">Delete threads:</label>
                <br>
                <span>This option delete all threads created by this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Delete posts:</label>
                <br>
                <span>This option delete all posts created by this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Delete posts and threads:</label>
                <br>
                <span>This option delete all posts and threads created by this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Delete user files:</label>
                <br>
                <span>This option delete all files uploaded by this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Reset given votes:</label>
                <br>
                <span>This option reset all given votes by this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.reset") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Reset reputation:</label>
                <br>
                <span>This option reset user reputation.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.reset") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Reset warnings:</label>
                <br>
                <span>This option reset user warnings.</span>
            </dt>
            <dd>
                <a href="{{ route('admin.general_settings.manage_users.reset.warnings', ['id' => $this->data->id, 'token' => token('reset_warnings_token')]) }}">{{ trans("buttons.reset") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Empty PM outbox:</label>
                <br>
                <span>Remove all private messages of this user.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.empty") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Remove user additional info:</label>
                <br>
                <span>Full name, City, Country adn WWW.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Clear about area:</label>
                <br>
                <span>Clear personal about area.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.clear") }}</a>
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="">Remove avatar:</label>
                <br>
                <span>Remove avatar and delete avatar file.</span>
            </dt>
            <dd>
                <a href="">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>

    </div>

    <div class="fieldset">
        <div class="legend">Delete user</div>

        <dl>
            <dt>
                <label for="">Delete user:</label><br>
                <span>Please note that deleting a user is final, they cannot be recovered.</span>
            </dt>
            <dd>
                <a href="sds">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>
    </div>

</div>

@include admin/partials/bot