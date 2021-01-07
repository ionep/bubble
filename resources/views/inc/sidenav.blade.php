<div class="sidenav" id="sidenav">
	<img src={{url('/photos/logo.png')}}  style="width:240px;height:auto;margin-top:10px;margin-bottom:10px;">
    <h2 class="text-center">WATER CONSUMPTION MONITORING</h2>
    <hr>
    <a href="/dashboard">
        <i class="glyphicon glyphicon-dashboard"></i> &nbsp; Dashboard
    </a>
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        <i class="glyphicon glyphicon-log-out"></i> &nbsp; Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</div>