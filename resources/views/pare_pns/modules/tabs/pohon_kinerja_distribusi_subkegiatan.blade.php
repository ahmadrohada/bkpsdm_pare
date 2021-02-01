<div class="row">
	<div class="col-md-6">


			<div class="box box-primary ">
					<div class="box-header with-border">
						<h1 class="box-title">
							Distibusi Sub Kegiatan
						</h1>
				 
						<div class="box-tools pull-right">
							{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
		
						</div>
					</div>
					<div class="box-body" style="padding-left:0px; padding-right:0px;">
							<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
						
						<div class="table-responsive auto">
								
							<div id="ditribusi_renja" class="demo"></div>
						</div>
					</div>
				</div> 

	</div>
	<div class="col-md-6">
			@include('pare_pns.tables.distribusi_subkegiatan-ka_skpd')
			@include('pare_pns.tables.distribusi_subkegiatan-kabid')
			@include('pare_pns.tables.distribusi_subkegiatan-kasubid')
			{{--  @include('pare_pns.tables.distribusi_subkegiatan-ind_subkegiatan')  --}}


	</div>
</div>



     



@include('pare_pns.modals.distribusi_kegiatan-add')

<script type="text/javascript">
	function initTreeDistribusiSubKegiatan() {
		$('#ditribusi_renja').jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/skpd_renja_distribusi_subkegiatan_tree") }}",
						"data" 	: function (node) {
							return { 	"id" 		: node.id ,
										"data" 		: node.data,
										"renja_id" 	: {!! $renja->id !!},
									 	"skpd_id"  	: {!! $renja->SKPD->id !!}
									};
						},
				}
				
			},
				'check_callback' : true,
				'themes' : { 'responsive' : false },
				'plugins': ['search'] ,
			'contextmenu' : {
					'items' : context_add_kegiatan
				},
			'plugins' : [ 'search','contextmenu','types','state' ],
			'types' : {
					'JPT' 				: { },
					'administrator' 	: { },
					'pengawas' 			: { },
					'pelaksana' 		: { },
					'subkegiatan' 		: { },
					'ind_subkegiatan'	: { },
					'rencana_aksi'		: { }, 
					'keg_bulanan'		: { },
				} 
			
		
	    }).on("loaded.jstree", function(){
			//$('#ditribusi_renja').jstree('open_all');
		}).on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				detail_table_jabatan((data.instance.get_node(data.selected[0]).type)+'|'+(data.instance.get_node(data.selected[0]).id));
			}
		});





	}
	
	function context_add_kegiatan(node){
		var items = {
			"tambah": {
				"label" 	: "Tambah Kegiatan",
				"icon"    	: "faa-ring fa fa-plus animated",
				"action" 	:function(obj){

						var id = node.id;
					
						if ( node.type === 'pengawas'){
							$('.distribusi_kegiatan_add, #tes').val(id);
							//SHOW MODAL UNTUK ADD KEGIATAN
							$('.distribusi_kegiatan_add').modal('show');
						} 	
				}
			},                  
			"delete": {
				"label"	: "Hapus Kegiatan",
				"icon" 	: "faa-ring fa fa-remove animated",
				"action": function (obj) {

					var id = node.id;
					unlink_kegiatan_kasubid(id);
					
					/* if(confirm('Anda Akan menghapus kegiatan jabatan ?')){
						var text = node.id;
						var tx = text.split('|');
						alert(tx[1]);
						//tree.delete_node(node);
					} */
				}
			}
		};


		if (node.type == "pengawas") {
			delete items.delete;
		}else if (node.type == "kegiatan") {
			delete items.tambah;
		}else{
			delete items.delete;
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
		//alert(id);
		switch ( tx[0] ){
			case 'JPT': //KA SKPD KABAN 
						$(".div_ka_skpd").show();
						$(".div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
						load_subkegiatan_ka_skpd(tx[1]);
				
			break;
			case 'administrator': 
						$(".div_kabid").show();
						$(".div_ka_skpd,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
						load_subkegiatan_kabid(tx[1]);
				
			break;
			case 'pengawas': //yang dapat kegiatan nih
						$(".div_kasubid").show();
						$(".div_ka_skpd,.div_kabid,.div_subkegiatan,.div_ind_subkegiatan").hide();
						load_subkegiatan_kasubid(tx[1]);
				
			break;
			case 'subkegiatan':
						$(".div_subkegiatan").show();
						$(".div_ka_skpd,.div_kabid,.div_kasubid,.div_ind_subkegiatan").hide();
						load_subkegiatan2(tx[1]);
				
			break;
			case 'ind_subkegiatan':
						$(".div_ind_subkegiatan").show();
						$(".div_ka_skpd,.div_kabid,.div_kasubid,.div_subkegiatan").hide();
						load_ind_subkegiatan_end2(tx[1]);
				
			break;
			case 'rencana_aksi':
						$(".div_ka_skpd,.div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();	
			break;
			case 'keg_bulanan':
						$(".div_ka_skpd,.div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
			break;
			case 'default':
					$(".div_ka_skpd,.div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
			break;
			default: 
			$(".div_ka_skpd").show();
			$(".div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
						
		
		}
	}
	$(".tutup_detail").click(function(){
		$(".div_ka_skpd").show();
		$(".div_kabid,.div_kasubid,.div_subkegiatan,.div_ind_subkegiatan").hide();
		jQuery('#ditribusi_renja').jstree().deselect_all(true);
	});  
	
	
</script>