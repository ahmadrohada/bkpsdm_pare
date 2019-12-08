<html>
<head>
		@include('admin.printouts.style')


		<title>Cetak TPP Report</title>
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
						TPP REPORT PARE PERIODE  XXXX
						</font>
					</td>
				</tr>
				<tr>
					<td colspan="2"  valign="top" align="center">
						<FONT style=" font-size:11pt;  font-family:Times New Roman,Cambria;">
						NAMA SKPD
						</font>
					</td>
				</tr>
				
				</table>


				<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri;">
						Tanggal Cetak xxxx
						 &nbsp;Dicetak oleh &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; xxxx
					</font>



					<table class="cetak_report">
							<thead>
								<tr>
									<th rowspan="2" width="30px" >NO</th>
									<th rowspan="2" width="220px">NAMA PEGAWAI</th>
									<th rowspan="2" width="">NIP</th>
															
									<th rowspan="2" width="80px" >TPP</th>
															
									<th colspan="5">KINERJA  ( 40 % )</th>
									<th colspan="4">KEHADIRAN  ( 60 % )</th>
															
															
															
									<th rowspan="2" width="80px">TOTAL</th>
															
								</tr>
								<tr>
									<th width="80px"> TPP x 40%</th>
									<th width="50px"> CAP</th>
									<th width="50px"> SKOR</th>
									<th width="50px"> POT</th>
									<th width="80px"> JM TPP</th>
														
									<th width="80px"> TPP x 60%</th>
									<th width="50px"> SKOR</th>
									<th width="50px"> POT </th>
									<th width="80px"> JM TPP</th>
								</tr>
							</thead>

		<tbody>
			@php $i=1 @endphp
			@foreach($data as $p)

			<tr>
                    <td align='right'>{{ $i++ }}</td>
                    <td>{{  Pustaka::nama_pegawai($p->gelardpn, $p->nama, $p->gelarblk) }}</td>
					<td align='center'>{{$p->nip}}</td>
					<td align='right'>Rp. {{number_format($p->tunjangan, '0', ',', '.')}}</td>
					<td align='right'>Rp. {{number_format($p->tpp_kinerja, '0', ',', '.')}}</td>
					<td align='center'>{{ ( $p->capaian_id != null ) ? Pustaka::persen_bulat($p->capaian) : "-" }}</td>
					<td align='center'>{{ ( $p->capaian_id != null ) ? Pustaka::persen_bulat($p->skor).' %' : "-" }}</td>
					<td align='center'>{{ ( $p->pot_kinerja <= 0 ) ? Pustaka::persen_bulat($p->pot_kinerja).' %' : "-" }}</td>
					<td align='right'>Rp. {{ number_format( (($p->tpp_kinerja)*($p->skor/100) ) - ( ($p->pot_kinerja/100 )*$p->tpp_kinerja), '0', ',', '.') }}</td>
					<td align='right'>Rp. {{number_format($p->tpp_kehadiran, '0', ',', '.')}}</td>
					<td align='center'>{{ ( $p->skor_kehadiran > 0 ) ? Pustaka::persen_bulat($p->skor_kehadiran).' %' : "-" }}</td>
					<td align='center'>{{ ( $p->pot_kehadiran > 0 ) ? Pustaka::persen_bulat($p->pot_kehadiran).' %' : "-" }}</td>
					<td align='right'>Rp. {{ number_format( (($p->tpp_kehadiran)*($p->skor_kehadiran/100) ) - ( ($p->pot_kehadiran/100 )*$p->tpp_kehadiran), '0', ',', '.')}}</td>
					<td align='right'>Rp. {{ number_format(   (($p->tpp_kinerja)*($p->skor/100) ) - ( ($p->pot_kinerja/100 )*$p->tpp_kinerja) + (($p->tpp_kehadiran)*($p->skor_kehadiran/100) ) - ( ($p->pot_kehadiran/100 )*$p->tpp_kehadiran), '0', ',', '.') }}</td>
                </tr>
			
			@endforeach
		</tbody>
	</table>
 

	<br>
<br>
<br>
<table  class="sign_report" width="100%">
<tr>
	<td width="48%">
		Mengetahui,
	</td>
	<td width="12%">
		
	</td>
	<td width="40%">
		Petugas Ceklis,
	</td>
</tr>
<tr height="90px">
	<td>
		Kepala Bidang Pengembangan Pegawai ASN
	</td>
	<td>
		
	</td>
	<td>
		Kasubid Kinerja dan Kompetensi ASN
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
	<u>Jajang Jaenudin, S.STP, MM</u><br>
	<font style="font-size:10pt;">NIP. 198006062000121001</font>
	</td>
	<td>
		
	</td>
	<td>
	<u>Marsidik Ari Kustijo, S.Sos</u><br>
	<font style="font-size:10pt;">NIP. 197403222005011005</font>
	</td>
</tr>

</table>


</body>
</html>