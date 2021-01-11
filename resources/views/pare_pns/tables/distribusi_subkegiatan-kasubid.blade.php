<div class="box box-warning div_kasubid" hidden>
	<div class="box-header with-border bg-yellow">
		<p class="jabatan-label jabatan_kasubid text-center"  style="margin-top:7px;">-</p>
		<p class="text-center" style="margin-top:10px; color:#edecee; text-shadow: #897e5d 0.02em 0.02em 0.05em;">
			<span class="jj_kasubid">-</span>
		</p>
		<input type="hidden" class="jj_jabatan_id">
	</div>
	<div class="box-body table-responsive" style="border:solid 1px #dbdbdb">
		<div class="col-md-3 col-xs-12 " style="margin-top:10px;  margin-left:-20px !important; text-align:center;">
			<img style="width: 100px; height: 125px;" class="img pasphpoto photo_kasubid" src="{{asset('assets/images/form/default_icon.png')}}">
		</div>
		<div class="col-md-9  col-xs-12" style="margin-top:10px; padding-left:0px;">
			<ul class="list-group list-group-unbordered">
				<li class="list-group-item ">
					<b>Pejabat</b> <a class="pull-right nama_kasubid">-</a>
				</li>
				<li class="list-group-item">
					<b>NIP</b> <a class="pull-right nip_kasubid">-</a>
				</li>
				<li class="list-group-item">
					<b>GOL / Pangkat</b> <a class="pull-right gol_kasubid" >-</a>
				</li>
				{{--  <li class="list-group-item">
					<b>TMT Jabatan</b> <a class="pull-right tmt_kasubid">-</a>
				</li>  --}}
			</ul>
		</div>
		<div class="col-md-12  col-xs-12 no-padding">
			<span  data-toggle="tooltip" title="Add Sub Kegiatan"><a class="btn btn-info btn-sm btn-block add_subkegiatan"><i class="fa fa-plus" ></i> Add Sub Kegiatan</a></span>	
		</div>
	</div>
	<div class="box-body table-responsive">
		<div class="toolbar"></div>
		<table id="subkegiatan_kasubid_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SUB KEGIATAN</th>
					<th >ANGGARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@include('pare_pns.modals.renja_subkegiatan_kasubid')


<script type="text/javascript">


//load_subkegiatan_kasubid({!!$renja->KepalaSKPD->id_jabatan!!});

