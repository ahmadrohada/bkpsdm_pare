<html>
<head>
		@include('admin.printouts.style')


		<title>Cetak</title>
</head>
<body>
	
	<div style="padding:5px 50px 10px 50px;">


		<table width="100%" style="margin-top:20px;">
			<tr>
				<td align="center" valign="top">
					<img src="{{asset('assets/images/logo_karawang.png')}}" width="90px" height="120px" >
				</td>
			</tr>
			<tr>
				<td align="center" style="padding:20px 0 35px 0 ;">
					<FONT style="font-size:13pt; font-family:Cambria; letter-spacing:1pt;">
						RENCANA AKSI
					</FONT>
				</td>
			</tr>
		</table>
	
		
	
			
	

	<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri;">
		Tanggal Cetak &nbsp;&nbsp;: {{ $waktu_cetak }} <br>
	</font>
	<table class="cetak_report">
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
			@php $i=1 @endphp
			@foreach( $data as $p)

				<tr>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td >{{ $p->rencana_aksi_label }}</td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
                </tr>
			
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