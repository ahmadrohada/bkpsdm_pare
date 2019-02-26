<div class="row">
	<div class="col-md-5">
		<div class="table-responsive">
			<input type='text' id = 'cari_skp_bulanan' class="form-control" placeholder="cari">
			<div id="skp_bulanan_tree" class="demo"></div>
			
		</div>

	</div>
	<div class="col-md-7">
		<div class="box box-primary" id='kegiatan_bulanan' hidden>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Kegiatan Bulanan
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN BULANAN</th>
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

	</div>



	
</div>


     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function initTreeKegBulanan() {
		$('#skp_bulanan_tree')
		.on("loaded.jstree", function(){
			$('#skp_bulanan_tree').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				detail_table_2(data.instance.get_node(data.selected[0]).id);
			
			}
		})
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skp_bulanan_tree") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $skp->Renja->id !!} , 
                          "jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
													"skp_tahunan_id" : {!! $skp->id !!} };
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


	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table_2(id){

	var tx = id.split('|');



	switch ( tx[0] ){
							case 'SKPBulanan':
												//SHOW KEGIATAN BULANAN
													
													$("#kegiatan_bulanan").show();
													load_kegiatan_bulanan( tx[1]);
													
										
							break;
							case 'KegiatanRenja':
												

			break;
			case 'RencanaAksi':
											

			break;
			
			default:
					$("#kegiatan_bulanan").hide();
			
		}


	}


  function load_kegiatan_bulanan(){
		var table_kegiatan_tahunan = $('#kegiatan_bulanan_table').DataTable({
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
									url	: '{{ url("api_resource/kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : {!! $skp->id !!}
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
	}
	


	
	var to = false;
	$('#cari_skp_bulanan').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_skp_bulanan').val();
		$('#skp_bulanan_tree').jstree(true).search(v);
		}, 250);
	});
	
	
</script>
