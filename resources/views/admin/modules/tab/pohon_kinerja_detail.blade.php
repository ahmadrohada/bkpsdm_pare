<div class="row">
	<div class="left_div col-md-6">
		<div class="box-tools pull-right">
			<i class="btn btn-box-tool fa fa-arrow-right tutup_right_div"></i>
			<i class="btn btn-box-tool fa fa-arrow-left buka_right_div "></i>
		</div>


		<div class="table-responsive">
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="renja_tree_kegiatan" class=""></div>
		</div>
		
	</div>
	<div class="right_div col-md-6">
		@include('admin.tables.pohon_kinerja-tujuan_detail')
		@include('admin.tables.pohon_kinerja-ind_tujuan_detail')
		@include('admin.tables.pohon_kinerja-sasaran_detail')
		@include('admin.tables.pohon_kinerja-ind_sasaran_detail')
		@include('admin.tables.pohon_kinerja-program_detail')
		@include('admin.tables.pohon_kinerja-ind_program_detail')
		@include('admin.tables.pohon_kinerja-kegiatan_detail')
		@include('admin.tables.pohon_kinerja-ind_kegiatan_detail')
		@include('admin.tables.pohon_kinerja-ind_kegiatan2_edit')
		
 
	</div>
</div>



     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>




<script type="text/javascript">

	$('.buka_right_div').hide();
	$(".tutup_right_div").click(function(){
		$('.left_div').removeClass('col-md-6');
		$('.left_div').addClass('col-md-12');

		$('.right_div').hide();
		$('.tutup_right_div').hide();
		$('.buka_right_div').show();

	});
	$(".buka_right_div").click(function(){
		$('.left_div').removeClass('col-md-12');
		$('.left_div').addClass('col-md-6');

		$('.right_div').show();
		$('.tutup_right_div').show();
		$('.buka_right_div').hide();

	});
		
	function RencanaKerjaList() {
		$('#renja_tree_kegiatan')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skpd_renja_aktivity") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $renja->id !!} };
						},
						"dataType" : "json"
				}
				,'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			},
				'plugins' : [/* 'contextmenu', */ 'types' ,'search'],
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
			
		
		})
		.on("loaded.jstree", function(){
			$('#renja_tree_kegiatan').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table(data.instance.get_node(data.selected[0]).id);
			}
		});
	}





	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#cari').val();
			$('#renja_tree_kegiatan').jstree(true).search(v);
		}, 250);
	});
	
	function detail_table(id){

		var tx = id.split('|');
		//alert(tx[0]);


		switch ( tx[0] ){
				case 'tujuan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").show();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_ind_tujuan( tx[1]);
					
				break;
				case 'ind_tujuan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").show();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_sasaran( tx[1]);
					
				break;
				case 'sasaran':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").show();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_ind_sasaran( tx[1]);
					
				break;
				case 'ind_sasaran':
							//alert(tx[0]);
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").show();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_program( tx[1]);
					
				break;
				case 'program':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").show();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_ind_program( tx[1]);
					
				break;
				case 'ind_program':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").show();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
							load_kegiatan( tx[1]);
					
				break;
				case 'kegiatan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").show();
							$(".div_ind_kegiatan_detail").hide();
							//load_ind_kegiatan( tx[1]);
							load_rencana_aksi(tx[1]);
					
				break;
				case 'ind_kegiatan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").show();
							load_ind_kegiatan_end( tx[1]);
					
				break;
				case 'rencana_aksi':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
					
				break;
				case 'kegiatan_bulanan':
							$(".div_misi_detail, .div_tujuan_list").hide();
							$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
							$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
							$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
							$(".div_ind_sasaran_detail, .div_program_list").hide();
							$(".div_program_detail, .div_ind_program_list").hide();
							$(".div_ind_program_detail, .div_kegiatan_list").hide();
							$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
							$(".div_ind_kegiatan_detail").hide();
					
				break;
				
				
				default:
						/* $("#kegiatan_tahunan").show();
						$("#rencana_aksi").hide(); */
				
		}
	}

	$(".tutup_detail").click(function(){
				$(".div_misi_detail, .div_tujuan_list").show();
				$(".div_tujuan_detail, .div_ind_tujuan_list").hide();
				$(".div_ind_tujuan_detail, .div_sasaran_list").hide();
				$(".div_sasaran_detail, .div_ind_sasaran_list").hide();
				$(".div_ind_sasaran_detail, .div_program_list").hide();
				$(".div_program_detail, .div_ind_program_list").hide();
				$(".div_ind_program_detail, .div_kegiatan_list").hide();
				$(".div_kegiatan_detail, .div_rencana_aksi_list").hide();
				$(".div_ind_kegiatan_detail").hide();
				jQuery('#renja_tree_kegiatan').jstree().deselect_all(true);
	}); 

</script>
