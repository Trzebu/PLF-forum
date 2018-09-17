@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <div class="col-12 row">
        <div class="col-3">
            <p>Threads:</p>
            @if (count($this->threads) > 0):
                @foreach ($this->threads as $thread):
                    <div class="col">
                        {{ $this->user->username($thread) }}
                    </div>
                @endforeach
            @else
                <p class="small-grey-text">You have no threads.</p>
            @endif
        </div>
        <div class="col-9">
            Select thread
        </div>
    </div>

</div>

@include partials/footer
