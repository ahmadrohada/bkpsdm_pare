

<html>
<head>
		@include('pare_pns.printouts.style')
		<title>Cetak SKP Tahunan</title>
</head>
<body>


<table class="kop_skp" border="0" width="100%">
	<tr>
		<td align="center" valign="top">
			<FONT style=" font-size:13pt; font-weight:bold; font-family:Times New Roman; letter-spacing:1.2pt;  ">FORMULIR SASARAN KERJA</FONT>
		</td>
	</tr>
	<tr>
		<td align="center"  style="padding:0px;" valign="top">
			<FONT style=" font-size:13pt; font-weight:bold; font-family:Times New Roman; letter-spacing:1.2pt;  ">PEGAWAI NEGERI SIPIL</FONT>
		</td>
	</tr>
</table>
<br>
<br>
	
<font style=" font-size:8pt;  font-family:Trebuchet MS,Calibri; color:#454545;">
	Dicetak oleh {{ $user }} [ {{ $tgl_cetak }} ] 
</font>	



<table class="cetak_skp_tahunan" style="margin-top:-2px;">
	<tr >
		<th width="6%" style="border:1.3pt solid black;"> NO</th>
		<th colspan="2" width="44%"  style="border:1.5pt solid black;">I. PEJABAT PENILAI</th>
		<th width="6%"  style="border:1.3pt solid black;">NO</th>
		<th colspan="2" width="44%"  style="border:1.3pt solid black;">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black;">1</td>
		<td  width="14%" style="border-left:1.3pt solid black;">Nama</td>
		<td width="30%">{{ $pejabat['u_nama'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black;">1</td>
		<td  width="14%" style="border-left:1.3pt solid black;">Nama</td>
		<td width="30%" style="border-right:1.3pt solid black;">{{ $pejabat['p_nama'] }}</td>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black;">2</td>
		<td style="border-left:1.3pt solid black;">NIP</td>
		<td >{{ $pejabat['u_nip'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black;">2</td>
		<td style="border-left:1.3pt solid black;">NIP</td>
		<td style="border-right:1.3pt solid black;">{{ $pejabat['p_nip'] }}</td>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black;">3</td>
		<td style="border-left:1.3pt solid black;">Pangkat/ Gol.Ruang</td>
		<td >{{ $pejabat['u_pangkat'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black;">3</td>
		<td style="border-left:1.3pt solid black;">Pangkat/ Gol.Ruang</td>
		<td style="border-right:1.3pt solid black;">{{ $pejabat['p_pangkat'] }}</td>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black;">4</td>
		<td style="border-left:1.3pt solid black;">Jabatan</td>
		<td >{{ $pejabat['u_jabatan'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black;">4</td>
		<td style="border-left:1.3pt solid black;">Jabatan</td>
		<td style="border-right:1.3pt solid black;">{{ $pejabat['p_jabatan'] }}</td>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black;">4</td>
		<td style="border-left:1.3pt solid black;">Unit Kerja</td>
		<td >{{ $pejabat['u_unit_kerja'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black;">4</td>
		<td style="border-left:1.3pt solid black;">Unit Kerja</td>
		<td style="border-right:1.3pt solid black;">{{ $pejabat['p_unit_kerja'] }}</td>
	</tr>
	<tr>
		<td align="center"  style="border-left:1.3pt solid black; border-bottom:1.3pt solid black;">5</td>
		<td style="border-left:1.3pt solid black; border-bottom:1.3pt solid black;">SKPD</td>
		<td style="border-bottom:1.3pt solid black;">{{ $pejabat['u_skpd'] }}</td>
		
		<td align="center"  style="border-left:1.3pt solid black; border-bottom:1.3pt solid black;">5</td>
		<td style="border-left:1.3pt solid black; border-bottom:1.3pt solid black;">SKPD</td>
		<td style="border-right:1.3pt solid black; border-bottom:1.3pt solid black;">{{ $pejabat['p_skpd'] }}</td>
	</tr>

	
</table>

@php
		$arrayForTable = [];
		foreach ($kegiatan_list as $dbValue) {
			$temp = [];
			$temp['kegiatan_skp_tahunan_label'] = $dbValue['kegiatan_skp_tahunan_label'];
			$temp['indikator_kegiatan_skp_tahunan_label'] = ( $dbValue['indikator_kegiatan_skp_tahunan_label'] != "" )? '('.$dbValue['indikator_kegiatan_skp_tahunan_label'].')': '';
			//TARGET
			$temp['target_ak'] 					= $dbValue['target_ak'];
			$temp['target_quantity'] 			= $dbValue['target_quantity'];
			$temp['target_quality'] 			= $dbValue['target_quality'];
			$temp['target_waktu'] 				= $dbValue['target_waktu'];
			$temp['target_biaya'] 				= $dbValue['target_cost'];

				
			if(!isset($arrayForTable[$dbValue['kegiatan_skp_tahunan_label']])){
			$arrayForTable[$dbValue['kegiatan_skp_tahunan_label']] = [];
			}
			$arrayForTable[$dbValue['kegiatan_skp_tahunan_label']][] = $temp;
			
		}

		$no = 1 ;

	@endphp

<table class="cetak_skp_tahunan" style="margin-top:-3px;">
	<thead>
		<tr >
			<th  rowspan="2" width="6%" style="border:1.3pt solid black;">NO</th>
			<th  rowspan="2" width="44%"  style="border:1.5pt solid black;">III. KEGIATAN TUGAS JABATAN</th>
			<th  rowspan="2" width="6%"  style="border:1.3pt solid black;">AK</th>
			<th  colspan="4" width="44%"  style="border:1.3pt solid black;">TARGET</th>
		</tr>
		<tr >
			<th width="12%" style="border:1.3pt solid black;">KUANT/OUTPUT</th>
			<th width="10%" style="border:1.3pt solid black;">KUAL/MUTU</th>
			<th width="10%" style="border:1.3pt solid black;">WAKTU</th>
			<th width="11%" style="border:1.3pt solid black;">BIAYA</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($arrayForTable as $id=>$values) :
		@foreach ($values as $key=>$value) :
		<tr>
			<td align='center' class='garis' >{{ $no}} </td>
			@php $no++; @endphp
			
			<td class='garis' >{{  $value['kegiatan_skp_tahunan_label'].'  '. $value['indikator_kegiatan_skp_tahunan_label'] }}</td>
			<td align='center' class='garis' >{{  $value['target_ak'] }}</td>
			<td align='center' class='garis' >{{  $value['target_quantity'] }}</td>
			<td align='center' class='garis' >{{  $value['target_quality'].' %' }}</td>
			<td align='center' class='garis' >{{  $value['target_waktu'] }}</td>
			<td align='right' class='garis'  >{{  $value['target_biaya'] }}</td>
		</tr>
		@endforeach
		@endforeach

	</tbody>
</table>



<table  class="sign_skp_tahunan" width="100%" style="margin-top:30px;">
	<tr>
		<td width="35%">
			
		</td>
		<td>
			
		</td>
		<td width="35%">
			Karawang, {{ $tgl_dibuat }}
		</td>
	</tr>
	
	<tr height="90px">
		<td width="35%">
			Pejabat Penilai,
		</td>
		<td>
			
		</td>
		<td width="35%">
			Pegawai Negeri Sipil Yang Dinilai
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
		<u>{{ $pejabat['p_nama'] }}</u><br>
		<font style="font-size:10pt;">NIP. {{ $pejabat['p_nip'] }}</font>
		</td>
		<td>
			
		</td>
		<td>
		<u>{{ $pejabat['u_nama'] }}</u><br>
		<font style="font-size:10pt;">NIP. {{ $pejabat['u_nip'] }}</font>
		</td>
	</tr>
	
	</table>

</body>
</html>


