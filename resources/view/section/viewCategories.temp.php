@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <table class="table">

        <thead class="w-100">
            <th style="width: 70%;">
                @if ($this->categories !== null):
                    {{ $this->section_details->name }}
                    <p class="small-grey-text">{{ $this->section_details->description }}</p>
                @else
                    This section does not exist, yet...
                @endif
            </th>
            <th class="w-10">Topics</th>
            <th class="w-10">Posts</th>
            <th class="w-10">Last post</th>
        </thead>

        @if ($this->categories !== null):
            @foreach ($this->categories as $category):

                <tr class="w-100">
                    <td style="width: 70%; padding-left: 25px">
                        <a href="">{{ $category->name }}</a>
                        <p class="small-grey-text">{{ $category->description }}</p>
                    </td>
                    <td class="w-10">0</td>
                    <td class="w-10">0</td>
                    <td class="w-10"><a href="">-</a></td>
                </tr>
                            
            @endforeach
        @else
            <tr class="w-100">
                <td>
                    <p class="small-grey-text">This section does not exist, yet...</p>
                </td>
            </tr>
        @endif

    </table>

</div>

@include partials/footer
