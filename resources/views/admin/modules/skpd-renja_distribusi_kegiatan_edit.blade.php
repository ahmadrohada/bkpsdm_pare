
<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
<div id="ditribusi_renja" class="demo"></div>
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>


@include('admin.modals.distribusi_kegiatan-add')

<script type="text/javascript">
$(document).ready(function() {
	
	
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
					'items' : context_add_kegiatan
				},
			"plugins" : [ 'search','contextmenu','types','state'/*,'dnd' ,"state","wholerow" */ ],
			'types' : {
					'ka_skpd' 		: { "disabled" : true },
					'kabid' 	: {  },
					'kasubid' 	: { /* options */ },
					'kegiatan' 	: { /* options */ },
				}
			
		
	    })
		.on("loaded.jstree", function(){
			$('#ditribusi_renja').jstree('open_all');
		});
	}

	function context_add_kegiatan(node){

		//diferent label
		if ((node.type === 'ka_skpd')|(node.type === 'kabid')) {
			var addLabel = 'Tambah Bawahan';
		}else{
			var addLabel = 'Tambah Kegiatan';
		}

		//var tree = $('#ditribusi_renja').jstree(true);
	
		// The default set of all items
		var items = {
			"tambah": {
				"label" : addLabel,
				"action" :function(obj){
					
						var text = node.id;
						var tx = text.split('|');
						//alert('id_jabatan = '+tx[1]);

						if ( tx[0] === 'kasubid'){
							$('.distribusi_kegiatan_add #tes').val(tx[1])
							$('.distribusi_kegiatan_add').modal('show');
						} 	
				}
			},                  
			"delete": {
				"label": "Hapus Kegiatan",
				"action": function (obj) { 
					if(confirm('Are you sure to remove this Kegiatan?')){
						tree.delete_node(node);
					}
				}
			}
		};



		if ((node.type === 'ka_skpd')|(node.type === 'kabid')) {
			delete items.tambah;
			delete items.delete;
		}else if (node.type === 'kasubid'){
			delete items.delete;
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
