<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
			<div id="ditribusi_renja" class="demo"></div>
		</div>
	</div>
	<div class="col-md-6">
			@include('admin.tables.renja-kegiatan_ka_skpd_edit')
			@include('admin.tables.renja-kegiatan_kabid_edit')
			@include('admin.tables.renja-kegiatan_kasubid_edit')
			@include('admin.tables.renja-ind_kegiatan_edit')



	</div>
</div>



     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>


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


	function detail_table_jabatan(id){

		var tx = id.split('|');

		//alert(tx[1]);

		switch ( tx[0] ){
			case 'ka_skpd':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail").hide();
						load_kegiatan_ka_skpd(tx[1]);
				
			break;
			case 'kabid':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").show();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail").hide();
						load_kegiatan_kabid(tx[1]);
				
			break;
			case 'kasubid':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").show();
						$(".div_kegiatan_detail").hide();
						load_kegiatan_kasubid(tx[1]);
				
			break;
			case 'kegiatan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail").show();
						load_ind_kegiatan( tx[1]);;
				
			break;
			default: 
						
		
		}
	}

	$(".tutup_detail_jabatan").click(function(){
		$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
		$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
		$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
		$(".div_kegiatan_detail").hide();
	}); 
	
	
</script>
