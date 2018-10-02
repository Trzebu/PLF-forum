@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>System registry</h1>
    <p class="grey-text">Here is where located all forum system registry. This options should be used only by developers!</p>
    <h1>Create new system registry</h1>
    <a href="{{ route('admin.general_settings.system_registry.new') }}">Add new registry</a>
    <table class="table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Reading</th>
                <th>Editing value</th>
                <th>Editing registry</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->registry as $reg):
                <tr>
                    <td>{{ $reg->registry_name }}</td>
                    <td>{{ trans('acp.registry_types.' . $reg->type) }}</td>
                    <td>{{ $reg->value }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "reading") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "edit_value") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "edit_reg") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include admin/partials/bot