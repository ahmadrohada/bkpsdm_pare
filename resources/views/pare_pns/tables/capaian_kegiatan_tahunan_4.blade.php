<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">
	</div>
	<div class="box-body table-responsive">
		<table id="realisasi_kegiatan_tahunan_table" class="table table-striped table-bordered nowrap" style="width:100%">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">KEGIATAN TAHUNAN</th>
					<th rowspan="2">INDIKATOR</th>
					<th colspan="5" >TARGET</th>
					<th colspan="5">REALISASI</th>
					<th colspan="4">HITUNG CAPAIAN</th>
					<th rowspan="2">TOTAL<br> HITUNG</th>
					<th rowspan="2">CAPAIAN <br>SKP</th>
					<th rowspan="2"><i class="fa fa-cog"></i></th>
					<th rowspan="2" style="padding: 3px 20px;"><i class="fa fa-cog"></i></th>
				</tr>
				<tr>
					<th>AK</th>
					<th>QUANTITY</th>
					<th>QUALITY</th>
					<th>WAKTU</th>
					<th>ANGGARAN</th>

					<th>AK</th>
					<th>QUANTITY</th>
					<th>QUALITY</th>
					<th>WAKTU</th>
					<th>ANGGARAN</th>

					<th>QUANTITY</th>
					<th>QUALITY</th>
					<th>WAKTU</th>
					<th>ANGGARAN</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<style>
table.dataTable tbody td {
  vertical-align: middle;
  
}
.big-col {
  width: 400px !important;
}
</style>
@include('pare_pns.modals.realisasi_kegiatan_tahunan')
@include('pare_pns.modals.penilaian_kualitas_kerja')

