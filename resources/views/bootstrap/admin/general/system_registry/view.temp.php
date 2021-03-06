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
                <th>Name/Edit</th>
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
                    {? $value = substr($reg->value, 0, Libs\Config::get("acp/general_settings/system_registry/view/table/value/length/max")) ?}
                    <td><a href="{{ route('admin.general_settings.system_registry.edit', ['id' => $reg->id]) }}">{{ $reg->registry_name }}</a></td>
                    <td>{{ trans('acp.registry_types.' . $reg->type) }}</td>
                    <td>{{ strlen($value) > 9 ? $value . "..." : $value }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "reading") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "edit_value") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                    <td>{{ $this->reg->permissions($reg->mode, "edit_reg") ? trans('buttons.yes') : trans('buttons.no') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include admin/partials/bot