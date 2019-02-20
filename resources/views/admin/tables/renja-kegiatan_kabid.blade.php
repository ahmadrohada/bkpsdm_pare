<div class="box box-primary div_kabid_detail">
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Jabatan
		</h1>


		<div class="box-tools pull-right">
			
		</div>
	</div>
	<div class="box-body table-responsive">

		
		<strong>Jabatan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="jabatan_kabid"></span>
		</p>

		<strong>Jenis Jabatan / Eselon</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="jj_kabid"></span>
		</p>

		<strong>Nama</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="nama_kabid"></span>
		</p>
		<strong>NIP</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="nip_kabid"></span>
		</p>
					
	</div>
</div>
<div class="box box-primary div_kegiatan_kabid_list">
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
					<th >TARGET</th>
					<th >ANGGARAN</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


//load_kegiatan_kabid({!!$renja->KepalaSKPD->id_jabatan!!});

function load_kegiatan_kabid(jabatan_id){

	$.ajax({
		url			: '{{ url("api_resource/detail_pejabat_aktif") }}',
		data 		: {jabatan_id : jabatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.jabatan_kabid').html(data['jabatan']);
				$('.jj_kabid').html(data['jenis_jabatan']+' ( eselon '+data['eselon']+' )');
				$('.nama_kabid').html(data['nama']);
				$('.nip_kabid').html(data['nip']);
				
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
									{ className: "text-center", targets: [ 0,2 ] },
									{ className: "text-right", targets: [ 3 ] }
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
								{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true},
								{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true},
								
								
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
