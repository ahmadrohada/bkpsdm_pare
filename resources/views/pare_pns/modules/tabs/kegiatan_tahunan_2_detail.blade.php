<!-- ========================== edit form URAIAN TUGAS JABATAN ESELON 3 , PADA SKP TAHUNAN  ======================================= -->
<div class="row">
	<div class="col-md-5" >
		<div class="box box-primary ">
			<div class="box-header with-border">
				<h1 class="box-title">
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				<input type='text' id = 'cari_ktj' class="form-control" placeholder="cari">
				<div class="table-responsive auto">
					<div id="kegiatan_tahunan_kabid" class="demo"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-7">
		@include('pare_pns.tables.skp_tahunan-kegiatan_2_detail')
		@include('pare_pns.tables.skp_tahunan-indikator_kegiatan_2_detail')
		@include('pare_pns.tables.skp_tahunan-rencana_aksi_2_detail')

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

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
	
	function refreshTreeKegTahunan(){
		jQuery('#kegiatan_tahunan_kabid').jstree(true).refresh(true);
		jQuery('#kegiatan_tahunan_kabid').jstree().deselect_all(true);
		//$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
		
	} 


		$('#kegiatan_tahunan_kabid')
		.on("loaded.jstree", function(){
			//$('#kegiatan_tahunan_kabid').jstree('open_all');
			
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				detail_table(data.instance.get_node(data.selected[0]).id);
			
			}
		})
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/skp_tahunan_subkegiatan_2") }}", 
						"data" 	: function (node) {
							return  {   "renja_id" 			: {!! $skp->Renja->id !!} , 
                          				"jabatan_id" 		: {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
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
			,"plugins" : [ "search"/* ,"state","contextmenu","wholerow" */ ]
			
		
	    });
	
	
	
	var to = false;
	$('#cari_ktj').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_ktj').val();
		$('#kegiatan_tahunan_kabid').jstree(true).search(v);
		}, 250);
	});
	
	


	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table(id){

		var tx = id.split('|');
		


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
			jQuery('#keg_tahunan_3_tree').jstree().deselect_all(true);
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
