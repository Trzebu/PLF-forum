@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>Welcome to board settings!</h1>
    <p class="grey-text">This screen will give you a quick overview of all the various statistics of your board. The links on the left hand side of this screen allow you to control every aspect of your board experience.</p>
    <table class="table-responsive">
        <thead>
            <tr>
                <th>Statistic</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
           <tr>
               <td>Number of posts</td>
               <td>{{ App\Models\Stats::posts() }}</td>
           </tr>
           <tr>
               <td>Number of threads</td>
               <td>{{ App\Models\Stats::threads() }}</td>
           </tr>
           <tr>
               <td>Given votes</td>
               <td>{{ App\Models\Stats::votes() }}</td>
           </tr>
           <tr>
               <td>Number of users</td>
               <td>{{ App\Models\Stats::accounts() }}</td>
           </tr>
        </tbody>
    </table>
</div>

@include admin/partials/bot