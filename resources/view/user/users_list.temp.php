@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
    @if ($this->user->getUsers() !== null):
        <table class="table">
            <thead>
                <th>User name</th>
                <th>Rank</th>
            </thead>
            <tbody>

                @foreach ($this->user->getUsers() as $user):
                    <tr>
                        <td><a href="{{ route('profile.index_by_id', ['id' => $user->id]) }}">{{ $this->user->username($user->id) }}</a></td>
                        <td>{{ $this->user->permissions($user->id)->name }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <center>{{ $this->user->paginateRender() }}</center>
    @else
        <h4>Currently we heven't registered users.</h4>
    @endif
</div>

@include partials/footer
