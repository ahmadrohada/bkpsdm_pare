<!-- ===============================  KEGIATAN TAHUNAN JFT =================================== -->
<div class="row">
	<div class="col-md-5">
		<div class="box box-sasaran ">
			<div class="box-header with-border">
				<h1 class="box-title">
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				
				<input type='text' id = 'cari' class="form-control" placeholder="cari">
				<div class="table-responsive auto">
					<div id="keg_tahunan_5_tree"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-7">
		@include('pare_pns.tables.skp_tahunan-kegiatan_5_edit')
	</div>
</div>

@include('pare_pns.modals.kegiatan_tahunan_jft')
     


<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
	

	function refreshTreeKegTahunan(){
		jQuery('#keg_tahunan_5_tree').jstree(true).refresh(true);
		jQuery('#keg_tahunan_5_tree').jstree().deselect_all(true);
		$('#kegiatan_tahunan_5_table').DataTable().ajax.reload(null,false);
	} 

	
	$('#keg_tahunan_5_tree').jstree({
            'core' : {
						'data' : {
						"url" 	: "{{ url("api_resource/skp_tahunan_kegiatan_5") }}", //Eselon 5
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

				//detail_table(data.instance.get_node(data.selected[0]).id);

			}
	});
	

	function context_add_kegiatan_tahunan(node){
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
					
				}
			}
		};


		if (node.type == "sasaran") {
			delete items.delete;
		}else if (node.type == "default") {
			delete items.tambah;
			delete items.delete;
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
	
	

	
	

</script>
