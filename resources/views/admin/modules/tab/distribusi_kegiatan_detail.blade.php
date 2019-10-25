<div class="row">
	<div class="col-md-5">
		<div class="table-responsive">
			<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
			<div id="ditribusi_renja"></div>
		</div>
	</div>
	<div class="col-md-7">
			@include('admin.tables.distribusi_kegiatan-ka_skpd')
			@include('admin.tables.distribusi_kegiatan-kabid')
			@include('admin.tables.distribusi_kegiatan-kasubid_detail')
			@include('admin.tables.distribusi_kegiatan-ind_kegiatan_detail')
			@include('admin.tables.distribusi_kegiatan-ind_kegiatan2_edit')
 

	</div>
</div>

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
			},
			
			"plugins" : [ 'search','types','state' ],
			'types' : {
					'JPT' 				: { "disabled" : true },
					'administrator' 	: { },
					'pengawas' 			: { },
					'pelaksana' 		: { },
					'kegiatan' 			: { },
				}
			
		
	    })
		.on("loaded.jstree", function(){
			$('#ditribusi_renja').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table_jabatan(data.instance.get_node(data.selected[0]).id , data.instance.get_node(data.selected[0]).type);
			}
		});
	}

	var to = false;
	$('#cari_keg').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_keg').val();
		$('#ditribusi_renja').jstree(true).search(v);
		}, 250);
	});


	function detail_table_jabatan(id,type){

		var id 		= id;
		var type 	= type;
		var tx = id.split('|');

		switch ( type ){
			case 'JPT':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_ka_skpd(tx[1]);
				
			break;
			case 'administrator':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").show();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_kabid(tx[1]);
				
			break;
			case 'pengawas':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").show();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").hide();
						load_kegiatan_kasubid(tx[1]);
				
			break;
			case 'kegiatan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").show();
						$(".div_ind_kegiatan_detail").hide();
						load_rencana_aksi2(tx[1]);
				
			break;
			case 'ind_kegiatan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").show();
						load_ind_kegiatan_end2( tx[1]);
				
				break;
				case 'rencana_aksi':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").hide();
					
				break;
				case 'kegiatan_bulanan':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
						$(".div_ind_kegiatan_detail").hide();
					
				break;
				case 'pelaksana':
						$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
						$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
						$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
						$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
						$(".div_ind_kegiatan_detail").hide();
				break;
				case 'default':
							$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").hide();
							$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
							$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							//load_ind_kegiatan_end2(id);
					
				break;

				default: 
				$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
				$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
				$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
				$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
				$(".div_ind_kegiatan_detail").hide();
						
		
		}
	}

	$(".tutup_detail").click(function(){
		$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
		$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
		$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
		$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
		$(".div_ind_kegiatan_detail").hide();
		jQuery('#ditribusi_renja').jstree().deselect_all(true);
	});  
	
	
</script>
