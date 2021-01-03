
<div class="row">
	<div class="col-md-5">
			<div class="box box-primary ">
				<div class="box-header with-border">
					<h1 class="box-title">
						&nbsp;
					</h1>
					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body" style="padding-left:0px; padding-right:0px;">
					<input type='text' id = 'cari_skp_bulanan' class="form-control" placeholder="cari">
					<div class="table-responsive auto">
						<div id="skp_bulanan_tree" class="demo"></div>
					</div>
				</div>
			</div>

	

	</div>
	<div class="col-md-7">


		<div class="box box-skp_bulanan" id='skp_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List SKP Bulanan 
				</h1>

				<div class="box-tools pull-right">
					
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">
					@if  ( request()->segment(4) == 'edit' )
						<span  data-toggle="tooltip" title="Create SKP Bulanan"><a class="btn btn-info btn-xs create_skp_bulanan" ><i class="fa fa-plus" ></i> SKP Bulanan</a></span>	
					@endif 

					
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
		<div class="box box-kegiatan_bulanan" id='kegiatan_bulanan' hidden>
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
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('pare_pns.modals.create_skp_bulanan')
@include('pare_pns.modals.kegiatan_bulanan')
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">



	function refreshTreeKegBulanan(){
		jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
		jQuery('#skp_bulanan_tree').jstree().deselect_all(true);
	} 

	$('#skp_bulanan_tree').jstree({
				'core' : {
					'data' : {
							"url" 	: "{{ url("api/skp_bulanan_tree4") }}", 
							'data' : function (node) {
								return { 	"id" 		: node.id ,
											"data" 		: node.data,
											"renja_id" : {!! $skp->Renja->id !!} , 
                          					"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_tahunan_id" : {!! $skp->id !!} 
										};
									}
							}
				},
						'check_callback' : true,
						'themes' : { 'responsive' : false },
						'plugins': ['search'] ,
				}).on("loaded.jstree", function(){
					//$('#kegiatan_tahunan_kaban').jstree('open_all');
				}).on("changed.jstree", function (e, data) {
					if(data.selected.length) {
						detail_table2((data.instance.get_node(data.selected[0]).data)+'|'+(data.instance.get_node(data.selected[0]).id));
					}
				});
	

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
	function detail_table2(id){
	var tx = id.split('|');
	
	switch ( tx[0] ){
							case 'skp_tahunan':
										$("#kegiatan_bulanan").hide();
										$("#skp_bulanan").show();
										load_skp_bulanan( tx[1]);
													
										
							break;
							case 'skp_bulanan':
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
		$('#kegiatan_bulanan_table').DataTable().clear().destroy();
		

		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				deferRender		: true,
				//order 			: [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3 ] },
									@if  ( request()->segment(4) == 'edit' )
										{ "visible": true, "targets": [3]}
									@else
										{ "visible": false, "targets": [3]}
									@endif 
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
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
												return "<span class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "target", name:"target", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target+"</span>";
											}else{
												return row.target;
											}
										}
									},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( row.status_skp != 1 ){
												if ( (row.kegiatan_bulanan_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														    '<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{

													if (row.rencana_aksi_target != "" ){
														return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_kegiatan_bulanan"  data-id="'+row.rencana_aksi_id+'" data-skp_bulanan_id="'+row.skp_bulanan_id+'"><i class="fa fa-plus" ></i></a></span>';
													}else{
														return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-plus" ></i></a></span>';
													}
													
															
												
												}
											}else{ //SUDAH ADA CAPAIAN NYA
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-pencil " ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
											}		
										
										}
									},
									
								
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
									{ className: "text-center", targets: [ 0,1,3,4 ] },
									@if  ( request()->segment(4) == 'edit' )
										{ "visible": true, "targets": [4]}
									@else
										{ "visible": false, "targets": [4]}
									@endif 
								],
				ajax			: {
									url	: '{{ url("api/skp_bulanan_list_4") }}',
									data: { 
										
											"skp_tahunan_id" : {!! $skp->id !!} 
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
				url			: '{{ url("api/skp_tahunan_detail") }}',
				data 		: {skp_tahunan_id : {{ $skp->id}}},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-skp_bulanan').find('[name=periode_skp]').html(data['periode']);
					$('.modal-skp_bulanan').find('[name=u_nama]').html(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=u_jabatan]').html(data['u_jabatan']);
					$('.modal-skp_bulanan').find('[name=p_nama]').html(data['p_nama']);
					$('.modal-skp_bulanan').find('[name=p_jabatan]').html(data['p_jabatan']);
					$('.modal-skp_bulanan').find('[name=masa_penilaian]').html(data['masa_penilaian']);

					$('.modal-skp_bulanan').find('[name=skp_tahunan_id]').val({{ $skp->id}});
					$('.modal-skp_bulanan').find('[name=tgl_mulai]').val(data['tgl_mulai']);
					$('.modal-skp_bulanan').find('[name=pegawai_id]').val(data['pegawai_id']);
					$('.modal-skp_bulanan').find('[name=u_jabatan_id]').val(data['u_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=p_jabatan_id]').val(data['p_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=u_nama]').val(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=p_nama]').val(data['p_nama']);

					//HIDE BULAN YANG DILUAR MAA PENILAIAN SKP TAHUNAN
					bln_1 = data['bln_skp_list'];
					$('.periode_skp_bulanan').children().each(function(index,element){
						$(this).prop('disabled',true);
        				for (j = 0; j < bln_1.length ; j++){
							if ( $(element).val() == data['bln_skp_list'][j]['bulan']){
								$(this).prop('disabled',false);
							}
						}
					})


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
					url		: '{{ url("api/hapus_skp_bulanan") }}',
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

	$(document).on('click','.create_kegiatan_bulanan',function(e){
		var id = $(this).data('id');
		var skp_bulanan_id = $(this).data('skp_bulanan_id');
		show_modal_create(id,skp_bulanan_id);
	});
	

	function show_modal_create(rencana_aksi_id,skp_bulanan_id){
		$.ajax({
				url			  : '{{ url("api/rencana_aksi_detail_4") }}',
				data 		  : {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-kegiatan_bulanan').find('[name=skp_bulanan_id]').val(skp_bulanan_id);
					$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_label]').val(data['label']);
					$('.modal-kegiatan_bulanan').find('[name=target]').val(data['target_rencana_aksi']);
					$('.modal-kegiatan_bulanan').find('[name=satuan]').val(data['satuan_target_rencana_aksi']);
					$('.modal-kegiatan_bulanan').find('.rencana_aksi_label').html(data['label']);

					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);


					$('.modal-kegiatan_bulanan').find('h4').html('Create Kegiatan Bulanan');
					$('.modal-kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-kegiatan_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.edit_kegiatan_bulanan',function(e){
		var id = $(this).data('id');
		
		$.ajax({
				url			  	: '{{ url("api/kegiatan_bulanan_detail") }}',
				data 		  	: {kegiatan_bulanan_id : id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					$('.modal-kegiatan_bulanan').find('[name=kegiatan_bulanan_id]').val(data['id']);
					//$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_label]').val(data['kegiatan_bulanan_label']);
					$('.modal-kegiatan_bulanan').find('[name=target]').val(data['kegiatan_bulanan_target']);
					$('.modal-kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);
					$('.modal-kegiatan_bulanan').find('.rencana_aksi_label').html(data['kegiatan_bulanan_label']); 

					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);


					$('.modal-kegiatan_bulanan').find('h4').html('Edit Kegiatan Bulanan');
					$('.modal-kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_bulanan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_bulanan').modal('show'); 
					
				},
				error: function(data){
					
				}						
		});	

	});
	
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
					url		: '{{ url("api/hapus_kegiatan_bulanan") }}',
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
	});


</script>
