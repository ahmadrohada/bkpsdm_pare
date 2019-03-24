<div class="row">
		<div class="form-horizontal col-md-6" style="margin-top:5px;">
			<div class="panel-default ">
				<i class="fa fa-calendar"></i>
				<span class="text-primary"> DETAIL RENJA</span>
			</div>
			
			<div class="form-group form-group-sm" style="margin-top:10px;">
				<label class="col-md-4">Tanggal dibuat</label>
				<div class="col-md-8">
					<span id="date_created" class="form-control">{{ $renja->created_at }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Periode</label>
				<div class="col-md-8">
					<span id="periode" class="form-control"> {{ $renja->periode->label }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">SKPD</label>
				<div class="col-md-8">
					<span class="form-control" style="height:60px;">{{ Pustaka::capital_string($renja->skpd->skpd) }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Kepala SKPD</label>
				<div class="col-md-8">
					<span class="form-control">{{ $renja->nama_kepala_skpd }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Admin SKPD</label>
				<div class="col-md-8">
					<span class="form-control">{{ $renja->nama_admin_skpd }}</span>
				</div>
			</div>
			
		</div>
</div>
