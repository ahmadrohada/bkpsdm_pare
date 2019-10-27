<div class="box box-warning div_ka_skpd_detail " >
	<div class="box-header with-border bg-yellow" >
		<p class="jabatan-label jabatan_ka_skpd text-center"  style="margin-top:7px;">-</p>
		<p class="text-center" style="margin-top:10px; color:#edecee; text-shadow: #897e5d 0.02em 0.02em 0.05em;">
			<span class="jj_ka_skpd">-</span>
		</p>
	</div>
	<div class="box-body table-responsive" style="border:solid 1px #dbdbdb">

		
		<div class="col-md-3 col-xs-3" style="padding-left:5px;">
			<img style="width: 100px; height: 125px;" class="img pasphpoto photo_ka_skpd" src="{{asset('assets/images/form/default_icon.png')}}">
		</div>
		<div class="col-md-9  col-xs-9" style="padding-left:0px;">
			<!-- <strong>Nama Pejabat </strong>
			<p class="text-muted " style="margin-top:7px;padding-bottom:5px;">
				<span class="nama_ka_skpd">-</span>
			</p>
			<strong>NIP</strong>
			<p class="text-muted " style="margin-top:7px;padding-bottom:5px;">
				<span class="nip_ka_skpd">-</span>
			</p>
			<strong>GOL / Pangkat</strong>
			<p class="text-muted " style="margin-top:7px;">
				<span class="gol_ka_skpd">-</span>
			</p>
			<strong>TMT Jabatan</strong>
			<p class="text-muted " style="margin-top:7px;">
				<span class="tmt_ka_skpd">-</span>
			</p> -->
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
				<li class="list-group-item">
					<b>TMT Jabatan</b> <a class="pull-right tmt_ka_skpd">-</a>
				</li>
			</ul>
		</div>
		
					
	</div>
</div>
<div class="box box-primary div_kegiatan_ka_skpd_list">
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
		<table id="kegiatan_ka_skpd_table" class="table table-striped table-hover table-condensed" >
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


load_kegiatan_ka_skpd({!!$renja->KepalaSKPD->id_jabatan!!});

function load_kegiatan_ka_skpd(jabatan_id){

	$.ajax({
		url			: '{{ url("api_resource/detail_pejabat_aktif") }}',
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




    $('#kegiatan_ka_skpd_table').DataTable({
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
									url	: '{{ url("api_resource/skpd-renja_kegiatan_list_kaskpd") }}',
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
