@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <h4>Create personal note for {{ $this->data->username }}</h4>

    <form method="post" action="{{ route('moderation_notes.add_personal_note', ['userId' => $this->data->id]) }}">
        <div class="form-group">
            <label for="post">Your contents:</label>
            @if (config("moderation/moderation_notes/personal_notes/contents/smilies")):
                @include partials/smilies_block
            @endif
            @if (config("moderation/moderation_notes/personal_notes/contents/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="personal_note_token" value="{{ token('personal_note_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="{{ trans('buttons.add') }}">
    </form>

</div>

@include partials/footer