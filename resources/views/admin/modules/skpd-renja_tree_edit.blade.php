
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
						"url" 	: "{{ url("api_resource/skpd_renja_tree") }}",
						"data" 	: function (node) {
							return { "renja_id" : 2 };
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
					'renja_id' 	: tx[2],
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
		});
	}


	function context_menu(node){
		var tree = $('#renja').jstree(true);
	
		// The default set of all items
		var items = {
			"Add": {
				"label": "Add Child",
				"action": function (obj) { 
					var $node = tree.create_node(node,'Renja New Node');
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
