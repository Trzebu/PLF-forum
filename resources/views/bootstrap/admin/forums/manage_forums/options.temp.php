@include admin/partials/top
@include admin/forums/navigation

<div class="main">
    
    <h1>
        {{ trans("acp.edit_forum") }} :: {{ $this->data->name }} {{ !is_null($this->data->parent) ? trans("general.in_section") . $this->section->getSection($this->data->parent)->name : "" }}
    </h1>
    <p class="grey-text">{{ trans("acp.edit_forum_description") }}.</p>    

    <div class="fieldset">
        <div class="legend">Moving</div>
        
        <form method="post" action="{{ route('admin.forums.manage_forums.options.move.categories', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="new_category">Categories to other section:</label>
                    <br><span>This option will move all categories from this section to other section.</span>
                    @if ($this->errors->has("parent")):
                        <br><span class="error">
                            {{ $this->errors->get("parent")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="new_category" name="new_category">
                        @foreach ($this->section->getSections() as $section):
                            @if ($this->data->id == $section->id || $this->data->parent == $section->id):
                                {? continue ?}
                            @endif
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </dd>
                <dd>
                    <input type="hidden" name="move_categories_token" value="{{ token('move_categories_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.move') }}">
                </dd>
            </dl>
        </form>

        @if (!is_null($this->data->parent)):
            <form method="post" action="{{ route('admin.forums.manage_forums.options.move.posts', ['id' => $this->data->id]) }}">
                <dl>
                    <dt>
                        <label for="move_posts">Posts to other category:</label>
                        <br><span>This option will move all posts from this category to other category.</span>
                        @if ($this->errors->has("move_posts")):
                            <br><span class="error">
                                {{ $this->errors->get("move_posts")->first() }}
                            </span>
                        @endif
                    </dt>
                    <dd>
                        <select id="move_posts" name="move_posts">
                            @foreach ($this->section->getAllCategories() as $category):
                                @if ($this->data->id == $category->id):
                                    {? continue ?}
                                @endif
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dd>
                        <input type="hidden" name="move_posts_token" value="{{ token('move_posts_token') }}">
                        <input type="submit" class="button" value="{{ trans('buttons.move') }}">
                    </dd>
                </dl>
            </form>
        @endif

    </div>

    <div class="fieldset">
        <div class="legend">Delete</div>
        <dl>
            <dt>
                <label for="parent">{{ is_null($this->data->parent) ? "Delete categories from this section" : "Delete posts from this category" }}:</label>
                <br><span>{{ is_null($this->data->parent) ? "This option will delete all categories from this section!" : "This option will delete all posts from this category!" }}</span>
                @if ($this->errors->has("parent")):
                    <br><span class="error">
                        {{ $this->errors->get("parent")->first() }}
                    </span>
                @endif
            </dt>
            <dd>
                @if (is_null($this->data->parent)):
                    <a href="{{ route('admin.forums.manage_forums.options.delete.categories', ['id' => $this->data->id, 'token' => token('delete_categories_section_token')]) }}">Delete</a>
                @else
                    <a href="{{ route('admin.forums.manage_forums.options.delete.posts', ['id' => $this->data->id, 'token' => token('delete_posts_category_token')]) }}">Delete</a>
                @endif
            </dd>
        </dl>

        <dl>
            <dt>
                <label for="parent">{{ is_null($this->data->parent) ? "Delete this section" : "Delete this category" }}:</label>
                @if ($this->errors->has("parent")):
                    <br><span class="error">
                        {{ $this->errors->get("parent")->first() }}
                    </span>
                @endif
            </dt>
            <dd>
                @if (is_null($this->data->parent)):
                    <a href="{{ route('admin.forums.delete.section', ['id' => $this->data->id, 'token' => token('delete_section_token')]) }}">Delete</a>
                @else
                    <a href="{{ route('admin.forums.delete.category', ['id' => $this->data->id, 'token' => token('delete_category_token')]) }}">Delete</a>
                @endif
            </dd>
        </dl>
    </div>

    <form method="post" action="{{ route('admin.forums.manage_forums.options.save', ['id' => $this->data->id]) }}">

        <div class="fieldset">
            <div class="legend">{{ trans("general.forum_settings") }}</div>
            @if (!is_null($this->data->parent)):
                <dl>
                    <dt>
                        <label for="parent">{{ trans("acp.parent_forum") }}:</label>
                        @if ($this->errors->has("parent")):
                            <br><span class="error">
                                {{ $this->errors->get("parent")->first() }}
                            </span>
                        @endif
                    </dt>
                    <dd>
                        <select id="parent" name="parent">
                            <option value="0">{{ trans("acp.no_parent") }}</option>
                            @foreach ($this->section->getSections() as $section):
                                @if ($this->data->parent == $section->id):
                                    <option value="{{ $section->id }}" selected>{{ $section->name }}</option>
                                @else
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </dd>
                </dl>
            @endif
            <dl>
                <dt>
                    <label for="name">{{ trans("general.forum_name") }}:</label>
                    @if ($this->errors->has("name")):
                        <br><span class="error">
                            {{ $this->errors->get("name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="name" type="text" name="name" value="{{ $this->data->name }}">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="forum_description">{{ trans('general.forum_description') }}:</label>
                    <br>
                    <span>{{ trans("acp.forum_description") }}</span>
                    @if ($this->errors->has("forum_description")):
                        <br><span class="error">
                            {{ $this->errors->get("forum_description")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <textarea id="forum_description" name="forum_description" style="width:300px;height:150px;">{{ $this->data->description }}</textarea>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="password">{{ trans("general.forum_password") }}:</label>
                    <br><span>{{ trans("acp.forum_password") }}</span>
                    @if ($this->errors->has("password")):
                        <br><span class="error">
                            {{ $this->errors->get("password")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="password" type="password" name="password">
                </dd>
                <dd>
                    <a href="{{ route('admin.forums.manage_forums.options.reset_password', ['id' => $this->data->id, 'token' => token('reset_password_token')]) }}">{{ trans("buttons.reset_password") }}</a>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="password_again">{{ trans("auth.password_again") }}:</label>
                    <br><span>{{ trans("acp.forum_password_again") }}</span>
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

        <div class="fieldset">
            <div class="legend">{{ trans("general.forum_settings_generel") }}</div>
            <dl>
                <dt>
                    <label for="status">Status</label>
                    @if ($this->errors->has("status")):
                        <br><span class="error">
                            {{ $this->errors->get("status")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="status" name="status">
                        @foreach (trans("acp.forum_status") as $key => $value):
                            @if ($key == $this->data->status):
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="url_name">URL name:</label>
                    <br><span>This name will viewed in URL address. If you set nothing here this will be created automatically.</span>
                    @if ($this->errors->has("url_name")):
                        <br><span class="error">
                            {{ $this->errors->get("url_name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="url_name" type="text" name="url_name" value="{{ $this->data->url_name }}">
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans("general.permissions") }}</div>
            @foreach ($this->permissions->translated() as $key => $value):
                <dl>
                    <dt>
                        <label for="">{{ $value }}</label>
                    </dt>
                    @if (in_array($key, $this->forum_permissions)):
                        <dd>
                            <label>
                                <input type="radio" name="permissions[{{ $key }}]" class="radio" value="1" checked="checked">
                                {{ trans('buttons.yes') }}
                            </label>
                            <label>
                                <input type="radio" name="permissions[{{ $key }}]" class="radio" value="0">
                                {{ trans('buttons.no') }}
                            </label>
                        </dd>
                    @else
                        <dd>
                            <label>
                                <input type="radio" name="permissions[{{ $key }}]" class="radio" value="1">
                                {{ trans('buttons.yes') }}
                            </label>
                            <label>
                                <input type="radio" name="permissions[{{ $key }}]" class="radio" value="0" checked="checked">
                                {{ trans('buttons.no') }}
                            </label>
                        </dd>
                    @endif
                </dl>
            @endforeach
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans('buttons.create') }}</div>
            <p class="buttons">
                <input type="hidden" name="edit_forum_token" value="{{ $this->token->generate('edit_forum_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.change') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>

    </form>
</div>

@include admin/partials/bot