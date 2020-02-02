<div class="row">
	<div class="col-md-5">

			<div class="box box-primary ">
				<div class="box-header with-border">
					<h1 class="box-title">
						&nbsp;
					</h1>
					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body" style="padding-left:0px; padding-right:0px;">
					<input type='text' id = 'cari_skp_bulanan' class="form-control" placeholder="cari">
						
					<div class="table-responsive auto">
						<div id="skp_bulanan_tree" class="demo"></div>
					</div>
				</div>
			</div>

	

	</div>
	<div class="col-md-7">


		<div class="box box-skp_bulanan" id='skp_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List SKP Bulanan 
				</h1>

				<div class="box-tools pull-right">
					
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">
					
				</div>

				<table id="skp_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th >No</th>
							<th >PERIODE</th>
							<th >NAMA ATASAN</th>
							<th >JM KEGIATAN</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>
<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-kegiatan_bulanan" id='kegiatan_bulanan' hidden>
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
							<th>No</th>
							<th>KEGIATAN BULANAN</th>
							<th>TARGET</th>
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
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skp_bulanan_tree5") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $skp->Renja->id !!} , 
                          "jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
													"skp_tahunan_id" : {!! $skp->id !!} };
						},
						"dataType" : "json"
				},'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			},'contextmenu' : { 
					'items' : context_menus
				},
				'plugins' : [ /* 'contextmenu', */  'types' ,'search'],
				'types' : {
					'skp_tahunan' 			: { /* options */ },
					'skp_bulanan' 	  	: { /* options */ },
			  	'rencana_aksi' 	  	: { /* options */ }
				}
			}).on('create_node.jstree', function (e, data) {
			

				modal_create_skp_bulanan();
				
		}).on("loaded.jstree", function(){
			$('#skp_bulanan_tree').jstree('open_all');
		}).on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				detail_table_2(data.instance.get_node(data.selected[0]).id);
			}
		});
	}



	function context_menus(node){
			var tree = $('#skp_bulanan_tree').jstree(true);

			if (node.type === 'skp_tahunan'){
				var addLabel = 'Create SKP Bulanan';
				var newLabel = 'SKP Bulanan';
			}
		
			
			var items = {
				"Add": {
					"label": addLabel,
					"action": function (obj) { 
						var $node = tree.create_node(node,newLabel);
						tree.edit($node);

					}
				},                         
				"Remove": {
					"label": "Remove",
					"action": function (obj) { 
						if(confirm('Hapus SKP Bulanan ?')){
							tree.delete_node(node);
						}
					}
				}
		};



		if (node.type === 'rencana_aksi'){
			delete items.Add;
			delete items.Remove;
		}else if ( node.type === 'skp_tahunan'){
			delete items.Remove;
		}else if ( node.type === 'skp_bulanan'){
			delete items.Add;
		}
	
		return items;
	}



	//========================== TABLE DETAIL KEGIATAN ==================================//
	function detail_table_2(id){

	var tx = id.split('|');



	switch ( tx[0] ){
							case 'SKPTahunan':
													$("#kegiatan_bulanan").hide();
													$("#skp_bulanan").show();
													load_skp_bulanan( tx[1]);
													
										
							break;
							case 'SKPBulanan':
												  //SHOW KEGIATAN BULANAN
												  $("#skp_bulanan").hide();
												  $("#kegiatan_bulanan").show();
												  load_kegiatan_bulanan( tx[1]);
													
										
							break;
							case 'KegiatanRenja':
												

							break;
							case 'RencanaAksi':
											

							break;
			
							default:
					
			
		}


	}


  function load_kegiatan_bulanan(skp_bulanan_id){
		$('.skp_bulanan_id').val(skp_bulanan_id);

		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_bulanan_5") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : skp_bulanan_id
									 },
								},
				columns			: [
									{ data: 'skp_bulanan_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label"},
									{ data: "target", name:"target", width:"140px"},
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	
		$('#skp_bulanan_table').DataTable({
				destroy			    : true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				//order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,1,3 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skp_bulanan_list_5") }}',
									data: { 
										
											"skp_tahunan_id" : {!! $skp->id !!} 
									 },
								},
				columns			: [
									{ data: 'bulan' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "periode", name:"periode" },
									{ data: "p_nama", name:"p_nama"},
									{ data: "jm_kegiatan", name:"jm_kegiatan"},
								],
								initComplete: function(settings, json) {
								
							}
		});	
	
	


	
	var to = false;
	$('#cari_skp_bulanan').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_skp_bulanan').val();
		$('#skp_bulanan_tree').jstree(true).search(v);
		}, 250);
	});
	

</script>
