@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Welcome {{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Show Users <small> {{ Lang::get('pages.dashboard-access-level',['access' => $access] ) }} </small>
			</h1>

			{!! Breadcrumbs::render('users') !!}

	    </section>
	    <section class="content">

			<!-- @include('pare_pns.modules.users-snapshots-boxes') -->
 			@include('pare_pns.modules.users-list-datatable')
			@include('pare_pns.modals.confirm-delete')

	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

	<script type="text/javascript">
		$(function () {
			$('#user_table').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
    </script>

@endsection