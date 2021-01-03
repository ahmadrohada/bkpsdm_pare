<div class="row">
	<div class="form-horizontal col-md-6">
							
		<div class="panel-default ">
			<i class="fa fa-calendar"></i>
			<span class="text-primary"> DETAIL CAPAIAN</span>
		</div>
					
		<div class="form-group form-group-sm" style="margin-top:10px;">
			<label class="col-md-4">Tanggal dibuat</label>
			<div class="col-md-8">
				<span id="date_created" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Periode Capaian</label>
			<div class="col-md-8">
				<span id="periode" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Masa Penilaian</label>
			<div class="col-md-8">
				<span id="masa_penilaian" class="form-control"></span>
			</div>
		</div>
					
	</div>
</div>
	
<div class="row">
	<div class="form-horizontal col-md-6" style="margin-top:40px;">
		<div class="panel-default ">

			<div class="col-xs-6 col-md-6" style="padding-left:0px;">
				<i class="fa fa-user"></i>
				<span class="text-primary"> PEJABAT PENILAI</span>
			</div>

						
			<div class="col-xs-6 col-md-6 no-padding" align="right" style="cursor:pointer;">
				
			</div>
			<br>
		</div>
							
		<div class="form-group form-group-sm form_nip"  style="margin-top:10px !important;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span id="p_nip" class="form-control p_nip"></span>
			</div>
		</div>

		
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Nama Pegawai</label>
			<div class="col-md-8">
				<span id="p_nama"  class="form-control"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Pangkat / Gol</label>
			<div class="col-md-8">
				<span id="p_golongan" class="form-control"></span>
			</div>
		</div>
							
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Eselon</label>
			<div class="col-md-8">
				<span id="p_eselon" class="form-control"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 ">Jabatan</label>
			<div class="col-md-8">
				<span id="p_jabatan"class="form-control" style="height:48px;"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Unit Kerja</label>
			<div class="col-md-8">
				<span class="form-control" id="p_unit_kerja"  style="height:60px;"></span>
			</div>
		</div>
	</div>	
					
	<div class="form-horizontal col-md-6" style="margin-top:40px;">
		<!-- Default panel contents -->
		<div class="panel-default ">
			<i class="fa fa-user"></i>
			<span class="text-primary"> PEJABAT YANG DINILAI</span>
		</div>
							
		<div class="form-group form-group-sm"  style="margin-top:10px;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span id="u_nip" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Nama Pegawai</label>
			<div class="col-md-8">
				<span id="u_nama" class="form-control"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Pangkat / Gol</label>
			<div class="col-md-8">
				<span id="u_golongan" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Eselon</label>
			<div class="col-md-8">
				<span id="u_eselon" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 ">Jabatan</label>
			<div class="col-md-8">
				<span id="u_jabatan" class="form-control" style="height:48px;"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Unit Kerja</label>
			<div class="col-md-8">
				<span class="form-control" id="u_unit_kerja"  style="height:60px;"></span>
			</div>
		</div>
	</div>	 
</div> 
			




<script type="text/javascript">


	

	$.ajax({
		url     	: '{{ url("api/capaian_bulanan_detail") }}',
		type    	: "GET",
		data    	: { capaian_bulanan_id: {{ $capaian->id }} },
		success		: function (data) {

				$("#date_created").html(data['date_created']);
				$("#periode").html(data['periode']);
				$("#masa_penilaian").html(data['masa_penilaian']);


				$("#u_nama").html(data['u_nama']);
				$("#u_nip").html(data['u_nip']);
				$("#u_golongan").html(data['u_pangkat']+' / '+data['u_golongan']);
				$("#u_jabatan").html(data['u_jabatan']);
				$("#u_eselon").html(data['u_eselon']);
				$("#u_unit_kerja").html(data['u_unit_kerja']);

				$("#p_nama").html(data['p_nama']);
				$("#p_nip").html(data['p_nip']);
				$("#p_golongan").html(data['p_pangkat']+' / '+data['p_golongan']);
				$("#p_jabatan").html(data['p_jabatan']);
				$("#p_eselon").html(data['p_eselon']);
				$("#p_unit_kerja").html(data['p_unit_kerja']);

			},
			error: function (data) {
				
			}

	}); 

	
	
</script>