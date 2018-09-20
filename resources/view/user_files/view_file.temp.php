@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    @if ($this->data !== null):

        <div class="col border-bottom text-center">
            <div class="media mt-10">
                <img class="img-fluid mx-auto d-block" src="{{ $this->file->isValidImage($this->data->path) ? route('/') . Libs\Config::get('upload_dir') . $this->data->path : '' }}">
            </div>
            <p>{{ $this->data->path }}</p>
        </div>

        <div class="col">
            <p class="small-grey-text">Owner: <a href="{{ route('profile.index_by_id', ['id' => $this->data->user_id]) }}">{{ $this->user->username($this->data->user_id) }}</a></p>
            <p class="small-grey-text">File ID: <b>{{ $this->data->id }}</b></p>
            <p class="small-grey-text">File name: <b>{{ $this->data->original_name }}</b></p>
            <p class="small-grey-text">File path: <a href="{{ route('/') . Libs\Config::get('upload_dir') . $this->data->path }}"><b>{{ $this->data->path }}</b></a></p>
            <p class="small-grey-text">File extension: <b>{{ pathinfo($this->data->path, PATHINFO_EXTENSION) }}</b></p>
            <p class="small-grey-text">File size: <b>{{ Libs\Tools\HumanFileSize::get($this->data->size) }}</b></p>
            <p class="small-grey-text">Uploaded at: <b>{{ $this->file->dateTimeAlphaMonth($this->data->created_at) }}</b></p>
        </div>

    @else
        <h4>This file doesn't exists.</h4>
    @endif

</div>

@include partials/footer