function load_subkegiatan_kasubid(jabatan_id){

	$(".photo_kasubid").prop("src","{{asset('assets/images/form/default_icon.png')}}");
	$.ajax({
		url			: '{{ url("api/detail_pejabat_aktif") }}',
		data 		: {jabatan_id : jabatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.jj_jabatan_id').val(jabatan_id);
				$('.jabatan_kasubid').html(data['jabatan']);
				$('.jj_kasubid').html(data['jenis_jabatan']+'/ '+data['eselon']);
				
				$(".photo_kasubid").prop("src",data['foto']);
				$('.nama_kasubid').html(data['nama']);
				$('.nip_kasubid').html(data['nip']);
				$('.tmt_kasubid').html(data['tmt']);
				$('.gol_kasubid').html(data['golongan']+" / "+data['pangkat']);
				
		},
		error: function(data){
			
		}						
	});



    $('#subkegiatan_kasubid_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false, 
				lengthChange	: false,
				deferRender		: true,
				searching      	: false,
				paging          : true,
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3 ] },
									{ className: "text-right", targets: [ 2 ] }
								],
				ajax			: {
									url	: '{{ url("api/skpd-renja_subkegiatan_list_kasubid") }}',
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
								{ data: "label_subkegiatan", name:"label_subkegiatan", orderable: true, searchable: true},
								//{ data: "target_subkegiatan", name:"target_subkegiatan", orderable: true, searchable: true,width:'80px'},
								{ data: "cost_subkegiatan", name:"cost_subkegiatan", orderable: true, searchable: true,width:'90px'},
								
								
								{  data: 'action',width:"50px",
									"render": function ( data, type, row ) {
										/* return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_subkegiatan_kasubid"  data-id="'+row.subkegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-warning btn-xs unlink_subkegiatan_kasubid"  data-id="'+row.subkegiatan_id+'" data-label="'+row.label_subkegiatan+'" ><i class="fa fa-chain-broken " ></i></a></span>'; */
										return '<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-warning btn-xs unlink_subkegiatan_kasubid"  data-id="'+row.subkegiatan_id+'" data-label="'+row.label_subkegiatan+'" ><i class="fa fa-chain-broken " ></i></a></span>'; 
									}
								},
							],
							initComplete: function(settings, json) {
								
							}
		
	});	

}





	$(document).on('click','.add_subkegiatan',function(e){
		var id_jabatan = $(".jj_jabatan_id").val() ;
		//alert(id_jabatan);
		$('.distribusi_subkegiatan_add, #tes').val(id_jabatan);
		//SHOW MODAL UNTUK ADD KEGIATAN
		$('.distribusi_subkegiatan_add').modal('show');

	});

	$(document).on('click','.edit_subkegiatan_kasubid',function(e){
		var kegiatan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/subkegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_kasubid').find('[name=label_subkegiatan]').val(data['label']);
					$('.modal-kegiatan_kasubid').find('[name=label_ind_subkegiatan]').val(data['indikator']);
					$('.modal-kegiatan_kasubid').find('[name=target_subkegiatan]').val(data['target']);
					$('.modal-kegiatan_kasubid').find('[name=satuan_subkegiatan]').val(data['satuan']);
					$('.modal-kegiatan_kasubid').find('[name=cost_subkegiatan]').val(data['cost']);
					
					$('.modal-kegiatan_kasubid').find('[name=subkegiatan_id]').val(data['subkegiatan_id']);
					$('.modal-kegiatan_kasubid').find('h4').html('Edit Sub Kegiatan');
					$('.modal-kegiatan_kasubid').find('.btn-submit').attr('id', 'submit-update-subkegiatan_kasubid');
					$('.modal-kegiatan_kasubid').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_kasubid').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	function unlink_subkegiatan_kasubid(subkegiatan_id){
		Swal.fire({
			title: "Hapus  Sub Kegiatan",
			text: "Kegiatan dan Rencana Aksi pada SKP Tahunan dan Capaian yang sudah dibuat akan ikut terhapus",
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
					url		: '{{ url("api/hapus_subkegiatan_kasubid") }}',
					type	: 'POST',
					data    : {subkegiatan_id:subkegiatan_id},
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

										$(".div_ka_skpd").show();
										$(".div_kabid, .div_kasubid,.div_subkegiatan").hide();
										$('#subkegiatan_kasubid_table').DataTable().ajax.reload(null,false);
										$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
										
										$('.distribusi_subkegiatan_add').modal('hide');
										jQuery('#ditribusi_renja').jstree(true).refresh(true);
								
										$('#kegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
										$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#subkegiatan_kasubid_table').DataTable().ajax.reload(null,false);
											
											$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
											$('#kegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
											$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
											jQuery('#ditribusi_renja').jstree(true).refresh(true);
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


	$(document).on('click','.unlink_subkegiatan_kasubid',function(e){
		var subkegiatan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus  Sub Kegiatan",
			text:"Kegiatan dan Rencana Aksi pada SKP Tahunan dan Capaian yang sudah dibuat akan ikut terhapus",
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
					url		: '{{ url("api/hapus_subkegiatan_kasubid") }}',
					type	: 'POST',
					data    : {subkegiatan_id:subkegiatan_id},
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
										$('#subkegiatan_kasubid_table').DataTable().ajax.reload(null,false);
										
										$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
										$('#kegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
										$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
										jQuery('#ditribusi_renja').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#subkegiatan_kasubid_table').DataTable().ajax.reload(null,false);
											
											$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
											$('#kegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
											$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
											jQuery('#ditribusi_renja').jstree(true).refresh(true);
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
