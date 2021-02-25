<div class="row">
	<div class="col-md-5">
		<div class="box box-primary ">
			<div class="box-header with-border"> 
				<h1 class="box-title">
					Kegiatan SKP Tahunan 
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				<input type='text' id = 'cari' class="form-control" placeholder="cari">
				<div class="table-responsive auto">
					<div id="kegiatan_skp_tahunan_3"></div>
				</div>
			</div>
		</div>
		
		
	</div> 
	<div class="col-md-7">
		@include('pare_pns.tables.rencana_aksi-kegiatan_skp_tahunan_top')
		@include('pare_pns.tables.rencana_aksi-kegiatan_skp_tahunan')
		@include('pare_pns.tables.rencana_aksi-rencana_aksi_3')

		<!-- ========================== DETAIL RENVANA AKSI ====================================== -->
		<div id='rencana_aksi_detail' hidden>
			<div class="box box-rencana_aksi">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Rencana Aksi
					</h1>

					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">
					
					<strong>Rencana Aksi</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="rencana_aksi_label"></span>
					</p>

					<strong>Pelaksana</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="pelaksana"></span>
					</p>

					<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
					<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
					
				</div>
			</div>
		</div>
		<!-- ============================================================================================== -->

		

		
	</div>
</div>

@include('pare_pns.modals.rencana_aksi')
     


<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function refreshTreeKegTahunan(){
		jQuery('#kegiatan_skp_tahunan_3').jstree(true).refresh(true);
		jQuery('#kegiatan_skp_tahunan_3').jstree().deselect_all(true);
		//$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
		
	} 
	
	$('#kegiatan_skp_tahunan_3').jstree({
				'core' : {
					'data' : {
							"url" 	: "{{ url("api/kegiatan_skp_tahunan_3_tree") }}", 
							'data' : function (node) {
								return { 	"id" 		: node.id ,
											"data" 		: node.data,
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_tahunan_id" : {!! $skp->id !!}
										};
									}
							}
				},
						'check_callback' : true,
						'themes' : { 'responsive' : false },
						'plugins': ['search'] ,
				}).on("loaded.jstree", function(){
					//$('#kegiatan_tahunan_kaban').jstree('open_all');
				}).on("changed.jstree", function (e, data) {
					if(data.selected.length) {
						detail_table((data.instance.get_node(data.selected[0]).data)+'|'+(data.instance.get_node(data.selected[0]).id));
					}
				});
	

	
	
	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari').val();
		$('#kegiatan_skp_tahunan_3').jstree(true).search(v);
		}, 250);
	});
	
	//========================== KEGIATAN ==================================//
	function detail_table(id){

		var tx = id.split('|');
		
		
		switch ( tx[0] ){
                case 'kegiatan_skp_tahunan':
					//alert(tx[0])
					load_kegiatan_skp_tahunan( tx[1]);
                  	$(".div_kegiatan_skp_tahunan").show();
					$(".div_kegiatan_skp_tahunan_top,.div_rencana_aksi").hide();

                  	
				break; 
				case 'ind_kegiatan_skp_tahunan':
					//alert(tx[0])
					load_ind_kegiatan_skp_tahunan( tx[1]);
					$(".div_rencana_aksi").show();
					$(".div_kegiatan_skp_tahunan_top,.div_kegiatan_skp_tahunan").hide();
				break;
				case 'rencana_aksi':
					$("#kegiatan_tahunan").hide();
					$("#indikator_kegiatan").hide();
					$("#rencana_aksi").hide();
					$("#rencana_aksi_detail").show();
					load_rencana_aksi_detail( tx[1]);	
				break;
				case 'kegiatan_bulanan':
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
    

    $(".tutup_detail").click(function(){
			$(".div_kegiatan_skp_tahunan_top").show();
			$(".div_kegiatan_skp_tahunan,.div_rencana_aksi").hide();
			jQuery('#kegiatan_skp_tahunan_3').jstree().deselect_all(true);
	}); 
	
	function load_rencana_aksi_detail(rencana_aksi_id){
		$.ajax({
				url			: '{{ url("api/rencana_aksi_detail") }}',
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
