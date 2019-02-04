<div class="row">
	<div class="col-md-5">

		<div class="table-responsive">
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="renja" class=""></div>
		</div>
		
	</div>
	<div class="col-md-7">
		@include('admin.tables.renja-tujuan_edit')
		@include('admin.tables.renja-ind_tujuan_edit')
		@include('admin.tables.renja-sasaran_edit')
		@include('admin.tables.renja-ind_sasaran_edit')
		@include('admin.tables.renja-program_edit')
		@include('admin.tables.renja-ind_program_edit')
		@include('admin.tables.renja-kegiatan_edit')
		@include('admin.tables.renja-ind_kegiatan_edit')
		

	</div>
</div>



     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>




<script type="text/javascript">

		
	function initRenjaTree() {
		$('#renja')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skpd_renja_aktivity") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $renja->id !!} };
						},
						"dataType" : "json"
				}
				,'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			}
			,'contextmenu' : {
					'items' : context_menu
				},
				'plugins' : [/* 'contextmenu', */ 'types' ,'search'],
				'types' : {
					'tujuan' 		: { /* options */ },
					'ind_tujuan' 	: { /* options */ },
					'sasaran' 		: { /* options */ },
					'ind_sasaran' 	: { /* options */ },
					'program' 		: { /* options */ },
					'ind_program' 	: { /* options */ },
					'kegiatan' 		: { /* options */ },
					'ind_kegiatan' 	: { /* options */ }
				}
			
		
		}).on('create_node.jstree', function (e, data) {
			var text = data.node.parent;
			var tx = text.split('|');



			switch ( tx[0] ){
				case 'ind_tujuan':
					var url = 'api_resource/sasaran_store'
				break;
				case 'sasaran':
					var url = 'api_resource/ind_sasaran_store'
				break;
				case 'ind_sasaran':
					var url = 'api_resource/program_store'
				break;
				case 'program':
					var url = 'api_resource/ind_program_store'
				break;
				case 'ind_program':
					var url = 'api_resource/kegiatan_store'
				break;
				case 'kegiatan':
					var url = 'api_resource/ind_kegiatan_store'
				break;

				default:
					var url = 'default_url';
				
			}


			$.post( '{!! url("'+url+'") !!}', 
				{ 	'parent'	: tx[0],
					'parent_id' : tx[1], 
					'renja_id' 	: {!! $renja->id !!},
					'position' 	: data.position, 
					'text' 		: data.node.text 
				})
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		}).on('rename_node.jstree', function (e, data) {

			var z = data.node.id;
			var dt = z.split('|');



			switch ( dt[0] ){
				case 'sasaran':
					var url = 'api_resource/sasaran_rename'
				break;
				case 'ind_sasaran':
					var url = 'api_resource/ind_sasaran_rename'
				break;
				case 'program':
					var url = 'api_resource/program_rename'
				break;
				case 'ind_program':
					var url = 'api_resource/ind_program_rename'
				break;
				case 'kegiatan':
					var url = 'api_resource/kegiatan_rename'
				break;
				case 'ind_kegiatan':
					var url = 'api_resource/ind_kegiatan_rename'
				break;

				default:
					var url = 'default_url';
				
			}

			$.post( '{!! url("'+url+'") !!}', 
			 		{ 	
						'id' 	: dt[1], 
						'text' 	: data.text 
					})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on("loaded.jstree", function(){
			$('#renja').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table(data.instance.get_node(data.selected[0]).id);
			}
		});
	}


	function context_menu(node){
		var tree = $('#renja').jstree(true);

		if (node.type === 'ind_tujuan'){
			var addLabel = 'Tambah Sasaran';
			var newLabel = 'Sasaran Renja';
		}else if ( node.type === 'sasaran'){
			var addLabel = 'Tambah Indikator';
			var newLabel = 'Indikator Sasaran Renja';
		}else if ( node.type === 'ind_sasaran'){
			var addLabel = 'Tambah Program';
			var newLabel = 'Program Renja';
		}else if ( node.type === 'program'){
			var addLabel = 'Tambah Indikator';
			var newLabel = 'Indikator Program Renja';
		}else if ( node.type === 'ind_program'){
			var addLabel = 'Tambah Kegiatan';
			var newLabel = 'Kegiatan Renja';
		}else if ( node.type === 'kegiatan'){
			var addLabel = 'Tambah Indikator';
			var newLabel = 'Indikator Kegiatan Renja';
		}else{
			var addLabel = 'Tambah Data';
			var newLabel = 'Data Renja';
		}
	
		// The default set of all items
		var items = {
			"Add": {
				"label": addLabel,
				"action": function (obj) { 
					var $node = tree.create_node(node,newLabel);
					tree.edit($node);

					
					
				}
			},
			"Rename": {
				"label": "Rename",
				"action": function (obj) { 
					tree.edit(node);
				}
			},
			"Edit": {
				"label": "Edit",
				"action": function (obj) { 
					//tree.edit(node);
				}
			},                         
			"Remove": {
				"label": "Remove",
				"action": function (obj) { 
					if(confirm('Are you sure to remove this category?')){
						tree.delete_node(node);
					}
				}
			}
		};



		if (node.type === 'tujuan'){
			delete items.Add;
			delete items.Rename;
			delete items.Edit;
			delete items.Remove;
		}else if ( node.type === 'ind_kegiatan'){
			delete items.Add;
		}
	
		return items;
	}


	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#cari').val();
			$('#renja').jstree(true).search(v);
		}, 250);
	});
	
	function detail_table(id){

		var tx = id.split('|');



		switch ( tx[0] ){
				case 'tujuan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").show();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail").hide();
							load_ind_tujuan( tx[1]);
					
				break;
				case 'ind_tujuan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").show();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail").hide();
							load_sasaran( tx[1]);
					
				break;
				case 'sasaran':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").show();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail").hide();
							load_ind_sasaran( tx[1]);
					
				break;
				case 'ind_sasaran':
							//alert(tx[0]);
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").show();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							load_program( tx[1]);
					
				break;
				case 'program':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").show();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail").hide();
							load_ind_program( tx[1]);
					
				break;
				case 'ind_program':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").show();
							$(".div_kegiatan_detail").hide();
							load_kegiatan( tx[1]);
					
				break;
				case 'kegiatan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail").show();
							load_ind_kegiatan( tx[1]);
					
				break;
				
				
				default:
						/* $("#kegiatan_tahunan").show();
						$("#rencana_aksi").hide(); */
				
		}
	}

	$(".tutup_detail").click(function(){
				$(".div_misi_detail, .div_tujuan_list").show();
				$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
				$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
				$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
				$(".div_ind_sasaran_detail, .div_program_list").hide();
				$(".div_program_detail, .div_ind_program_list").hide();
				$(".div_ind_program_detail, .div_kegiatan_list").hide();
				$(".div_kegiatan_detail").hide();
	}); 

</script>
