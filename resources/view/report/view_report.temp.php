@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <div class="col border-bottom text-center">
        <h5>View report #{{ $this->data->id }} by {{ $this->user->username($this->data->user_id) }}.</h5>
    </div>

</div>

@include partials/footer