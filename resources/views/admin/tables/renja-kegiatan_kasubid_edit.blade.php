<div class="box box-primary div_kasubid_detail">
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
			<span class="jabatan_kasubid"></span>
		</p>

		<strong>Jenis Jabatan / Eselon</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="jj_kasubid"></span>
		</p>

		<strong>Nama</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="nama_kasubid"></span>
		</p>
		<strong>NIP</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="nip_kasubid"></span>
		</p>
					
	</div>
</div>
<div class="box box-primary div_kegiatan_kasubid_list">
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
		<table id="kegiatan_kasubid_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >TARGET</th>
					<th >ANGGARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('admin.modals.renja_kegiatan_kasubid')


<script type="text/javascript">


//load_kegiatan_kasubid({!!$renja->KepalaSKPD->id_jabatan!!});

function load_kegiatan_kasubid(jabatan_id){

	$.ajax({
		url			: '{{ url("api_resource/detail_pejabat_aktif") }}',
		data 		: {jabatan_id : jabatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.jabatan_kasubid').html(data['jabatan']);
				$('.jj_kasubid').html(data['jenis_jabatan']+' ( eselon '+data['eselon']+' )');
				$('.nama_kasubid').html(data['nama']);
				$('.nip_kasubid').html(data['nip']);
				
		},
		error: function(data){
			
		}						
	});



    $('#kegiatan_kasubid_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,4 ] },
									{ className: "text-right", targets: [ 3 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd-renja_kegiatan_list_kasubid") }}',
									data: { jabatan_id: jabatan_id ,
											renja_id:{!! $renja->id !!}
										},
								}, 
				columns			:[
								{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"20px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true},
								{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true,width:'80px'},
								{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true,width:'80px'},
								
								
								{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_kegiatan_kasubid"  data-id="'+row.kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus Kegiatan Pada Jabatan" style="margin:1px;" ><a class="btn btn-warning btn-xs unlink_kegiatan_kasubid"  data-id="'+row.kegiatan_id+'" data-label="'+row.label_kegiatan+'" ><i class="fa fa-chain-broken " ></i></a></span>';
											
									}
								},
							],
							initComplete: function(settings, json) {
								
							}
		
	});	

}


	$(document).on('click','.edit_kegiatan_kasubid',function(e){
		var kegiatan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api_resource/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_kasubid').find('[name=label_kegiatan]').val(data['label']);
					$('.modal-kegiatan_kasubid').find('[name=label_ind_kegiatan]').val(data['indikator']);
					$('.modal-kegiatan_kasubid').find('[name=target_kegiatan]').val(data['target']);
					$('.modal-kegiatan_kasubid').find('[name=satuan_kegiatan]').val(data['satuan']);
					$('.modal-kegiatan_kasubid').find('[name=cost_kegiatan]').val(data['cost']);
					
					$('.modal-kegiatan_kasubid').find('[name=kegiatan_id]').val(data['kegiatan_id']);
					$('.modal-kegiatan_kasubid').find('h4').html('Edit Kegiatan');
					$('.modal-kegiatan_kasubid').find('.btn-submit').attr('id', 'submit-update-kegiatan_kasubid');
					$('.modal-kegiatan_kasubid').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_kasubid').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	function unlink_kegiatan_kasubid(kegiatan_id){
		Swal.fire({
			title: "Hapus  Kegiatan",
			text: "Hanya menghapus kegiatan pada jabatan saja",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_kegiatan_kasubid") }}',
					type	: 'POST',
					data    : {kegiatan_id:kegiatan_id},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {

										$(".div_ka_skpd_detail, .div_kegiatan_ka_skpd_list").show();
										$(".div_kabid_detail, .div_kegiatan_kabid_list").hide();
										$(".div_kasubid_detail, .div_kegiatan_kasubid_list").hide();
										$(".div_kegiatan_detail").hide();

										$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
										jQuery('#ditribusi_renja').jstree(true).refresh(true);
										$('#kegiatan_list_add').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
											jQuery('#ditribusi_renja').jstree(true).refresh(true);
											$('#kegiatan_list_add').DataTable().ajax.reload(null,false);
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Tes Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	}


	$(document).on('click','.unlink_kegiatan_kasubid',function(e){
		var kegiatan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus  Kegiatan",
			text:/* $(this).data('label')+ */ "Hanya menghapus kegiatan pada jabatan saja",
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_kegiatan_kasubid") }}',
					type	: 'POST',
					data    : {kegiatan_id:kegiatan_id},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
										jQuery('#ditribusi_renja').jstree(true).refresh(true);
										$('#kegiatan_list_add').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
											jQuery('#ditribusi_renja').jstree(true).refresh(true);
											$('#kegiatan_list_add').DataTable().ajax.reload(null,false);
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Tes Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	});
	

</script>
