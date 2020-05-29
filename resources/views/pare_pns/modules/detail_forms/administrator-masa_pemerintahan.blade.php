<div class="row">
	<div class="form-horizontal col-md-6">
							
		<div class="panel-default ">
			<i class="fa fa-calendar"></i>
			<span class="text-primary"> DETAIL MASA PEMERINTAHAN</span>
		</div>
					
		<div class="form-group form-group-sm" style="margin-top:10px;">
			<label class="col-md-4">Tanggal dibuat</label>
			<div class="col-md-8">
				<span id="date_created" class="form-control">{!! $mp->created_at !!}</span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Periode Masa Pemerintahan</label>
			<div class="col-md-8">
				<span id="periode" class="form-control">{!! $mp->label !!}</span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Masa Pemerintahan</label>
			<div class="col-md-8">
				<span id="masa_penilaian" class="form-control">{!! $mp->awal !!} s.d {!! $mp->akhir !!}</span>
			</div>
		</div>
					
	</div>
</div>
	
