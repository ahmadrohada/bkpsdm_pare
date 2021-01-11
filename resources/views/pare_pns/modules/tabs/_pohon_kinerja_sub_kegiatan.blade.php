<div class="row">
	<div class="col-md-5">
		<div class="box box-primary ">
			<div class="box-header with-border">
				<h1 class="box-title">
					
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				<input type='text' id = 'cari_keg_tahunan' class="form-control" placeholder="cari">
				<div class="table-responsive auto">
					<div id="pk_keg_tahunan_tree"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-7">
		@include('pare_pns.tables.kegiatan_tahunan-kegiatan_detail')

		<div id='rencana_aksi' hidden>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						Detail Kegiatan Tahunan 
					</h1>
 
					<div class="box-tools pull-right">
						{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
						{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_pk','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

						{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '410', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
					</div>
				</div>
				<div class="box-body table-responsive">

					<strong>Kegiatan Tahunan</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:8px;">
						<span class="kegiatan_tahunan_label"></span>
						<input type="hidden" class="kegiatan_tahunan_id">
						<input type="hidden" class="kegiatan_renja_id">
					</p>

					<p><strong>Target</strong></p>
					<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
					<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
					<i class="fa fa-hourglass-start"></i> <span class="txt_waktu_pelaksanaan" style="margin-right:10px;"></span>
					<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>

					<hr>
							
					<table class="table table-hover table-condensed">
						<tr class="success">
							<th>No</th>
							<th>Indikator</th>
							<th>Target</th>
						</tr>
					</table>
					<table class="table table-hover table-condensed" id="list_indikator_pk"></table>
					
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-header with-border">
					<h1 class="box-title">
						List Rencana Aksi
					</h1>

				</div>
				<div class="box-body table-responsive">
					<div class="toolbar">
						
					</div>

					<table id="rencana_aksi_table" class="table table-striped table-hover" >
						<thead>
							<tr>
								<th>No</th>
								<th>RENCANA AKSI</th>
								<th>PELAKSANA</th>
								<th>WAKTU</th>
								<th>TARGET</th>
							</tr>
						</thead>
					</table>

				</div>
			</div>
		</div>
		
	</div>
</div>



<script type="text/javascript">
	

	
	function initTreeSubKegiatanPK() {
		$('#pk_keg_tahunan_tree').jstree({
			'core' : {
				'data' : {
					'url' 	: "{{ url("api/pohon_kinerja-subkegiatan_tree") }}", 
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
					pk_detail_table(data.instance.get_node(data.selected[0]).id);
				}
		}); 

		
	}

	
	
	var to = false;
	$('#cari_keg_tahunan').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_keg_tahunan').val();
		$('#pk_keg_tahunan_tree').jstree(true).search(v);
		}, 250);
	});
	
	//========================== KEGIATAN ==================================//
	function pk_detail_table(id){

		var tx = id.split('|');
		//alert(tx[0])
		
		switch ( tx[0] ){
                case 'KegiatanTahunan':
                  	//SHOW DETAIL KEGIATAN TAHUNAN DAN RENCANA AKSI LIST
                  /* 	$(".div_kegiatan_list_pk").hide();
					$("#rencana_aksi").show();
					load_rencana_aksi_pk(tx[1]); */
                       
				break; 
				case 'RencanaAksi':
					/* $(".div_kegiatan_list_pk").hide();
					$("#rencana_aksi").hide(); */
				break;
				case 'IndikatorKegiatan':
					/* $(".div_kegiatan_list_pk").hide();
					$("#rencana_aksi").hide();
 */
				break;
				case 'KegiatanBulanan':
					/* $(".div_kegiatan_list_pk").hide();
					$("#rencana_aksi").show(); */

				break;
				default:
					
				break;
			}
		

    }
    

    $(".tutup_detail_pk").click(function(){
			$(".div_kegiatan_list_pk").show();
			$("#rencana_aksi").hide();
			jQuery('#pk_keg_tahunan_tree').jstree().deselect_all(true);
	});  
	
	


	

	
	function load_rencana_aksi_pk(kegiatan_tahunan_id){

		

$.ajax({
		url			: '{{ url("api/kegiatan_tahunan_detail") }}',
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

				document.getElementById('list_indikator_pk').innerHTML = "";
				var bawahan = document.getElementById('list_indikator_pk');
				for(var i = 0 ; i < data['list_indikator'].length; i++ ){
					 
					$("<tr><td>"+ (i+1) +"</td><td>"+data['list_indikator'][i].label+"</td><td>"+data['list_indikator'][i].target+" "+data['list_indikator'][i].satuan+"</td></tr>").appendTo(bawahan);
				}
				
		},
		error: function(data){
				document.getElementById('list_indikator_pk').innerHTML = "";
			
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
							{ className: "text-center", targets: [ 0,2,3,4 ] },
						  { 'orderable': false , targets: [2]  } 
						],
		ajax			: {
							url	: '{{ url("api/skp_tahunan_rencana_aksi_3") }}',
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
							
						
						],
						initComplete: function(settings, json) {
						
					}
		
					
	
});	
}

</script>
