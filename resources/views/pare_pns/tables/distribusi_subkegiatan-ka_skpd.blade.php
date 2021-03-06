<div class="box box-warning div_ka_skpd" >
	<div class="box-header with-border bg-yellow" >
		<p class="jabatan-label jabatan_ka_skpd text-center"  style="margin-top:7px;">-</p>
		<p class="text-center" style="margin-top:10px; color:#edecee; text-shadow: #897e5d 0.02em 0.02em 0.05em;">
			<span class="jj_ka_skpd">-</span>
		</p>
	</div>
	<div class="box-body table-responsive" style="border:solid 1px #dbdbdb">
		<div class="col-md-3 col-xs-12 " style="margin-top:10px;  margin-left:-20px !important; text-align:center;">
			<img style="width: 100px; height: 125px;" class="img pasphpoto photo_ka_skpd" src="{{asset('assets/images/form/default_icon.png')}}">
		</div>
		<div class="col-md-9  col-xs-12" style="margin-top:10px; padding-left:0px;">
			<ul class="list-group list-group-unbordered">
				<li class="list-group-item ">
					<b>Pejabat</b> <a class="pull-right nama_ka_skpd">-</a>
				</li>
				<li class="list-group-item">
					<b>NIP</b> <a class="pull-right nip_ka_skpd">-</a>
				</li>
				<li class="list-group-item">
					<b>GOL / Pangkat</b> <a class="pull-right gol_ka_skpd" >-</a>
				</li>
				{{--  <li class="list-group-item">
					<b>TMT Jabatan</b> <a class="pull-right tmt_ka_skpd">-</a>
				</li>  --}}
			</ul>
		</div>			
	</div>
	<div class="box-body table-responsive">

		<div class="toolbar"></div>
		<table id="subkegiatan_ka_skpd_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SUB KEGIATAN</th>
					<th >ANGGARAN</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<script type="text/javascript">


load_subkegiatan_ka_skpd({!!$renja->KepalaSKPD->id_jabatan!!});

function load_subkegiatan_ka_skpd(jabatan_id){

	$(".photo_ka_skpd").prop("src","{{asset('assets/images/form/default_icon.png')}}");

	$.ajax({
		url			: '{{ url("api/detail_pejabat_aktif") }}',
		data 		: {jabatan_id : jabatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.jabatan_ka_skpd').html(data['jabatan']);
				$('.jj_ka_skpd').html(data['jenis_jabatan']+' / '+data['eselon']);

				$(".photo_ka_skpd").prop("src",data['foto']);
				$('.nama_ka_skpd').html(data['nama']);
				$('.nip_ka_skpd').html(data['nip']);
				$('.tmt_ka_skpd').html(data['tmt']);
				$('.gol_ka_skpd').html(data['golongan']+" / "+data['pangkat']);
				
		},
		error: function(data){
			
		}						
	});




    $('#subkegiatan_ka_skpd_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false, 
				lengthChange	: false,
				deferRender		: true,
				searching      	: true,
				paging          : true,
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0 ] },
									{ className: "text-right", targets: [ 2 ] }
								],
				ajax			: {
									url	: '{{ url("api/skpd-renja_subkegiatan_list_kaskpd") }}',
									data: { jabatan_id: jabatan_id ,
											renja_id:{!! $renja->id !!}
										}, 
								}, 
				columns			:[
								{ data: 'subkegiatan_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_subkegiatan", name:"label_subkegiatan", orderable: true, searchable: true},
								//{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true},
								{ data: "cost_subkegiatan", name:"cost_subkegiatan", orderable: true, searchable: true,width:"110px"},
								
								
								/* {  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_kegiatan"  data-id="'+row.kegiatan_id+'" data-label="'+row.label_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								}, */
							],
							initComplete: function(settings, json) {
								
							}
		
	});	

}
	

</script>
