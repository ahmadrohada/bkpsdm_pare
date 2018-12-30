
<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
<div id="ditribusi_renja" class="demo"></div>
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>


@include('admin.modals.distribusi_kegiatan-add')

<script type="text/javascript">
$(document).ready(function() {
	
	
	initTree();

	$(".distribusi_kegiatan").click(function(){
		initTree();
    });

	

	
	
	function initTree() {
		$('#ditribusi_renja')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skpd_renja_distribusi_kegiatan_tree") }}",
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
					'items' : context_menu_2
				},
			"plugins" : [ 'search','contextmenu','types','state'/*,'dnd' ,"state","wholerow" */ ],
			'types' : {
					'ka_skpd' 		: { /* options */ },
					'kabid' 	: {  },
					'kasubid' 	: { /* options */ },
					'kegiatan' 	: { /* options */ },
				}
			
		
	    })
		.on('changed.jstree', function (e, data) {
			var text = data.node.id;
			var tx = text.split('|');
			//alert('id_jabatan = '+tx[1]);

			if ( tx[0] === 'kasubid'){
			$('.distribusi_kegiatan_add #tes').val(tx[1])
			$('.distribusi_kegiatan_add').modal('show');
			}
			


		})
		.on("loaded.jstree", function(){
			$('#ditribusi_renja').jstree('open_all');
		});
	}

	function context_menu_2(node){
		var tree = $('#ditribusi_renja').jstree(true);
	
		// The default set of all items
		var items = {
			                       
			"Remove": {
				"label": "Remove",
				"action": function (obj) { 
					if(confirm('Are you sure to remove this Kegiatan?')){
						tree.delete_node(node);
					}
				}
			}
		};



		if ((node.type === 'ka_skpd')|(node.type === 'kabid')) {
			delete items.Remove;
		}else if (node.type === 'kasubid'){
			delete items.Remove;
		}
		return items;
	}

	
	var to = false;
	$('#cari_keg').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_keg').val();
		$('#ditribusi_renja').jstree(true).search(v);
		}, 250);
	});
	
	

});
</script>
