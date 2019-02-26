<div class="row">
	<div class="col-md-5">

		<div class="table-responsive">
			<input type='text' id = 'cari' class="form-control" placeholder="cari">
			<div id="kegiatan_tahunan_pelaksana"></div>
			
		</div>
		
	</div>
	<div class="col-md-7">
		<div class="box box-primary" id='kegiatan_tahunan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Kegiatan Tahunan
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="kegiatan_tahunan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN TAHUNAN</th>
							<th rowspan="2">AK</th>
							<th colspan="4">TARGET</th>
						</tr>
						<tr>
							<th>OUTPUT</th>
							<th>MUTU</th>
							<th>WAKTU</th>
							<th>BIAYA</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>
		<div id='rencana_aksi' hidden>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Kegiatan Tahunan
					</h1>

					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">

					<strong>Kegiatan Tahunan</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="kegiatan_tahunan_label"></span>
						<input type="hidden" class="kegiatan_tahunan_id">
					</p>

					<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
					<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
					<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
					<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>
					
				</div>
			</div>



			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						List Kegiatan Bulanan
					</h1>

				</div>
				<div class="box-body table-responsive">
					<div class="toolbar">
					</div>

					<table id="rencana_aksi_table" class="table table-striped table-hover" >
						<thead>
							<tr>
								<th>No</th>
								<th>KEGIATAN BULANAN</th>
								<th>WAKTU</th>
							</tr>
						</thead>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>



     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function initTreeKegTahunan() {
		$('#kegiatan_tahunan_pelaksana')
		.on("loaded.jstree", function(){
			//$('#kegiatan_tahunan_pelaksana').jstree('open_all');
			
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				detail_table(data.instance.get_node(data.selected[0]).id);
			
			}
		})
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skp_tahunan_kegiatan_4") }}", 
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
		$('#kegiatan_tahunan_pelaksana').jstree(true).search(v);
		}, 250);
	});
	
	


	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table(id){

		var tx = id.split('|');
	


		switch ( tx[0] ){
                case 'KegiatanTahunan':
                          //SHOW DETAIL KEGIATAN TAHUNAN DAN RENCANA KERJA LIST
                            $("#kegiatan_tahunan").hide();
						    						$("#rencana_aksi").show();
                            load_rencana_aksi( tx[1]);
                       
                break;
                case 'KegiatanRenja':
                           

				break;
				case 'RencanaAksi':
                        

				break;
				
				default:
						
				
			}
		

    }
    

    $(".tutup_detail").click(function(){
			$("#kegiatan_tahunan").show();
			$("#rencana_aksi").hide();
			jQuery('#kegiatan_tahunan_pelaksana').jstree().deselect_all(true);
    }); 


	var table_kegiatan_tahunan = $('#kegiatan_tahunan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5 ] },
									{ className: "text-right", targets: [ 6 ] },
									{ "orderable": false, targets: [ 0,1,2,3,4,5,6 ]  }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_tahunan_4") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_tahunan_id" : {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'kegiatan_tahunan_id' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label", width:"220px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-muted'>"+row.kegiatan_label+"</p>";
											}else{
												return row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "ak", name:"ak" },
									{ data: "output", name:"output"},
									{ data: "mutu", name:"mutu"},
									{ data: "waktu", name:"waktu"},
									{ data: "biaya", name:"biaya"},
									
								
								],
								initComplete: function(settings, json) {
								
							}
	});	

	function load_rencana_aksi(kegiatan_tahunan_id){



$.ajax({
		url			: '{{ url("api_resource/kegiatan_tahunan_detail") }}',
		data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.kegiatan_tahunan_id').val(data['id']);
				$('.kegiatan_tahunan_label').html(data['label']);
				$('.txt_ak').html(data['ak']);
				$('.txt_output').html(data['output']);
				$('.txt_waktu').html(data['target_waktu'] +' bln');
				$('.txt_cost').html('Rp. ' +data['cost']);
				
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
			columnDefs		  : [
								{ className: "text-center", targets: [ 0,2] },
								{ 'orderable': false , targets: [ ]  }
							],
			ajax			: {
								url	: '{{ url("api_resource/skp_tahunan_rencana_aksi_4") }}',
                                data: { kegiatan_tahunan_id: kegiatan_tahunan_id,
                                        "jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!}
                                      },
							},
							columns			: [
								{ data: 'rencana_aksi_id' , width:"10%",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label", name:"label"},
								{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan"},
							
							],
							initComplete: function(settings, json) {
							
						}
			
						
		
	});	
	}

</script>
