

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
		@include('admin.tables.pohon_kinerja-tujuan_edit')
		@include('admin.tables.pohon_kinerja-ind_tujuan_edit')
		@include('admin.tables.pohon_kinerja-sasaran_edit')
		@include('admin.tables.pohon_kinerja-ind_sasaran_edit')
		@include('admin.tables.pohon_kinerja-program_edit')
		@include('admin.tables.pohon_kinerja-ind_program_edit')
		@include('admin.tables.pohon_kinerja-kegiatan_edit')
		@include('admin.tables.pohon_kinerja-ind_kegiatan_edit')
		@include('admin.tables.pohon_kinerja-ind_kegiatan2_edit')
		
 
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
					'url' : "{{ url("api_resource/skpd_pohon_kinerja") }}",  
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
					//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
					detail_table((data.instance.get_node(data.selected[0]).data)+'|'+(data.instance.get_node(data.selected[0]).id));
					
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
							$(".div_tujuan_list").hide();
							
							//Tujuan
							$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").show();
							//Sasaran
							$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").hide();
							//Program
							$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").hide();
							//kegiatan
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							//Indikator Kegiatan
							$(".div_ind_kegiatan_detail").hide();

							load_ind_tujuan( tx[1]);
							load_sasaran( tx[1]);
					
				break;
				case 'sasaran':
							$(".div_tujuan_list").hide();

							//Tujuan
							$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").hide();
							//Sasaran
							$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").show();
							//Program
							$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").hide();
							//kegiatan
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							//Indikator Kegiatan
							$(".div_ind_kegiatan_detail").hide();
							load_ind_sasaran( tx[1]);
							load_program( tx[1]);
					
				break;
				case 'program':
							$(".div_tujuan_list").hide();
							//Tujuan
							$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").hide();
							//Sasaran
							$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").hide();
							//Program
							$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").show();
							//kegiatan
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							//Indikator Kegiatan
							$(".div_ind_kegiatan_detail").hide();
						
							/* $(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							$(".div_ind_kegiatan_detail").hide(); */
							load_ind_program( tx[1]);
							load_kegiatan( tx[1]);
					
				break;
				case 'kegiatan':
							$(".div_tujuan_list").hide();
							//Tujuan
							$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").hide();
							//Sasaran
							$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").hide();
							//Program
							$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").hide();
							//kegiatan
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").show();
							//Indikator Kegiatan
							$(".div_ind_kegiatan_detail").hide();
							load_ind_kegiatan( tx[1]);
					
				break;
				case 'ind_kegiatan':
							$(".div_tujuan_list").hide();
							//Tujuan
							$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").hide();
							//Sasaran
							$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").hide();
							//Program
							$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").hide();
							//kegiatan
							$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
							//Indikator Kegiatan
							$(".div_ind_kegiatan_detail").show();
							load_ind_kegiatan_end( tx[1]);
					
				break;
				
				
				default:
						/* $("#kegiatan_tahunan").show();
						$("#rencana_aksi").hide(); */
				
		}
	}

	$(".tutup_detail").click(function(){
				$(".div_tujuan_list").show();
				//Tujuan
				$(".div_tujuan_detail, .div_ind_tujuan_list,.div_sasaran_list").hide();
				//Sasaran
				$(".div_sasaran_detail, .div_ind_sasaran_list,.div_program_list").hide();
				//Program
				$(".div_program_detail, .div_ind_program_list,.div_kegiatan_list").hide();
				//kegiatan
				$(".div_kegiatan_detail, .div_ind_kegiatan_list").hide();
				//Indikator Kegiatan
				$(".div_ind_kegiatan_detail").hide();
				jQuery('#renja_tree_kegiatan').jstree().deselect_all(true);
	}); 

</script>
