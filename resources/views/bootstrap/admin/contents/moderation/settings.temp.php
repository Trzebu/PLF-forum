@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Moderation and reporting settings</h1>
    <p class="grey-text">Here is where you can change general moderation/reporting settings.</p>

    <form method="post" action="{{ route('admin.contents.moderation') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="bbcode_case_response">BbCode block in response in case:</label>
                    <br>
                    <span>Using BbCode block in response area in cases.</span>
                    @if ($this->errors->has("bbcode_case_response")):
                        <br><span class="error">
                            {{ $this->errors->get("bbcode_case_response")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="bbcode_case_response" class="radio" value="true" {{ config('report/case/response/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="bbcode_case_response" class="radio" value="false" {{ !config('report/case/response/contents/bbcode') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="smilies_case_response">Smilies block in response in case:</label>
                    <br>
                    <span>Using smilies block in response area in cases.</span>
                    @if ($this->errors->has("smilies_case_response")):
                        <br><span class="error">
                            {{ $this->errors->get("smilies_case_response")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="smilies_case_response" class="radio" value="true" {{ config('report/case/response/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="smilies_case_response" class="radio" value="false" {{ !config('report/case/response/contents/smilies') ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_characters_response_case">Min characters in response to case:</label>
                    <br>
                    <span>Here you can set minimum characters needed to send response in case.</span>
                    @if ($this->errors->has("min_characters_response_case")):
                        <br><span class="error">
                            {{ $this->errors->get("min_characters_response_case")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_characters_response_case" type="number" name="min_characters_response_case" value="{{ config('report/case/response/contents/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_characters_response_case">Max characters in response to case:</label>
                    <br>
                    <span>Here you can set maximum allowed characters in PM.</span>
                    @if ($this->errors->has("max_characters_response_case")):
                        <br><span class="error">
                            {{ $this->errors->get("max_characters_response_case")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_characters_response_case" type="number" name="max_characters_response_case" value="{{ config('report/case/response/contents/length/max') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_characters_report">Min characters in reporting contents:</label>
                    <br>
                    <span>Here you can set minimum characters needed to send report.</span>
                    @if ($this->errors->has("min_characters_report")):
                        <br><span class="error">
                            {{ $this->errors->get("min_characters_report")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_characters_report" type="number" name="min_characters_report" value="{{ config('report/report_contents/contents/length/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_characters_report">Max characters in report:</label>
                    <br>
                    <span>Here you can set maximum allowed characters in reported contents.</span>
                    @if ($this->errors->has("max_characters_report")):
                        <br><span class="error">
                            {{ $this->errors->get("max_characters_report")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_characters_report" type="number" name="max_characters_report" value="{{ config('report/report_contents/contents/length/max') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="moderation_settings_token" value="{{ token('moderation_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot