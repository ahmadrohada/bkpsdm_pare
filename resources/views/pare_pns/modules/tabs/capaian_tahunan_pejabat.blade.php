<div class="row">
	<div class="form-horizontal col-md-6">
		<div class="panel-default ">
			<i class="fa fa-user"></i>
			<span class="text-primary"> PEGAWAI YANG DINILAI</span>
		</div>
							
		<div class="form-group form-group-sm"  style="margin-top:10px;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span class="form-control u_nip"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Nama Pegawai</label>
			<div class="col-md-8">
				<span class="form-control u_nama"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Pangkat / Gol</label>
			<div class="col-md-8">
				<span class="form-control u_golongan"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Eselon</label>
			<div class="col-md-8">
				<span class="form-control u_eselon"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 ">Jabatan</label>
			<div class="col-md-8">
				<span class="form-control u_jabatan" style="height:48px;"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Unit Kerja</label>
			<div class="col-md-8">
				<span class="form-control u_unit_kerja" style="height:60px;"></span>
			</div>
		</div>		
		{{-- <div class="panel-default ">
			<i class="fa fa-calendar"></i>
			<span class="text-primary"> DETAIL CAPAIAN TAHUNAN</span>
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
		</div> --}}
					
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
				@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )
				<span class="btn btn-xs btn-success btn_edit_pejabat_penilai " data-toggle="tooltip" data-placement="top" title="Edit Pejabat Penilai"> 
				<i class="fa fa-pencil" ></i>EDIT</span>
				<span class="btn btn-xs btn-danger btn_batal_pejabat_penilai hidden" data-toggle="tooltip" data-placement="top" title="Batal"> 
				<i class="fa fa-refresh" ></i>BATAL</span>
				@endif
			</div>
			<br>
			
		</div>
							
		<div class="form-group form-group-sm form_nip_pejabat_penilai"  style="margin-top:10px !important;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span class="form-control p_nip"></span>
			</div>
		</div>

		<div class="form-group form-group-sm form_edit_pejabat_penilai"  style="margin-top:10px;">
			<label class="col-md-4">NIP / NAMA</label>
			<div class="col-md-8">
				<select class="form-control p_nip_edit_pejabat_penilai" name="p_nip" style="width:100%;"></select>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Nama Pegawai</label>
			<div class="col-md-8">
				<span class="form-control p_nama"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Pangkat / Gol</label>
			<div class="col-md-8">
				<span class="form-control p_golongan"></span>
			</div>
		</div>
							
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Eselon</label>
			<div class="col-md-8">
				<span class="form-control p_eselon"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 ">Jabatan</label>
			<div class="col-md-8">
				<span class="form-control p_jabatan" style="height:48px;"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Unit Kerja</label>
			<div class="col-md-8">
				<span class="form-control p_unit_kerja"style="height:60px;"></span>
			</div>
		</div>
	</div>	
					
	<div class="form-horizontal col-md-6" style="margin-top:40px;">
		<div class="panel-default ">

			<div class="col-xs-6 col-md-6" style="padding-left:0px;">
				<i class="fa fa-user"></i>
				<span class="text-primary"> ATASAN PEJABAT PENILAI</span>
			</div>

						 
			<div class="col-xs-6 col-md-6 no-padding" align="right" style="cursor:pointer;">
				@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )
				<span class="btn btn-xs btn-success btn_edit_atasan_pejabat_penilai " data-toggle="tooltip" data-placement="top" title="Edit Atasan Pejabat Penilai"> 
				<i class="fa fa-pencil" ></i>EDIT</span>
				<span class="btn btn-xs btn-danger btn_batal_atasan_pejabat_penilai hidden" data-toggle="tooltip" data-placement="top" title="Batal"> 
				<i class="fa fa-refresh" ></i>BATAL</span>
				@endif
			</div>
			<br>
			
		</div>
							
		<div class="form-group form-group-sm form_nip_atasan_pejabat_penilai"  style="margin-top:10px !important;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span class="form-control ap_nip"></span>
			</div>
		</div>

		<div class="form-group form-group-sm form_edit_atasan_pejabat_penilai"  style="margin-top:10px;">
			<label class="col-md-4">NIP / NAMA</label>
			<div class="col-md-8">
				<select class="form-control ap_nip_edit_atasan_pejabat_penilai" name="ap_nip" style="width:100%;"></select>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Nama Pegawai</label>
			<div class="col-md-8">
				<span class="form-control ap_nama"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Pangkat / Gol</label>
			<div class="col-md-8">
				<span class="form-control ap_golongan"></span>
			</div>
		</div>
							
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 " >Eselon</label>
			<div class="col-md-8">
				<span class="form-control ap_eselon"></span>
			</div>
		</div>
							
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4 ">Jabatan</label>
			<div class="col-md-8">
				<span class="form-control ap_jabatan" style="height:48px;"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Unit Kerja</label>
			<div class="col-md-8">
				<span class="form-control ap_unit_kerja"style="height:60px;"></span>
			</div>
		</div>
	</div>	 
