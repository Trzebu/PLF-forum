@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>User administration</h1>
    <p class="grey-text">Here you can change your users information and certain specific options.</p>

    <form method="post" action="{{ route('admin.general_settings.manage_users.find') }}">

        <div class="fieldset">

            <div class="legend">
                Select user
            </div>

            <dl>
                <dt>
                    <label for="userID">Enter username:</label>
                    <br>
                    <span>email or ID.</span>
                    @if ($this->errors->has("userID")):
                        <br><span class="error">
                            {{ $this->errors->get("userID")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="userID" type="text" name="userID">
                </dd>
            </dl>

            <p class="buttons">
                <input type="submit" class="button" value="{{ trans('buttons.find') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>

    </form>

</div>

@include admin/partials/bot