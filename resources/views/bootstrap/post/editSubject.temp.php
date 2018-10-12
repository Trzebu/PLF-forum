@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

    <h4>Create new thread.</h4>

    <form method="post" action="{{ $this->route }}">

        <div class="form-group">
            <label for="title">{{ trans("general.subject") }}:</label>
            <input id="title" type="text" name="title" class="form-control {{ $this->errors->has('title') ? 'is-invalid' : '' }} w-100" placeholder="Type something..." value="{{ Libs\Http\Request::old('title') ? Libs\Http\Request::old('title') : $this->post->subject }}">
            @if ($this->errors->has("title")):
                <div class="invalid-feedback">
                    {{ $this->errors->get("title")->first() }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="post">{{ trans("general.contents") }}:</label>
            {? $textareaContent = Libs\Http\Request::old('title') ? Libs\Http\Request::old('title') : $this->post->contents  ?}
            @if (config("posting/smilies")):
                @include partials/smilies_block
            @endif
            @if (config("posting/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="post_edit_token" value="{{ token('post_edit_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="{{ trans('buttons.send') }}">

        @if ($this->post->status == 0 || $this->section->checkPermissions($this->post->category)):
            <label>{{ trans('buttons.settings') }}:</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="lock" {{ $this->post->status == 0 ?: 'checked="checked"' }}> {{ trans("general.lock_topic") }}
                </label>
            </div>
        @endif
        @if ($this->section->checkPermissions($this->post->category)):
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
            <div class="form-group">
                <label for="subject_color">{{ trans("general.subject_color") }}:</label>
                <input id="subject_color" type="text" name="subject_color" class="form-control {{ $this->errors->has('subject_color') ? 'is-invalid' : '' }} w-100" value="{{ $this->post->subject_color }}">
                @if ($this->errors->has("subject_color")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("subject_color")->first() }}
                    </div>
                @endif
            </div>
        @endif

    </form>

    @if ($this->section->checkPermissions($this->post->category)):
        <form method="post" action="{{ route('post.move_to', ['postId' => $this->post->id]) }}">
            <div class="form-group">
                <label for="move_to">Move to:</label>
                <select class="form-control" name="category">
                    @foreach ($this->categories as $category):
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="move_to_token" value="{{ $this->token->generate('move_to_token') }}">
                <input type="submit" class="btn btn-success w-100" name="" value="Move">
            </div>
        </form>
    @endif

</div>

@include partials/footer