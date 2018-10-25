@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    @if ($this->data !== null):

        <div class="col border-bottom text-center">
            <div class="media mt-10">
                <img class="img-fluid mx-auto d-block" src="{{ $this->file->isValidImage($this->data->path) ? route('/') . Libs\Config::get('uploading/upload_dir') . $this->data->path : route('/') . '/public/app/img/file-ico.png' }}">
            </div>
            <p>{{ $this->data->original_name }}</p>
        </div>

        <div class="col">
            <p class="small-grey-text">Owner: <a href="{{ route('profile.index_by_id', ['id' => $this->data->user_id]) }}">{{ $this->user->username($this->data->user_id) }}</a></p>
            <p class="small-grey-text">File ID: <b>{{ $this->data->id }}</b></p>
            <p class="small-grey-text">File name: <b>{{ $this->data->original_name }}</b></p>
            <p class="small-grey-text">File path: <a href="{{ route('/') . Libs\Config::get('uploading/upload_dir') . $this->data->path }}"><b>{{ route('/') . Libs\Config::get('uploading/upload_dir') . $this->data->path }}</b></a></p>
            <p class="small-grey-text">File extension: <b>{{ pathinfo($this->data->path, PATHINFO_EXTENSION) }}</b></p>
            <p class="small-grey-text">File size: <b>{{ Libs\Tools\HumanFileSize::get($this->data->size) }}</b></p>
            <p class="small-grey-text">Uploaded at: <b>{{ $this->file->dateTimeAlphaMonth($this->data->created_at) }}</b></p>
            <p class="text-danger">WARNING: This file has not been scanned for viruses.</p>
        </div>

        @if (Auth()->data()->id == $this->data->user_id || Auth()->permissions("file_managing")):
            <div class="col mb-10">
                <a href="{{ route('user_files.remove', ['fileId' => $this->data->id, 'token' => $this->token->generate('remove_token')]) }}" class="btn btn-danger">Remove this file</a>
            </div>
        @else
            <div class="col mb-10">
                <a class="btn btn-success" href="{{ route('report.contents', ['id' => $this->data->id, 'contents' => 'file', 'token' => $this->token->generate('report_token')]) }}">Report this file</a>
            </div>
        @endif
        @if (Auth()->permissions("file_uploading")):
            <div class="col mb-10">
                <a href="{{ route('user_files.duplicate', ['fileId' => $this->data->id, 'token' => $this->token->generate('duplicate')]) }}" class="btn btn-success">Duplicate this file</a>
            </div>
        @endif
        @if ($this->isValidImage):
            <div class="col mb-10">
                <a href="{{ route('user_files.set_as_avatar', ['fileId' => $this->data->id, 'token' => $this->token->generate('set_as_avatar')]) }}" class="btn btn-success">Set as avatar</a>
            </div>
        @endif

    @else
        <h4>This file doesn't exists.</h4>
    @endif

</div>

@include partials/footer
