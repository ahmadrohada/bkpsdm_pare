<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Pustaka {

    public static function nama_pegawai($glr_dpn,$nama,$glr_blk) {
       
        if ( $glr_dpn == null ) { $titik = ""; }else{ $titik = "."; }
        if ( $glr_blk == null )  { $koma = ""; }else {$koma = ", "; }
         return $glr_dpn.$titik.ucwords(strtolower($nama)).$koma.$glr_blk ;
 

    }

    public static function capital_string($nama_skpd) {
       
        $kata_sb = array("dan", "pada" , "yang");
		$singkatan = array("asn", "SKPD" , "ASN");

        $pecah = explode(" ", $nama_skpd);

        $hasil_nama_skpd = "";

        for ($x =0; $x < count($pecah); $x++) {

            if ($x == 0 ){
                $hasil_nama_skpd = ucwords(strtolower($pecah[$x]));
            }else{

                if ( in_array( strtolower($pecah[$x]) , $kata_sb) ){
                    $hasil_nama_skpd = $hasil_nama_skpd.' '.strtolower($pecah[$x]);
                }else if ( in_array( strtolower($pecah[$x]) , $singkatan) ){
                    $hasil_nama_skpd = $hasil_nama_skpd.' '.strtoupper($pecah[$x]);
                }else{
                    $hasil_nama_skpd = $hasil_nama_skpd.' '.ucwords(strtolower($pecah[$x]));
                }

                
            }
            
        } 


        return  $hasil_nama_skpd;

    }
	
	public static function sakip($data){
		
				switch($data)
					{
				case "AA" : $nilai= 7;
						break;
				case "A"  : $nilai= 6;
						break;
				case "AB" : $nilai= 5;
						break;
				case "B"  : $nilai= 4;
						break;
				case "CC" : $nilai= 3;
						break;
				case "C"  : $nilai= 2;
						break;
				case "D"  : $nilai= 1;
						break;
					}

	return $nilai;

	}

	public static function eselon($data){
		
		if ( ($data === NULL ) | ( $data == 0  ) ){
			return "";
		}else{
			switch($data)
						{
					case "1" : $jenis_jabatan= "";
							break;
					case "2"  : $jenis_jabatan= "JPT";
							break;
					case "3" :  $jenis_jabatan= "JPT";
							break;
					case "4"  : $jenis_jabatan= "administrator";
							break;
					case "5" :  $jenis_jabatan= "administrator";
							break;
					case "6"  : $jenis_jabatan= "pengawas";
							break;
					case "7"  : $jenis_jabatan= "pengawas";
							break;
					case "8"  : $jenis_jabatan= "";
							break;
					case "9"  : $jenis_jabatan= "pelaksana";
							break;
					case "10"  : $jenis_jabatan= "";
							break;
					case "11"  : $jenis_jabatan= "";
							break;
						}

			return $jenis_jabatan;
		}
		

	

	}

	public static function short_eselon($data){
		
		if ( $data === NULL ){
			return "";
		}else{
			switch($data)
						{
					case "Non Struktural (JFU)" : $eselon= "JFU";
							break;
					case "Non Struktural (JFT)"  : $eselon= "JFT";
							break;
					default		: $eselon = $data;
							break;
						}

			return $eselon;
		}
		

	

	}
	
	public static function periode_tahun($data){
		if ( $data != null ){
			$x			= explode(' ',$data);
		}else{
			$x = "0 0";
		}
	return $x[1];

	}

	public static function balik($data){
		$tanggal = substr($data,8,2); 
		$bulan = substr($data,5,2); 
		$tahun = substr($data,0,4); 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Jan';
						break;
				case 02 : $nm_bulan='Feb';
						break;
				case 03 : $nm_bulan='Mar';
						break;
				case 04 : $nm_bulan='Apr';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Jun';
						break;
				case 07 : $nm_bulan='Jul';
						break;
				case 8 : $nm_bulan='Agust';
						break;
				case 9 : $nm_bulan='Sept';
						break;
				case 10 : $nm_bulan='Okt';
						break;
				case 11 : $nm_bulan='Nov';
						break;
				case 12 : $nm_bulan='Des';
						break;
					}

					
		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';
		
		$data=$tanggal.'   '.$nm_bulan.'  '.$tahun;
	return $data;

	}

	public static function nol($data){
		

		//ubah angka ke nama bulan
				switch($data)
					{
				case 1 : $x='01';
						break;
				case 2 : $x='02';
						break;
				case 3 : $x='03';
						break;
				case 4 : $x='04';
						break;
				case 5 : $x='05';
						break;
				case 6 : $x='06';
						break;
				case 7 : $x='07';
						break;
				case 8 : $x='08';
						break;
				case 9 : $x='09';
						break;
				case 10 : $x='10';
						break;
				case 11 : $x='11';
						break;
				case 12 : $x='12';
						break;
					}

	return $x;

	}

