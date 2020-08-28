<header class="main-header ">
    {{-- UPPER LEFT LOGO --}}
    <a href="/home" class="logo">
        <span class="logo-mini">
			<img src="{{asset('assets/images/form/logo.png')}}" style="height:30px;" >
		</span>
        <span class="logo-lg">
			<strong>PARE</strong>
		</span>
    </a>
    {{-- LOAD TEMPLATE NAVIGATION --}}
    @include('pare_pns.partials.dashboard-nav')
</header>