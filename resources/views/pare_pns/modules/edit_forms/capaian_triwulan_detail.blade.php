<div class="row">
	<div class="form-horizontal col-md-6">
							
		<div class="panel-default ">
			<i class="fa fa-calendar"></i>
			<span class="text-primary"> DETAIL CAPAIAN TRIWULAN</span>
		</div>
					
		<div class="form-group form-group-sm" style="margin-top:10px;">
			<label class="col-md-4">Tanggal dibuat</label>
			<div class="col-md-8">
				<span id="date_created" class="form-control"></span>
			</div>
		</div>
		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Periode Triwulan</label>
			<div class="col-md-8">
				<span id="periode_triwulan" class="form-control"></span>
			</div>
		</div>
	</div>
		
	<div class="form-horizontal col-md-6">
							
		<div class="panel-default ">
			<i class="fa fa-calendar"></i>
			<span class="text-primary"> DETAIL SKP Tahunan</span>
		</div>
					
		<div class="form-group form-group-sm" style="margin-top:10px;">
			<label class="col-md-4">Periode SKP tahunan</label>
			<div class="col-md-8">
				<span id="periode_skp_tahunan" class="form-control"></span>
			</div>
		</div>

		<div class="form-group form-group-sm" style="margin-top:-10px;">
			<label class="col-md-4">Masa Penilaian SKP Tahunan</label>
			<div class="col-md-8">
				<span id="masa_penilaian_skp_tahunan" class="form-control"></span>
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

				
			@if ( $capaian_triwulan->status   === '0')
				<div class="col-xs-6 col-md-6 no-padding" align="right" style="cursor:pointer;">
					<span class="btn btn-xs btn-success btn_edit_pejabat " data-toggle="tooltip" data-placement="top" title="Edit Pejabat Penilai"> 
					<i class="fa fa-pencil" ></i>EDIT</span>
					<span class="btn btn-xs btn-danger btn_batal_pejabat hidden" data-toggle="tooltip" data-placement="top" title="Batal"> 
					<i class="fa fa-refresh" ></i>BATAL</span>
				</div>		
			@endif
			


			<br>
		</div>
							
		<div class="form-group form-group-sm form_nip"  style="margin-top:10px !important;">
			<label class="col-md-4">NIP</label>
			<div class="col-md-8">
				<span id="p_nip" class="form-control p_nip"></span>
			</div>
		</div>

		<div class="form-group form-group-sm form_edit_nip"  style="margin-top:10px;">
			<label class="col-md-4">NIP / NAMA</label>
			<div class="col-md-8">
				<select class="form-control p_nip_edit" id="p_nip_edit" name="p_nip" style="width:100%;"></select>
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


	cap_triwulan_detail();
	
	function cap_triwulan_detail(){

		$.ajax({
			url     	: '{{ url("api/capaian_triwulan_detail") }}',
			type    	: "GET",
			data    	: { capaian_triwulan_id: {{ $capaian_triwulan->id }} },
			success		: function (data) {

					$("#date_created").html(data['date_created']);
					$("#periode_triwulan").html(data['periode_triwulan']);

					$("#periode_skp_tahunan").html(data['periode_skp_tahunan']);
					$("#masa_penilaian_skp_tahunan").html(data['masa_penilaian_skp_tahunan']);


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
	}

	/** ============== ----------------------- ================= **/	
	/** ============== FUNGSI EDIT Atasan ================= **/
	/** ============== ----------------------- ================= **/		

	$('.form_edit_nip').hide();

	$(document).on('click', '.btn_edit_pejabat', function(){
		
		$('.form_edit_nip').show();
		$('.form_nip').hide();

		$('.btn_batal_pejabat').removeClass('hidden');
		$('.btn_edit_pejabat').addClass('hidden');

		$('.p_nip_edit').select2('open');

	});

	$(document).on('click','.btn_batal_pejabat',function(e){
        e.preventDefault();
		
		$('.form_edit_nip').hide();
		$('.form_nip').show();
		
		$('.btn_batal_pejabat').addClass('hidden');
		$('.btn_edit_pejabat').removeClass('hidden');
		
		
		
    });
	
	

	$('.p_nip_edit').select2({
        placeholder         : "Ketik NIP atau Nama Pegawai",
		minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api/ganti_atasan_capaian_triwulan") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama					: params.term,
					capaian_triwulan_id		: {{$capaian_triwulan->id}}
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
	

	$(".p_nip_edit").change(function(){

		var id = $(".p_nip_edit option:selected").val();

		$.ajax({
			url     	: '{{ url("api/set_pejabat_penilai_capaian_triwulan") }}',
			type    	: "POST",
			data    	: { capaian_triwulan_id: {{ $capaian_triwulan->id }}, 
							pejabat_penilai_id  : id
							
						  },
			success		: function (data) {

				$('.btn_batal_pejabat').addClass('hidden');
				$('.btn_edit_pejabat').removeClass('hidden');

				$('.form_edit_nip').hide();
				$('.form_nip').show();

				$("#p_nama").html(data['p_nama']);
				$("#p_nip").html(data['p_nip']);
				$("#p_golongan").html(data['p_pangkat']+' / '+data['p_golongan']);
				$("#p_jabatan").html(data['p_jabatan']);
				$("#p_eselon").html(data['p_eselon']);
				$("#p_unit_kerja").html(data['p_unit_kerja']);

			},
			error: function (data) {
				Swal.fire({
						title: "Gagal",
						text: "Set Atasan tidak berhasil",
						type: "warning"
					}).then (function(){	
				});
				$('.btn_batal_pejabat').addClass('hidden');
				$('.btn_edit_pejabat').removeClass('hidden');

				$('.form_edit_nip').hide();
				$('.form_nip').show();
			}

		}); 

	});
	
</script>