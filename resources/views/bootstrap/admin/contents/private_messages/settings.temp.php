@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Private Messages settings</h1>
    <p class="grey-text">Here is where you can change general private messages settings.</p>

    <form method="post" action="{{ route('admin.contents.private_messages') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="bbcode">BbCode block:</label>
                    <br>
                    <span>Here you can set whether the bbcode block should be enabled and compiled in private messages.</span>
                    @if ($this->errors->has("bbcode")):
                        <br><span class="error">
                            {{ $this->errors->get("bbcode")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="bbcode" class="radio" value="true" {{ config('private_message/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="bbcode" class="radio" value="false" {{ !config('private_message/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="smilies">Smilies block:</label>
                    <br>
                    <span>Here you can set whether the smilies block should be enabled and compiled in private messages.</span>
                    @if ($this->errors->has("smilies")):
                        <br><span class="error">
                            {{ $this->errors->get("smilies")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="smilies" class="radio" value="true" {{ config('private_message/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="smilies" class="radio" value="false" {{ !config('private_message/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_characters_private_messages">Min characters in thread subject:</label>
                    <br>
                    <span>Here you can set minimum characters needed to send PM.</span>
                    @if ($this->errors->has("min_characters_private_messages")):
                        <br><span class="error">
                            {{ $this->errors->get("min_characters_private_messages")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_characters_private_messages" type="number" name="min_characters_private_messages" value="{{ config('private_message/contents/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_characters_pm">Max characters in one PM:</label>
                    <br>
                    <span>Here you can set maximum allowed characters in PM.</span>
                    @if ($this->errors->has("max_characters_pm")):
                        <br><span class="error">
                            {{ $this->errors->get("max_characters_pm")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_characters_pm" type="number" name="max_characters_pm" value="{{ config('private_message/contents/length/max') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="private_messages_settings_token" value="{{ token('private_messages_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot