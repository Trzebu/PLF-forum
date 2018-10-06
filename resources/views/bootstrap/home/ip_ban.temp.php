@include partials/top

@if ($this->data !== null):
    
    <div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
        <div class="text-danger">
            <h1>Your IP has been banned by board administrator!</h1>
            Banned at: {{ $this->user->dateTimeAlphaMonth($this->data->created_at) }}<br>
            Your IP: {{ Libs\Http\Request::clientIP() }}
            <p>
                Reason:<br>{{ $this->data->reason }}
            </p>
            <p class="small-grey-text">
                If you think that this is mistake, contact with board administrator: <a href="mailto:{{ Libs\Config::get('page/contact/administrator') }}">{{ Libs\Config::get('page/contact/administrator') }}</a>
            </p>
        </div>

    </div>

@else
    Something wrong happened... Try again later.
@endif

@include partials/footer
