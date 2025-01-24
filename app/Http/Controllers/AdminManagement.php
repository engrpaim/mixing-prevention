<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminManagement extends Controller
{
    //
    protected $isGetAllIp;

    public function __construct()
    {
        $this->isGetAllIp =  DB::select('SELECT * FROM admin_models');
        $toBeAjax = $this->isGetAllIp;
        $compiledAll = '';
        foreach($toBeAjax as $dataPerAjax){
            if(isset($dataPerAjax) && $dataPerAjax !== null){
                $outputModel = '
                <tr>
                    <td class="px-4 py-2 text-left border border-blue-500">'.$dataPerAjax->name.'</td>
                    <td class="px-4 py-2 text-left border border-blue-500">'.$dataPerAjax->ip.'</td>
                    <td class="px-4 py-2 text-left border border-blue-500">
                        <button>'.$dataPerAjax->model.'</button>
                        <button>'.$dataPerAjax->view.'</button>
                        <button>'.$dataPerAjax->manage.'</button>
                    </td>
                </tr>
                ';
            }
            $compiledAll .= $outputModel;

        }
        dump($compiledAll);
    }

    public function table(){
        $allIp =  $this->isGetAllIp;
        dump( $allIp );
        return view('admin');
    }

    public function addAdmin(Request $request){
        // dump($request->all());

        $allIp =  $this->isGetAllIp;
        dump( $allIp );
        $userIpAddress = $request->input('slot1').".".$request->input('slot2').".".$request->input('slot3').".".$request->input('slot4');
        $name = $request->input('name');
        $area = $request->input('area');
        $manage = $request->input('manage');
        $model = $request->input('model');
        $view = $request->input('view');

        if(   $manage == null){
            $manage = 'off';
            //dd($manage);
        }
        if(   $model == null){
            $model = 'off';
            //dd($manage);
        }
        if(   $view == null){
            $view = 'off';
            //dd($view);
        }

        // dump($userIpAddress,$name,$area,$manage,$model,$view);
        try{

        }catch(\Exception $e){}
        $request->validate( [
                                'userIpAddress' => [
                                    'string',
                                    'max:255',

                                ],
                                'name' => [
                                    'string',
                                    'max:255',

                                ],
                                'area' => [
                                    'string',
                                    'max:255',
                                ],
                                'manage' => [
                                    'string',
                                    'max:255',
                                ],
                                'model' => [
                                    'string',
                                    'max:255',
                                ],
                                'view' => [
                                    'string',
                                    'max:255',
                                ]
                            ]
                        );

        try{
            $dataInsert = DB::table('admin_models')->insert([
                'ip' =>$userIpAddress,
                'name' => $request->input('name'),
                'area' => $area,
                'manage' =>  $manage,
                'model' => $model,
                'view' => $view,
                'addedBy' => request()->ip(),
                'created_At' => now(),
                'update_At' => now(),
            ]);
            if($dataInsert){
                return view('admin',['success' => $request->input('name') . " is added with I.P address " .$userIpAddress ]);
            }
        }catch(\Illuminate\Database\QueryException $e){

            if(str_contains( $e->errorInfo[2],"'name'")){

                return view('admin',['error' => "Name ".$name . " already exist" ]);

            }else{

                return view('admin',['error' => "I.P address ".$userIpAddress . " already exist" ]);

            }

        }catch (\Exception $e) {
            return view('admin', ['error' => 'An unexpected error occurred.']);
        }





    }


}
