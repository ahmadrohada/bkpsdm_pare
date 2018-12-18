<div class="box box-primary">

	<div class="box-header with-border">
		<h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary"> DETAIL SKP TAHUNAN</span>
			</small>
		</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<div class="no-padding col-md-12" >
			<div class="form-horizontal panel-info col-md-6">
						
				<div class="panel-default ">
					<i class="fa fa-calendar"></i>
					<span class="text-primary"> DETAIL SKP</span>
				</div>
				
				<div class="form-group form-group-sm" style="margin-top:10px;">
					<label class="col-md-4">Tanggal dibuat</label>
					<div class="col-md-8">
						<span id="date_created" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4">Periode SKP</label>
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
				
			<div class="form-horizontal panel-info col-md-6" style="margin-top:40px;">
				<div class="panel-default ">

					<div class="col-xs-6 col-md-6" style="padding-left:0px;">
						<i class="fa fa-user"></i>
						<span class="text-primary"> PEJABAT PENILAI
						</span>
					</div>

					
					<div class="col-xs-6 col-md-6 no-padding" align="right" style="cursor:pointer;">
							
						
						<span class="btn btn-xs btn-success btn_edit_pejabat " data-toggle="tooltip" data-placement="top" title="Edit Pejabat Penilai"> 
							<i class="fa fa-pencil" ></i>
							EDIT
						</span>
							
						<span class="btn btn-xs btn-danger btn_batal_pejabat hidden" data-toggle="tooltip" data-placement="top" title="Batal"> 
							<i class="fa fa-refresh" ></i>
							BATAL
						</span>
							
						
							
					</div>
					<br>
				</div>
						
						<div class="form-group form-group-sm form_nip"  style="margin-top:10px !important;">
							<label class="col-md-4">NIP</label>
							<div class="col-md-8">
								<span id="p_nip" class="form-control p_nip">{{ $nip_penilai }}</span>
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
								<span id="p_nama"  class="form-control">{{ $nama_pejabat_penilai}}</span>
							</div>
						</div>
						
						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 " >Pangkat / Gol</label>
							<div class="col-md-8">
								<span id="p_golongan" class="form-control">{{ $pangkat_golongan_pejabat_penilai }}</span>
							</div>
						</div>
						
						
						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 " >Eselon</label>
							<div class="col-md-8">
								<span id="p_eselon" class="form-control">{{ $eselon_pejabat_penilai }}</span>
							</div>
						</div>
						
						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 ">Jabatan</label>
							<div class="col-md-8">
								<span id="p_jabatan"class="form-control" style="height:48px;">{{ $jabatan_pejabat_penilai }}</span>
							</div>
						</div>

						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4">Unit Kerja</label>
							<div class="col-md-8">
								<span class="form-control" id="p_unit_kerja"  style="height:60px;">{{ $unit_kerja_pejabat_penilai }}</span>
							</div>
						</div>
					</div>	
						
					<div class="form-horizontal panel-info col-md-6" style="margin-top:40px;">
						<!-- Default panel contents -->
						<div class="panel-default ">
						<i class="fa fa-user"></i>
						<span class="text-primary"> PEJABAT YANG DINILAI</span>
						
						</div>
						
						<div class="form-group form-group-sm"  style="margin-top:10px;">
							<label class="col-md-4">NIP</label>
							<div class="col-md-8">
								<span id="u_nip" class="form-control">{{ $pejabat_yang_dinilai->nip }}</span>
							</div>
						</div>

						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 " >Nama Pegawai</label>
							<div class="col-md-8">
								<span id="u_nama" class="form-control">{{ $skp_tahunan->u_nama }}</span>
							</div>
						</div>
						
						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 " >Pangkat / Gol</label>
							<div class="col-md-8">
								<span id="u_golongan" class="form-control">{{ $pejabat_yang_dinilai->golongan->pangkat }} &nbsp;<b> / </b>&nbsp; {{ $pejabat_yang_dinilai->golongan->golongan }}</span>
							</div>
						</div>

						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 " >Eselon</label>
							<div class="col-md-8">
								<span id="u_eselon" class="form-control">{{ $pejabat_yang_dinilai->eselon->eselon }}</span>
							</div>
						</div>

						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4 ">Jabatan</label>
							<div class="col-md-8">
								<span id="u_jabatan" class="form-control" style="height:48px;">{{ $pejabat_yang_dinilai->jabatan }}</span>
							</div>
						</div>

						<div class="form-group form-group-sm" style="margin-top:-10px;">
							<label class="col-md-4">Unit Kerja</label>
							<div class="col-md-8">
								<span class="form-control" id="u_unit_kerja"  style="height:60px;">{{ Pustaka::capital_string($pejabat_yang_dinilai->UnitKerja->unit_kerja) }}</span>
							</div>
						</div>
					</div>	  
						
				</div>
		</div>	

	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {


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
            url				: '{{ url("api_resource/select_pegawai_list") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama: params.term,
					skp_tahunan_id:{{$skp_tahunan->id}}
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text: item.nama,
						    id: item.id,
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

		var pegawai_id = $(".p_nip_edit option:selected").val();

		$.ajax({
			url     	: '{{ url("api_resource/set_pejabat_penilai_skp_tahunan") }}',
			type    	: "POST",
			data    	: { skp_tahunan_id: {{ $skp_tahunan->id }}, pegawai_id  : pegawai_id },
			success		: function (data) {

				$('.btn_batal_pejabat').addClass('hidden');
				$('.btn_edit_pejabat').removeClass('hidden');

				$('.form_edit_nip').hide();
				$('.form_nip').show();

				$("#p_nama").html(data['p_nama']);
				$("#p_nip").html(data['p_nip']);
				$("#p_golongan").html(data['p_golongan']);
				$("#p_jabatan").html(data['p_jabatan']);
				$("#p_eselon").html(data['p_eselon']);
				$("#p_unit_kerja").html(data['p_unit_kerja']);

			},
			error: function (data) {
				swal({
						title: "Gagal",
						text: "Set Atasan tidak berhasil",
						type: "warning"
					}).then (function(){	
				});
				$('.form_edit_nip').hide();
				$('.form_nip').show();
			}

		}); 

	});
	
	
});
</script>