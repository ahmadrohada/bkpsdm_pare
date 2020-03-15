{{-- @if (session('status'))
	<div class="alert alert-success alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h5><i class="icon fa fa-check"></i> Success</h5>
		
	</div>
@endif --}}

{{-- @if (session('anError'))
	<div class="alert alert-danger alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h5>
			<i class="icon fa fa-warning"></i>
			Success
		</h5>
		{{ session('anError') }}
	</div>
@endif --}}

@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h5>
			<i class="icon fa fa-warning"></i>
			Gagal
		</h5>
		
	</div>
@endif


