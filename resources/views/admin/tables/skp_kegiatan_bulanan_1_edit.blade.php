<div class="row">
	<div class="col-md-5">
		<div class="table-responsive">
			<input type='text' id = 'cari_skp_bulanan' class="form-control" placeholder="cari">
			<div id="skp_bulanan_tree" class="demo"></div>
			
		</div>

	</div>
	<div class="col-md-7">


		<div class="box box-primary" id='skp_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List SKP Bulanan
				</h1>

				<div class="box-tools pull-right">
					
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">
					<span  data-toggle="tooltip" title="Create SKP Bulanan"><a class="btn btn-info btn-xs create_skp_bulanan" ><i class="fa fa-plus" ></i> SKP Bulanan</a></span>
				</div>

				<table id="skp_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th >No</th>
							<th >PERIODE</th>
							<th >NAMA ATASAN</th>
							<th >JM KEGIATAN</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>
<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan' hidden>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Kegiatan Bulanan
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th>No</th>
							<th>KEGIATAN BULANAN</th>
							<th>TARGET</th>
							<th>PENGAWAS</th>
							<th>PELAKSANA</th>
							
							<!-- <th><i class="fa fa-cog"></i></th> -->
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('admin.modals.create_skp_bulanan_1') 
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function initTreeKegBulanan() {
		$('#skp_bulanan_tree')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skp_bulanan_tree1") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $skp->Renja->id !!} , 
                          			"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
									"skp_tahunan_id" : {!! $skp->id !!} };
						},
						"dataType" : "json"
				},'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			},'contextmenu' : { 
					'items' : context_menus
				},
				'plugins' : [ /* 'contextmenu', */  'types' ,'search'],
				'types' : {
					'skp_tahunan' 			: { /* options */ },
					'skp_bulanan' 	  	: { /* options */ },
			  	'rencana_aksi' 	  	: { /* options */ }
				}
			}).on('create_node.jstree', function (e, data) {
			

				modal_create_skp_bulanan();
				
		}).on("loaded.jstree", function(){
			$('#skp_bulanan_tree').jstree('open_all');
		}).on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table_2(data.instance.get_node(data.selected[0]).id);
			}
		});
	}



	function context_menus(node){
			var tree = $('#skp_bulanan_tree').jstree(true);

			if (node.type === 'skp_tahunan'){
				var addLabel = 'Create SKP Bulanan';
				var newLabel = 'SKP Bulanan';
			}
		
			
			var items = {
				"Add": {
					"label": addLabel,
					"action": function (obj) { 
						var $node = tree.create_node(node,newLabel);
						tree.edit($node);

					}
				},                         
				"Remove": {
					"label": "Remove",
					"action": function (obj) { 
						if(confirm('Hapus SKP Bulanan ?')){
							tree.delete_node(node);
						}
					}
				}
		};



		if (node.type === 'rencana_aksi'){
			delete items.Add;
			delete items.Remove;
		}else if ( node.type === 'skp_tahunan'){
			delete items.Remove;
		}else if ( node.type === 'skp_bulanan'){
			delete items.Add;
		}
	
		return items;
	}



	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table_2(id){

	var tx = id.split('|');



	switch ( tx[0] ){
							case 'SKPTahunan':
													$("#kegiatan_bulanan").hide();
													$("#skp_bulanan").show();
													load_skp_bulanan( tx[1]);
													
										
							break;
							case 'SKPBulanan':
												  	//SHOW KEGIATAN BULANAN
												  	$("#skp_bulanan").hide();
													$("#kegiatan_bulanan").show();
													load_kegiatan_bulanan( tx[1]);
													
										
							break;
							case 'KegiatanRenja':
												

							break;
							case 'RencanaAksi':
											

							break;
			
							default:
					
			
		}


	}


  function load_kegiatan_bulanan(skp_bulanan_id){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_bulanan_1") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : skp_bulanan_id
									 },
								},
				columns			: [
									{ data: 'rencana_aksi_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.rencana_aksi_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label;
											}
										}
									},
									
									{ data: "output", name:"output", width:"90px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target + ' '+ row.satuan+"</span>";
											}else{
												return row.target + ' '+ row.satuan;
											}
										}
									},
									{ data: "penanggung_jawab", name:"penanggung_jawab",
										"render": function ( data, type, row ) {
											
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.penanggung_jawab+"</span>";
											}else{
												return row.penanggung_jawab;
											}
											
										}
									},
									{ data: "pelaksana", name:"pelaksana",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.pelaksana+"</span>";
											}else{
												return row.pelaksana;
											}
										}
									}/* ,
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( row.status_skp != 1 ){
												if ( (row.kegiatan_bulanan_id) >= 1 ){
													//disabled jika sudah dilaksanakan/dia add pelaksana
													return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-plus" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
												}else{
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
											
												}
											}else{ //SUDAH ADA CAPAIAN NYA
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-plus" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
											}		
										
										}
									}, */
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	
		$('#skp_bulanan_table').DataTable({
				destroy			    : true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				//order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,1,3,4 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skp_bulanan_list_1") }}',
									data: { 
										
											"skp_tahunan_id" : {!! $skp->id !!},
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!}
									 },
								},
				columns			: [
									{ data: 'bulan' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "periode", name:"periode" },
									{ data: "p_nama", name:"p_nama"},
									{ data: "jm_kegiatan", name:"jm_kegiatan"},
									{  data: 'action',width:"20px",
											"render": function ( data, type, row ) {
											if (row.status == 0 ){
												return '<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_skp_bulanan"  data-id="'+row.skp_bulanan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return '<span  data-toggle="tooltip" title="" style="margin:2px;" ><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											}
											
											
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	
	


	
	var to = false;
	$('#cari_skp_bulanan').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_skp_bulanan').val();
		$('#skp_bulanan_tree').jstree(true).search(v);
		}, 250);
	});
	


