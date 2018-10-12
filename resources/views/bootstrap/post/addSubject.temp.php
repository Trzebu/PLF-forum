@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <h4>Create new thread in {{ $this->sectionName }}/{{ $this->section->name }}</h4>

    <form method="post" action="{{ route('post.add_subject_to_category_send', ['categoryId' => $this->section->id]) }}">

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control {{ $this->errors->has('title') ? 'is-invalid' : '' }} w-100" placeholder="Type something..." value="{{ Libs\Http\Request::old('title') }}">
            @if ($this->errors->has("title")):
                <div class="invalid-feedback">
                    {{ $this->errors->get("title")->first() }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="post">Your contents:</label>
            @if (config("posting/smilies")):
                @include partials/smilies_block
            @endif
            @if (config("posting/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
    </form>

</div>

@include partials/footer