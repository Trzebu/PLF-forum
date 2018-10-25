@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <div class="col border-bottom text-center">
        <h5>Report #{{ $this->data->id }}.</h5>
    </div>

    <div class="col border-bottom">
        <p class="small-grey-text">Report ID: <b>{{ $this->data->id }}</b></p>
        <p class="small-grey-text">Report status: <b>{{ trans("report.statuses." . $this->data->status) }}</b></p>
        <p class="small-grey-text">Contents type: <b>{{ $this->data->content_type }}</b></p>
        <p class="small-grey-text">Content reported at: <b>{{ $this->user->dateTimeAlphaMonth($this->data->created_at) }}</b></p>
        <p class="small-grey-text">Last case update: <b>{{ $this->data->created_at == $this->data->updated_at ? "No updated." : $this->user->dateTimeAlphaMonth($this->data->updated_at) }}</b></p>
        <p class="small-grey-text">Link to reported contents: <a target="_blank" href="{{ $this->link }}">{{ $this->link }}</a></p>
    </div>

    <div class="col border-bottom">
        <center><h5>Conversation with moderator:</h5></center>
        <div class="border-bottom border-top">
            @for ($i = 0; $i < count($this->conversation); $i++):
                <div class="col">
                    <b>#{{ $i }} {{ $this->user->username($this->conversation[$i]->user_id) }}:</b>
                    <div class="col">
                        {? $content = $this->conversation[$i]->reason ?}
            
                        @if (config("report/case/response/contents/bbcode")):
                            {? $this->bb->parse($content, false) ?}
                            {? $content = $this->bb->getHtml() ?}
                        @endif

                        @if (config("report/case/response/contents/smilies")):
                            {? $content = Libs\Smilies::parse($content) ?}
                        @endif

                        {{ $content }}
                    </div>
                </div>
            @endfor
        </div>

        @if ($this->data->status == 0 || $this->data->status == 1 || $this->data->status == 2 || $this->data->status == 3):
            <form method="post" action="{{ route('report.send_response', ['id' => $this->data->id]) }}">
                <div class="form-group">
                    <label for="post"><b>More questions for {{ $this->user->username($this->data->mod_id) }}:</b></label>
                    @if (config("report/case/response/contents/smilies")):
                        @include partials/smilies_block
                    @endif
                    @if (config("report/case/response/contents/bbcode")):
                        @include partials/post_bbcode_block
                    @else
                        @include partials/post_default_block
                    @endif
                </div>
                <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
                <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
            </form>
        @else
            <h5>This case is close.</h5>
            @if ($this->data->status == 4 || $this->data->status == 5):
                <a href="{{ route('report.reconsideration', ['id' => $this->data->id, 'token' => $this->token->generate('url_token')]) }}" class="btn btn-info btn-lg w-100 mb-10">Ask for reconsideration!</a>
            @endif
        @endif
    </div>
</div>

@include partials/footer