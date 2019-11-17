<div class="row">
	<div class="col-md-5">

		<div class="table-responsive">
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="keg_tahunan_5_tree"></div>
			
		</div>
		
	</div>
	<div class="col-md-7">
		@include('admin.tables.skp_tahunan-kegiatan_5_edit')

	

		
	</div>
</div>

@include('admin.modals.kegiatan_tahunan_jft')
     


<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
	

	
	function initTreeKegTahunan() {
		$('#keg_tahunan_5_tree')
		
		.jstree({
            'core' : {
						'data' : {
						"url" 	: "{{ url("api_resource/skp_tahunan_kegiatan_5") }}", //Eselon 4
						"data" 	: function (node) {
							return  {   "renja_id" 			: {!! $skp->Renja->id !!} , 
                                        "jabatan_id" 		: {!! $skp->PejabatYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" 	: {!! $skp->id !!}
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
					'items' : context_add_kegiatan_tahunan
				
			}
			,"plugins" : [ "search","state","contextmenu","types"/* ,"wholerow" */ ],
			'types' : {
					'JPT' 				: { "disabled" : true },
					'sasaran' 			: { },
					'kegiatan' 			: { }
				}
			
		
	    })
		.on("loaded.jstree", function(){
			//$('#keg_tahunan_5_tree').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {

				detail_table(data.instance.get_node(data.selected[0]).id);

			}
		});
	}

	function context_add_kegiatan_tahunan(node){

		//alert(node.type);

		var items = {
			"tambah": {
				"label" 	: "Tambah Kegiatan",
				"icon"    	: "faa-ring fa fa-plus animated",
				"action" 	:function(obj){

						var text = node.id;
						var tx = text.split('|');
						//alert('id_jabatan = '+tx[1]);
					
						if ( node.type === 'sasaran'){
							//$('.modal-kegiatan_tahunan_jft, .sasaran_id').val(tx[1]);
							//SHOW MODAL UNTUK ADD KEGIATAN TAHUNAN
							//$('.modal-kegiatan_tahunan_jft').modal('show');
							show_modal_kegiatan(tx[1]);
						} 	
				}
			},                  
			"delete": {
				"label"	: "Hapus Kegiatan",
				"icon" 	: "faa-ring fa fa-remove animated",
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


		if (node.type == "sasaran") {
			delete items.delete;
		}else if (node.type == "kegiatan_tahunan") {
			delete items.tambah;
		}else{
			//delete items.delete;
			//delete items.tambah;
		}
		return items;
	}
	
	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari').val();
		$('#keg_tahunan_5_tree').jstree(true).search(v);
		}, 250);
	});
	
	//========================== KEGIATAN ==================================//
	function detail_table(id){

		var tx = id.split('|');
		//alert(tx[0])
		
		switch ( tx[0] ){
                case 'KegiatanTahunan':
                  	//SHOW DETAIL KEGIATAN TAHUNAN DAN RENCANA KERJA LIST
                  	$("#kegiatan_tahunan").hide();
					$("#indikator_kegiatan").show();
					$("#rencana_aksi").hide();
					$("#rencana_aksi_detail").hide();

                  	load_indikator_kegiatan( tx[1]);
				break; 
				case 'KegiatanRenja':
					show_modal_create(tx[1]);
				break;
				case 'IndikatorKegiatan':
					$("#kegiatan_tahunan").hide();
					$("#indikator_kegiatan").hide();
					$("#rencana_aksi").show();
					$("#rencana_aksi_detail").hide();
					load_rencana_aksi( tx[1]);	
					rencana_aksi_list( tx[1]);

				break;
				case 'RencanaAksi':
					$("#kegiatan_tahunan").hide();
					$("#indikator_kegiatan").hide();
					$("#rencana_aksi").hide();
					$("#rencana_aksi_detail").show();
					load_rencana_aksi_detail( tx[1]);	
				break;
				case 'KegiatanBulanan':
					$("#kegiatan_tahunan").hide();
					$("#indikator_kegiatan").hide();
					$("#rencana_aksi").hide();
					$("#rencana_aksi_detail").show();
					load_rencana_aksi_detail( tx[1]);	
				break;
				
				default:
					$("#kegiatan_tahunan").show();
					$("#indikator_kegiatan").hide();
					$("#rencana_aksi").hide();
					$("#rencana_aksi_detail").hide();
				
			}
		

    }
    

    $(".tutup").click(function(){
			$("#kegiatan_tahunan").show();
			$("#indikator_kegiatan").hide();
			$("#rencana_aksi").hide();
			$("#rencana_aksi_detail").hide();
			jQuery('#keg_tahunan_5_tree').jstree().deselect_all(true);
	}); 
	
	function load_rencana_aksi_detail(rencana_aksi_id){
		$.ajax({
				url			: '{{ url("api_resource/rencana_aksi_detail") }}',
				data 		: {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.pelaksana').html(data['pelaksana']);
						$('.rencana_aksi_label').html(data['label']);
						$('.txt_output').html(data['target_rencana_aksi']+" "+data['satuan_target_rencana_aksi']);
						$('.txt_waktu').html(data['waktu_pelaksanaan']);
						
				},
				error: function(data){
					
				}						
		});
	}

	
	

</script>
