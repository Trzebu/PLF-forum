@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

    <h4>Create new thread.</h4>

    <form method="post" action="{{ route('post.add_subject.send') }}">

        <div class="form-group">
            <label for="category">{{ trans("general.category") }}:</label>
            <select name="category" id="category" class="form-control w-100">
                <option selected>{{ trans("buttons.choose") }}...</option>
                @foreach ($this->section->getAllCategories() as $category):
                    @if ($category->status != 0 && !$this->section->checkPermissions($category->id)):
                        {? continue; ?}
                    @endif
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">{{ trans("general.subject") }}:</label>
            <input id="title" type="text" name="title" class="form-control {{ $this->errors->has('title') ? 'is-invalid' : '' }} w-100" placeholder="Type something..." value="{{ Libs\Http\Request::old('title') }}">
            @if ($this->errors->has("title")):
                <div class="invalid-feedback">
                    {{ $this->errors->get("title")->first() }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="post">{{ trans("general.contents") }}:</label>
            @if (Libs\Config::get("posting/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="{{ trans('buttons.send') }}">

        @if ($this->section->checkPermissions($category->id)):
            <label>{{ trans('buttons.settings') }}:</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="lock"> {{ trans("general.lock_topic") }}
                </label>
            </div>
            <label><b>Post topic as:</b></label>
            <div class="radio">
                <label>
                    <input type="radio" name="type" checked="checked" value="0"> {{ trans("general.normal") }}
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="type"  value="1"> {{ trans("general.sticky") }}
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="type"  value="2"> {{ trans("general.global") }}
                </label>
            </div>
            <div class="form-group">
                <label for="subject_color">{{ trans("general.subject_color") }}:</label>
                <input id="subject_color" type="text" name="subject_color" class="form-control {{ $this->errors->has('subject_color') ? 'is-invalid' : '' }} w-100" value="blue">
                @if ($this->errors->has("subject_color")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("subject_color")->first() }}
                    </div>
                @endif
            </div>
        @endif

    </form>

</div>

@include partials/footer