<div class="box box-primary">

	<div class="box-header with-border">
		<h3 class="box-title">
			<small>
				<i class="fa  fa-calendar-check-o "></i>
				<span class="text-primary"> DETAIL PERJANJIAN KINERJA</span>
			</small>
		</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="no-padding col-md-12"  >
			<div class="form-horizontal panel-info col-md-8 ">
						
				
								
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4">
						<label>Periode</label>
					</div>
					<div class="col-md-8">
						{{ $perjanjian_kinerja->periode_tahunan->label }}
					</div>
				</div>


				@if ( $sasaran != null)
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4">
						<label>Sasaran</label>
					</div>
					<div class="col-md-8">
						{{ $sasaran->sasaran->label }}
					</div>
				</div>
				@endif

				@if ( $indikator_sasaran != null)
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4">
						<label>Indikator Sasaran</label>
					</div>
					<div class="col-md-8">
						{{ $indikator_sasaran->label }}
					</div>
				</div>
				@endif
				
				
			</div>
		</div>	

	</div>
</div>