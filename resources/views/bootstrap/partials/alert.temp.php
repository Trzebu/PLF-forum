@if ($this->exists("alert_info")):
    <div class="alert alert-primary" role="alert">
        {{ $this->flash("alert_info") }}
    </div>
@endif

@if ($this->exists("alert_success")):
    <div class="alert alert-success" role="alert">
        {{ $this->flash("alert_success") }}
    </div>
@endif

@if ($this->exists("alert_error")):
    <div class="alert alert-danger" role="alert">
        {{ $this->flash("alert_error") }}
    </div>
@endif