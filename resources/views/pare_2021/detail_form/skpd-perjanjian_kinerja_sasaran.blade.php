<div class="box box-primary">

	<div class="box-header with-border">
		<h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary"> DETAIL SASARAN PERJANJIAN KINERJA</span>
			</small>
		</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="no-padding col-md-12"  >
			<div class="form-horizontal panel-info col-md-6 ">
						
				
								
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4">
						<label>Periode</label>
					</div>
					<div class="col-md-8">
						{{ $sasaran_perjanjian_kinerja->perjanjian_kinerja->periode_tahunan->label }}
					</div>
				</div>
				
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4">
						<label>Label Sasaran</label>
					</div>
					<div class="col-md-8">
                    {{ $sasaran_perjanjian_kinerja->sasaran->label }}
					</div>
				</div>
				
				
			</div>
		</div>	

	</div>
</div>