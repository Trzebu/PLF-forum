@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <div class="col border-bottom text-center">
        <h5>Reports typed by your category.</h5>
    </div>

    @if ($this->reports !== null):
        <table class="table">
            <thead>
                <th>Report ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Content ID</th>
                <th>Status</th>
                <th>Action</th>
                <th>Date</th>
            </thead>
            <tbody>
                @foreach ($this->reports as $report):
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td><a href="{{ route('profile.index_by_id', ['id' => $report->user_id]) }}">{{ $this->user->username($report->user_id) }}</a></td>
                        <td>{{ $report->content_type }}</td>
                        <td>{{ $report->content_id }}</td>
                        <td>{{ trans("report.statuses." . $report->status) }}</td>
                        <td><a href="{{ route('report.view_by_id', ['id' => $report->id]) }}" class="btn btn-success">View {{ $report->id }}</a></td>
                        <td>{{ $this->user->dateTimeAlphaMonth($report->created_at, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <center>{{ $this->report->paginateRender() }}</center>
    @else
        <h5>Currently you don't have new reports to moderate.</h5>
    @endif

</div>

@include partials/footer