//================================== RUMUS PERHITUNGAN REALISASI KEGIATAN PADA CAPAIAN TAHUAN ==========//
/** RUMUS UNTUK MENENTUKAN CAPAIAN SKP TAHUNAN **/
/* 
	//Aspek kuantitas
	$capaian_output = ( $data->capaian_output / $data->target_output )*100;
	
	//Aspek kualitas
	$persen_capaian_kualitas = ( ($akurasi+$ketelitian+$kerapihan+$keterampilan) / 20 )*100;
	
	$capaian_kualitas = ($persen_capaian_kualitas / $data->target_kualitas)*100;
	
	//Aspek waktu
	$persen_efisiensi_waktu = 100 - ( ($data->capaian_waktu / $data->target_waktu) * 100);
	
	if ( $persen_efisiensi_waktu <= 24 ) {
		
		$capaian_waktu = ((1.76 * $data->target_waktu - $data->capaian_waktu)/ $data->target_waktu )*100;
	}else{
		
		$capaian_waktu = 76 - (((1.76 * $data->target_waktu - $data->capaian_waktu)/ $data->target_waktu )*100) -100;
	}
	
	//jika kegiatan tidak ada biaya
	if ( ( $data->capaian_biaya != 0 ) && ( $data->target_biaya != 0 )){
		//Aspek biaya
		$persen_efisiensi_biaya = 100 - ( ($data->capaian_biaya / $data->target_biaya) * 100);
		
		
		if ( $persen_efisiensi_biaya <= 24 ) {
			$capaian_biaya = ((1.76 * $data->target_biaya - $data->capaian_biaya)/ $data->target_biaya )*100;
		}else{
			$capaian_biaya = 76 - (((1.76 * $data->target__biaya - $data->capaian_biaya)/ $data->target_biaya )*100) -100;
		}
		
		
		
	}else{
		$capaian_biaya = 0;
	}
	
	
		if ( $capaian_biaya != 0 ){
			$capaian_skp = ($capaian_output+$capaian_kualitas+$capaian_waktu+$capaian_biaya)/4 ;
		}else{
			$capaian_skp = ($capaian_output+$capaian_kualitas+$capaian_waktu)/3 ;
		}

**/
	

	public static function balik2($data){
		$tanggal = substr($data,8,2); 
		$bulan = substr($data,5,2); 
		$tahun = substr($data,0,4); 


		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Januari';
						break;
				case 02 : $nm_bulan='Februari';
						break;
				case 03 : $nm_bulan='Maret';
						break;
				case 04 : $nm_bulan='April';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Juni';
						break;
				case 07 : $nm_bulan='Juli';
						break;
				case 8 : $nm_bulan='Agustus';
						break;
				case 9 : $nm_bulan='September';
						break;
				case 10 : $nm_bulan='Oktober';
						break;
				case 11 : $nm_bulan='November';
						break;
				case 12 : $nm_bulan='Desember';
						break;
					}

		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';
		$data=$tanggal.'   '.$nm_bulan.'  '.$tahun;
	return $data;
	}

	public static function tgl_sql($data){
		
		if ( $data != null ){
			$x			= explode('-',$data);
		}else{
			$x = "00-00-0000";
		}
		

		$tanggal 	= $x[0];
		$nm_bulan 	= $x[1];
		$tahun 		= $x[2];

		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';

		$data= $tahun."-".$nm_bulan."-".$tanggal;
	return $data;
	}

	public static function persen($data,$data2){

		if ( $data == 0 | $data2 == 0 ){
			$hasil = 0 ;
		}else{

			if ( ($data*100%$data2) == 0 ){
				$hasil = number_format(($data/$data2)*100 , 0);
			}else{
				$hasil = number_format(($data/$data2)*100 , 2);
			}

		}

		return $hasil. " %";

	}

	public static function persen2($data,$data2){

		if ( $data == 0 | $data2 == 0 ){
			$hasil = 0 ;
		}else{

			if ( ($data%$data2) == 0 ){
				$hasil = number_format(($data/$data2) , 0);
			}else{
				$hasil = number_format(($data/$data2) , 2);
			}

		}

		return $hasil. " %";

	}

	public static function persen_bulat($data){

		if ( $data > 0 ){
			$x	= explode('.',$data);

			if ( isset($x[1])){
				if (  $x[1] == '00' ){
					$hasil = number_format(($data) , 0);
				}else{
					$hasil = number_format(($data) , 2);
				}
			}else{
				$hasil = number_format(($data) , 0);
			}

			

		}else{
			$hasil = 0 ;
		}
		


		return $hasil;

	}

	public static function ave($data,$data2){

		if ( $data == 0 | $data2 == 0 ){
			$hasil = 0 ;
		}else{

			if ( ($data%$data2) == 0 ){
				$hasil = number_format(($data/$data2) , 2);
			}else{
				$hasil = number_format(($data/$data2) , 2);
			}
			
		}

		return $hasil;

	}

	public static function perilaku($data){
		if ($data == 0 ){
			$keterangan = "Buruk";
		}else if ($data <= 50 ){
			$keterangan = "Buruk";
		}else if ($data <= 60) {
			$keterangan = "Kurang";
		}else if ($data <= 75) {
			$keterangan = "Cukup";
		}else if ($data <= 90) {
			$keterangan = "Baik";
		}else if ($data >=90.001) {
			$keterangan = "Sangat Baik";
		}

		return $keterangan;

	}



	public static function tgl_form($data){

		$x			= explode('-',$data);
		$tanggal 	= $x[2];
		$nm_bulan 	= $x[1];
		$tahun 		= $x[0];

		
		
		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';

		$data= $tanggal.'-'.$nm_bulan.'-'.$tahun;
	return $data;
	}
	
	public static function bulan($data){
		
		$bulan = $data; 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Januari';
						break;
				case 02 : $nm_bulan='Februari';
						break;
				case 03 : $nm_bulan='Maret';
						break;
				case 04 : $nm_bulan='April';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Juni';
						break;
				case 07 : $nm_bulan='Juli';
						break;
				case 8 : $nm_bulan='Agustus';
						break;
				case 9 : $nm_bulan='September';
						break;
				case 10 : $nm_bulan='Oktober';
						break;
				case 11 : $nm_bulan='November';
						break;
				case 12 : $nm_bulan='Desember';
						break;
					}

					
		
		$data=$nm_bulan;
	return $data;

	}
	public static function bulan2($data){
		
		$bulan = $data; 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 'Januari' 	: $nm_bulan='01';
						break;
				case 'Februari' : $nm_bulan='02';
						break;
				case 'Maret' 	: $nm_bulan='03';
						break;
				case 'April' 	: $nm_bulan='04';
						break;
				case 'Mei' 		: $nm_bulan='05';
						break;
				case 'Juni' 	: $nm_bulan='06';
						break;
				case 'Juli' 	: $nm_bulan='07';
						break;
				case 'Agustus' 	: $nm_bulan='08';
						break;
				case 'September': $nm_bulan='09';
						break;
				case 'Oktober' 	: $nm_bulan='10';
						break;
				case 'November' : $nm_bulan='11';
						break;
				case 'Desember' : $nm_bulan='12';
						break;
					}

		
	return $nm_bulan;

	}


	public static function bulan_short($data){
		
		$bulan = $data; 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Jan';
						break;
				case 02 : $nm_bulan='Feb';
						break;
				case 03 : $nm_bulan='Mar';
						break;
				case 04 : $nm_bulan='Apr';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Jun';
						break;
				case 07 : $nm_bulan='Jul';
						break;
				case 8 : $nm_bulan='Agu';
						break;
				case 9 : $nm_bulan='Sep';
						break;
				case 10 : $nm_bulan='Okt';
						break;
				case 11 : $nm_bulan='Nov';
						break;
				case 12 : $nm_bulan='Des';
						break;
					}

					
		
		$data=$nm_bulan;
	return $data;

	}


	public static function periode($data){
		$tanggal = substr($data,8,2); 
		$bulan = substr($data,5,2); 
		$tahun = substr($data,0,4); 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Jan';
						break;
				case 02 : $nm_bulan='Feb';
						break;
				case 03 : $nm_bulan='Mar';
						break;
				case 04 : $nm_bulan='Apr';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Jun';
						break;
				case 07 : $nm_bulan='Jul';
						break;
				case 8 : $nm_bulan='Agust';
						break;
				case 9 : $nm_bulan='Sept';
						break;
				case 10 : $nm_bulan='Okt';
						break;
				case 11 : $nm_bulan='Nov';
						break;
				case 12 : $nm_bulan='Des';
						break;
					}

					
		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';
		
		$data=$nm_bulan.' '.$tahun;
	return $data;

	}


	public static function angka_bln($data){
		$bulan = substr($data,5,2); 
		switch($bulan)
		{
		case 01 : $nm_bulan=1;
				break;
		case 02 : $nm_bulan=2;
				break;
		case 03 : $nm_bulan=3;
				break;
		case 04 : $nm_bulan=4;
				break;
		case 05 : $nm_bulan=5;
				break;
		case 06 : $nm_bulan=6;
				break;
		case 07 : $nm_bulan=6;
				break;
		case 08 : $nm_bulan=8;
				break;
		case 09 : $nm_bulan=9;
				break;
		case 10 : $nm_bulan=10;
				break;
		case 11 : $nm_bulan=11;
				break;
		case 12 : $nm_bulan=12;
				break;
			}
		return $bulan;

	}

	public static function angka_bln_tz($data){
		$bulan = substr($data,5,2); 
	
		return $bulan;

	}

	public static function bulan_lalu($bulan){
		
				switch($bulan)
					{
				case 01 : $nm_bulan='12';
						break;
				case 02 : $nm_bulan='01';
						break;
				case 03 : $nm_bulan='02';
						break;
				case 04 : $nm_bulan='03';
						break;
				case 05 : $nm_bulan='04';
						break;
				case 06 : $nm_bulan='05';
						break;
				case 07 : $nm_bulan='06';
						break;
				case 8 : $nm_bulan='07';
						break;
				case 9 : $nm_bulan='08';
						break;
				case 10 : $nm_bulan='09';
						break;
				case 11 : $nm_bulan='10';
						break;
				case 12 : $nm_bulan='11';
						break;
					}

	return $nm_bulan;

	}

	public static function tahun($data){
		$tanggal = substr($data,8,2); 
		$bulan = substr($data,5,2); 
		$tahun = substr($data,0,4); 

		//ubah angka ke nama bulan
				switch($bulan)
					{
				case 01 : $nm_bulan='Jan';
						break;
				case 02 : $nm_bulan='Feb';
						break;
				case 03 : $nm_bulan='Mar';
						break;
				case 04 : $nm_bulan='Apr';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Jun';
						break;
				case 07 : $nm_bulan='Jul';
						break;
				case 8 : $nm_bulan='Agust';
						break;
				case 9 : $nm_bulan='Sept';
						break;
				case 10 : $nm_bulan='Okt';
						break;
				case 11 : $nm_bulan='Nov';
						break;
				case 12 : $nm_bulan='Des';
						break;
					}

					
		$tanggal = isset($tanggal) ? $tanggal : '';
		$nm_bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';
		
		$data=$tahun;
	return $data;

	}
	
	
	function namahari($tanggal){
    
		//fungsi mencari namahari
		//format $tgl YYYY-MM-DD
		//harviacode.com
		
		$tgl=substr($tanggal,8,2);
		$bln=substr($tanggal,5,2);
		$thn=substr($tanggal,0,4);
	 
		$info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
		
		switch($info){
			case '0': return "Minggu"; break;
			case '1': return "Senin"; break;
			case '2': return "Selasa"; break;
			case '3': return "Rabu"; break;
			case '4': return "Kamis"; break;
			case '5': return "Jumat"; break;
			case '6': return "Sabtu"; break;
		};
		
	}
	
	public static function tgl_jam($data) {
       
		$x		= explode(' ', $data);
		$tgl	= $x[0];
		$jam 	= $x[1];
		$jam 	= substr($jam,0,5); 

		$tanggal = substr($tgl,8,2); 
		$bulan = substr($tgl,5,2); 
		$tahun = substr($tgl,0,4); 

		switch($bulan)
					{
						
				case 01 : $nm_bulan='Januari';
						break;
				case 02 : $nm_bulan='Februari';
						break;
				case 03 : $nm_bulan='Maret';
						break;
				case 04 : $nm_bulan='April';
						break;
				case 05 : $nm_bulan='Mei';
						break;
				case 06 : $nm_bulan='Juni';
						break;
				case 07 : $nm_bulan='Juli';
						break;
				case 8 : $nm_bulan='Agustus';
						break;
				case 9 : $nm_bulan='September';
						break;
				case 10 : $nm_bulan='Oktober';
						break;
				case 11 : $nm_bulan='November';
						break;
				case 12 : $nm_bulan='Desember';
						break;
					}

	
		$tanggal = isset($tanggal) ? $tanggal : '';
		$bulan = isset($nm_bulan) ? $nm_bulan : '';
		$tahun = isset($tahun) ? $tahun : '';
		
		$data=$tanggal.'   '.$nm_bulan.'  '.$tahun;
	return $data . "&nbsp;&nbsp;[" .$jam. "]" ;

	}

	public static function tgl_jam_short($data) {
       
		$x		= explode(' ', $data);
		$tgl	= $x[0];
		$jam 	= $x[1];
		$jam 	= substr($jam,0,5); 

		$tanggal = substr($tgl,8,2); 
		$bulan = substr($tgl,5,2); 
		$tahun = substr($tgl,0,4); 

		
		$tanggal = isset($tanggal) ? $tanggal : '';
		$tahun = isset($tahun) ? $tahun : '';
		
		$data=$tanggal.'/'.$bulan.'/'.$tahun;
	return $data . "&nbsp;&nbsp;[" .$jam. "]" ;

	}
	
	public static function trimester($data) {
       
	
		switch($data)
					{
						
				case 1 : $trimester='Triwulan I ( Januari - Maret )';
						break;
				case 2 : $trimester='Triwulan II ( April - Juni )';
						break;
				case 3 : $trimester='Triwulan III ( Juli - September )';
						break;
				case 4 : $trimester='Triwulan IV ( Oktober - Desember )';
						break;
						
					}

		return $trimester;

	}
	
	public static function triwulan($data) {
       
	
		switch($data)
					{
						
				case 1 : $triwulan='Triwulan I ( Januari - Maret )';
						break;
				case 2 : $triwulan='Triwulan II ( April - Juni )';
						break;
				case 3 : $triwulan='Triwulan III ( Juli - September )';
						break;
				case 4 : $triwulan='Triwulan IV ( Oktober - Desember )';
						break;
						
					}

		return $triwulan;

    }

	public static function triwulan_lalu($data) {
       
	
		$tanggal = substr($data,8,2); 
		$bulan   = substr($data,5,2); 
		$tahun   = substr($data,0,4); 

		$hasil =  mktime(0, 0, 0, date($bulan)-2, date($tanggal), date($tahun));
		//return date("Y-m-d", $hasil);

		if ( date("Y",$hasil) == ($tahun - 1)){
			$hasil =  mktime(0, 0, 0, date($bulan)-1, date($tanggal), date($tahun));
		}else if ( date("Y",$hasil) == ($tahun - 1)){
			$hasil =  mktime(0, 0, 0, date($bulan), date($tanggal), date($tahun));
		}


		return date("Y-m-01",$hasil);
	}
	
	public static function tgl_besok($data) {
       
	
		$tanggal = substr($data,8,2); 
		$bulan   = substr($data,5,2); 
		$tahun   = substr($data,0,4); 

		$hasil =  mktime(0, 0, 0, date($bulan), date($tanggal)+1, date($tahun));
		return date("Y-m-d", $hasil);
		
	}
	
	public static function tgl_akhir($data) {
       
		return date("Y-m-t", strtotime($data));
    }
	


}