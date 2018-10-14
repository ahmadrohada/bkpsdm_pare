@extends('admin.layouts.dashboard')

@section('template_title')
	 Add 
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				<!-- {{ Lang::get('pages.dashboard-welcome',['username' => Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)] ) }} -->
				Add Pegawai
			</h1>

			

	    </section>
	    <section class="content">

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
              @include('admin.modules.add_user-image-box')
            </div>
          <div class="col-lg-7 col-md-7 col-sm-12">
              @include('admin.modules.profile-pegawai')
          </div>
        </div>

	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('admin.structure.dashboard-scripts')

@endsection