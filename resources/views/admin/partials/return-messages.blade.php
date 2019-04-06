@if (session('status'))
	<div class="alert alert-success alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h4><i class="icon fa fa-check"></i> Success</h4>
		{{ session('status') }}
	</div>
@endif

@if (session('anError'))
	<div class="alert alert-danger alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h5>
			<i class="icon fa fa-warning"></i>
			Success Logout
		</h5>
		
	</div>
@endif

@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<h5>
			<i class="icon fa fa-warning"></i>
			Gagal
		</h5>
		
	</div>
@endif