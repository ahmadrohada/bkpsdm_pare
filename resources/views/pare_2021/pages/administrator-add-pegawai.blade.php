@extends('pare_pns.layouts.dashboard')

@section('template_title')
	 Add ASN
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Add Pegawai
			</h1>
	    </section>
	    <section class="content">

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
              @include('pare_pns.modules.add_user-image-box')
            </div>
          <div class="col-lg-7 col-md-7 col-sm-12">
              @include('pare_pns.modules.profile-pegawai')
          </div>
        </div>

	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

@endsection