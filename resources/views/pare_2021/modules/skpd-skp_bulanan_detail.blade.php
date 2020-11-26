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
					<span id="periode" class="form-control">{{ $skp->skp_tahunan->renja->periode->label }}</span>
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
					<span class="form-control">{{ $skp->pejabat_penilai->nip }}</span>
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
					<span class="form-control">{{ ( $skp->pejabat_penilai->golongan ? $skp->pejabat_penilai->golongan->pangkat : '' ) }} /  {{ ( $skp->pejabat_penilai->golongan ? $skp->pejabat_penilai->golongan->golongan : '' ) }}</span>
				</div>
			</div>
					
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Eselon</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->pejabat_penilai->eselon ? $skp->pejabat_penilai->eselon->eselon : '' ) }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 ">Jabatan</label>
				<div class="col-md-8">
					<span class="form-control" style="height:48px;">{{  pustaka::capital_string( ( $skp->pejabat_penilai->Jabatan ? $skp->pejabat_penilai->Jabatan->skpd : '' )) }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Unit Kerja</label>
				<div class="col-md-8">
					<span class="form-control" style="height:60px;">{{ pustaka::capital_string( ( $skp->pejabat_penilai->skpd ? $skp->pejabat_penilai->skpd->skpd : '' )) }}</span>
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
					<span class="form-control">{{ $skp->pejabat_yang_dinilai->nip }}</span>
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
					<span class="form-control">{{ ( $skp->pejabat_yang_dinilai->golongan ? $skp->pejabat_yang_dinilai->golongan->pangkat : '' ) }} /  {{ ( $skp->pejabat_penilai->golongan ? $skp->pejabat_penilai->golongan->golongan : '' ) }}</span>
				</div>
			</div>
					
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 " >Eselon</label>
				<div class="col-md-8">
					<span class="form-control">{{ ( $skp->pejabat_yang_dinilai->eselon ? $skp->pejabat_yang_dinilai->eselon->eselon : '' ) }}</span>
				</div>
			</div>
					
			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4 ">Jabatan</label>
				<div class="col-md-8">
					<span class="form-control" style="height:48px;">{{  pustaka::capital_string( ( $skp->pejabat_yang_dinilai->Jabatan ? $skp->pejabat_yang_dinilai->Jabatan->skpd : '' )) }}</span>
				</div>
			</div>

			<div class="form-group form-group-sm" style="margin-top:-10px;">
				<label class="col-md-4">Unit Kerja</label>
				<div class="col-md-8">
					<span class="form-control" style="height:60px;">{{ pustaka::capital_string( ( $skp->pejabat_yang_dinilai->skpd ? $skp->pejabat_yang_dinilai->skpd->skpd : '' )) }}</span>
				</div>
			</div>
		</div>	 
</div>
					
