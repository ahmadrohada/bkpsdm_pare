

@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	<link rel="stylesheet" href="../assets/css/bootstrap-treeview.min.css">

<style>
#treeview-searchable .node-disabled {
    display: none;
}

.node-treeview-searchable{
	font-size:9pt;
}

.dropdown-menu{
	border-color:#2cd7e4;
}

.dropdown-menu > li > a {
    color: #000;
}

.dropdown-menu > li > a:hover {
    background-color: #00acd6;
    color: #fff;
}
.form-horizontal .control-label{
text-align:left;
}
@media (max-width: 768px) {
    .affix {
        position: static;
		min-width:100%
    }
}

</style>

	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Peta Jabatan
			</h1>

			{!! Breadcrumbs::render('peta_jabatan') !!}

	    </section>
	    <section class="content">
			
			
			@include('admin.modules.peta-jabatan-list')
			
			
	    </section>
	</div>
@endsection