<script type="text/javascript">

  	function LoadKegiatanTahunanTable(){
		
		var table_kegiatan_tahunan = $('#realisasi_kegiatan_tahunan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				autoWidth		: true,
				bInfo			: false,
				bSort			: false,
				//fixedHeader		: true,
				lengthChange	: false,
				//order 		: [ 0 , 'asc' ],
				lengthMenu		: [25,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4,5,6,8,9,10,11,13,14,15,16,17,18,19 ] },
									{ className: "text-right", targets: [ 7,12] },
									/* { visible: false, "targets": [10]}, */
									{ "width": "150px", "targets": [0,1] },     
									@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
										{ visible: true, "targets": [19]},
										{ visible: false, "targets": [13,14,15,16,17,18]},
									@else
										{ visible: false, "targets": [19]},
										{ visible: true, "targets": [13,14,15,16,17,18]},
									@endif

									@if (  request()->segment(2) != 'capaian_tahunan_bawahan_approvement' )
										{ visible: false, "targets": [20]},
									@else
										{ visible: true, "targets": [20]},
									@endif
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_tahunan_4") }}',
									data: { 
										
											"renja_id" 				: {!! $capaian->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 			: {!! $capaian->PegawaiYangDinilai->Jabatan->id !!},
											"capaian_id" 			: {!! $capaian->id !!},
											"jenis_jabatan"			: {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan !!},
									 },
								},
				rowCallback		: function(row, data, index){
									
										$(row).find('td:eq(3)').css('background-color', '#FFF8DC');
										$(row).find('td:eq(4)').css('background-color', '#FFF8DC');
										$(row).find('td:eq(5)').css('background-color', '#FFF8DC');
										$(row).find('td:eq(6)').css('background-color', '#FFF8DC');
										$(row).find('td:eq(7)').css('background-color', '#FFF8DC');

										$(row).find('td:eq(8)').css('background-color', '#F0F8FF');
										$(row).find('td:eq(9)').css('background-color', '#F0F8FF');
										$(row).find('td:eq(10)').css('background-color', '#F0F8FF');
										$(row).find('td:eq(11)').css('background-color', '#F0F8FF');
										$(row).find('td:eq(12)').css('background-color', '#F0F8FF');

										$(row).find('td:eq(13)').css('background-color', '#FFF0F5');
										$(row).find('td:eq(14)').css('background-color', '#FFF0F5');
										$(row).find('td:eq(15)').css('background-color', '#FFF0F5');
										$(row).find('td:eq(16)').css('background-color', '#FFF0F5');

										$(row).find('td:eq(18)').css('background-color', '#B0E0E6');
										$(row).find('td:eq(18)').css('font-weight', 'bold');
									
									},
				rowsGroup		: [ 0,1,3,5,6,7,8,10,11,12,14,15,16,17,18,20 ],
				columns			: [ 
									{ data: "no",searchable:false},
									{ data: "kegiatan_tahunan_label", name:"kegiatan_tahunan_label",width:"420px",
										"render": function ( data, type, row ) {
											return row.kegiatan_tahunan_label;
											
										}
									}, 
									{ data: "indikator_kegiatan_label", name:"indikator_kegiatan_label",width:"20%",
										"render": function ( data, type, row ) {
											return row.indikator_kegiatan_label;
											
										}
									}, 
									
									{ data: "target_ak", name:"target_ak",
										"render": function ( data, type, row ) {
											return row.target_ak ;
										}
									},
									{ data: "target_quantity", name:"target_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_quantity ;
										}
									},
									{ data: "target_quality", name:"target_quality", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_quality ;
										}
									},
									{ data: "target_waktu", name:"target_waktu", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_waktu ;
										}
									},
									{ data: "target_cost", name:"target_cost", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_cost ;
										}
									},
									{ data: "realisasi_ak", name:"realisasi_ak", width:"100px",
										"render": function ( data, type, row ) {
											return row.realisasi_ak ;
										}
									},
									{ data: "realisasi_quantity", name:"realisasi_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return  row.realisasi_quantity;
										}
									},
									{ data: "realisasi_quality", name:"realisasi_quality", width:"100px",
										"render": function ( data, type, row ) {
											return  row.realisasi_quality;
										}
									},
									{ data: "realisasi_waktu", name:"realisasi_waktu", width:"50px",
										"render": function ( data, type, row ) {
											return row.realisasi_waktu ;
										}
									},
									{ data: "realisasi_cost", name:"realisasi_cost", width:"50px",
										"render": function ( data, type, row ) {
											return row.realisasi_cost ;
										}
									},
									{ data: "hitung_quantity", name:"hitung_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return  row.hitung_quantity;
										}
									},
									{ data: "hitung_quality", name:"hitung_quality", width:"100px",
										"render": function ( data, type, row ) {
											return  row.realisasi_quality;
										}
									},
									{ data: "hitung_waktu", name:"hitung_waktu", width:"50px",
										"render": function ( data, type, row ) {
											return row.hitung_waktu ;
										}
									},
									{ data: "hitung_cost", name:"hitung_cost", width:"50px",
										"render": function ( data, type, row ) {
											return row.hitung_cost ;
										}
									},
									{ data: "total_hitung", name:"total_hitung", width:"50px",
										"render": function ( data, type, row ) {
											return row.total_hitung ;
										}
									},
									{ data: "capaian_skp", name:"capaian_skp", width:"50px",
										"render": function ( data, type, row ) {
											return row.capaian_skp ;
										}
									},
									{  data: 'action',width:"6%",
											"render": function ( data, type, row ) {

											//form realisasi untuk kegiatan tahunan , bukan untuk indikator
											@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
										
									
												if ( {!! $capaian->status !!} == 1 ){
													return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
															'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
												}else{
													if ( (row.realisasi_kegiatan_id) >= 1 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_tahunan"  data-kegiatan_id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_tahunan"  data-realisasi_kegiatan_id ="'+row.realisasi_kegiatan_id+'"  data-realisasi_kegiatan_id="'+row.realisasi_kegiatan_id+'"  data-kegiatan_id="'+row.kegiatan_id+'"  data-label="'+row.kegiatan_label+'" ><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_tahunan"  data-kegiatan_id="'+row.kegiatan_tahunan_id+'" data-kegiatan_tahunan_id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-plus" ></i></a></span>'+
																'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
													
													} 
												}
											@else
												if ( {!! $capaian->status !!} == 1 ){
													return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
															'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
												}else{
													if ( (row.realisasi_indikator_id) >= 1 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_tahunan"  data-indikator_id="'+row.indikator_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_tahunan"  data-realisasi_kegiatan_id ="'+row.realisasi_kegiatan_id+'"  data-realisasi_indikator_kegiatan_id="'+row.realisasi_indikator_id+'"  data-kegiatan_id="'+row.kegiatan_id+'"  data-label="'+row.indikator_kegiatan_label+'" ><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_tahunan"  data-indikator_id="'+row.indikator_kegiatan_id+'" data-kegiatan_tahunan_id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-plus" ></i></a></span>'+
																'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
													
													} 
												}
											@endif

										}
									},
									{  data: 'realisasi_kegiatan_id',name:'realisasi_kegiatan_id',
										"render": function ( data, type, row ) {
											
											if ( (row.penilaian) >= 1 ){
												return  '<span data-toggle="tooltip" title="Ubah data penilaian" style="margin:2px;" ><a class="btn btn-success btn-xs penilaian_kualitas_kerja"  data-realisasi_kegiatan_id="'+row.realisasi_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>';	
											}else{
												return  '<span data-toggle="tooltip" title="Berikan Penilaian Kualitas Kerja"  style="margin:2px;" ><a class="btn btn-info btn-xs penilaian_kualitas_kerja"  data-realisasi_kegiatan_id="'+row.realisasi_kegiatan_id+'"><i class="fa fa-pagelines" ></i></a></span>';
											} 
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	

		


		
		 
	}

	

	$(document).on('click','.create_realisasi_tahunan',function(e){
	
		@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
			var kegiatan_id = $(this).data('kegiatan_id');
			$('.modal-realisasi_tahunan').find('h4').html('Add Realisasi Kegiatan Tahunan');
			$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-save');
			$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Simpan Data');
			show_modal_create_jft(kegiatan_id);
		@else
			var indikator_kegiatan_id = $(this).data('indikator_id');
			$('.modal-realisasi_tahunan').find('h4').html('Add Realisasi Kegiatan Tahunan');
			$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-save');
			$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Simpan Data');
			show_modal_create(indikator_kegiatan_id);
		@endif								
		
		
	});

	function show_modal_create(indikator_kegiatan_id){
		$.ajax({
				url			  	: '{{ url("api_resource/add_realisasi_kegiatan_tahunan") }}',
				data 		  	: { 
									indikator_kegiatan_id : indikator_kegiatan_id ,
									capaian_id : {!! $capaian->id !!} },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_tahunan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_tahunan').find('[name=ind_kegiatan_id]').val(data['ind_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=kegiatan_tahunan_id]').val(data['kegiatan_tahunan_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_indikator_kegiatan_tahunan_id]').val(data['realisasi_indikator_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_kegiatan_tahunan_id]').val(data['realisasi_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					
					$('.modal-realisasi_tahunan').find('[name=target_quantity]').val(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('[name=target_angka_kredit]').val(data['target_ak']);
					$('.modal-realisasi_tahunan').find('[name=target_quality]').val(data['target_quality']);
					$('.modal-realisasi_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('[name=target_cost]').val(data['target_cost']);
					$('.modal-realisasi_tahunan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_tahunan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_tahunan').find('.indikator_label').html(data['indikator_label']);
					


					$('.modal-realisasi_tahunan').find('.target_quantity').html(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('.target_angka_kredit').html(data['target_ak']);
					$('.modal-realisasi_tahunan').find('.target_quality').html(data['target_quality']);
					$('.modal-realisasi_tahunan').find('.target_waktu').html(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('.target_cost').html(data['target_cost']);
					$('.modal-realisasi_tahunan').find('.satuan').html(data['satuan']);

					$('.modal-realisasi_tahunan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_tahunan').find('.realisasi_angka_kredit').val(data['realisasi_ak']);
					$('.modal-realisasi_tahunan').find('.realisasi_quality').val(data['realisasi_quality']);
					$('.modal-realisasi_tahunan').find('.realisasi_waktu').val(data['realisasi_waktu']);
					$('.modal-realisasi_tahunan').find('.realisasi_cost').val(data['realisasi_cost']);
					
					

					
					$('.modal-realisasi_tahunan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	function show_modal_create_jft(kegiatan_id){
		$.ajax({
				url			  	: '{{ url("api_resource/add_realisasi_kegiatan_tahunan_5") }}',
				data 		  	: { 
									kegiatan_id 	: kegiatan_id ,
									capaian_id 		: {!! $capaian->id !!} },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_tahunan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_tahunan').find('[name=ind_kegiatan_id]').val(data['ind_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=kegiatan_tahunan_id]').val(data['kegiatan_tahunan_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_indikator_kegiatan_tahunan_id]').val(data['realisasi_indikator_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_kegiatan_tahunan_id]').val(data['realisasi_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					
					$('.modal-realisasi_tahunan').find('[name=target_quantity]').val(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('[name=target_angka_kredit]').val(data['target_angka_kredit']);
					$('.modal-realisasi_tahunan').find('[name=target_quality]').val(data['target_quality']);
					$('.modal-realisasi_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('[name=target_cost]').val(data['target_cost']);
					$('.modal-realisasi_tahunan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_tahunan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_tahunan').find('.indikator_label').html(data['indikator_label']);
					


					$('.modal-realisasi_tahunan').find('.target_quantity').html(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('.target_angka_kredit').html(data['target_angka_kredit']);
					$('.modal-realisasi_tahunan').find('.target_quality').html(data['target_quality']);
					$('.modal-realisasi_tahunan').find('.target_waktu').html(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('.target_cost').html(data['target_cost']);
					$('.modal-realisasi_tahunan').find('.satuan').html(data['satuan']);

					$('.modal-realisasi_tahunan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_tahunan').find('.realisasi_angka_kredit').val(data['realisasi_angka_kredit']);
					$('.modal-realisasi_tahunan').find('.realisasi_quality').val(data['realisasi_quality']);
					$('.modal-realisasi_tahunan').find('.realisasi_waktu').val(data['realisasi_waktu']);
					$('.modal-realisasi_tahunan').find('.realisasi_cost').val(data['realisasi_cost']);
					
					

					
					$('.modal-realisasi_tahunan').modal('show');   
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_tahunan',function(e){
		@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
			var kegiatan_id = $(this).data('kegiatan_id');
			$('.modal-realisasi_tahunan').find('h4').html('Edit Realisasi Kegiatan Tahunan');
			$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-update');
			$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Update Data');
			show_modal_create_jft(kegiatan_id);
		@else
			var indikator_kegiatan_id = $(this).data('indikator_id');
			$('.modal-realisasi_tahunan').find('h4').html('Edit Realisasi Kegiatan Tahunan');
			$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-update');
			$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Update Data');
			show_modal_create(indikator_kegiatan_id);
		@endif	
		
		/* var indikator_kegiatan_id = $(this).data('indikator_id');
		$('.modal-realisasi_tahunan').find('h4').html('Edit Realisasi Kegiatan Tahunan');
		$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-update');
		$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Update Data');
		show_modal_create(indikator_kegiatan_id); */
		
	});

	$(document).on('click','.hapus_realisasi_tahunan',function(e){

		var realisasi_indikator_kegiatan_id = $(this).data('realisasi_indikator_kegiatan_id') ;
		var kegiatan_id = $(this).data('kegiatan_id') ;
		var realisasi_kegiatan_id = $(this).data('realisasi_kegiatan_id') ;
		var label = $(this).data('label');

		
		hapus(realisasi_indikator_kegiatan_id,kegiatan_id,realisasi_kegiatan_id,label);
		
		
	});

	function hapus(realisasi_indikator_kegiatan_id,kegiatan_id,realisasi_kegiatan_id,label){
		
		Swal.fire({
			title: "Hapus  realisasi Kegiatan",
			text:label,
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_realisasi_kegiatan_tahunan") }}',
					type	: 'POST',
					data    : { kegiatan_id:kegiatan_id,
								realisasi_indikator_kegiatan_id:realisasi_indikator_kegiatan_id,
								realisasi_kegiatan_id:realisasi_kegiatan_id
								},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	}

	function hapus_jft(realisasi_kegiatan_id,label){
		
		

		Swal.fire({
			title: "Hapus  realisasi Kegiatan JFT",
			text: label ,
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_realisasi_kegiatan_tahunan_5") }}',
					type	: 'POST',
					data    : { 
								realisasi_kegiatan_id:realisasi_kegiatan_id
							  },
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	}


	$(document).on('click','.penilaian_kualitas_kerja',function(e){
		var realisasi_kegiatan_id = $(this).data('realisasi_kegiatan_id');
		$.ajax({
				url			  	: '{{ url("api_resource/penilaian_kualitas_kerja_detail") }}',
				data 		  	: { 
									realisasi_kegiatan_id : realisasi_kegiatan_id ,
								},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-penilaian_kualitas_kerja').find('[class=realisasi_kegiatan_tahunan_id]').val(data['realisasi_kegiatan_tahunan_id']);
					$('.modal-penilaian_kualitas_kerja').find('h4').html('Penilaian Kualitas Kerja');
					
					$('.akurasi').rating('update',data['akurasi']);
					$('.ketelitian').rating('update',data['ketelitian']);
					$('.kerapihan').rating('update',data['kerapihan']);
					$('.keterampilan').rating('update',data['keterampilan']);
					hitung_penilaian_kualitas_kerja();
					$('.modal-penilaian_kualitas_kerja').modal('show');  
				},
				error: function(data){
					
				}						
		});	

	});

	

</script>
