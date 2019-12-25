<html>
<head>
		@include('admin.printouts.style')


		<title>Cetak TPP Report - Eselon II</title>
</head>
<body>
	
		<table class="kop" border="0">
				<tr>
					<td rowspan="4" align="right" valign="top">
						<img src="{{asset('assets/images/logo_karawang.png')}}" width="90px" height="120px" >
					</td>
					<td align="center" valign="top">
						<FONT style="font-size:14pt; font-family:Cambria; letter-spacing:1pt;  ">PEMERINTAH KABUPATEN KARAWANG</FONT>
					</td>
				</tr>
				<tr>
					<td align="center"  style="padding:0px;" valign="top">
						<FONT style=" font-size:16pt; font-weight:bold; font-family:Cambria; letter-spacing:1.2pt;  ">BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</FONT>
					</td>
				</tr>
				<tr>
					<td align="center" style="padding-top:0px;"  valign="top">
						<font style=" text-align:center;  font-size:11pt; ont-family:Times New Roman,verdana,calibri; " > 
							Jl. Ahmad Yani No. 1 Karawang 41315
						</font>
					</td>
				</tr>
				<tr>
					<td align="center" style="padding-top:0px;" valign="top">
						<font style=" text-align:center; font-size:11pt; font-family:Times New Roman,verdana,calibri; " > 
							Telp. (0267) 404047
						</font>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top">
						<hr class="kop_hr">
						<hr class="kop_hr2">
					</td>
				</tr>
				<tr>
					<td colspan="2"  valign="top" align="center">
						<FONT style=" font-size:11pt;  font-weight:bold; font-family:Times New Roman,Cambria;">
						
						</font>
					</td>
				</tr>
				<tr>
					<td colspan="2"  valign="top" align="center">
						<FONT style=" font-size:11pt;  font-family:Times New Roman,Cambria;">
							PERJANJIAN KINERJA  TAHUN {{ $periode }}
						</font>
					</td>
				</tr>
				<tr>
					<td colspan="2"  valign="top" align="center">
						<FONT style=" font-size:11pt;  font-family:Times New Roman,Cambria;">
							{{ $nama_skpd }}
						</font>
					</td>
				</tr>
				<tr>
					<td colspan="2"  valign="top" align="center">
						<FONT style=" font-size:11pt;  font-family:Times New Roman,Cambria;">
							{{ $jabatan }}
						</font>
					</td>
				</tr>
				
				</table>

				<br>

	<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri;">
		Tanggal Cetak &nbsp;&nbsp;: {{ $waktu_cetak }} <br>
	</font>
	<table class="cetak_report">
		<thead>
			<tr>
				<th width="5%" >NO</th>
				<th width="">SASARAN STRATEGIS/KEGIATAN</th>
				<th width="35%">INDIKATOR KEGIATAN</th>
				<th width="15%" >TARGET</th>
															
			</tr>
		</thead>

		<tbody>
			@php $i=1 @endphp
			@foreach($data as $p)

				<tr>
                    <td align='right'>{{ $i++ }}</td>
					<td>{{ $p->kegiatan_label }}</td>
					<td>{{ $p->indikator_kegiatan_label }}</td>
					<td align='center'>{{ $p->target." ".$p->satuan  }}</td>
                </tr>
			
			@endforeach
		</tbody>
	</table>
	<br>
	<table class="cetak_report">
		<thead>
			<tr>
				<th width="5%" >NO</th>
				<th width="">KEGIATAN</th>
				<th width="18%">ANGGARAN</th>
				<th width="20%" > KETERANGAN </th>
															
			</tr>
		</thead>

		<tbody>
			{{ $i=1 }} 
			@foreach($data_2 as $x)

				<tr>
                    <td align='right'>{{ $i++ }}</td>
					<td>{{ $x->kegiatan_label }}</td>
					<td align='right'>Rp. {{ number_format( $x->anggaran, '0', ',', '.') }}</td>
					<td></td>
                </tr>
			
			@endforeach
			<tr>
				<td colspan="2"><b>TOTAL ANGGARAN</b></td>
				<td colspan="2" align='right'><b>Rp. {{ number_format( $total_anggaran, '0', ',', '.') }}</b></td>
			</tr>
		</tbody>
	</table>
 

	<br>
<br>
<br>
<table  class="sign_report" width="100%">
<tr>
	<td width="48%">
		
	</td>
	<td width="12%">
		
	</td>
	<td width="40%">
		Karawang, {{ Pustaka::balik2($tgl_dibuat) }}
	</td>
</tr>
<tr height="90px">
		<td>
			BUPATI KARAWANG
		</td>
		<td>
			
		</td>
		<td>
			{{ Pustaka::capital_string($jabatan) }}
		</td>
	</tr>
	<tr height="150px">
		<td height="60px">
			
		</td>
		<td>
			
		</td>
		<td>
			
		</td>
	</tr>
	
	<tr>
		<td>
		{{ $nama_bupati }}
		
		</td>
		<td>
			
		</td>
		<td>
		<u>{{ $nama_pejabat }}</u><br>
		{{ $jenis_jabatan }}<br>
		<font style="font-size:10pt;">NIP. {{ $nip_pejabat }}</font>
		</td>
	</tr>

</table>


</body>
</html>