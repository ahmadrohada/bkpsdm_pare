<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Models\UsersRole;
use App\Models\Profile;
use App\Http\Requests;
use App\Models\Social;
use App\Models\User;
use App\Models\Role;
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

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

	
	public function ShowPetaJabatan(){  

		$user                  = \Auth::user();
		
        return view('pare_pns.pages.show-peta-jabatan',compact('tree'),[
        		'user' 		          => $user,
        	]);
    }


    public function DataPetaJabatan(){  

		$user       = \Auth::user();
		
		$renja 		= PetaJabatan::select('id','skpd','parent_id')->get();
		
	
		$no = 0;
		
		foreach ($renja as $x) {
			
			$no++;
				
			$sub_data['id']				= $x->id;
			$sub_data['text']			= $x->skpd;
			$sub_data['parent_id']		= $x->parent_id;
			
			//array_push($response["list_renja"], $h);
			$data[] = $sub_data ;		
		}	
		
		$itemsByReference = array();

		// Build array of item references:
		foreach($data as $key => &$item) {
		   $itemsByReference[$item['id']] = &$item;
		   // Children array:
		   $itemsByReference[$item['id']]['nodes'] = array();
		}

		// Set items as children of the relevant parent item.
		foreach($data as $key => &$item)  {
		//echo "<pre>";print_r($itemsByReference[$item['parent_id']]);die;
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  $itemsByReference [$item['parent_id']]['nodes'][] = &$item;
			}
		}
		// Remove items that were added to parents elsewhere:
		foreach($data as $key => &$item) {
			 if(empty($item['nodes'])) {
				unset($item['nodes']);
				}
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  unset($data[$key]);
			 }
		}

		// Encode:
		//echo json_encode($data);
		return $data;
			
	} 
		
	
	

	public function DataPetaJabatanSkpd(){  

        $id_skpd_admin      = \Auth::user()->pegawai->history_jabatan
                                    ->where('status','active')
                                    ->first()
                                    ->id_skpd;

        
        $renja 		= PetaJabatan::select('id','skpd','parent_id')
                                    ->where('id_skpd','=',$id_skpd_admin)
                                    ->get();
		
		//ORDER BY WEEK ASC,c.id ASC
		$no = 0;
		
		
		foreach ($renja as $x) {
			
			$no++;
				
			$sub_data['id']				= $x->id;
			$sub_data['text']			= Pustaka::capital_string($x->skpd);
			$sub_data['parent_id']		= $x->parent_id;
			
			//array_push($response["list_renja"], $h);
			$data[] = $sub_data ;		
		}	
		
		$itemsByReference = array();

		// Build array of item references:
		foreach($data as $key => &$item) {
		   $itemsByReference[$item['id']] = &$item;
		   // Children array:
		   $itemsByReference[$item['id']]['nodes'] = array();
		}

		// Set items as children of the relevant parent item.
		foreach($data as $key => &$item)  {
		//echo "<pre>";print_r($itemsByReference[$item['parent_id']]);die;
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  $itemsByReference [$item['parent_id']]['nodes'][] = &$item;
			}
		}
		// Remove items that were added to parents elsewhere:
		foreach($data as $key => &$item) {
			 if(empty($item['nodes'])) {
				unset($item['nodes']);
				}
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  unset($data[$key]);
			 }
		}

		// Encode:
		//echo json_encode($data);
		return $data;
			
    } 
    
    public function ShowPetaJabatanSkpd(){  

		$user                   = \Auth::user();
		$userRole               = $user->hasRole('user');
        $adminskpdRole               = $user->hasRole('admin_skpd');
        $adminRole              = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'User';
        } elseif ($adminskpdRole) {
            $access = 'Admin Skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
        }
        
        return view('pare_pns.pages.show-peta-jabatan',compact('tree'),[
        		'user' 		          => $user,
				'access' 	          => $access,
        	]);
    }

    public function childView($Category){                 
            $html ='<ul>';
            foreach ($Category->childs as $arr) {
                if(count($arr->childs)){
                $html .='<li class="tree-view closed"><a class="tree-name">'.$arr->label.'</a>';                  
                        $html.= $this->childView($arr);
                    }else{
                        $html .='<li class="tree-view"><a class="tree-name">'.$arr->label.'</a>';                                 
                        $html .="</li>";
                    }
                                   
            }
            
            $html .="</ul>";
            return $html;
    }  
	
	
	
	
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
