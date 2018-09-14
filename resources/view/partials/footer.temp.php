        </div>
        <footer class="footer navbar w-100 mt-10">
            <div class="container">
                <h4>Stats:</h4>
            </div>
            <div class="container" style="justify-content: left">
                <div class="col">
                    <h5>Posts:</h5>
                    Threads amount: {{ App\Models\Stats::threads() }}<br>
                    Posts amount: {{ App\Models\Stats::posts() }}<br>
                    Given votes: {{ App\Models\Stats::votes() }}
                </div>
                <div class="col">
                    <h5>Users:</h5>
                    Registered accounts: {{ App\Models\Stats::accounts() }}<br>
                    Online: 0<br>
                </div>
                <div class="col">
                    <h5>Last registered account:</h5>

                    @foreach (App\Models\Stats::lastRegistered() as $user):
                        <a href="{{ route('profile.index_by_id', ['id' => $user['id']]) }}">{{ $user['username'] }}</a>
                    @endforeach

                </div>
            </div>
            <div class="container">
                <h4>Groups name:</h4>
            </div>
            <div class="container">
                {{ implode(", ", App\Models\Stats::getGroups()) }}
            </div>
            <div class="container">
                <a href="https://github.com/Trzebu">{{ date('Y') }} by Trzebu</a>
            </div>
        </footer>        
    </body>
</html>