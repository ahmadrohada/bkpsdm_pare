<div class="row">
		<div class="form-horizontal col-md-6" style="margin-top:5px;">
			<div class="panel-default ">
				<i class="fa fa-calendar"></i>
				<span class="text-primary"> DETAIL SKP</span>
			</div>
			
			<div class="form-group form-group-sm" style="margin-top:10px;">
				<label class="col-md-4">Tanggal dibuat</label>
				<div class="col-md-8">
					<span id="date_created" class="form-control">{{ $skp->created_at->format('d'.'-'.'m'.'-'.'Y') }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Periode SKP</label>
				<div class="col-md-8">
					<span id="periode" class="form-control">{{ $skp->renja->periode->label }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Masa Penilaian</label>
				<div class="col-md-8">
					<span id="masa_penilaian" class="form-control">{{ $skp->tgl_mulai }} s.d {{ $skp->tgl_selesai }}</span>
				</div>
			</div>
			
		</div>
</div>
<div class="row">
			
		<div class="form-horizontal col-md-6" style="margin-top:20px;">
			<div class="panel-default ">

				<div class="col-xs-6 col-md-6" style="padding-left:0px;">
					<i class="fa fa-user"></i>
					<span class="text-primary"> PEJABAT PENILAI
					</span>
				</div>
				<br>
			</div>
					
			<div class="form-group form-group-sm"  style="margin-top:10px !important;">
				<label class="col-md-4">NIP</label>
				<div class="col-md-8">
					<span class="form-control">{{ $skp->PejabatPenilai->nip }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Nama Pegawai</label>
				<div class="col-md-8">
					<span class="form-control">{{ $skp->u_nama }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Pangkat / Gol</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->PejabatPenilai->golongan ? $skp->PejabatPenilai->golongan->pangkat : '' ) }} /  {{ ( $skp->PejabatPenilai->golongan ? $skp->PejabatPenilai->golongan->golongan : '' ) }}</span>
				</div>
			</div>
					
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Eselon</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->PejabatPenilai->eselon ? $skp->PejabatPenilai->eselon->eselon : '' ) }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 ">Jabatan</label>
				<div class="col-md-8">
					<span class="form-control" style="height:48px;">{{  pustaka::capital_string( ( $skp->PejabatPenilai->Jabatan ? $skp->PejabatPenilai->Jabatan->skpd : '' )) }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Unit Kerja</label>
				<div class="col-md-8">
					<span class="form-control" style="height:60px;">{{ pustaka::capital_string( ( $skp->PejabatPenilai->skpd ? $skp->PejabatPenilai->skpd->skpd : '' )) }}</span>
				</div>
			</div>
		</div>	
					
		<div class="form-horizontal col-md-6" style="margin-top:20px;">
			<div class="panel-default ">

				<div class="col-xs-6 col-md-6" style="padding-left:0px;">
					<i class="fa fa-user"></i>
					<span class="text-primary"> PEJABAT YANg DINILAI
					</span>
				</div>
				<br>
			</div>
					
			<div class="form-group form-group-sm"  style="margin-top:10px !important;">
				<label class="col-md-4">NIP</label>
				<div class="col-md-8">
					<span class="form-control">{{ $skp->PejabatYangDinilai->nip }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Nama Pegawai</label>
				<div class="col-md-8">
					<span class="form-control">{{ $skp->p_nama }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Pangkat / Gol</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->PejabatYangDinilai->golongan ? $skp->PejabatYangDinilai->golongan->pangkat : '' ) }} /  {{ ( $skp->PejabatPenilai->golongan ? $skp->PejabatPenilai->golongan->golongan : '' ) }}</span>
				</div>
			</div>
					
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Eselon</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->PejabatYangDinilai->eselon ? $skp->PejabatYangDinilai->eselon->eselon : '' ) }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 ">Jabatan</label>
				<div class="col-md-8">
					<span class="form-control" style="height:48px;">{{  pustaka::capital_string( ( $skp->PejabatYangDinilai->Jabatan ? $skp->PejabatYangDinilai->Jabatan->skpd : '' )) }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Unit Kerja</label>
				<div class="col-md-8">
					<span class="form-control" style="height:60px;">{{ pustaka::capital_string( ( $skp->PejabatYangDinilai->skpd ? $skp->PejabatYangDinilai->skpd->skpd : '' )) }}</span>
				</div>
			</div>
		</div>	  
</div>
					
