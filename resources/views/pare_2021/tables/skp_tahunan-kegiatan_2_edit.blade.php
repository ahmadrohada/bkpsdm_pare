<!-- ========================== edit form URAIAN TUGAS JABATAN ESELON 3 , PADA SKP TAHUNAN  ======================================= -->

<div class="row">
	<div class="col-md-5" >

		<div class="table-responsive" >
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="ktj" class="demo"></div>
			
		</div>
		
	</div>
	<div class="col-md-7">
		<div class="box box-primary" id='kegiatan_tahunan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Kegiatan SKP Tahunan
				</h1>

				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar"> 

				</div>

				<table id="kegiatan_tahunan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN TAHUNAN</th>
							<th rowspan="2">AK</th>
							<th colspan="4">TARGET</th>
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>OUTPUT</th>
							<th>MUTU</th>
							<th>WAKTU</th>
							<th>BIAYA</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

		<div id='rencana_aksi' hidden>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Kegiatan Tahunan
					</h1>

					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_detail_kegiatan_tahunan','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">

					<strong>Nama Kegiatan Tahunan</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="kegiatan_tahunan_label"></span>
						<input type="hidden" class="kegiatan_tahunan_id">
					</p>

					<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
					<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
					<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
					<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>
					
				</div>
			</div>



			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						List Rencana Aksi
					</h1>

				</div>
				<div class="box-body table-responsive">
					<div class="toolbar">
						<span  data-toggle="tooltip" title="Create Rencana Aksi"><a class="btn btn-info btn-xs create_rencana_aksi "><i class="fa fa-plus" ></i></a></span>
					</div>

					<table id="rencana_aksi_table" class="table table-striped table-hover" >
						<thead>
							<tr>
								<th>No</th>
								<th>RENCANA AKSI</th>
								<th>WAKTU</th>
								<th>PELAKSANA</th>
								<th><i class="fa fa-cog"></i></th>
							</tr>
						</thead>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

@include('pare_pns.modals.kegiatan_tahunan')
@include('pare_pns.modals.rencana_aksi')
     


