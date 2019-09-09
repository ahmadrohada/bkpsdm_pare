<!-- ========================== edit form URAIAN TUGAS JABATAN ESELON 3 , PADA SKP TAHUNAN  ======================================= -->

<div class="row">
	<div class="col-md-5">

		<div class="table-responsive">
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="keg_tahunan_3_tree"></div>
			
		</div>
		
	</div>
	<div class="col-md-7">
		@include('admin.tables.skp_tahunan-kegiatan_3_edit')
		@include('admin.tables.skp_tahunan-rencana_aksi_3_edit')

		<div id='rencana_aksi_detail' hidden>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Rencana Aksi
					</h1>

					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_detail_kegiatan_tahunan','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">

					<strong>Label</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="kegiatan_tahunan_label"></span>
						<input type="hidden" class="kegiatan_tahunan_id">
					</p>

					<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
					<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
					
				</div>
			</div>
		</div>

		<div id='indikator_kegiatan_detail' hidden>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Indikator Kegiatan
					</h1>

					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_detail_kegiatan_tahunan','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">

					<strong>Label</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="indikator_kegiatan_label"></span>
					</p>

					<i class="fa fa-industry"></i> <span class="txt_output_indikator_kegiatan" style="margin-right:10px;"></span>
					
				</div>
			</div>
		</div>

		
	</div>
</div>

@include('admin.modals.rencana_aksi')
     


<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
	

	
	function initTreeKegTahunan() {
		$('#keg_tahunan_3_tree')
		.on("loaded.jstree", function(){
			$('#keg_tahunan_3_tree').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				detail_table(data.instance.get_node(data.selected[0]).id);
			}
		})
		.jstree({
            'core' : {
						'data' : {
						"url" 	: "{{ url("api_resource/skp_tahunan_kegiatan_3") }}", //Eselon 4
						"data" 	: function (node) {
							return  {   "renja_id" : {!! $skp->Renja->id !!} , 
                                        "jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}
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
	}

	
	
	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari').val();
		$('#keg_tahunan_3_tree').jstree(true).search(v);
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
					$("#rencana_aksi").show();
					$("#indikator_kegiatan_detail").hide();
					$("#rencana_aksi_detail").hide();
                  	load_rencana_aksi( tx[1]);
                       
				break; 
				case 'KegiatanRenja':
					show_modal_create(tx[1]);
				break;
				case 'RencanaAksi':
					$("#kegiatan_tahunan").hide();
					$("#rencana_aksi").hide();
					$("#indikator_kegiatan_detail").hide();
					$("#rencana_aksi_detail").show();
					load_rencana_aksi_detail( tx[1]);	
				break;
				case 'IndikatorKegiatan':
					$("#kegiatan_tahunan").hide();
					$("#rencana_aksi").hide();
					$("#indikator_kegiatan_detail").show();
					$("#rencana_aksi_detail").hide();
					load_indikator_kegiatan_detail( tx[1]);	

				break;
				default:
					$("#kegiatan_tahunan").show();
					$("#rencana_aksi").hide();
					$("#indikator_kegiatan_detail").hide();
					$("#rencana_aksi_detail").hide();
				
			}
		

    }
    

    $(".tutup_detail_detail_kegiatan_tahunan").click(function(){
			$("#kegiatan_tahunan").show();
			$("#rencana_aksi").hide();
			jQuery('#keg_tahunan_3_tree').jstree().deselect_all(true);
	}); 
	
	


	

	
	function load_indikator_kegiatan_detail(id){
		$.ajax({
				url			: '{{ url("api_resource/ind_kegiatan_detail") }}',
				data 		: {ind_kegiatan_id : id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						
						$('.indikator_kegiatan_label').html(data['label']);
						$('.txt_output_indikator_kegiatan').html(data['target']+" "+data['satuan']);
						
				},
				error: function(data){
					
				}						
		});
	}
	
	
	function load_rencana_aksi_detail(rencana_aksi_id){



		$.ajax({
				url			: '{{ url("api_resource/rencana_aksi_detail") }}',
				data 		: {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.kegiatan_tahunan_id').val(data['id']);
						$('.kegiatan_tahunan_label').html(data['label']);
						$('.txt_output').html(data['target_rencana_aksi']+" "+data['satuan_target_rencana_aksi']);
						$('.txt_waktu').html(data['waktu_pelaksanaan']);
						
				},
				error: function(data){
					
				}						
		});
	}

	
	
	
	function load_rencana_aksi(kegiatan_tahunan_id){

		

		$.ajax({
				url			: '{{ url("api_resource/kegiatan_tahunan_detail") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.kegiatan_tahunan_id').val(data['id']);
						$('.kegiatan_renja_id').val(data['kegiatan_renja_id']);
						$('.kegiatan_tahunan_label').html(data['label']);
						$('.txt_ak').html(data['ak']);
						$('.txt_output').html(data['output']);
						$('.txt_waktu_pelaksanaan').html(data['target_waktu'] +' bulan');
						$('.txt_cost').html('Rp. ' +data['cost']);
						$('.txt_kualitas').html(data['quality']+" %");

						document.getElementById('list_indikator').innerHTML = "";
						var bawahan = document.getElementById('list_indikator');
						for(var i = 0 ; i < data['list_indikator'].length; i++ ){
							 
							$("<tr><td>"+ (i+1) +"</td><td>"+data['list_indikator'][i].label+"</td><td>"+data['list_indikator'][i].target+" "+data['list_indikator'][i].satuan+"</td></tr>").appendTo(bawahan);
						}
						
				},
				error: function(data){
					
				}						
		});


		var table_rencana_aksi = $('#rencana_aksi_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			    : [ 2 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5 ] },
								  { 'orderable': false , targets: [2]  } 
								],
				ajax			: {
									url	: '{{ url("api_resource/skp_tahunan_rencana_aksi") }}',
									data: { kegiatan_tahunan_id: kegiatan_tahunan_id },
								},
								columns			: [
									{ data: 'rencana_aksi_id' , width:"10%",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "label", name:"label"},
									{ data: "pelaksana", name:"pelaksana",
										"render": function ( data, type, row ) {
											if (row.kegiatan_bulanan >= 1){
												return "<p class='text-info'>"+row.pelaksana+"</p>";
											}else{
												return "<p class='text-warning'>"+row.pelaksana+"</p>";
											}
										}
									},
									{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan"},
									{ data: "target", name:"target"},
									
									{  data: 'action',width:"15%",
											"render": function ( data, type, row ) {
												if (row.kegiatan_bulanan >= 1){
													return  '<span  data-toggle="tooltip" title="" style="margin:1px;" ><a class="btn btn-default btn-xs "  ><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="" style="margin:1px;" ><a class="btn btn-default btn-xs " ><i class="fa fa-close " ></i></a></span>';
											
												}else{
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_rencana_aksi"  data-id="'+row.rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_rencana_aksi"  data-id="'+row.rencana_aksi_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											
												}
												
													
										
										}
									},
								
								],
								initComplete: function(settings, json) {
								
							}
				
							
			
		});	
	}

</script>
