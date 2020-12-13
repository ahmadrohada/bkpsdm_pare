<html>
<head>
		@include('pare_pns.printouts.style')


		<title>Cetak Capaian Tahunan</title>
</head>
<body>
	
		

<table class="kop_skp" border="0" width="100%">
	<tr>
		<td align="center" valign="top">
			<FONT style=" font-size:13pt; font-weight:bold; font-family:Times New Roman; letter-spacing:1.2pt;  ">PENILAIAN CAPAIAN SASARAN KERJA PEGAWAI</FONT>
		</td>
	</tr>
	<tr>
		<td align="center"  style="padding:0px;" valign="top">
			<FONT style=" font-size:9pt; font-family:Trebuchet MS,Calibri; color:#454545;"> 
				Masa Penilaian 
			</FONT>
		</td>
	</tr>
	</table>
	<br>
	<br>
	
	<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
			Dicetak oleh 
	
	</font>	
	
	
	<table class="cetak_skp_tahunan" style="margin-top:-3px;">
	<thead>
		<tr >
			<th  rowspan="2" width="4%" style="border:1.3pt solid black;">NO</th>
			<th  rowspan="2" width="25%"  style="border:1.5pt solid black;">I. KEGIATAN TUGAS JABATAN</th>
			<th  rowspan="2" width="4%"  style="border:1.3pt solid black;">AK</th>
			<th  colspan="6" width="25%"  style="border:1.3pt solid black;">TARGET</th>
			<th  rowspan="2" width="4%"  style="border:1.3pt solid black;">AK</th>
			<th  colspan="6" width="25%"  style="border:1.3pt solid black;">REALISASI</th>
			<th  rowspan="2" width="6%"  style="border:1.3pt solid black;">PERHITU NGAN</th>
			<th  rowspan="2" width="5%"  style="border:1.3pt solid black;">NILAI CAPAIAN SKP</th>
		</tr>
		<tr >
			<th width="12%" colspan="2" style="border:1.3pt solid black;">KUANT/OUTPUT</th>
			<th width="10%" style="border:1.3pt solid black;">KUAL/MUTU</th>
			<th width="10%" colspan="2" style="border:1.3pt solid black;">WAKTU</th>
			<th width="11%" style="border:1.3pt solid black;">BIAYA</th>
			
			<th width="12%" colspan="2" style="border:1.3pt solid black;">KUANT/OUTPUT</th>
			<th width="10%" style="border:1.3pt solid black;">KUAL/MUTU</th>
			<th width="10%" colspan="2" style="border:1.3pt solid black;">WAKTU</th>
			<th width="11%" style="border:1.3pt solid black;">BIAYA</th>
			
		</tr>
	</thead>
		@php 
		$i=0 ;
		echo $kegiatan_list;
		@endphp
		@foreach($kegiatan_list as $p)
				<tr>
					<td  align='center' class='garis'>{{ $i+1 }}</td>
					<td  class='garis'>{{ $p->kegiatan_tahunan_label }}</td>
					<td  align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='8%' align='center'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' >bln</td>
					<td  align='right' class='garis-end'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='8%' align='center'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis'>{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' >bln</td>
					<td  align='right' class='garis' >{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis'  >{{ $p->realisasi_kegiatan_target_ak }}</td>
					<td  width='5%' align='center' class='garis-end'>{{ $p->realisasi_kegiatan_target_ak }}</td>
				</tr>
	
		@endforeach
				
				
					
			
					
					
				
		
			<tr >
				<td  height="20px;" align='center' class='garis tabel-end'></td>
				<td  class='garis tabel-end'></td>
				<td  align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='garis tabel-end'></td>
				<td  width='8%' align='center' class='tabel-end' ></td>
				<td  align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='tabel-end' ></td>
				<td  align='right' class='garis-end tabel-end'></td>
				<td  align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='garis tabel-end'></td>
				<td  width='8%' align='center' class='tabel-end' ></td>
				<td  align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='garis tabel-end'></td>
				<td  width='5%' align='center' class='tabel-end' ></td>
				<td  align='right' class=' garis tabel-end'></td>
				<td  width='5%' align='center' class='garis  tabel-end'  ></td>
							<td  width='5%' align='center' class='garis-end  tabel-end'></td>
			</tr>
			
			
		
	
	
		
		<!-- === TUGAS TAMBAHAN TAHUNAN  --- ==== -->
		<tr >
			<td  align='center' class='garis tabel-end'></td>
			<td  class='garis tabel-end' align="center"><b>II. TUGAS TAMBAHAN DAN KREATIVITAS</b></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td   align='center' class='garis tabel-end'></td>
			<td  align='center' class='tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='  tabel-end'></td>
			<td  align='center' class='garis tabel-end'></td>
			<td  align='center' class='tabel-end garis'></td>
			<td  align='right' class='garis-end tabel-end'></td>
		</tr>
		<!--  tugas tambahan -->
		<tr >
			<td  align='center' class='garis'></td>
			<td  class='garis'><b>a. Tugas Tambahan</b></td>
			<td  align='center' class='garis'></td>
			<td  align='center' colspan="6" class='garis'></td>
			<td  align='center' class='garis'></td>
			<td  align='right' colspan="6" class='garis'></td>
			<td  align='center' class='garis'></td>
			<td  align='center' class='garis-end'></td>
		</tr>
		
		<tr >
						<td  align='center' class='garis'>".$no."</td>
						<td  class='garis'>".$dt_2['label']."</td>
						<td  align='center' class='garis'></td>
						<td  align='center' colspan='6' class='garis'></td>
						<td  align='center' class='garis'></td>
						<td  align='right' colspan='6' class='garis'></td>
						<td  align='center' class='garis'></td>";
						
					<td  align='center' valign='middle' rowspan='".$end_row_2."' class='garis-end'>".$nilai."</td>";
					
						
						
						
						
					</tr>
			
				
			
				
				<tr >
					<td  height="20px;" align='center' class='garis'></td>
					<td  class='garis'>  </td>
					<td  align='center' class='garis'></td>
					<td  align='center' colspan="6" class='garis'></td>
					<td  align='center' class='garis'></td>
					<td  align='right' colspan="6" class='garis'></td>
					<td  align='center' class='garis'></td>
					<td  align='center' class='garis-end'></td>
				</tr>
				
				
				
		<!--  kreativitas -->		
				<tr >
					<td  align='center' class='garis'></td>
					<td  class='garis'><b>b. Kreativitas</b></td>
					<td  align='center' class='garis'></td>
					<td  align='center' colspan="6" class='garis'></td>
					<td  align='center' class='garis'></td>
					<td  align='right' colspan="6" class='garis'></td>
					<td  align='center' class='garis'></td>
					<td  align='center' class='garis-end'></td>
				</tr>
				
				
			<tr >
						<td  align='center' class='garis'>".$no."</td>
						<td  class='garis'>".$dt_3['label']."</td>
						<td  align='center' class='garis'></td>
						<td  align='center' colspan='6' class='garis'></td>
						<td  align='center' class='garis'></td>
						<td  align='right' colspan='6' class='garis'></td>
						<td  align='center' class='garis'></td>";
						
					
						<td  align='center' valign='middle' rowspan='".$end_row_3."' class='garis-end'>".$nilai."</td>";
						
						
						
				
				
				
				<tr >
					<td  height="20px;" align='center' class='tabel-end garis'></td>
					<td  class='tabel-end garis'>  </td>
					<td  align='center' class='tabel-end garis'></td>
					<td  align='center' colspan="6" class='tabel-end garis'></td>
					<td  align='center' class='tabel-end garis'></td>
					<td  align='right' colspan="6" class='tabel-end garis'></td>
					<td  align='center' class='tabel-end garis'></td>
					<td  align='center' class='tabel-end  garis-end'></td>
				</tr>
		
		
		
		  
				<tr >
					<td  align='center' valign='middle' colspan="17" rowspan="2" class='garis-end tabel-end'>NIlai Capaian SKP</td>
					<td  align='center' class='garis-end tabel-end'></td>
				</tr>
				<tr >
					
					<td  align='center' class='garis-end tabel-end'></td>
				</tr>
			
		
		
	</table>
	
	
	<span class="pull-right text-primary rata_rata_capaian" style="font-weight:bold; font-family:isi_2;"> </span>
	
	<table  class="sign_skp_tahunan" width="100%" style="margin-top:30px;">
	<tr>
		<td width="35%">
			
		</td>
		<td>
			
		</td>
		<td width="35%">
			Karawang, 
		</td>
	</tr>
	
	<tr height="90px">
		<td width="35%">
			
		</td>
		<td>
			
		</td>
		<td width="35%">
			Pejabat Penilai,
		</td>
	</tr>
	<tr height="150px">
		<td height="50px">
			
		</td>
		<td>
			
		</td>
		<td>
			
		</td>
	</tr>
	<tr>
		
		
		<td>
		
		</td>
		<td>
			
		</td>
		<td>
		<u><br>
		<font style="font-size:10pt;">NIP. </font>
		</td>
	</tr>
	
	</table>
	
	
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</pagebreak>
	
	
	
	
	
	<table class="" style="width:100%;">
	<tr>
		<td width="49%"  valign="top" style="padding-top:20px;">
			<table class="cetak_skp_tahunan" style="margin-top:-3px;">
				<tr>
					<td rowspan="13" 				width="7%" class="garis_bold">4.</td>
					<td class="garis_bold"  colspan="4"		width="80%" >UNSUR YANG DINILAI</td>
					<td class="garis_bold tengah" 	width="13%" >Jumlah</td>
				</tr>	
				<tr>
					<td class="garis_kiri" colspan="2" >a. Sasaran Kerja Pegawai ( SKP )</td>
					<td class="garis_none tengah"></td>
					<td class="garis_kanan ">x &nbsp;&nbsp;&nbsp;&nbsp;60%</td>
					<td class="garis_bold tengah"> </td>
				</tr>	
				<tr>
					<td rowspan="9"  class="garis_bold" >b. Perilaku Kerja</td>
					<td class="garis_bold">1. Orientasi Pelayanan</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>	
				<tr>
					<td class="garis_bold">2. Integritas</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>	
				<tr>
					<td class="garis_bold">3. Komitmen</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_bold">4. Disiplin</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_bold">5. Kerjasama</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_bold">6. Kepemimpinan</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_bold">Jumlah</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_bold">Nilai Rata-rata</td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold tengah"></td>
					<td class="garis_bold kosong"></td>
				</tr>
				<tr>
					<td class="garis_kiri">Nilai Perilaku Kerja</td>
					<td class="garis_none tengah"></td>
					<td class="garis_kanan ">x &nbsp;&nbsp;&nbsp;&nbsp;40%</td>
					<td class="garis_bold tengah"> </td>
				</tr>
				
				
				<tr>
					<td class="garis_bold" colspan="4" rowspan="2" >NILAI PRESTASI KERJA</td>
					<td class="garis_bold tengah"></td>
				</tr>
				
				<tr>
					<td class="garis_bold tengah"></td>
				</tr>
				
				
				<tr>
					<td class="garis_y" height="205px"  colspan="6">5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI  (APABILA ADA)</td>
				</tr>
				
				<tr>
					<td class="garis_x" colspan="6" align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
				</tr>
				
			</table>
		</td>
		<td width="2%">
			
		</td>
		<td width="49%" valign="top" style="padding-top:20px;">
			<table class="cetak_skp_tahunan" style="margin-top:-3px;">
				<tr>
					<td  width="4%" class="garis_y" height="243px;">6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN</td>
				</tr>	
				<tr>
					<td class="garis_x"  align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
				</tr>
				<tr>
					<td  class="garis_y" height="240px;">7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN</td>
				</tr>	
				<tr>
					<td class="garis_x" align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
				</tr>
			</table>
		</td>
	
	</tr>
	</table>
	
	
	
	
	
	
	
	
	
	<pagebreak/>
	
	
	
	<br>
	<table   style="width:100%;">
	<tr>
		<td width="49%" valign="bottom">
			<table class="cetak_skp_tahunan" style="margin-top:-3px;">
				<tr>
					<td  width="4%" class="garis_bold" height="180px;">8. REKOMENDASI</td>
				</tr>	
				<tr>
					<td class="garis_bold" align="right" height="450px;">
						<table style="border:none!important;">
							<tr>
								<td align="center" style="border:none!important;">
									9. DIBUAT TANGGAL 
								</td>
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
									PEJABAT PENILAI,
								</td>
							</tr>
							<tr height="110px" style="border:none!important;">
								<td height="50px" style="border:none!important;">
									
								</td>
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
								<u></u><br>
								<font style="font-size:10pt;">NIP. </font>
								</td>
							</tr>
	
						</table>
						
						<table style="border:none!important;">
							<tr>
								<td align="center" style="border:none!important;" width="50%">
									10. DITERIMA TANGGAL 
								</td>
								<td style="border:none!important; " width="50%"></td>
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
									PEGAWAI NEGERI SIPIL YANG DINILAI,
								</td>
								<td style="border:none!important; "></td>
							</tr>
							<tr height="110px" style="border:none!important;">
								<td height="50px" colspan="2" style="border:none!important;">
									
								</td>
								
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
								<u></u><br>
								<font style="font-size:10pt;">NIP. </font>
								</td>
								<td style="border:none!important; "></td>
							</tr>
	
						</table>
						
						<table style="border:none!important;">
							<tr>
								<td align="center" style="border:none!important;">
									11. DITERIMA TANGGAL 
								</td>
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
									ATASAN PEJABAT PENILAI,
								</td>
							</tr>
							<tr height="110px" style="border:none!important;">
								<td height="50px" style="border:none!important;">
									
								</td>
							</tr>
							<tr>
								<td align="center" style="border:none!important;">
								<u></u><br>
								<font style="font-size:10pt;">NIP. </font>
								</td>
							</tr>
	
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="2%" >
			
		</td>
		<td width="49%" valign="bottom" style="padding-bottm:0px;">
			
		
		
		
		
			<table class="kop_skp" border="0" width="100%">
				<tr>
					<td align="center" valign="top">
						<img src="../images/lambang-pancasila.png" >
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						<FONT style=" font-size:11pt; font-weight:bold; font-family:Times New Roman; letter-spacing:1.2pt;  ">PENILAIAN PRESTASI KERJA</FONT>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						<FONT style=" font-size:11pt; font-weight:bold; font-family:Times New Roman; letter-spacing:1.2pt;  ">PEGAWAI NEGERI SIPIL</FONT>
					</td>
				</tr>
				
			</table>
				<br>
		
		
		
		
		
		
		
			
			
	
				
			<table >
				<tr>
					<td valign="top" width="10%" class="garis_bold">
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">INSTANSI</font>
					</td>
					<td valign="top" width="1%" class="garis_bold">
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">:</font>
					</td>
					<td valign="top"  width="88%" >
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
						
						</font>
					</td>
				</tr>	
				<tr>
					<td valign="top" width="1%" class="garis_bold">
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">MASA PENILAIAN</font>
					</td>
					<td valign="top" width="1%" class="garis_bold">
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">:</font>
					</td>
					<td valign="top"  width="88%" >
						<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">s.d</font>
					</td>
				</tr>	
			</table>
			
			<table class="cetak_skp_tahunan" style="margin-bottom:-20px;">
				<tr>
					<td rowspan="6" 				width="5%" class="garis_bold">1.</td>
					<td class="garis_bold"  colspan="2"		width="95%" ><b>PNS YANG DINILAI</b></td>
				</tr>	
				<tr>
					<td class="garis" width="30%">a. Nama</td>
					<td class="garis-end" width="70%">
				</tr>	
				<tr>
					<td class="garis" >b. NIP</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >d. Jabatan/Pekerjaan</td>
					<td class="garis-end" ></td>
				</tr>
				<tr>
					<td class="garis tabel-end" >e. Unit Organisasi</td>
					<td class="garis-end tabel-end" ></td>
				</tr>
				<tr>
					<td rowspan="6" 				width="5%" class="garis_bold">2.</td>
					<td class="garis_bold"  colspan="2"		width="95%" ><b>PEJABAT PENILAI</b></td>
				</tr>	
				<tr>
					<td class="garis" width="30%">a. Nama</td>
					<td class="garis-end" width="70%"></td>
				</tr>	
				<tr>
					<td class="garis" >b. NIP</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >d. Jabatan/Pekerjaan</td>
					<td class="garis-end" ></td>
				</tr>
				<tr>
					<td class="garis tabel-end" >e. Unit Organisasi</td>
					<td class="garis-end tabel-end" ></td>
				</tr>
				<tr>
					<td rowspan="6" 				width="5%" class="garis_bold">3.</td>
					<td class="garis_bold"  colspan="2"		width="95%" ><b>ATASAN PEJABAT PENILAI</b></td>
				</tr>	
				<tr>
					<td class="garis" width="30%">a. Nama</td>
					<td class="garis-end" width="70%"></td>
				</tr>	
				<tr>
					<td class="garis" >b. NIP</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
					<td class="garis-end" ></td>
				</tr>	
				<tr>
					<td class="garis" >d. Jabatan/Pekerjaan</td>
					<td class="garis-end" ></td>
				</tr>
				<tr>
					<td class="garis tabel-end" >e. Unit Organisasi</td>
					<td class="garis-end tabel-end" ></td>
				</tr>
			</table>
		
		</td>
	
	</tr>
	</table>
	
	

</body>
</html>