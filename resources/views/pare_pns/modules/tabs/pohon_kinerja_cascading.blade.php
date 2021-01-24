

<div class="row"> 
	<div class="left_div col-md-6">


		<div class="box box-primary ">
			<div class="box-header with-border">
				<h1 class="box-title">
					Pohon Kinerja ( {{$renja->periode->label}} ) 
				</h1>
		
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
					<i class="btn btn-box-tool fa fa-arrow-right tutup_right_div"></i>
					<i class="btn btn-box-tool fa fa-arrow-left buka_right_div "></i>
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				<input type='text' id = 'cari_pk' class="form-control" placeholder="cari">
				
				<div class="table-responsive auto">
					<div id="renja_tree_kegiatan" class=""></div>
				</div>
			</div>
		</div>
		
		



		
		
	</div> 
	<div class="right_div col-md-6">
		@include('pare_pns.tables.pohon_kinerja-tujuan_top')
		@include('pare_pns.tables.pohon_kinerja-tujuan')
		@include('pare_pns.tables.pohon_kinerja-sasaran')
		@include('pare_pns.tables.pohon_kinerja-program')
		@include('pare_pns.tables.pohon_kinerja-kegiatan')
		@include('pare_pns.tables.pohon_kinerja-subkegiatan')
		@include('pare_pns.tables.pohon_kinerja-ind_subkegiatan')
		
 
	</div>
</div>

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


		
	function renja_list_kegiatan_tree() {

		$('#renja_tree_kegiatan').jstree({
			'core' : {
				'data' : {
					'url' : "{{ url("api/skpd_pohon_kinerja") }}",   
					'data' : function (node) {
						return { 	"id" 		: node.id ,
									"data" 		: node.data,
									"renja_id" 	: {!! $renja->id !!}
								};
					}
				}
			},
			
			'check_callback' : true,
			'themes' : { 'responsive' : false },
			'plugins': ['search'] ,
			
		}).on("loaded.jstree", function(){
				//$('#renja_tree_kegiatan').jstree('open_all');
		}).on("changed.jstree", function (e, data) {
				if(data.selected.length) {
					//alert((data.instance.get_node(data.selected[0]).data)+'|'+(data.instance.get_node(data.selected[0]).id));
					//detail_table((data.instance.get_node(data.selected[0]).data)+'|'+(data.instance.get_node(data.selected[0]).id));
					detail_table(data.instance.get_node(data.selected[0]).id);
				}
		}); 

	}



	var to = false;
	$('#cari_pk').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#cari_pk').val();
			$('#renja_tree_kegiatan').jstree(true).search(v);
		}, 250);
	});
	
	function detail_table(id){

		var tx = id.split('|');
		switch ( tx[0] ){
				case 'tujuan':
							load_tujuan( tx[1]);
							$(".div_tujuan").show();
							$(".div_tujuan_top,.div_sasaran,.div_program,.div_kegiatan,.div_subkegiatan,.div_ind_subkegiatan").hide();
							
					
				break;
				case 'sasaran':
							load_sasaran( tx[1]);
							$(".div_sasaran").show();
							$(".div_tujuan_top,.div_tujuan,.div_program,.div_kegiatan,.div_subkegiatan,.div_ind_subkegiatan").hide();
						
							
					
				break;
				case 'program':
							load_program( tx[1]);
							$(".div_program").show();
							$(".div_tujuan_top,.div_tujuan,.div_sasaran,.div_kegiatan,.div_subkegiatan,.div_ind_subkegiatan").hide();
						
					
				break;
				case 'kegiatan':
							load_kegiatan( tx[1]);
							$(".div_kegiatan").show();
							$(".div_tujuan_top,.div_tujuan,.div_sasaran,.div_program,.div_subkegiatan,.div_ind_subkegiatan").hide();
	
				break;
				case 'subkegiatan':
							load_subkegiatan( tx[1]);
							$(".div_subkegiatan").show();
							$(".div_tujuan_top,.div_tujuan,.div_sasaran,.div_program,.div_kegiatan,.div_ind_subkegiatan").hide();
				break;
				case 'ind_subkegiatan':
							load_ind_subkegiatan( tx[1]);
							$(".div_ind_subkegiatan").show();
							$(".div_tujuan_top,.div_tujuan,.div_sasaran,.div_program,.div_kegiatan,.div_subkegiatan").hide();
				break;
				
				
				default:
						/* $("#kegiatan_tahunan").show();
						$("#rencana_aksi").hide(); */
				
		}
	}

	$(".tutup_detail").click(function(){
				$(".div_tujuan_top").show();
				$(".div_tujuan,.div_sasaran,.div_program,.div_kegiatan,.div_subkegiatan,.div_ind_subkegiatan").hide();
				jQuery('#renja_tree_kegiatan').jstree().deselect_all(true);
	}); 

</script>
