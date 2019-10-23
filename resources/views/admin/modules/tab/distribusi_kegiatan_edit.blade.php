<div class="row">
	<div class="col-md-5">
		<div class="table-responsive">
			<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
			<div id="ditribusi_renja" class="demo"></div>
		</div>
	</div>
	<div class="col-md-7">
			@include('admin.tables.distribusi_kegiatan-ka_skpd')
			@include('admin.tables.distribusi_kegiatan-kabid')
			@include('admin.tables.distribusi_kegiatan-kasubid')
			@include('admin.tables.distribusi_kegiatan-ind_kegiatan_edit')
			@include('admin.tables.distribusi_kegiatan-ind_kegiatan2_edit')


	</div>
</div>



     



@include('admin.modals.distribusi_kegiatan-add')

<script type="text/javascript">
	function initTreeDistribusiKegiatan() {
		$('#ditribusi_renja')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skpd_renja_distribusi_kegiatan_tree") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $renja->id !!},
									 "skpd_id"  : {!! $renja->SKPD->id !!}
									 };
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
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table_jabatan(data.instance.get_node(data.selected[0]).id);
			}
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
							$('.distribusi_kegiatan_add, #tes').val(tx[1]);
							//SHOW MODAL UNTUK ADD KEGIATAN
							$('.distribusi_kegiatan_add').modal('show');
						} 	
				}
			},                  
			"delete": {
				"label": "Hapus Kegiatan",
				"action": function (obj) {
					var text = node.id;
					var tx = text.split('|');
					unlink_kegiatan_kasubid(tx[1]);
					
					/* if(confirm('Anda Akan menghapus kegiatan jabatan ?')){
						var text = node.id;
						var tx = text.split('|');
						alert(tx[1]);
						//tree.delete_node(node);
					} */
				}
			}
		};
		if ((node.type === 'ka_skpd')|(node.type === 'kabid')) {
			delete items.tambah;
			delete items.delete;
		}else if (node.type === 'kasubid'){
			delete items.delete;
		} else if (node.type === 'kegiatan'){
			delete items.tambah;
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
	function detail_table_jabatan(id){
		var tx = id.split('|');
		//alert(tx[1]);
		switch ( tx[0] ){
			case 'ka_skpd':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_ka_skpd(tx[1]);
				
			break;
			case 'kabid':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").show();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_kabid(tx[1]);
				
			break;
			case 'kasubid':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").show();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_kasubid(tx[1]);
				
			break;
			case 'kegiatan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").show();
						$(".div_ind_kegiatan_detail").hide();
						load_ind_kegiatan2( tx[1]);
				
			break;
			case 'ind_kegiatan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
						$(".div_ind_kegiatan_detail").show();
						load_ind_kegiatan_end2( tx[1]);
				
			break;
			default: 
			$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
			$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
			$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
			$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
			$(".div_ind_kegiatan_detail").hide();
						
		
		}
	}
	$(".tutup_detail").click(function(){
		$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
		$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
		$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
		$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
		$(".div_ind_kegiatan_detail").hide();
		jQuery('#ditribusi_renja').jstree().deselect_all(true);
	});  
	
	
</script>