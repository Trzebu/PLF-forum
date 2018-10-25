@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>Permissions group</h1>
    <p class="grey-text">Here is where you can view, add or edit existing permissions group.</p>
    <a href="{{ route('admin.permissions.groups.new') }}">Create new group.</a>

    <table class="table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->permissions->getRank() as $rank):
                <tr>
                    <td>{{ $rank->name }}</td>
                    <td>
                        <a href="{{ route('admin.permissions.groups.view', ['id' => $rank->id]) }}">
                            <i class="fas fa-cogs i_green"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@include admin/partials/bot