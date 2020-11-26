<html>
<head>
		@include('pare_pns.printouts.style')
		


		<title>Cetak</title>

</head>
<body>
	@php  
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Pegawai.xls");
	@endphp
	
	<div style="padding:5px 50px 10px 50px;">



	<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri;">
		Tanggal Cetak &nbsp;&nbsp;: {{ $waktu_cetak }} <br>
	</font>
	<table class="cetak_report_reaksi" style=" font-size:7pt !important; page-break-inside:avoid;">
		<thead>
			<tr>
				<th rowspan="2" width="5%" >NO</th>
				<th rowspan="2"  width="">SASARAN</th>
				<th rowspan="2"  width="">INDIKATOR SASARAN KINERJA UTAMA</th>
				<th rowspan="2"  width="" >TARGET ( SESUAI DENGAN TAHUN YANG DIJANJIKAN )</th>
				<th rowspan="2"  width="">PROGRAM</th>
				<th rowspan="2"  width="">KEGIATAN</th>
				<th rowspan="2"  width="">URAIAN KEGIATAN</th>
				<th rowspan="2"  width="">TARGET URAIAN KEGIATAN ( OUTPUT )</th>
				<th rowspan="2"  width="">ANGGARAN KEGIATAN ( APBD )</th>
				<th colspan="12" width="">TARGET PELAKSANAAN URAIAN KEGIATAN</th>
				<th colspan="3" width="">TARGET KEGIATAN ( TW )</th>
															
			</tr>
			<tr>
				<th width="">1</th>
				<th width="">2</th>
				<th width="">3</th>
				<th width="">4</th>
				<th width="">5</th>
				<th width="">6</th>
				<th width="">7</th>
				<th width="">8</th>
				<th width="">9</th>
				<th width="">10</th>
				<th width="">11</th>
				<th width="">12</th>
				<th width=""></th>
				<th width="">KINERJA</th>
				<th width="">ANGGARAN</th>
															
			</tr>
		</thead>

		<tbody>
			@php 
				$i=1; 
				$merge = 1 ;
			@endphp
			@foreach( json_decode($data) as $p) 
				@php 
					if ( $p->jm_row_kegiatan > 1 ) { //5 
						if ( $merge == 1  ) {
							echo 	'<tr>
										<td class="tengah" width="3%">'.$i++.'</td>
										<td class="tengah" >'.$p->sasaran_label.'</td>
										<td >'.$p->indikator_sasaran_label.'</td>
										<td >'.$p->indikator_sasaran_target.'</td>
										<td >'.$p->program_label.'</td>
										<td rowspan="'.$p->jm_row_kegiatan.'" >'.$p->kegiatan_label.'|'.$merge.'</td>
										<td >'.$p->rencana_aksi_label.'</td>
										<td >'.$p->rencana_aksi_target.'</td>
										<td rowspan="'.$p->jm_row_kegiatan.'"  class="kanan">'.$p->kegiatan_anggaran.'</td>
										<td class="tengah" width="22px">'.$p->b_1.'</td>
										<td class="tengah" width="22px">'.$p->b_2.'</td>
										<td class="tengah" width="22px">'.$p->b_3.'</td>
										<td class="tengah" width="22px">'.$p->b_4.'</td>
										<td class="tengah" width="22px">'.$p->b_5.'</td>
										<td class="tengah" width="22px">'.$p->b_6.'</td>
										<td class="tengah" width="22px">'.$p->b_7.'</td>
										<td class="tengah" width="22px">'.$p->b_8.'</td>
										<td class="tengah" width="22px">'.$p->b_9.'</td>
										<td class="tengah" width="22px">'.$p->b_10.'</td>
										<td class="tengah" width="22px">'.$p->b_11.'</td>
										<td class="tengah" width="22px">'.$p->b_12.'</td>
										<td ></td>
										<td ></td>
										<td ></td>
									</tr>';
							$merge = $p->jm_row_kegiatan + 1;
						}else{
							echo '<tr>
										<td class="tengah" width="3%">'.$i++.'</td>
										<td >'.$p->sasaran_label.'</td>
										<td >'.$p->indikator_sasaran_label.'</td>
										<td >'.$p->indikator_sasaran_target.'</td>
										<td >'.$p->program_label.'</td>
										<td >'.$p->rencana_aksi_label.'</td>
										<td >'.$p->rencana_aksi_target.'</td>
										<td class="tengah" width="22px">'.$p->b_1.'</td>
										<td class="tengah" width="22px">'.$p->b_2.'</td>
										<td class="tengah" width="22px">'.$p->b_3.'</td>
										<td class="tengah" width="22px">'.$p->b_4.'</td>
										<td class="tengah" width="22px">'.$p->b_5.'</td>
										<td class="tengah" width="22px">'.$p->b_6.'</td>
										<td class="tengah" width="22px">'.$p->b_7.'</td>
										<td class="tengah" width="22px">'.$p->b_8.'</td>
										<td class="tengah" width="22px">'.$p->b_9.'</td>
										<td class="tengah" width="22px">'.$p->b_10.'</td>
										<td class="tengah" width="22px">'.$p->b_11.'</td>
										<td class="tengah" width="22px">'.$p->b_12.'</td>
										<td ></td>
										<td ></td>
										<td ></td>
									</tr>';
						}
						$merge =  $merge - 1 ;
					}else{
						echo 	'<tr>
									<td class="tengah" width="3%">'.$i++.'</td>
									<td >'.$p->sasaran_label.'</td>
									<td >'.$p->indikator_sasaran_label.'</td>
									<td >'.$p->indikator_sasaran_target.'</td>
									<td >'.$p->program_label.'</td>
									<td >'.$p->kegiatan_label.'|'.$merge.'</td>
									<td >'.$p->rencana_aksi_label.'</td>
									<td >'.$p->rencana_aksi_target.'</td>
									<td class="kanan">'.$p->kegiatan_anggaran.'</td>
									<td class="tengah" width="22px">'.$p->b_1.'</td>
									<td class="tengah" width="22px">'.$p->b_2.'</td>
									<td class="tengah" width="22px">'.$p->b_3.'</td>
									<td class="tengah" width="22px">'.$p->b_4.'</td>
									<td class="tengah" width="22px">'.$p->b_5.'</td>
									<td class="tengah" width="22px">'.$p->b_6.'</td>
									<td class="tengah" width="22px">'.$p->b_7.'</td>
									<td class="tengah" width="22px">'.$p->b_8.'</td>
									<td class="tengah" width="22px">'.$p->b_9.'</td>
									<td class="tengah" width="22px">'.$p->b_10.'</td>
									<td class="tengah" width="22px">'.$p->b_11.'</td>
									<td class="tengah" width="22px">'.$p->b_12.'</td>
									<td ></td>
									<td ></td>
									<td ></td>
								</tr>';
						$merge = 1 ;
					}
							
					@endphp	
			@endforeach 
		</tbody> 
	</table>
	

	<table  class="sign_report" width="100%" style="margin-top:60px;">
		<tr>
			<td width="45%">
				
			</td>
			<td width="10%">
				
			</td>
			<td width="45%">
				Karawang, xxx
			</td>
		</tr>
		<tr>
				<td>
					PEJABAT PENILAI,
				</td>
				<td>
					
				</td>
				<td>
					
				</td>
			</tr>
			<tr>
				<td  height="70px">
					
				</td>
				<td>
					
				</td>
				<td>
					
				</td>
			</tr>
			
			<tr>
				<td>
					<u>xxx</u><br>
					
					<font style="font-size:10pt;">NIP. xxx</font>
				
				</td>
				<td>
					
				</td>
				<td>
					<u>xxx</u><br>
					
					<font style="font-size:10pt;">NIP. xxx</font>
				</td>
			</tr>
		
		</table>


</body>
</html>