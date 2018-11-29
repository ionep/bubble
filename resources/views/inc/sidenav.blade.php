<div class="sidenav">
    <h2>Consumption Monitor</h2>
    <hr>
    <a href="/dashboard">Dashboard</a>
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</div>