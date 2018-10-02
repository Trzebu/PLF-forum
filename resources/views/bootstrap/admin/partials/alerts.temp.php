@if ($this->exists('alert_success')):
    <div class="alert success">
        {{ $this->flash('alert_success') }}
    </div>
@endif

@if ($this->exists('alert_error')):
    <div class="alert error">
        {{ $this->flash('alert_error') }}
    </div>
@endif

@if ($this->exists('alert_info')):
    <div class="alert info">
        {{ $this->flash('alert_info') }}
    </div>
@endif