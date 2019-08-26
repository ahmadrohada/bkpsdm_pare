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
	
		return $bulan;

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
	
	public static function trimester($data) {
       
	
		switch($data)
					{
						
				case 1 : $trimester='Trimester I ( Januari - Maret )';
						break;
				case 2 : $trimester='FebruTrimester II ( April - Juni )';
						break;
				case 3 : $trimester='Trimester III ( Juli - September )';
						break;
				case 4 : $trimester='Trimester IV ( Oktober - Desember )';
						break;
						
					}

		return $trimester;

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