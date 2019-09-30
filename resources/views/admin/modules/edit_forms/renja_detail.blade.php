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
				<label class="col-md-4 " ></label>
				<div class="col-md-8 text-right">
					<span class="btn btn-xs btn-success btn_edit_ka_skpd " data-toggle="tooltip" data-placement="top" title="Ganti Kepala SKPD"> 
					<i class="fa fa-pencil" ></i>EDIT</span>
					<span class="btn btn-xs btn-danger btn_batal_ka_skpd hidden" data-toggle="tooltip" data-placement="top" title="Batal"> 
					<i class="fa fa-refresh" ></i>BATAL</span>
				</div>
			</div>

			<div class="form-group form-group-sm form_edit_nip"  style="margin-top:10px;">
				<label class="col-md-4">NIP / Nama Kepala SKPD</label>
				<div class="col-md-8">
					<select class="form-control p_nip_edit" id="p_nip_edit" name="p_nip" style="width:100%;"></select>
				</div>
			</div>

			<div class="form-group form-group-sm form_nip" style="margin-top:-10px;">
				<label class="col-md-4 " >Kepala SKPD</label>
				<div class="col-md-8">
					<span class="form-control nama_kepala_skpd">{{ $renja->nama_kepala_skpd }}</span>
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

<script type="text/javascript">

	$('.form_edit_nip').hide();

	$(document).on('click', '.btn_edit_ka_skpd', function(){
		
		$('.form_edit_nip').show();
		$('.form_nip').hide();

		$('.btn_batal_ka_skpd').removeClass('hidden');
		$('.btn_edit_ka_skpd').addClass('hidden');

		$('.p_nip_edit').select2('open');

	});

	$(document).on('click','.btn_batal_ka_skpd',function(e){
        e.preventDefault();
		
		$('.form_edit_nip').hide();
		$('.form_nip').show();
		
		$('.btn_batal_ka_skpd').addClass('hidden');
		$('.btn_edit_ka_skpd').removeClass('hidden');
		
    });

	$('.p_nip_edit').select2({
        placeholder         : "Ketik NIP atau Nama Kepala SKPD",
		minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api_resource/select_ka_skpd_list") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama				: params.term,
					renja_id			: {{$renja->id}}
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
			url     	: '{{ url("api_resource/set_kepala_skpd_renja") }}',
			type    	: "POST",
			data    	: { renja_id: {{ $renja->id }}, 
							ka_skpd_id  : id
							
						},
			success		: function (data) {

				$('.btn_batal_ka_skpd').addClass('hidden');
				$('.btn_edit_ka_skpd').removeClass('hidden');

				$('.form_edit_nip').hide();
				$('.form_nip').show();

				$(".nama_kepala_skpd").html(data['nama_kepala_skpd']);
			

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