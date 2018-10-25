@include admin/partials/top
@include admin/forums/navigation

<div class="main">
    
    <h1>Forums general settings</h1>
    <p class="grey-text">Here is where you can change general forums settings.</p>

    <form method="post" action="{{ route('admin.forums.settings.set') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            <dl>
                <dt>
                    <label for="threads_per_page">Threadas per page:</label>
                    <br>
                    <span>Here you can set how many threads will be showed per one page in category view.</span>
                    @if ($this->errors->has("threads_per_page")):
                        <br><span class="error">
                            {{ $this->errors->get("threads_per_page")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="threads_per_page" type="number" name="threads_per_page" value="{{ config('category/view/post/per_page') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="posts_per_page">Posts per page:</label>
                    <br>
                    <span>Here you can set how many posts will be showed per one page in thread view.</span>
                    @if ($this->errors->has("posts_per_page")):
                        <br><span class="error">
                            {{ $this->errors->get("posts_per_page")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="posts_per_page" type="number" name="posts_per_page" value="{{ config('post/answers/per_page') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_votes_per_page">Max votes per post:</label>
                    <br>
                    <span>Here you can set maximum votes can be given to one post.</span>
                    @if ($this->errors->has("max_votes_per_page")):
                        <br><span class="error">
                            {{ $this->errors->get("max_votes_per_page")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_votes_per_page" type="number" name="max_votes_per_page" value="{{ config('posting/voting/max_votes_per_post') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_votes_per_page">Min votes per post:</label>
                    <br>
                    <span>Here you can set minimum votes can be given to one post.</span>
                    @if ($this->errors->has("min_votes_per_page")):
                        <br><span class="error">
                            {{ $this->errors->get("min_votes_per_page")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_votes_per_page" type="number" name="min_votes_per_page" value="{{ config('posting/voting/min_votes_per_post') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="forums_settings_token" value="{{ token('forums_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot