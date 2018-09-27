@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <div class="col border-bottom text-center">
        <h5>View report #{{ $this->data->id }} by {{ $this->user->username($this->data->user_id) }}.</h5>
    </div>

    <div class="col border-bottom">
        <p class="small-grey-text">Report ID: <b>{{ $this->data->id }}</b></p>
        <p class="small-grey-text">Report status: <b>{{ trans("report.statuses." . $this->data->status) }}</b></p>
        <p class="small-grey-text">Contents type: <b>{{ $this->data->content_type }}</b></p>
        <p class="small-grey-text">Author: <a href="{{ route('profile.index_by_id', ['id' => $this->author]) }}"><b>{{ $this->user->username($this->author) }}</b></a></p>
        <p class="small-grey-text">Content reported at: <b>{{ $this->user->dateTimeAlphaMonth($this->data->created_at) }}</b></p>
        <p class="small-grey-text">Last case update: <b>{{ $this->data->created_at == $this->data->updated_at ? "No updated." : $this->user->dateTimeAlphaMonth($this->data->updated_at) }}</b></p>
        <p class="small-grey-text">Content created at: <b>{{ $this->user->dateTimeAlphaMonth($this->contentCreatedAt) }}</b></p>
        <p class="small-grey-text">Link to reported contents: <a target="_blank" href="{{ $this->link }}">{{ $this->link }}</a></p>
    </div>

    <div class="col border-bottom">
        {{ $this->contents }}
    </div>

    <div class="col border-bottom">
        <center><h5>{{ $this->user->username($this->data->user_id) }} wrote:</h5></center>
        <div class="border-bottom border-top">
            {{ $this->data->reason }}
        </div>

        <form method="post" action="sds">
            <div class="form-group">
                <label for="post"><b>More questions for {{ $this->user->username($this->data->user_id) }}:</b></label>
                <textarea name="post" id="post" class="form-control {{ $this->errors->has('post') ? 'is-invalid' : '' }} w-100 mb-10" style="height: 200px" placeholder="Type something..."></textarea>
                @if ($this->errors->has("post")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("post")->first() }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
            <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
        </form>
    </div>

    <div class="col border-bottom">
        <center><h5>Report options:</h5></center>
        <form method="post" action="{{ route('report.change_case_status', ['id' => $this->data->id]) }}">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Change case status</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="status">
                    @for ($i = 1; $i < count(trans("report.statuses")); $i++):
                        <option value="{{ $i }}">{{ trans("report.statuses." . $i) }}</option>
                    @endfor
                </select>
            </div>
            <input type="hidden" name="status_change_token" value="{{ $this->token->generate('status_change_token') }}">
            <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Change">
        </form>
        <form method="post" action="{{ route('report.forward_case', ['id' => $this->data->id]) }}">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Forward the case</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="forward">
                    @foreach ($this->user->getByPermission("moderator") as $moderator):
                        <option value="{{ $this->user->username($moderator->id) }}">{{ $this->user->username($moderator->id) }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="forward_token" value="{{ $this->token->generate('forward_token') }}">
            <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Forward">
        </form>
    </div>

</div>

@include partials/footer