</div> 
			




<script type="text/javascript">


	

	$.ajax({
		url     	: '{{ url("api_resource/capaian_tahunan_pejabat") }}',
		type    	: "GET",
		data    	: { capaian_tahunan_id: {{ $capaian->id }} },
		success		: function (data) {

				$(".u_nama").html(data['u_nama']);
				$(".u_nip").html(data['u_nip']);
				$(".u_golongan").html(data['u_pangkat']);
				$(".u_jabatan").html(data['u_jabatan']);
				$(".u_eselon").html(data['u_eselon']);
				$(".u_unit_kerja").html(data['u_unit_kerja']);

				$(".p_nama").html(data['p_nama']);
				$(".p_nip").html(data['p_nip']);
				$(".p_golongan").html(data['p_pangkat']);
				$(".p_jabatan").html(data['p_jabatan']);
				$(".p_eselon").html(data['p_eselon']);
				$(".p_unit_kerja").html(data['p_unit_kerja']);

				$(".ap_nama").html(data['ap_nama']);
				$(".ap_nip").html(data['ap_nip']);
				$(".ap_golongan").html(data['ap_pangkat']);
				$(".ap_jabatan").html(data['ap_jabatan']);
				$(".ap_eselon").html(data['ap_eselon']);
				$(".ap_unit_kerja").html(data['ap_unit_kerja']);

			},
			error: function (data) {
				
			}

	}); 

	/** ============== ----------------------- ================= **/	
	/** ============ FUNGSI EDIT PEJABAT PENILAI =============== **/
	/** ============== ----------------------- ================= **/		

	$('.form_edit_pejabat_penilai').hide();

	$(document).on('click', '.btn_edit_pejabat_penilai', function(){
		
		$('.form_edit_pejabat_penilai').show();
		$('.form_nip_pejabat_penilai').hide();

		$('.btn_batal_pejabat_penilai').removeClass('hidden');
		$('.btn_edit_pejabat_penilai').addClass('hidden');

		$('.p_nip_edit_pejabat_penilai').select2('open');

	});

	$(document).on('click','.btn_batal_pejabat_penilai',function(e){
        e.preventDefault();
		
		$('.form_edit_pejabat_penilai').hide();
		$('.form_nip_pejabat_penilai').show();
		
		$('.btn_batal_pejabat_penilai').addClass('hidden');
		$('.btn_edit_pejabat_penilai').removeClass('hidden');
		
		
		
    });
	
	

	$('.p_nip_edit_pejabat_penilai').select2({
        placeholder         : "Ketik NIP atau Nama Pegawai",
		minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api_resource/ganti_atasan_capaian_tahunan") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama					: params.term,
					capaian_tahunan_id		: {{$capaian->id}}
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text	: item.nama,
						    id		: item.id,
                        }
                        
                    })
                };
                
                
            }
        },
        language: {
            inputTooShort: function (args) {
                // args.minimum is the minimum required length
                // args.input is the user-typed text
                var min = args.minimum;
                var inp = args.input.length;
                var cur = min - inp;
                return "input minimal " + cur + " Karakter";
            },
            inputTooLong: function (args) {
                // args.maximum is the maximum allowed length
                // args.input is the user-typed text
                return "input maximal";
            },
            errorLoading: function () {
                return "Nama Pegawai tidak ditemukan";
            },
            loadingMore: function () {
                return "Loading lebih banyak data";
            },
            noResults: function () {
                return "Tidak ada hasil";
            },
            searching: function () {
                return "Searching...";
            },
            maximumSelected: function (args) {
                // args.maximum is the maximum number of items the user may select
                return "Error loading data";
            }
        } 

    });
	

	$(".p_nip_edit_pejabat_penilai").change(function(){

		var id = $(".p_nip_edit_pejabat_penilai option:selected").val();

		$.ajax({
			url     	: '{{ url("api_resource/update_pejabat_penilai") }}',
			type    	: "POST",
			data    	: { capaian_tahunan_id: {{ $capaian->id }}, 
							pejabat_penilai_id  : id
							
						  },
			success		: function (data) {

				$('.btn_batal_pejabat_penilai').addClass('hidden');
				$('.btn_edit_pejabat_penilai').removeClass('hidden');

				$('.form_edit_pejabat_penilai').hide();
				$('.form_nip_pejabat_penilai').show();

				$(".p_nama").html(data['p_nama']);
				$(".p_nip").html(data['p_nip']);
				$(".p_golongan").html(data['p_pangkat']+' / '+data['p_golongan']);
				$(".p_jabatan").html(data['p_jabatan']);
				$(".p_eselon").html(data['p_eselon']);
				$(".p_unit_kerja").html(data['p_unit_kerja']);

			},
			error: function (data) {
				Swal.fire({
						title: "Gagal",
						text: "Set Atasan tidak berhasil",
						type: "warning"
					}).then (function(){	
				});
				$('.btn_batal_pejabat_penilai').addClass('hidden');
				$('.btn_edit_pejabat_penilai').removeClass('hidden');

				$('.form_edit_pejabat_penilai').hide();
				$('.form_nip_pejabat_penilai').show();
			}

		}); 

	});



	/** ==============-==== ----------------------- ================= **/	
	/** =========== FUNGSI EDIT ATASAN PEJABAT PENILAI ================ **/
	/** ================ ----------------------- ===================== **/		

	$('.form_edit_atasan_pejabat_penilai').hide();

	$(document).on('click', '.btn_edit_atasan_pejabat_penilai', function(){
		
		$('.form_edit_atasan_pejabat_penilai').show();
		$('.form_nip_atasan_pejabat_penilai').hide();

		$('.btn_batal_atasan_pejabat_penilai').removeClass('hidden');
		$('.btn_edit_atasan_pejabat_penilai').addClass('hidden');

		$('.ap_nip_edit_atasan_pejabat_penilai').select2('open');

	});

	$(document).on('click','.btn_batal_atasan_pejabat_penilai',function(e){
        e.preventDefault();
		
		$('.form_edit_atasan_pejabat_penilai').hide();
		$('.form_nip_atasan_pejabat_penilai').show();
		
		$('.btn_batal_atasan_pejabat_penilai').addClass('hidden');
		$('.btn_edit_atasan_pejabat_penilai').removeClass('hidden');
		
		
		
    });
	
	

	$('.ap_nip_edit_atasan_pejabat_penilai').select2({
        placeholder         : "Ketik NIP atau Nama Pegawai",
		minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api_resource/ganti_atasan_capaian_tahunan") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama					: params.term,
					capaian_tahunan_id		: {{$capaian->id}}
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text	: item.nama,
						    id		: item.id,
                        }
                        
                    })
                };
                
                
            }
        },
        language: {
            inputTooShort: function (args) {
                // args.minimum is the minimum required length
                // args.input is the user-typed text
                var min = args.minimum;
                var inp = args.input.length;
                var cur = min - inp;
                return "input minimal " + cur + " Karakter";
            },
            inputTooLong: function (args) {
                // args.maximum is the maximum allowed length
                // args.input is the user-typed text
                return "input maximal";
            },
            errorLoading: function () {
                return "Nama Pegawai tidak ditemukan";
            },
            loadingMore: function () {
                return "Loading lebih banyak data";
            },
            noResults: function () {
                return "Tidak ada hasil";
            },
            searching: function () {
                return "Searching...";
            },
            maximumSelected: function (args) {
                // args.maximum is the maximum number of items the user may select
                return "Error loading data";
            }
        } 

    });
	

	$(".ap_nip_edit_atasan_pejabat_penilai").change(function(){

		var id = $(".ap_nip_edit_atasan_pejabat_penilai option:selected").val();

		$.ajax({
			url     	: '{{ url("api_resource/update_atasan_pejabat_penilai") }}',
			type    	: "POST",
			data    	: { capaian_tahunan_id: {{ $capaian->id }}, 
							pejabat_penilai_id  : id
							
						  },
			success		: function (data) {

				$('.btn_batal_atasan_pejabat_penilai').addClass('hidden');
				$('.btn_edit_atasan_pejabat_penilai').removeClass('hidden');

				$('.form_edit_atasan_pejabat_penilai').hide();
				$('.form_nip_atasan_pejabat_penilai').show();

				$(".ap_nama").html(data['ap_nama']);
				$(".ap_nip").html(data['ap_nip']);
				$(".ap_golongan").html(data['ap_pangkat']+' / '+data['ap_golongan']);
				$(".ap_jabatan").html(data['ap_jabatan']);
				$(".ap_eselon").html(data['ap_eselon']);
				$(".ap_unit_kerja").html(data['ap_unit_kerja']);

			},
			error: function (data) {
				Swal.fire({
						title: "Gagal",
						text: "Set Atasan Pejabat Penilai tidak berhasil",
						type: "warning"
					}).then (function(){	
				});
				$('.btn_batal_atasan_pejabat_penilai').addClass('hidden');
				$('.btn_edit_atasan_pejabat_penilai').removeClass('hidden');

				$('.form_edit_atasan_pejabat_penilai').hide();
				$('.form_nip_atasan_pejabat_penilai').show();
			}

		}); 

	});
	



</script>