<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
	
	
	
	function initTree() {
		$('#ktj')
		.on("loaded.jstree", function(){
			$('#ktj').jstree('open_all');
			//$('#ktj').jstree(true).select_node('KegiatanSKP|1');
			//$('#ktj').jstree(true).select_node('KegiatanSKP|2');
			//$("#ktj").jstree("disable_node", 'KegiatanSKP|1');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table(data.instance.get_node(data.selected[0]).id);
				
				
				
			}
		})
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/skp_tahunan_kegiatan_2") }}", //Eselon 2
						"data" 	: function (node) {
							return  {   "renja_id" : {!! $skp->Renja->id !!} , 
                                        "jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}
                                    };
						},
						"dataType" : "json"
				}
				,'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			}
			,"plugins" : [ "search"/* ,"state","contextmenu","wholerow" */ ]
			
		
	    });
	}

	
	
	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari').val();
		$('#ktj').jstree(true).search(v);
		}, 250);
	});
	
	


	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table(id){

		var tx = id.split('|');
		


		switch ( tx[0] ){
                case 'KegiatanTahunan':
                          //SHOW DETAIL KEGIATAN TAHUNAN DAN RENCANA KERJA LIST
                            $("#kegiatan_tahunan").hide();
						    $("#rencana_aksi").show();
                            load_rencana_aksi( tx[1]);
                       
                break; 
                case 'KegiatanRenja':
									show_modal_create(tx[1]);
                  

				break;
				case 'RencanaAksi':
                        

				break;
				
				default:
						$("#kegiatan_tahunan").show();
						$("#rencana_aksi").hide();
				
			}
		

    }
    

    $(".tutup_detail_detail_kegiatan_tahunan").click(function(){
			$("#kegiatan_tahunan").show();
			$("#rencana_aksi").hide();
			jQuery('#ktj').jstree().deselect_all(true);

		}); 
	
	var table_kegiatan_tahunan = $('#kegiatan_tahunan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5,7 ] },
									{ className: "text-right", targets: [ 6 ] },
									{ "orderable": false, targets: [ 0,1,2,3,4,5,6,7 ]  }
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_tahunan_2") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_tahunan_id" : {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'kegiatan_tahunan_id' ,
										"render": function ( data, type, row ,meta) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+(meta.row + meta.settings._iDisplayStart + 1 )+"</p>" ;
											}else{
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
											
									}
									},
									{ data: "label", name:"label", width:"220px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+row.kegiatan_label+"</p>";
											}else{
												return row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "angka_kredit", name:"angka_kredit" },
									{ data: "output", name:"output",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+row.renja_output+"</p>";									
											}else{
												return row.output;									
											}
										}
									},
									{ data: "mutu", name:"mutu",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";									
											}else{
												return row.mutu;									
											}
										}
									},
									{ data: "waktu", name:"waktu",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";									
											}else{
												return row.waktu;									
											}
										}
									},
									{ data: "biaya", name:"biaya",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+row.renja_biaya+"</p>";									
											}else{
												return row.biaya;									
											}
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {

											if ( (row.kegiatan_tahunan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_tahunan"  data-id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_tahunan"  data-id="'+row.kegiatan_tahunan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_kegiatan_tahunan"  data-id="'+row.kegiatan_id+'" data-label="'+row.kegiatan_label+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											}
													
										
										}
									},
								
								],
								initComplete: function(settings, json) {
								
							}
	});	


	$(document).on('click','.create_kegiatan_tahunan',function(e){
	
    var kegiatan_id = $(this).data('id');
		show_modal_create(kegiatan_id);

	});

	function show_modal_create(kegiatan_id){
		$.ajax({
				url			: '{{ url("api/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_tahunan').find('[name=kegiatan_id]').val(data['kegiatan_id']);
					$('.modal-kegiatan_tahunan').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan').find('[name=cost]').val(data['cost']);

					$('.modal-kegiatan_tahunan').find('[name=quality]').val(100);


					$('.modal-kegiatan_tahunan').find('h4').html('Create Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-kegiatan_tahunan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-kegiatan_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.edit_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/kegiatan_tahunan_detail") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_tahunan').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-kegiatan_tahunan').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan').find('[name=quality]').val(data['quality']);
					$('.modal-kegiatan_tahunan').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-kegiatan_tahunan').find('[name=cost]').val(data['cost']);


					$('.modal-kegiatan_tahunan').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-kegiatan_tahunan').find('h4').html('Edit Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_tahunan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});



	$(document).on('click','.hapus_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		//alert(kegiatan_tahunan_id);

		Swal.fire({
			title: "Hapus  Kegiatan Tahunan",
			text:$(this).data('label'),
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
					url		: '{{ url("api/hapus_kegiatan_tahunan") }}',
					type	: 'POST',
					data    : {kegiatan_tahunan_id:kegiatan_tahunan_id},
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
										$('#kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
										jQuery('#ktj').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
											jQuery('#ktj').jstree(true).refresh(true);
											
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
	});

//=============================== RENCANA AKSI =============================================//

	
	$(document).on('click','.create_rencana_aksi',function(e){
		$('.modal-rencana_aksi').find('h4').html('Create Rencana Aksi');
		$('.modal-rencana_aksi').find('.btn-submit').attr('id', 'submit-save_rencana_aksi');
		$('.modal-rencana_aksi').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-rencana_aksi').modal('show');
	});

	$(document).on('click','.edit_rencana_aksi',function(e){
		var rencana_aksi_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/rencana_aksi_detail") }}',
				data 		: {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-rencana_aksi').find('[name=label]').val(data['label']);
					$('.modal-rencana_aksi').find('[name=target_pelaksanaan]').val(data['target_pelaksanaan']).trigger('change.select2');


					$('.modal-rencana_aksi').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-rencana_aksi').find('h4').html('Edit Rencana Aksi');
					$('.modal-rencana_aksi').find('.btn-submit').attr('id', 'submit-update_rencana_aksi');
					$('.modal-rencana_aksi').find('[name=text_button_submit]').html('Update Data');
					$('.modal-rencana_aksi').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_rencana_aksi',function(e){
		var rencana_aksi_id = $(this).data('id') ;
		//alert(rencana_aksi_id);

		Swal.fire({
			title: "Hapus  rencana Aksi",
			text:$(this).data('label'),
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
					url		: '{{ url("api/hapus_rencana_aksi") }}',
					type	: 'POST',
					data    : {rencana_aksi_id:rencana_aksi_id},
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
										$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
										jQuery('#ktj').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
											jQuery('#ktj').jstree(true).refresh(true);
											
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
	});



	
	
	
	function load_rencana_aksi(kegiatan_tahunan_id){



		$.ajax({
				url			: '{{ url("api/kegiatan_tahunan_detail") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.kegiatan_tahunan_id').val(data['id']);
						$('.kegiatan_tahunan_label').html(data['label']);
						$('.txt_ak').html(data['ak']);
						$('.txt_output').html(data['output']);
						$('.txt_waktu').html(data['target_waktu'] +' bln');
						$('.txt_cost').html('Rp. ' +data['cost']);
						
				},
				error: function(data){
					
				}						
		});


		var table_rencana_aksi = $('#rencana_aksi_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,4 ] },
									{ 'orderable': false , targets: [ 0,1,2 ]  }
								],
				ajax			: {
									url	: '{{ url("api/skp_tahunan_rencana_aksi") }}',
									data: { kegiatan_tahunan_id: kegiatan_tahunan_id },
								},
								columns			: [
									{ data: 'rencana_aksi_id' , width:"10%",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "label", name:"label"},
									{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan",width:"170px"},
									{ data: "pelaksana", name:"pelaksana"},
									{  data: 'action',width:"15%",
											"render": function ( data, type, row ) {

											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_rencana_aksi"  data-id="'+row.rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_rencana_aksi"  data-id="'+row.rencana_aksi_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											
													
										
										}
									},
								
								],
								initComplete: function(settings, json) {
								
							}
				
							
			
		});	
	}

</script>
