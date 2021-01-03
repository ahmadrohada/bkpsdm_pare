
<input type='text' id = 'cari' class="form-control" placeholder="cari">
<div id="renja" class=""></div>
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>




<script type="text/javascript">
$(document).ready(function() {
	
	initRenjaTree();
	/* $(".renja_tree").click(function(){
		initRenjaTree();
		
    }); */
	
	
	function initRenjaTree() {
		$('#renja')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/skpd_renja_tree") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $pk->renja->id !!} };
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
				'plugins' : ['contextmenu', 'types' ,'search'],
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
					var url = 'api/sasaran_store'
				break;
				case 'sasaran':
					var url = 'api/ind_sasaran_store'
				break;
				case 'ind_sasaran':
					var url = 'api/program_store'
				break;
				case 'program':
					var url = 'api/ind_program_store'
				break;
				case 'ind_program':
					var url = 'api/kegiatan_store'
				break;
				case 'kegiatan':
					var url = 'api/ind_kegiatan_store'
				break;

				default:
					var url = 'default_url';
				
			}


			$.post( '{!! url("'+url+'") !!}', 
				{ 	'parent'	: tx[0],
					'parent_id' : tx[1], 
					'renja_id' 	: {!! $pk->renja->id !!},
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
					var url = 'api/sasaran_rename'
				break;
				case 'ind_sasaran':
					var url = 'api/ind_sasaran_rename'
				break;
				case 'program':
					var url = 'api/program_rename'
				break;
				case 'ind_program':
					var url = 'api/ind_program_rename'
				break;
				case 'kegiatan':
					var url = 'api/kegiatan_rename'
				break;
				case 'ind_kegiatan':
					var url = 'api/ind_kegiatan_rename'
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
	
	

});
</script>
