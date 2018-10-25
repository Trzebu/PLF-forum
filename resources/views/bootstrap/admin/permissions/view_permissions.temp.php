@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>Permissions group</h1>
    <p class="grey-text">Here is where you can view, add or edit existing permission.</p>
    <a href="{{ route('admin.permissions.new') }}">Create new permission.</a>

    <table class="table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->permissions as $key => $value):
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        <a href="{{ route('admin.permissions.edit_permission', ['name' => $key]) }}">
                            <i class="fas fa-cogs i_green"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@include admin/partials/bot