@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <form method="post" action="{{ $this->route }}">
        <div class="form-group">
            <label for="post">Edit your post:</label>
            {? $textareaContent = Libs\Http\Request::old("post") ? Libs\Http\Request::old("post") : $this->post->contents ?}
            @if (config("posting/answers/smilies")):
                @include partials/smilies_block
            @endif
            @if (config("posting/answers/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
    </form>

    @if (Auth()->permissions("global_moderator")):
        <p>{{ trans("buttons.options") }}:</p>
        <p><a href="{{ $this->hideAnsRoute }}">{{ $this->post->status == 1 ? trans("buttons.restore")  : trans("buttons.hide") }}</a></p>
        <p><a href="{{ $this->deleteRoute }}">{{ trans("buttons.delete") }}</a></p>
    @endif

</div>

@include partials/footer
