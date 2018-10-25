@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Users avatar settings</h1>
    <p class="grey-text">Here is where you can change users avatar settings.</p>

    <form method="post" action="{{ route('admin.contents.downloads.avatar') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="default_avatar">Default avatar:</label>
                    <br>
                    <span>It's default avatar. This will be showed as avatar when user haven't setted own avatar.</span>
                    @if ($this->errors->has("default_avatar")):
                        <br><span class="error">
                            {{ $this->errors->get("default_avatar")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="default_avatar" type="text" name="default_avatar" value="{{ config('avatar/default') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="gravatar">Use gravatar:</label>
                    <br>
                    <span>If user haven't setted avatar try get avatar from gravatar.</span>
                    @if ($this->errors->has("gravatar")):
                        <br><span class="error">
                            {{ $this->errors->get("gravatar")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="gravatar" class="radio" value="true" {{ config('avatar/use_gravatar') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="gravatar" class="radio" value="false" {{ !config('avatar/use_gravatar') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_avatar_height">Minimum avatar hegiht:</label>
                    <br>
                    <span>enter the value in pixels.</span>
                    @if ($this->errors->has("min_avatar_height")):
                        <br><span class="error">
                            {{ $this->errors->get("min_avatar_height")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_avatar_height" type="number" name="min_avatar_height" value="{{ config('avatar/height/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_avatar_hegiht">Maximum avatar height:</label>
                    <br>
                    <span>enter the value in pixels.</span>
                    @if ($this->errors->has("max_avatar_hegiht")):
                        <br><span class="error">
                            {{ $this->errors->get("max_avatar_hegiht")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_avatar_hegiht" type="number" name="max_avatar_hegiht" value="{{ config('avatar/height/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_avatar_width">Minimum avatar width:</label>
                    <br>
                    <span>enter the value in pixels.</span>
                    @if ($this->errors->has("min_avatar_width")):
                        <br><span class="error">
                            {{ $this->errors->get("min_avatar_width")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_avatar_width" type="number" name="min_avatar_width" value="{{ config('avatar/width/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_avatar_width">Maximum avatar width:</label>
                    <br>
                    <span>enter the value in pixels.</span>
                    @if ($this->errors->has("max_avatar_width")):
                        <br><span class="error">
                            {{ $this->errors->get("max_avatar_width")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_avatar_width" type="number" name="max_avatar_width" value="{{ config('avatar/width/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_avatar_size">Minimum avatar file size:</label>
                    <br>
                    <span>enter the value in bytes.</span>
                    @if ($this->errors->has("min_avatar_size")):
                        <br><span class="error">
                            {{ $this->errors->get("min_avatar_size")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_avatar_size" type="number" name="min_avatar_size" value="{{ config('avatar/size/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_avatar_size">Maximum avatar file size:</label>
                    <br>
                    <span>enter the value in bytes.</span>
                    @if ($this->errors->has("max_avatar_size")):
                        <br><span class="error">
                            {{ $this->errors->get("max_avatar_size")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_avatar_size" type="number" name="max_avatar_size" value="{{ config('avatar/size/max') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="avatar_settings_token" value="{{ token('avatar_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot