@include admin/partials/top
@include admin/forums/navigation

<div class="main">
    
    <h1>New forum :: {{ $this->name }}</h1>
    <p class="grey-text">Here you can create new forum.</p>    

    <form method="" action="">

        <div class="fieldset">
            <div class="legend">Forum settings</div>
            <dl>
                <dt>
                    <label for="parent">Parent forum</label>
                    @if ($this->errors->has("parent")):
                        <br><span class="error">
                            {{ $this->errors->get("parent")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="parent" name="parent">
                        <option value="0">No parent</option>
                        @foreach ($this->section->getSections() as $section):
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="forum_name">Forum name:</label>
                    @if ($this->errors->has("forum_name")):
                        <br><span class="error">
                            {{ $this->errors->get("forum_name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="forum_name" type="text" name="forum_name">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="forum_description">Forum description:</label>
                    <br>
                    <span>Any HTML markup entered here will be displayed as is.</span>
                    @if ($this->errors->has("forum_description")):
                        <br><span class="error">
                            {{ $this->errors->get("forum_description")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <textarea id="forum_description" name="forum_description" style="width:300px;height:150px;"></textarea>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="password">Forum password:</label>
                    <br><span>Defines a password for this forum, use the permission system in preference.</span>
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
                    <label for="password_again">Password again:</label>
                    <br><span>Only needs to be set if a forum password is entered.</span>
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