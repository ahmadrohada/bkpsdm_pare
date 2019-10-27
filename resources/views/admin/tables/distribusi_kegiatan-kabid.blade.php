<div class="box box-warning div_kabid_detail " hidden>
	<div class="box-header with-border bg-yellow">
		<p class="jabatan-label jabatan_kabid text-center"  style="margin-top:7px;">-</p>
		<p class="text-center" style="margin-top:10px; color:#edecee; text-shadow: #897e5d 0.02em 0.02em 0.05em;">
			<span class="jj_kabid">-</span>
		</p>
	</div>
	<div class="box-body table-responsive" style="border:solid 1px #dbdbdb">
		<div class="col-md-3 col-xs-3" style="padding-left:5px;">
			<img style="width: 100px; height: 125px;" class="img pasphpoto photo_kabid" src="{{asset('assets/images/form/default_icon.png')}}">
		</div>
		<div class="col-md-9  col-xs-9" style="padding-left:0px;">
			<ul class="list-group list-group-unbordered">
				<li class="list-group-item ">
					<b>Pejabat</b> <a class="pull-right nama_kabid">-</a>
				</li>
				<li class="list-group-item">
					<b>NIP</b> <a class="pull-right nip_kabid">-</a>
				</li>
				<li class="list-group-item">
					<b>GOL / Pangkat</b> <a class="pull-right gol_kabid" >-</a>
				</li>
				<li class="list-group-item">
					<b>TMT Jabatan</b> <a class="pull-right tmt_kabid">-</a>
				</li>
			</ul>
		</div>
		
					
	</div>
</div>
<div class="box box-primary div_kegiatan_kabid_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            Kegiatan List
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
		
		</div>
		<table id="kegiatan_kabid_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >ANGGARAN</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


//load_kegiatan_kabid({!!$renja->KepalaSKPD->id_jabatan!!});

function load_kegiatan_kabid(jabatan_id){
	$(".photo_kabid").prop("src","{{asset('assets/images/form/default_icon.png')}}");
	$.ajax({
		url			: '{{ url("api_resource/detail_pejabat_aktif") }}',
		data 		: {jabatan_id : jabatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.jabatan_kabid').html(data['jabatan']);
				$('.jj_kabid').html(data['jenis_jabatan']+'/ '+data['eselon']);
				
				$(".photo_kabid").prop("src",data['foto']);
				$('.nama_kabid').html(data['nama']);
				$('.nip_kabid').html(data['nip']);
				$('.tmt_kabid').html(data['tmt']);
				$('.gol_kabid').html(data['golongan']+" / "+data['pangkat']);
				
		},
		error: function(data){
			
		}						
	});



    $('#kegiatan_kabid_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0 ] },
									{ className: "text-right", targets: [ 2 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd-renja_kegiatan_list_kabid") }}',
									data: { jabatan_id: jabatan_id ,
											renja_id:{!! $renja->id !!}
										},
								}, 
				columns			:[
								{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true},
								//{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true},
								{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true,width:"110px"},
								
								
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
