@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>System registry</h1>
    <p class="grey-text">Here is where located all forum system registry. This options should be used only by developers!</p>
    <table class="table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Permissions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->registry as $reg):
                <tr>
                    <td>{{ $reg->registry_name }}</td>
                    <td>{{ $reg->type }}</td>
                    <td>{{ $reg->value }}</td>
                    <td>{{ $reg->mode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include admin/partials/bot