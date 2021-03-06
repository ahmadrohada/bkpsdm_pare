<div class="row">
	<div class="col-md-6">

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
	<div class="col-md-6">


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
					<span  data-toggle="tooltip" title="Tambah Kegiatan"><a class="btn btn-info btn-xs create_kegiatan_bulanan" ><i class="fa fa-plus" ></i> Kegiatan</a></span>
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
@include('pare_pns.modals.kegiatan_bulanan_jft')
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function refreshTreeKegBulanan(){
		jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
		jQuery('#skp_bulanan_tree').jstree().open_all(true);
		$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
	} 

	
		$('#skp_bulanan_tree')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/skp_bulanan_tree5") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $skp->Renja->id !!} , 
                          "jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
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
				'plugins' : [ /* 'contextmenu', */  'types' ,'search','state'],
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
		$('.skp_bulanan_id').val(skp_bulanan_id);

		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo 			: false,
				order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3 ] }
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_bulanan_5") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : skp_bulanan_id
									 },
								},
				columns			: [
									{ data: 'skp_bulanan_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label"},
									{ data: "target", name:"target", width:"140px"},
									{  data: 'action',width:"40px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_bulanan"  data-id="'+row.skp_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.skp_bulanan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											
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
				bInfo 			: false,
				//order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,1,3,4 ] }
								],
				ajax			: {
									url	: '{{ url("api/skp_bulanan_list_5") }}',
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
		show_modal_kegiatan_bulanan(0);
	

	});
	
	$(document).on('click','.edit_kegiatan_bulanan',function(e){
		var kegiatan_bulanan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/kegiatan_bulanan_detail_jft") }}',
				data 		: {kegiatan_bulanan_id : kegiatan_bulanan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {

					//Add data kegiatan_tahunan to select2
					var option = new Option(data['kegiatan_tahunan_label'],data['kegiatan_tahunan_id'],true,true);
					$('.modal-kegiatan_bulanan_jft').find('[name=kegiatan_tahunan_id]').append(option).trigger('change');

					$('.modal-kegiatan_bulanan_jft').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_bulanan_jft').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-kegiatan_bulanan_jft').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_bulanan_jft').find('[name=quality]').val(data['quality']);
					$('.modal-kegiatan_bulanan_jft').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_bulanan_jft').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-kegiatan_bulanan_jft').find('[name=cost]').val(data['cost']);

					$('.modal-kegiatan_bulanan_jft').find('[name=kegiatan_bulanan_id]').val(data['id']);
					$('.modal-kegiatan_bulanan_jft').find('h4').html('Edit Kegiatan Bulanan');
					$('.modal-kegiatan_bulanan_jft').find('.btn-submit').attr('id', 'submit-update_jft');
					$('.modal-kegiatan_bulanan_jft').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_bulanan_jft').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_kegiatan_bulanan',function(e){
		var kegiatan_bulanan_id = $(this).data('id') ;
		//alert(kegiatan_bulanan_id);

		Swal.fire({
			title: "Hapus Kegiatan Bulanan",
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
					url		: '{{ url("api/hapus_kegiatan_bulanan_jft") }}',
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
										$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
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


</script>
