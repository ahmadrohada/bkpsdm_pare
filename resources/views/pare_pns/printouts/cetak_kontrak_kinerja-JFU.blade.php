<html>
<head>
		@include('pare_pns.printouts.style')


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
						KONTRAK KINERJA TAHUN {{ $periode }}
					</FONT>
				</td>
			</tr>
		</table>
	
		
	
			<p class="isi_text">
				Dalam rangka mewujudkan manajemen pemerintahan yang efektif, transparan dan 
				akuntabel serta berorientasi pada hasil, kami yang bertanda tangan dibawah ini :
			</p>
			
			<table  class="tb_pejabat" width="100%" style="margin-left:-2px; margin-top:17px;">
				<tr>
					<td width="15%">Nama</td><td width="2%">:</td><td width="" align="left">{{ $nama_pejabat }}</td>
				</tr>
				<tr>
					<td>Jabatan</td><td>:</td><td>{{ Pustaka::capital_string($jabatan) }}</td>
				</tr>
			</table>
			
			<p style="margin-top:5px;">Selanjutnya disebut PIHAK KESATU</p>
		
			
			<table class="tb_pejabat"  width="100%" style="margin-left:-2px; margin-top:20px;">
				<tr>
					<td width="15%">Nama</td><td width="2%">:</td><td width="" align="left">{{ $nama_atasan }}</td>
				</tr>
				<tr>
					<td>Jabatan</td><td>:</td><td>{{ Pustaka::capital_string($jabatan_atasan) }}</td>
				</tr>
			</table>
				<p style="margin-top:5px;">Selaku atasan PIHAK KESATU, selanjutnya disebut PIHAK KEDUA</p>
			
				
			
			
				<p class="isi_text" style="margin-top:35px;">
				PIHAK KESATU berjanji akan mewujudkan target kinerja yang seharusnya sesuai
				perjanjian ini, dalam rangka mewujudkan target kinerja jangka menengah seperti yang
				telah ditetapkan dalam dokumen perencanaan. Keberhasilan dan kegagalan pencapaian target
				kinerja tersebut menjadi tanggung jawab kami.
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				PIHAK KEDUA akan memberikan supervisi yang diperlukan serta akan melakukan
				evaluasi terhadap capaian kinerja dari perjanjian ini dan mengambil tindakan yang diperlukan
				dalam rangka pemberian penghargaan dan sanksi.
				</p>
			
			
				<table  class="sign_report" width="100%" style="margin-top:60px;">
					<tr>
						<td width="45%">
							
						</td>
						<td width="10%">
							
						</td>
						<td width="45%">
							Karawang, {{ Pustaka::balik2($tgl_dibuat) }}
						</td>
					</tr>
					<tr>
							<td>
								PIHAK KEDUA,
							</td>
							<td>
								
							</td>
							<td>
								PIHAK KESATU,
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
								<u>{{ $nama_atasan }}</u><br>
								
								<font style="font-size:10pt;">NIP. {{ $nip_atasan }}</font>
							
							</td>
							<td>
								
							</td>
							<td>
								<u>{{ $nama_pejabat }}</u><br>
								
								<font style="font-size:10pt;">NIP. {{ $nip_pejabat }}</font>
							</td>
						</tr>
					
					</table>
		</div>
	
		
			
	
		<pagebreak></pagebreak>
		<table class="kop" border="0">
				{{-- <tr>
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
				</tr> --}}
				<tr>
					<td height="180px"></td>
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
							KONTRAK KINERJA  TAHUN {{ $periode }}
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
	@php
		$arrayForTable = [];
		foreach ($data as $databaseValue) {
			$temp = [];
			$temp['rencana_aksi_label'] = $databaseValue['rencana_aksi_label'];
			$temp['rencana_aksi_target'] = $databaseValue['target'];
			$temp['rencana_aksi_satuan'] = $databaseValue['satuan'];
			if(!isset($arrayForTable[$databaseValue['kegiatan_label']])){
				$arrayForTable[$databaseValue['kegiatan_label']] = [];
			}
			$arrayForTable[$databaseValue['kegiatan_label']][] = $temp;
		}

		$no = 1 ;

	@endphp
		
		

	<table class="cetak_report">
		<thead>
			<tr>
				<th width="5%" >NO</th>
				<th width="">KEGIATAN</th>
				<th width="35%">RENCANA AKSI</th>
				<th width="15%" >TARGET</th>
															
			</tr>
		</thead>

		<tbody>
			 
			@foreach ($arrayForTable as $id=>$values) :
				@foreach ($values as $key=>$value) : 
				<tr>
					@if ($key == 0) :
						<td rowspan={{ count($values) }} >{{ $no}} </td>
						<td rowspan={{ count($values) }} >{{ $id }} </td>
						@php $no++; @endphp
					@endif
						<td>{{  $value['rencana_aksi_label' ]}}</td>
						<td>{{  $value['rencana_aksi_target' ].' '. $value['rencana_aksi_satuan' ]}}</td>
				</tr>
			
				@endforeach
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
				Karawang, {{ Pustaka::balik2($tgl_dibuat) }}
			</td>
		</tr>
		<tr>
				<td>
					PEJABAT PENILAI,
				</td>
				<td>
					
				</td>
				<td>
					{{ Pustaka::capital_string($jabatan) }}
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
					<u>{{ $nama_atasan }}</u><br>
					
					<font style="font-size:10pt;">NIP. {{ $nip_atasan }}</font>
				
				</td>
				<td>
					
				</td>
				<td>
					<u>{{ $nama_pejabat }}</u><br>
					
					<font style="font-size:10pt;">NIP. {{ $nip_pejabat }}</font>
				</td>
			</tr>
		
		</table>


</body>
</html>