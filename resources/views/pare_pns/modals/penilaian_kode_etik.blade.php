<div class="modal fade modal-penilaian_kode_etik" id="penilaian_kode_etik" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Penilaian Kode Etik Pegawai
                </h4>
            </div>
            <div class="modal-body">
			<form class="penilaian_kode_etik_form">
			<input type="hidden" class="capaian_bulanan_id" name="capaian_bulanan_id" >
			<input type="hidden" class="penilaian_kode_etik_id" name="penilaian_kode_etik_id" >

              <strong>Santun</strong>
              <p class="text-muted">Senantiasa bersikap halus dan baik budi bahasanya maupun tingkah lakunya</p>
			  <input  value="1" class="rating-kk santun" name="santun">
              <hr>

              <strong>Amanah</strong>
              <p class="text-muted">Dapat mempertanggungjawabkan tugas, fungsi dan perannya kepada masyarakat</p>
			  <input value="1" class="rating-kk amanah" name="amanah" >
              <hr>

			  
			  <strong>Harmonis</strong>
			  <p class="text-muted">Memelihara rasa persatuan dan kesatuan, saling menghormati serta menjaga dan menjalin kerjasama dengan sesama pegawai maupun pihak lainnya</p>
			  <input   value="1" class="rating-kk harmonis" name="harmonis">
			  <hr>

			  <strong>Adaptif</strong>
			  <p class="text-muted">Dapat mengantisipasi berbagai potensi, masalah dan perubahan yang terjadi dalam lingkup tugas, fungsi dan perannya</p>
			  <input  value="1" class="rating-kk adaptif" name="adaptif" >
			  <hr>

			  <strong>Terbuka</strong>
			  <p class="text-muted">Membuka diri terhadap hak masyarakat untuk memperoleh informasi yang benar, dan/atau daerah.jujur dan tidak diskriminatif tentang penyelenggaraan tugas, fungsi dan perannya dengan tetap memperlihatkan perlindungan atas hak azasi pribadi, golongan dan rahasia negara </p>
			  <input  value="1" class="rating-kk terbuka" name="terbuka" >
			  <hr>

			  <strong>Efektif</strong>
			  <p class="text-muted">Mampu mencapai target pelaksanaan tugas dan fungsi dengan cara atau proses yang paling optimal serta dengan mengunakan masukan terrendah untuk mencapai keluaran yang maksimal</p>
			  <input  value="1" class="rating-kk efektif" name="efektif" >
			  <hr>
			 
			  Capaian Bulanan Kode Etik :  <span class="text-success cbke"></span>
                        
            </div>

			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-sm btn-primary pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan_penilaian_kode_etik' )) !!}
            </div>
			</form>
        </div>
    </div>
</div>



<link rel="stylesheet" href="{{asset('assets/css/star-rating.css')}}" />
<script src="{{asset('assets/js/star-rating.js')}}"></script>

<script type="text/javascript">


	$(".rating-kk").rating({
			showCaption: true,
			min: 0, 
			max: 5, 
			step: 1, 
			size: "xs", 
			stars: "5",
			starCaptions: {
								0: 'kosong', 
								1: 'Sangat Kurang', 
								2: 'Kurang', 
								3: 'Cukup',
								4: 'Baik',
								5: 'Sangat Baik'}
	});

	

	$(document).on('change', '.santun, .amanah , .harmonis, .adaptif, .terbuka, .efektif', function(){
		hitung_capaian_bulanan_kode_etik();
	});

	$('.modal-penilaian_kode_etik').on('shown.bs.modal', function(){
		hitung_capaian_bulanan_kode_etik();
		Swal.close();
	});

	$('.modal-penilaian_kode_etik').on('hidden.bs.modal', function(){
		$('.sidebar-mini').attr("style", "padding-right:0px;");

		sumary_show();
	});

	
	
	function hitung_capaian_bulanan_kode_etik(){
		a = parseInt($(".santun").val() ? $(".santun").val() : 0);
		b = parseInt($(".amanah").val() ? $(".amanah").val() : 0);
		c = parseInt($(".harmonis").val() ? $(".harmonis").val() : 0);
		d = parseInt($(".adaptif").val() ? $(".adaptif").val() : 0);
		e = parseInt($(".terbuka").val() ? $(".terbuka").val() : 0);
		f = parseInt($(".efektif").val() ? $(".efektif").val() : 0);
		
		
		g =(( a+b+c+d+e+f )/30 )*100;

		
		
		if (( g.toFixed(2) % 2 === 0 )| ( g.toFixed(2) % 5 === 0 ) ){
			gx = g.toFixed(0);
			
		}else{
			gx = g.toFixed(2);
		}
		
		$(".cbke").html(gx+' %');
	}

	function on_submit_ke(){
		$('.modal-penilaian_kode_etik').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#simpan_penilaian_kode_etik').prop('disabled',true);
		$('#update_penilaian_kode_etik').prop('disabled',true);
	}
	function reset_submit_ke(){
		$('.modal-penilaian_kode_etik').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-penilaian_kode_etik').find('.button_simpan').addClass('fa-floppy-o');
		$('#simpan_penilaian_kode_etik').prop('disabled',false);
		$('#update_penilaian_kode_etik').prop('disabled',false);
	}



	$(document).on('click', '#simpan_penilaian_kode_etik', function(){
		on_submit_ke();
        var data = $('.penilaian_kode_etik_form').serialize();
		$.ajax({
			url		: '{{ url("api/simpan_penilaian_kode_etik") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);
				reset_submit_ke();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					penilaian_kode_etik_show();
					$('.modal-penilaian_kode_etik').modal('hide');
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit_ke();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert(data);

				

				
			}
			
		  });
		
    });

	$(document).on('click', '#update_penilaian_kode_etik', function(){
		on_submit_ke();
        var data = $('.penilaian_kode_etik_form').serialize();
		$.ajax({
			url		: '{{ url("api/update_penilaian_kode_etik") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);
				reset_submit_ke();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					penilaian_kode_etik_show();
					$('.modal-penilaian_kode_etik').modal('hide');
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit_ke();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert(data);

				

				
			}
			
		  });
		
    });



</script>