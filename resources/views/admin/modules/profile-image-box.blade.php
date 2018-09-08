{{-- Profile Image Box --}}
<div class="box box-primary">
    <div class="box-body box-profile">

        {!! HTML::show_gravatar($user->nip,'','profile-user-img img-responsive img-circle') !!}

        <h3 class="profile-username text-center">
        	{{ $user->nama }} {{ $user->nama }}
        </h3>

        <p class="text-muted text-center">
        	{{ $user->nama}}
        </p>

    </div>
</div>