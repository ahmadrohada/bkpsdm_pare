

<html>
<head>
		@include('pare_pns.printouts.style')
		<title>Cetak Capaian Tahunan</title>
</head>
<body>


<table class="kop_skp" border="0" width="100%">
	<tr>
		<td align="center" valign="top">
			<FONT style=" font-size:13pt; font-weight:bold; letter-spacing:1.2pt;  ">PENILAIAN CAPAIAN SASARAN KERJA PEGAWAI</FONT>
		</td>
	</tr>
	<tr>
		<td align="center"  style="padding:0px;" valign="top">
			<FONT style=" font-size:9pt; font-family:Trebuchet MS,Calibri; color:#454545;"> 
				Masa Penilaian {{ $sumary['masa_penilaian'] }}
			</FONT>
		</td>
	</tr>
	</table>
	<br>
	<br>
	
	<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
			Dicetak oleh {{ $user }} [ {{ $tgl_cetak }} ] 
	</font>	

	@php
		$arrayForTable = [];
		foreach ($kegiatan_list as $dbValue) {
			$temp = [];
			$temp['kegiatan_tahunan_label'] 	= $dbValue['kegiatan_tahunan_label'];
			$temp['indikator_kegiatan_label']	= $dbValue['indikator_kegiatan_label'];
			//TARGET
			$temp['target_ak'] 					= $dbValue['target_ak'];
			$temp['target_qty'] 				= $dbValue['target_quantity'];
			$temp['target_qty_satuan'] 			= $dbValue['target_quantity'];
			$temp['target_quality'] 			= $dbValue['target_quality'];
			$temp['target_waktu'] 				= $dbValue['target_waktu'];
			$temp['target_biaya'] 				= $dbValue['target_cost'];
			//CAPAIAN
			$temp['realisasi_ak'] 				= $dbValue['realisasi_ak'];
			$temp['realisasi_qty'] 				= $dbValue['realisasi_quantity'];
			$temp['realisasi_qty_satuan'] 		= $dbValue['realisasi_quantity'];
			$temp['realisasi_quality'] 			= $dbValue['realisasi_quality'];
			$temp['realisasi_waktu'] 			= $dbValue['realisasi_waktu'];
			$temp['realisasi_biaya'] 			= $dbValue['realisasi_cost'];
			$temp['perhitungan']				= $dbValue['hitung_quantity']+$dbValue['hitung_quality']+$dbValue['hitung_waktu'];
			
			if ( $dbValue['hitung_cost'] <=0 ){
                $temp['nilai_capaian'] 			= Pustaka::persen_bulat(number_format(($dbValue['hitung_quantity'] + $dbValue['hitung_quality'] + $dbValue['hitung_waktu'] + $dbValue['hitung_cost'] )/3 ,2) ) ;
            }else{
                $temp['nilai_capaian'] 			= Pustaka::persen_bulat(number_format(($dbValue['hitung_quantity'] + $dbValue['hitung_quality'] + $dbValue['hitung_waktu'] + $dbValue['hitung_cost'] )/4 ,2) );
            }
 

			//$temp['rencana_aksi_satuan'] = $dbValue['satuan'];
			if(!isset($arrayForTable[$dbValue['kegiatan_tahunan_label']])){
				$arrayForTable[$dbValue['kegiatan_tahunan_label']] = [];
			}
			$arrayForTable[$dbValue['kegiatan_tahunan_label']][] = $temp;
		}

		$no = 1 ;

	@endphp
	
	
	<table class="cetak_skp_tahunan" style="margin-top:-3px; font-style:Times New Roman;">
	<thead>
		<tr >
			<th  rowspan="2" width="3%" style="border:1.3pt solid black;">NO</th>
			<th  rowspan="2" width="25%"  style="border:1.5pt solid black;">I. KEGIATAN TUGAS JABATAN</th>
			<th  rowspan="2" width="5%"  style="border:1.3pt solid black;">AK</th>
			<th  colspan="6" width="25%"  style="border:1.3pt solid black;">TARGET</th>
			<th  rowspan="2" width="5%"  style="border:1.3pt solid black;">AK</th>
			<th  colspan="6" width="25%"  style="border:1.3pt solid black;">REALISASI</th>
			<th  rowspan="2" width="6%"  style="border:1.3pt solid black;">PERHITUNGAN</th>
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
	<tbody>
		@foreach ($arrayForTable as $id=>$values) :
			@foreach ($values as $key=>$value) : 
				<tr>
					@if ($key == 0) :
						<td align='center' class='garis' rowspan={{ count($values) }} >{{ $no}} </td>
						@php $no++; @endphp
					@endif
						<td class='garis' >{{  $value['kegiatan_tahunan_label'].' ( '. $value['indikator_kegiatan_label'].' )'}}</td>
					@if ($key == 0) :
						<td align='center' class='garis' rowspan={{ count($values) }} >{{  $value['target_ak'] }}</td>
					@endif
						<td align='center' class='garis' >{{  $value['target_qty'] }}</td>
						<td align='center' class='garis' >{{  $value['target_qty_satuan'] }}</td>
						<td align='center' class='garis' >{{  $value['target_quality'].' %' }}</td>
					@if ($key == 0) :
						<td align='center' class='garis' rowspan={{ count($values) }} >{{  $value['target_waktu'] }}</td>
						<td class='garis' rowspan={{ count($values) }} >bln</td>
						<td align='right' class='garis' rowspan={{ count($values) }} >{{  $value['target_biaya'] }}</td>
					@endif
						
					@if ($key == 0) :
						<td align='center' class='garis' rowspan={{ count($values) }} >{{  $value['realisasi_ak'] }}</td>
					@endif
						<td align='center' class='garis' >{{  $value['realisasi_qty'] }}</td>
						<td align='center' class='garis' >{{  $value['realisasi_qty_satuan'] }}</td>
						<td align='center' class='garis' >{{  $value['realisasi_quality'].' %' }}</td>
					@if ($key == 0) :
						<td align='center' class='garis' rowspan={{ count($values) }} >{{  $value['realisasi_waktu'] }}</td>
						<td class='garis' rowspan={{ count($values) }}>bln</td>
						<td align='right' class='garis' rowspan={{ count($values) }} >{{  $value['realisasi_biaya'] }}</td>
						<td align='center' class='garis' rowspan={{ count($values) }}>{{ $value['perhitungan']}}</td>
						<td align='center' class='garis-end' rowspan={{ count($values) }}>{{ $value['nilai_capaian']}}</td>
					@endif
					
						
				</tr>
			
			@endforeach
		@endforeach
	</tbody>
		
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
		@foreach ($unsur_penunjang_tugas_tambahan_list as $dt) : 
			<tr >
				<td  align='center' class='garis'>1</td>
				<td  class='garis'>{{ $dt['tugas_tambahan_label']}}</td>
				<td  align='center' class='garis'></td>
				<td  align='center' colspan='6' class='garis'></td>
				<td  align='center' class='garis'></td>
				<td  align='right' colspan='6' class='garis'></td>
				<td  align='center' class='garis'></td>";
				<td  align='center' valign='middle' rowspan='".$end_row_2."' class='garis-end'></td>	
			</tr>
		@endforeach
				
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
				
				
		@foreach ($unsur_penunjang_kreativitas_list as $dt) : 
			<tr >
				<td  align='center' class='garis'>1</td>
				<td  class='garis'>{{ $dt['kreativitas_label']}}</td>
				<td  align='center' class='garis'></td>
				<td  align='center' colspan='6' class='garis'></td>
				<td  align='center' class='garis'></td>
				<td  align='right' colspan='6' class='garis'></td>
				<td  align='center' class='garis'></td>";
				<td  align='center' valign='middle' rowspan='".$end_row_2."' class='garis-end'></td>	
			</tr>
		@endforeach
						
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
			<td  align='center' style="vertical-align:middle" colspan="17" rowspan="2" class='garis-end tabel-end'>NIlai Capaian SKP</td>
			<td  align='center' class='garis-end tabel-end'>{{ $sumary['capaian_skp'] }}</td>
		</tr>
		<tr >
			<td  align='center' class='garis-end tabel-end'>{{ Pustaka::skor_capaian($sumary['capaian_skp']) }}</td>
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
			Karawang, {{ $sumary['tgl_dibuat'] }}
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
		<u>{{ $pejabat['p_nama'] }}</u><br>
		<font style="font-size:10pt;">NIP. {{ $pejabat['p_nip'] }}</font>
		</td>
	</tr>
	
	</table>
	
	
	<pagebreak />
	
	
	<table width="100%">
		<tr>
			<td>
				<table class="cetak_skp_tahunan">
					<tr>
						<td rowspan="13" width="7%" class="garis_bold">4.</td>
						<td class="garis_bold"  colspan="4" width="80%" >UNSUR YANG DINILAI</td>
						<td class="garis_bold tengah" 	width="10%" >Jumlah</td>
					</tr>	
					<tr>
						<td class="garis_kiri" colspan="2"  width="80%">a. Sasaran Kerja Pegawai ( SKP )</td>
						<td class="garis_none tengah"></td>
						<td class="garis_kanan ">{{ $sumary['capaian_skp'] }} &nbsp;&nbsp;&nbsp;&nbsp;x &nbsp;&nbsp;&nbsp;&nbsp;60%</td>
						<td class="garis_bold tengah"> {{ $sumary['capaian_skp'] * 60/100 }} </td>
					</tr>	
					<tr>
						<td rowspan="9"  class="garis_bold" >b. Perilaku Kerja</td>
						<td class="garis_bold"  width="80%">1. Orientasi Pelayanan</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['pelayanan'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_pelayanan'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>	
					<tr>
						<td class="garis_bold">2. Integritas</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['integritas'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_integritas'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>	
					<tr>
						<td class="garis_bold">3. Komitmen</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['komitmen'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_komitmen'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_bold">4. Disiplin</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['disiplin'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_disiplin'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_bold">5. Kerjasama</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['kerjasama'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_kerjasama'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_bold">6. Kepemimpinan</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['kepemimpinan'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_kepemimpinan'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_bold">Jumlah</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['jumlah'] }}</td>
						<td class="garis_bold kosong"></td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_bold">Nilai Rata-rata</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['rata_rata'] }}</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['ket_rata_rata'] }}</td>
						<td class="garis_bold kosong"></td>
					</tr>
					<tr>
						<td class="garis_kiri">Nilai Perilaku Kerja</td>
						<td class="garis_none tengah"></td>
						<td class="garis_kanan ">{{ $penilaian_perilaku_kerja['rata_rata'] }}  &nbsp;&nbsp;&nbsp;&nbsp;x &nbsp;&nbsp;&nbsp;&nbsp;40%</td>
						<td class="garis_bold tengah">{{ $penilaian_perilaku_kerja['rata_rata'] * 40/100 }} </td>
					</tr>
					
					
					<tr>
						<td class="garis_bold" colspan="4" style="vertical-align:middle;" rowspan="2" >NILAI PRESTASI KERJA</td>
						<td class="garis_bold tengah">{{ ($sumary['capaian_skp'] * 60/100) + ($penilaian_perilaku_kerja['rata_rata'] * 40/100) }}</td>
					</tr>
					
					<tr>
						<td class="garis_bold tengah">{{ Pustaka::skor_capaian(($sumary['capaian_skp'] * 60/100) + ($penilaian_perilaku_kerja['rata_rata'] * 40/100)) }}</td>
					</tr>
					
					
					<tr>
						<td class="garis_y" height="205px"  colspan="6">5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI  (APABILA ADA)</td>
					</tr>
					
					<tr>
						<td class="garis_x" colspan="6" align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
					</tr>
					
				</table>
			</td>
			<td width="2%"></td>
			<td width="48%">
				<table class="cetak_skp_tahunan">
					<tr>
						<td class="garis_y" height="243px;">6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN</td>
					</tr>
					<tr>
						<td class="garis_x" align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
					</tr>
					<tr>
						<td class="garis_y" height="240px">7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN</td>
					</tr>
					
					<tr>
						<td class="garis_x" align="right" style="padding-right:45px;" height="30px;">Tanggal .......................</td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>
	
	
			
	
	
	<pagebreak />

	<table width="100%">
		<tr>
			<td width="50%">
				<table class="cetak_skp_tahunan">
					<tr>
						<td class="garis_y" height="173px;">8.  REKOMENDASI</td>
					</tr>
					<tr>
						<td class="garis_y" height="500px">
							
							<table align="right" style="border:none!important;">
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
									<u>{{ $pejabat['p_nama'] }}</u><br>
									<font style="font-size:10pt;">NIP.{{ $pejabat['p_nip'] }} </font>
									</td>
								</tr>
		
							</table>
							
							<table style="border:none!important; margin-top:40px;">
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
									<u>{{ $pejabat['u_nama'] }}</u><br>
									<font style="font-size:10pt;">NIP.{{ $pejabat['u_nip'] }} </font>
									</td>
									<td style="border:none!important; "></td>
								</tr>
		
							</table>
							
							<table align="right" style="border:none!important;">
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
										<u>{{ $pejabat['ap_nama'] }}</u><br>
										<font style="font-size:10pt;">NIP.{{ $pejabat['ap_nip'] }} </font>
										</td>
										<td style="border:none!important; "></td>
								</tr>
		
							</table>
						</td>
					</tr>
					<tr>
						<td class="garis_x"></td>
					</tr>
				</table>
			</td>
			<td width="2%">
				
			</td>
			<td width="48%">
				<table class="kop_skp" border="0">
					<tr>
						<td align="center" valign="top">
							<img src="{{ asset('assets/images/lambang-pancasila.png') }}" >
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
				<table style="border:0 !important;">
					<tr>
						<td valign="top">
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">INSTANSI</font>
						</td>
						<td valign="top">
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">:</font>
						</td>
						<td valign="top" >
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
								{{ strtoupper($pejabat['u_skpd']) }}
							</font>
						</td>
					</tr>	
					<tr>
						<td valign="top">
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">MASA PENILAIAN</font>
						</td>
						<td valign="top" >
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">:</font>
						</td>
						<td valign="top">
							<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
								{{ $sumary['masa_penilaian'] }}
							</font>
						</td>
					</tr>	
				</table>
				
				<table class="cetak_skp_tahunan" style="margin-bottom:-20px;">
					<tr>
						<td rowspan="6" 				class="garis_bold">1.</td>
						<td class="garis_bold"  colspan="2"		width="95%" ><b>PNS YANG DINILAI</b></td>
					</tr>	
					<tr>
						<td class="garis" >a. Nama</td>
						<td class="garis-end" >{{ $pejabat['u_nama'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >b. NIP</td>
						<td class="garis-end" >{{ $pejabat['u_nip'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
						<td class="garis-end" >{{ $pejabat['u_pangkat'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >d. Jabatan/Pekerjaan</td>
						<td class="garis-end" >{{ $pejabat['u_jabatan'] }}</td>
					</tr>
					<tr>
						<td class="garis tabel-end" >e. Unit Organisasi</td>
						<td class="garis-end tabel-end" >{{ $pejabat['u_unit_kerja'] }}</td>
					</tr>
					<tr>
						<td rowspan="6" class="garis_bold">2.</td>
						<td class="garis_bold"  colspan="2"><b>PEJABAT PENILAI</b></td>
					</tr>	
					<tr>
						<td class="garis" >a. Nama</td>
						<td class="garis-end" >{{ $pejabat['p_nama'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >b. NIP</td>
						<td class="garis-end" >{{ $pejabat['p_nip'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
						<td class="garis-end" >{{ $pejabat['p_pangkat'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >d. Jabatan/Pekerjaan</td>
						<td class="garis-end" >{{ $pejabat['p_jabatan'] }}</td>
					</tr>
					<tr>
						<td class="garis tabel-end" >e. Unit Organisasi</td>
						<td class="garis-end tabel-end" >{{ $pejabat['p_unit_kerja'] }}</td>
					</tr>
					<tr>
						<td rowspan="6" class="garis_bold">3.</td>
						<td class="garis_bold"  colspan="2"	><b>ATASAN PEJABAT PENILAI</b></td>
					</tr>	
					<tr>
						<td class="garis" >a. Nama</td>
						<td class="garis-end" >{{ $pejabat['ap_nama'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >b. NIP</td>
						<td class="garis-end" >{{ $pejabat['ap_nip'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >c. Pangkat,Golongan,Ruang,TMT</td>
						<td class="garis-end" >{{ $pejabat['ap_pangkat'] }}</td>
					</tr>	
					<tr>
						<td class="garis" >d. Jabatan/Pekerjaan</td>
						<td class="garis-end" >{{ $pejabat['ap_jabatan'] }}</td>
					</tr>
					<tr>
						<td class="garis tabel-end" >e. Unit Organisasi</td>
						<td class="garis-end tabel-end" >{{ $pejabat['ap_unit_kerja'] }}</td>
					</tr>
				</table>
			</td>
	
		</tr>
	</table>
	
			

</body>
</html>


