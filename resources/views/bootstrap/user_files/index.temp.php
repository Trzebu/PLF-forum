@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <form action="{{ route('user_files.upload_new') }}" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" accept="" class="custom-file-input {{ $this->errors->has('file') ? 'is-invalid' : '' }}" name="file" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">{{ $this->translate->get('buttons.choose_file') }}</label>
            </div>
        </div>
        @if ($this->errors->has("file")):
            <p class="text-danger">{{ $this->errors->get("file")->first() }}</p>
        @endif
        <input type="hidden" name="upload_file_token" value="{{ $this->token->generate('upload_file_token') }}">
        <div class="form-group">
            <button type="submit" class="btn btn-success mx-auto d-block w-100">{{ trans('buttons.upload') }}!</button>
        </div>
    </form>

    @if ($this->files !== null):

        <table class="table border-bottom">

            <thead>
                <th>ID</th>
                <th>File name</th>
                <th>Original name</th>
                <th>Size</th>
                <th>Extension</th>
                <th>Uploaded at</th>
                <th>Manage</th>
            </thead>

            <tbody>
                @foreach ($this->files as $file):
                    <tr>
                        <td>{{ $file->id }}</td>
                        <td><a href="{{ route('/') . Libs\Config::get('uploading/upload_dir') . $file->path }}">{{ $file->path }}</a></td>
                        <td>{{ $file->original_name }}</td>
                        <td>{{ Libs\Tools\HumanFileSize::get($file->size, true) }}</td>
                        <td>{{ pathinfo($file->path, PATHINFO_EXTENSION) }}</td>
                        <td>{{ $this->file->dateTimeAlphaMonth($file->created_at, true) }}</td>
                        <td><a href="{{ route('user_files.view_file', ['fileId' => $file->id]) }}">Manage</a></td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <center>{{ $this->file->paginateRender() }}</center>
    @else
        <h4>You don't have uploaded files!</h4>
    @endif

</div>

@include partials/footer
