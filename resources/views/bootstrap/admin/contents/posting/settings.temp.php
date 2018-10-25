@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Posting settings</h1>
    <p class="grey-text">Here is where you can change general posting settings.</p>

    <form method="post" action="{{ route('admin.contents.posting') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="bbcode">BbCode block:</label>
                    <br>
                    <span>Here you can set whether the bbcode block should be enabled and compiled in answers.</span>
                    @if ($this->errors->has("bbcode")):
                        <br><span class="error">
                            {{ $this->errors->get("bbcode")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="bbcode" class="radio" value="true" {{ config('posting/answers/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="bbcode" class="radio" value="false" {{ !config('posting/answers/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="smilies">Smilies block:</label>
                    <br>
                    <span>Here you can set whether the smilies block should be enabled and compiled in answers.</span>
                    @if ($this->errors->has("smilies")):
                        <br><span class="error">
                            {{ $this->errors->get("smilies")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="smilies" class="radio" value="true" {{ config('posting/answers/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="smilies" class="radio" value="false" {{ !config('posting/answers/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_characters_answer">Min characters in answer:</label>
                    <br>
                    <span>Here you can set minimum characters needed to send answer.</span>
                    @if ($this->errors->has("min_characters_answer")):
                        <br><span class="error">
                            {{ $this->errors->get("min_characters_answer")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_characters_answer" type="number" name="min_characters_answer" value="{{ config('posting/answers/contents/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_characters_answer">Max characters in answer:</label>
                    <br>
                    <span>Here you can set maximum characters amount in one answer.</span>
                    @if ($this->errors->has("max_characters_answer")):
                        <br><span class="error">
                            {{ $this->errors->get("max_characters_answer")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_characters_answer" type="number" name="max_characters_answer" value="{{ config('posting/answers/contents/length/max') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="posting_settings_token" value="{{ token('posting_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot