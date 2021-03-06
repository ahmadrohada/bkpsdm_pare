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
	<table class="cetak_report">
		<thead>
			<tr>
				<th width="5%" >NO</th>
				<th width="">KEGIATAN</th>
				<th width="20%" >TARGET</th>
															
			</tr>
		</thead>

		<tbody>
			@php $i=1 @endphp
			@foreach($data as $p)
				
				<tr>
                    <td align='right'>{{ $i++ }}</td>
					<td>{{ $p->label }}</td>
					<td align='center'>{{ $p->target." ".$p->satuan  }}</td>
                </tr>
			
			@endforeach
			</tbody>
	</table>
	{{-- <br>
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
	</table> --}}

	


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