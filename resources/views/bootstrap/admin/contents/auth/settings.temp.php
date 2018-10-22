@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Authentication settings</h1>
    <p class="grey-text">Here is where you can change users authentication settings.</p>

    <form method="post" action="{{ route('admin.contents.authentication') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="bbcode_about">BbCode in about:</label>
                    <br>
                    <span>Here you can set whether the bbcode block should be enabled and compiled in about.</span>
                    @if ($this->errors->has("bbcode_about")):
                        <br><span class="error">
                            {{ $this->errors->get("bbcode_about")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="bbcode_about" class="radio" value="true" {{ config('user/auth/about/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="bbcode_about" class="radio" value="false" {{ !config('user/auth/about/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="smilies_about">Smilies in about:</label>
                    <br>
                    <span>Here you can set whether the Smilies block should be enabled and compiled in about.</span>
                    @if ($this->errors->has("smilies_about")):
                        <br><span class="error">
                            {{ $this->errors->get("smilies_about")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="smilies_about" class="radio" value="true" {{ config('user/auth/about/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="smilies_about" class="radio" value="false" {{ !config('user/auth/about/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="bbcode_signature">BbCode in signature:</label>
                    <br>
                    <span>Here you can set whether the BbCode block should be enabled and compiled in signature.</span>
                    @if ($this->errors->has("bbcode_signature")):
                        <br><span class="error">
                            {{ $this->errors->get("bbcode_signature")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="bbcode_signature" class="radio" value="true" {{ config('user/auth/signature/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="bbcode_signature" class="radio" value="false" {{ !config('user/auth/signature/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="smilies_signature">Smilies in signature:</label>
                    <br>
                    <span>Here you can set whether the Smilies block should be enabled and compiled in signature.</span>
                    @if ($this->errors->has("smilies_signature")):
                        <br><span class="error">
                            {{ $this->errors->get("smilies_signature")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="smilies_signature" class="radio" value="true" {{ config('user/auth/signature/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="smilies_signature" class="radio" value="false" {{ !config('user/auth/signature/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>


            <dl>
                <dt>
                    <label for="min_about">Minimum about characters:</label>
                    @if ($this->errors->has("min_about")):
                        <br><span class="error">
                            {{ $this->errors->get("min_about")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_about" type="number" name="min_about" value="{{ config('user/auth/about/contents/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_about">Maximum about characters:</label>
                    @if ($this->errors->has("max_about")):
                        <br><span class="error">
                            {{ $this->errors->get("max_about")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_about" type="number" name="max_about" value="{{ config('user/auth/about/contents/length/max') }}">
                </dd>
            </dl>
            
            <dl>
                <dt>
                    <label for="min_signature">Minimum signature characters:</label>
                    @if ($this->errors->has("min_signature")):
                        <br><span class="error">
                            {{ $this->errors->get("min_signature")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_signature" type="number" name="min_signature" value="{{ config('user/auth/signature/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_signature">Maximum signature characters:</label>
                    @if ($this->errors->has("max_signature")):
                        <br><span class="error">
                            {{ $this->errors->get("max_signature")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_signature" type="number" name="max_signature" value="{{ config('user/auth/signature/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_city">Maximum city characters:</label>
                    @if ($this->errors->has("max_city")):
                        <br><span class="error">
                            {{ $this->errors->get("max_city")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_city" type="number" name="max_city" value="{{ config('user/auth/additional/city/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_country">Maximum country characters:</label>
                    @if ($this->errors->has("max_country")):
                        <br><span class="error">
                            {{ $this->errors->get("max_country")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_country" type="number" name="max_country" value="{{ config('user/auth/additional/country/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_full_name">Maximum full user name characters:</label>
                    @if ($this->errors->has("max_full_name")):
                        <br><span class="error">
                            {{ $this->errors->get("max_full_name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_full_name" type="number" name="max_full_name" value="{{ config('user/auth/additional/full_name/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_www">Maximum WWW characters:</label>
                    @if ($this->errors->has("max_www")):
                        <br><span class="error">
                            {{ $this->errors->get("max_www")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_www" type="number" name="max_www" value="{{ config('user/auth/additional/www/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_email">Minimum email characters:</label>
                    @if ($this->errors->has("min_email")):
                        <br><span class="error">
                            {{ $this->errors->get("min_email")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_email" type="number" name="min_email" value="{{ config('user/auth/email/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_email">Maximum email characters:</label>
                    @if ($this->errors->has("max_email")):
                        <br><span class="error">
                            {{ $this->errors->get("max_email")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_email" type="number" name="max_email" value="{{ config('user/auth/email/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_password">Minimum password length:</label>
                    @if ($this->errors->has("min_password")):
                        <br><span class="error">
                            {{ $this->errors->get("min_password")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_password" type="number" name="min_password" value="{{ config('user/auth/password/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_password">Maximum password length:</label>
                    @if ($this->errors->has("max_password")):
                        <br><span class="error">
                            {{ $this->errors->get("max_password")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_password" type="number" name="max_password" value="{{ config('user/auth/password/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_username">Minimum username length:</label>
                    @if ($this->errors->has("min_username")):
                        <br><span class="error">
                            {{ $this->errors->get("min_username")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_username" type="number" name="min_username" value="{{ config('user/auth/username/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_username">Maximum username length:</label>
                    @if ($this->errors->has("max_username")):
                        <br><span class="error">
                            {{ $this->errors->get("max_username")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_username" type="number" name="max_username" value="{{ config('user/auth/username/length/max') }}">
                </dd>
            </dl>

        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="authentication_settings_token" value="{{ token('authentication_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot