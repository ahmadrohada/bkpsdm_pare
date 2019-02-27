<div class="row">
	<div class="col-md-5">
		<div class="table-responsive">
			<input type='text' id = 'cari_skp_bulanan' class="form-control" placeholder="cari">
			<div id="skp_bulanan_tree" class="demo"></div>
			
		</div>

	</div>
	<div class="col-md-7">


		<div class="box box-primary" id='skp_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List SKP Bulanan
				</h1>

				<div class="box-tools pull-right">
					
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">
					<span  data-toggle="tooltip" title="Create SKP Bulanan"><a class="btn btn-info btn-xs create_skp_bulanan" ><i class="fa fa-plus" ></i> SKP Bulanan</a></span>
				</div>

				<table id="skp_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th >No</th>
							<th >PERIODE</th>
							<th >NAMA ATASAN</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>
<!--====================== KEGIATAN BULANAN LIST =========================================== -->
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

@include('admin.modals.create_skp_bulanan')
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">

	function initTreeKegBulanan() {
		$('#skp_bulanan_tree')
		.on("loaded.jstree", function(){
			$('#skp_bulanan_tree').jstree('open_all');
			//$('#skp_bulanan_tree').jstree(true).select_node('SKPBulanan|1');
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
											"skp_bulanan_id" : skp_bulanan_id
									 },
								},
				columns			: [
									{ data: 'kegiatan_bulanan_id' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label", width:"220px"},
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

	
		$('#skp_bulanan_table').DataTable({
				destroy			    : true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			    : [ 3 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,1,3 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skp_bulanan_list_4") }}',
									data: { 
										
											"skp_tahunan_id" : {!! $skp->id !!} 
									 },
								},
				columns			: [
									{ data: 'skp_bulanan_id' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "periode", name:"periode" },
									{ data: "p_nama", name:"p_nama"},
									{ data: "bulan", name:"bulan"}
									
								
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
	


//======================== SKP BULANAN ==============================//
	$(document).on('click','.create_skp_bulanan',function(e){

		$.ajax({
				url			: '{{ url("api_resource/skp_tahunan_detail") }}',
				data 		: {skp_tahunan_id : {{ $skp->id}}},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-skp_bulanan').find('[name=periode_skp]').html(data['periode']);
					$('.modal-skp_bulanan').find('[name=u_nama]').html(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=u_jabatan]').html(data['u_jabatan']);
					$('.modal-skp_bulanan').find('[name=p_nama]').html(data['p_nama']);
					$('.modal-skp_bulanan').find('[name=p_jabatan]').html(data['p_jabatan']);

					$('.modal-skp_bulanan').find('[name=skp_tahunan_id]').val({{ $skp->id}});
					$('.modal-skp_bulanan').find('[name=tgl_mulai]').val(data['tgl_mulai']);
					$('.modal-skp_bulanan').find('[name=pegawai_id]').val(data['pegawai_id']);
					$('.modal-skp_bulanan').find('[name=u_jabatan_id]').val(data['u_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=p_jabatan_id]').val(data['p_jabatan_id']);
					$('.modal-skp_bulanan').find('[name=u_nama]').val(data['u_nama']);
					$('.modal-skp_bulanan').find('[name=p_nama]').val(data['p_nama']);

					//DISABLED BULAN YANG UDAH ADA
					//data['skp_bulanan_list'][0]['bulan']
					bln = data['skp_bulanan_list'];
					$('.periode_skp_bulanan').children().each(function(index,element){
					
        		for (i = 0; i < bln.length ; i++){
							if ( $(element).val() == data['skp_bulanan_list'][i]['bulan']){
								$(this).prop('disabled',true);
							}
						}
					})

					$('.modal-skp_bulanan').find('h4').html('Create SKP Bulanan');
					$('.modal-skp_bulanan').find('.btn-submit').attr('id', 'submit-save_skp_bulanan');
					$('.modal-skp_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-skp_bulanan').modal('show');
				},
				error: function(data){
					
				}						
		});	



		
	});
	
</script>