//======================== SKP BULANAN ==============================//
	$(document).on('click','.create_skp_bulanan',function(e){
		modal_create_skp_bulanan();
	});

	function modal_create_skp_bulanan(){
		$.ajax({
				url			: '{{ url("api_resource/skp_tahunan_detail") }}',
				data 		: {skp_tahunan_id : {{ $skp->id}}},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-skp_bulanan').find('[name=periode_skp]').html(data['periode']);
					$('.modal-skp_bulanan').find('[name=u_nama]').html(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=u_jabatan]').html(data['u_jabatan']);
					$('.modal-skp_bulanan').find('[name=p_nama]').html(data['p_nama']);
					$('.modal-skp_bulanan').find('[name=p_jabatan]').html(data['p_jabatan']);

					$('.modal-skp_bulanan').find('[name=skp_tahunan_id]').val({{ $skp->id}});
					$('.modal-skp_bulanan').find('[name=tgl_mulai]').val(data['tgl_mulai']);
					$('.modal-skp_bulanan').find('[name=pegawai_id]').val(data['pegawai_id']);
					$('.modal-skp_bulanan').find('[name=u_jabatan_id]').val(data['u_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=p_jabatan_id]').val(data['p_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=u_nama]').val(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=p_nama]').val(data['p_nama']);

					//DISABLED BULAN YANG UDAH ADA
					//data['skp_bulanan_list'][0]['bulan']
					bln = data['skp_bulanan_list'];
					$('.periode_skp_bulanan').children().each(function(index,element){
					
        			for (i = 0; i < bln.length ; i++){
							if ( $(element).val() == data['skp_bulanan_list'][i]['bulan']){
								$(this).prop('disabled',true);
							}
						}
					})

					$('.modal-skp_bulanan').find('h4').html('Create SKP Bulanan');
					$('.modal-skp_bulanan').find('.btn-submit').attr('id', 'submit-save_skp_bulanan');
					$('.modal-skp_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-skp_bulanan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	}


	$(document).on('click','.hapus_skp_bulanan',function(e){
		var skp_bulanan_id = $(this).data('id') ;
		//alert(skp_bulanan_id);

		Swal.fire({
			title: "Hapus  SKP Bulanan",
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
					url		: '{{ url("api_resource/hapus_skp_bulanan") }}',
					type	: 'POST',
					data    : {skp_bulanan_id:skp_bulanan_id},
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
										$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
											jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
											
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

/* 	
	
	$(document).on('click','.hapus_kegiatan_bulanan',function(e){
		var kegiatan_bulanan_id = $(this).data('id') ;
		//alert(kegiatan_bulanan_id);

		Swal.fire({
			title: "Hapus  Kegiatan Bulanan",
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
					url		: '{{ url("api_resource/hapus_kegiatan_bulanan") }}',
					type	: 'POST',
					data    : {kegiatan_bulanan_id:kegiatan_bulanan_id},
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
										$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
											jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
											
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
	}); */


</script>
