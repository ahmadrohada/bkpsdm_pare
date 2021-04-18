<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Capaian Tahunan ( Format E-Lapkin )
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="approval_request_capaian_tahunan_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>NIP ATASAN PEJABAT PENILAI</th>
						<th>NIP PEJABAT PENILAI</th>
						<th>PNS ID</th>
						<th>NIP_BARU</th>
						<th>NAMA</th>
						<th>DINAS</th>
						<th>TAHUN</th>
						<th>NILAI SKP</th>
						<th>ORIENTASI PELAYANAN</th>
						<th>INTEGRITAS</th>
						<th>KOMITMEN</th>
						<th>DISIPLIN</th>
						<th>KERJASAMA</th>
						<th>KEPEMIMPINAN</th>
						<th>ATASAN PENILAI JABATAN</th>
						<th>PENILAI JABATAN</th>
						<th>PENILAI GOLONGAN</th>
						<th>ATASAN PENILAI GOLONGAN</th>
						<th>PENILAI TMT GOLONGAN</th>
						<th>ATASAN PENILAI TMT GOLONGAN</th>
						<th>PENILAI UNOR NAMA</th>
						<th>ATASAN PENILAI UNOR NAMA</th>
						<th>PENILAI NAMA</th>
						<th>ATASAN PENILAI NAMA</th>
						<th>PENILAI NIP NRP</th>
						<th>ATASAN PENILAI NIP NRP</th>
						<th>STATUS PENILAI</th>
						<th>STATUS ATASAN PENILAI</th>
						<th>JENIS JABATAN</th>
						<th>KERJASAMA</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
		
	$('#approval_request_capaian_tahunan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: true,
				lengthChange	: true,
				order 			: [ 0 , 'desc' ],
				lengthMenu		: [20,45,80],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,4 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/approval_request_capaian_tahunan_list") }}',
									
									data: { pegawai_id : 47 },
									delay:3000
								},
				

				columns	:[
								{ data: 'capaian_tahunan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},

								
								
							]
			
	});


	

/* 	$(document).on('click','.approval_capaian_tahunan',function(e){
		var capaian_tahunan_id = $(this).data('capaian_tahunan_id') ;
		window.location.assign("capaian_tahunan_bawahan_approvement/"+capaian_tahunan_id);
	});

	$(document).on('click','.lihat_capaian_tahunan',function(e){
		var capaian_tahunan_id = $(this).data('capaian_tahunan_id') ;
		window.location.assign("capaian_tahunan_bawahan/"+capaian_tahunan_id);
	}); */

	
	
</script>
