<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;

use App\Models\Social;
use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Skpd;
use App\Models\Renja;
use App\Models\TPPReport;
use App\Models\UnitKerja;

use App\Models\SKPTahunan;
use App\Models\Sasaran;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\RencanaKerja;
use App\Models\PetaJabatan;



use App\Helpers\Pustaka;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class HomeSKPDController extends Controller {
    
    

    //=======================================================================================//
    protected function nama_skpd($skpd_id){
            //nama SKPD 
            $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                            ->WHERE('id',$skpd_id)
                            ->SELECT(['skpd.skpd AS skpd'])
                            ->first();
            return $nama_skpd->skpd;
    }

    protected function nama_puskesmas($puskesmas_id){
        //nama puskesmas 
        $nama_puskesmas  = UnitKerja::WHERE('m_unit_kerja.id',$puskesmas_id)
                                    ->SELECT(['m_unit_kerja.unit_kerja AS puskesmas'])
                                    ->first();
        return $nama_puskesmas->puskesmas;
    }

    protected function total_pegawai(){
        
        return 	Pegawai::WHERE('status','active')->WHERE('nip','!=','admin')->count();
    } 
    
    
    protected function total_users(){
        return 	\DB::table('db_pare_2018.users AS users')
                                ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                    $join   ->on('users.id_pegawai','=','pegawai.id');
                                    $join   ->where('pegawai.status','=', 'active');
                                })
                                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                    $join   ->on('a.id_pegawai','=','pegawai.id');
                                    $join   ->where('a.status','=', 'active');
                                })->count();
    }
    

    protected function total_pegawai_skpd( $skpd_id){
        
        return 	Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                            $join   ->where('a.status','=', 'active');
                                    })
                                    ->WHERE('a.id_skpd','=', $skpd_id)
                                    ->WHERE('tb_pegawai.nip','!=','admin')
                                    ->WHERE('tb_pegawai.status','active')
                                    ->count();
    }

    protected function total_puskesmas(){
        return 	SKPD::WHERE('parent_id','=', 168 )->count();
    }

    protected function total_pegawai_puskesmas( $puskesmas_id){
        
        return 	Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function($join) use($puskesmas_id){ 
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id')
                                            ->where(function ($query) use($puskesmas_id) {
                                                $query  ->where('a.id_unit_kerja','=', $puskesmas_id)
                                                        ->orwhere('a.id_jabatan','=', $puskesmas_id);
                                            });
                                            $join   ->where('a.status','=', 'active');
                                    })
                                    ->WHERE('tb_pegawai.nip','!=','admin')
                                    ->WHERE('tb_pegawai.status','active')
                                    ->count();
    }
    

    protected function total_unit_kerja( $skpd_id){
        
        return 	SKPD::WHERE('m_skpd.parent_id','=', $skpd_id)
                                    ->rightjoin('demo_asn.m_skpd AS a', function($join){
                                        $join   ->on('a.parent_id','=','m_skpd.id');
                                    })
                                    ->count();
    }


    protected function total_pohon_kinerja( $skpd_id){
        
        return 	Renja::WHERE('renja.skpd_id','=', $skpd_id)->count();
    }

    protected function total_skp_tahunan($skpd_id){
        return 	Renja::WHERE('renja.skpd_id',$skpd_id)
                            ->leftjoin('db_pare_2018.skp_tahunan AS skp', function($join){
                                $join   ->on('skp.renja_id','=','renja.id');
                            })->count();
    }
   
    protected function total_tpp_report($skpd_id){
        return 	TPPReport::WHERE('tpp_report.skpd_id',$skpd_id)
                            ->count();
    }

    protected function total_skpd()
	{
       return SKPD::whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->count();  
       
               
	}

    public function showHomeSKPD(Request $request)
    {
        return redirect('/skpd/pegawai');
    }
    
    public function showPegawai(Request $request)
    {
        $user                   = \Auth::user();
       //CARI id skpd nya
       $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       return view('pare_pns.pages.skpd-home-pegawai', [
               
               'skpd_id'                => $skpd_id,
               'nama_skpd'     	        => $this->nama_skpd($skpd_id),
               'total_pegawai' 	        => $this->total_pegawai_skpd($skpd_id),
               'total_unit_kerja' 	    => $this->total_unit_kerja($skpd_id),
               'total_pohon_kinerja' 	=> $this->total_pohon_kinerja($skpd_id),
               'total_skp_tahunan' 	    => $this->total_skp_tahunan($skpd_id),
               'total_tpp_report' 	    => $this->total_tpp_report($skpd_id),
               'total_puskesmas'        => $this->total_puskesmas(),

               'h_box'                  => 'box-fuchsia',
               
           ]
       );  

        
    }
    
    public function showUnitKerja(Request $request)
    {
            
        $skpd_id      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

        
         

		return view('pare_pns.pages.skpd-home-unit_kerja', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),


                'h_box'                   => 'box-teal',
                
        	]
        );   

        
    }

    public function showRenja(Request $request)
    {
            
        
        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-renja', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),

                'h_box'                  => 'box-light-blue',
               
           ]
        );   

        
    }

    public function ShowPetaJabatan(Request $request)
    {
            

        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-peta_jabatan', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),


                'h_box'                  => 'box-green',
               
           ]
        ); 
        
    }

    public function ShowStrukturOrganisasi(Request $request)
    {
            

        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-struktur_organisasi', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),

                'h_box'                  => 'box-green',
               
           ]
        ); 
        
    }


    public function showPerjanjianKinerja(Request $request)
    {
        $user                   = \Auth::user();
        
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-perjanjian_kinerja', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),

                'h_box'                  => 'box-aqua',
               
           ]
        );   

        
    }

    public function showSKPTahunan(Request $request)
    {
        $user                   = \Auth::user();
        
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-skp_tahunan', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),

                'h_box'                  => 'box-red',
               
           ]
        );   

        
    }

    public function showSKPBulanan(Request $request)
    {
        $user                   = \Auth::user();
        
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-skp_bulanan', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),


                'h_box'                  => 'box-green',
               
           ]
        );   

        
    }


    public function showSKPDTPPReport(Request $request)
    {
        $user      = \Auth::user();
        
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        return view(
            'pare_pns.pages.skpd-home-tpp_report',
            [
                'skpd'                   => $pegawai->JabatanAktif->SKPD,
                'pegawai_id'             => $pegawai->id,
                'nama_pegawai'           => Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk),
                'h_box'                  => 'box-success',
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
                'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
                'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
                'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
                'total_puskesmas'        => $this->total_puskesmas(),

            ]
        ); 
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        
    }


    public function showPuskesmas(Request $request)
    {
        $user      = \Auth::user();
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        
       
		return view('pare_pns.pages.skpd-home-puskesmas', [
            'skpd_id'                => $skpd_id,
            'nama_skpd'     	     => $this->nama_skpd($skpd_id),
            'total_pegawai' 	     => $this->total_pegawai_skpd($skpd_id),
            'total_unit_kerja' 	     => $this->total_unit_kerja($skpd_id),
            'total_pohon_kinerja' 	 => $this->total_pohon_kinerja($skpd_id),
            'total_skp_tahunan' 	 => $this->total_skp_tahunan($skpd_id),
            'total_tpp_report' 	     => $this->total_tpp_report($skpd_id),
            'total_puskesmas'        => $this->total_puskesmas(),


            'h_box'                   => 'box-maroon',
            
        ]
    );   

        
    }

    public function SKPDPuskesmasPegawai(Request $request)
    {
            
        $puskesmas_id     = $request->puskesmas_id;
        
       

		return view('pare_pns.pages.skpd-puskesmas-pegawai', [
                //'users' 		          => $users,
                'puskesmas_id'            => $puskesmas_id,
                'nama_puskesmas'     	  => $this->nama_puskesmas($puskesmas_id),
                'total_pegawai' 	      => $this->total_pegawai_puskesmas($puskesmas_id),
                'total_unit_kerja' 	      => $this->total_unit_kerja($puskesmas_id),
                'total_tpp_report' 	      => $this->total_tpp_report($puskesmas_id),
                'total_puskesmas'         => $this->total_puskesmas(),
                'total_jabatan'           => 'x',
                'total_renja'             => 'x',
                'h_box'                   => 'box-maroon',
                
        	]
        );   

        
    }

    public function showCapaianTriwulanPK(Request $request)
    {
        $user                   = \Auth::user();
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        return view('pare_pns.pages.skpd-home-capaian_pk_triwulan', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'h_box'                  => 'box-teal',
               
           ]
        );   

        
    }

    public function showCapaianTahunanPK(Request $request)
    {
        $user                   = \Auth::user();
        
        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('pare_pns.pages.skpd-home-capaian_pk_tahunan', [
                'skpd_id'                => $skpd_id,
                'nama_skpd'     	     => $this->nama_skpd($skpd_id),
                'h_box'                  => 'box-maroon',
               
           ]
        );   

        
    }

    
}
