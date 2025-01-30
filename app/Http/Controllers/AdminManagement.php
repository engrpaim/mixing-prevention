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

    }

    public function table(){
        $toBeAjax = $this->isGetAllIp;
        return view('admin',['ipaddress' =>  $toBeAjax]);
    }

    public function delete($ip){
        $deleted = DB::table('admin_models')->where('ip',$ip)->delete();
        $toBeAjax  =  DB::select('SELECT * FROM admin_models');
        return view('admin',['ipaddress' =>  $toBeAjax]);

    }

    public function update(Request $request){

        $dataTosave = [];
        $name = '';
        foreach($request->all() as $dataKey => $dataValue){
            if($dataKey != '_token' && !str_contains($dataKey ,"current") ){
                $allcolumn = explode("_",$dataKey);
                $column = explode("_",$dataKey)[0];

                if($name == ''  ){

                    for($i = 0 ; $i < count( $allcolumn);$i++){
                        if($i > 0){
                            $name .= " ". $allcolumn[$i];
                        }
                    }

                }

                $status = $dataValue;
                $dataTosave [$column] = $status;

            }
        }
        $ip =  $request->input('ip') != null ? $request->input('ip'):$request->input('current_ip');
        $namenew =  $request->input('name') != null ? $request->input('name'):$request->input('current_name');

        $model = isset($dataTosave ['model']) ? 'ON' : 'OFF';
        $admin = isset($dataTosave ['admin']) ? 'ON' : 'OFF';
        $view = isset($dataTosave ['view']) ? 'ON' : 'OFF';
        $manage = isset($dataTosave ['manage']) ? 'ON' : 'OFF';
        $toBeAjax = $this->isGetAllIp;
        try{
            $trimName=trim($name);
            $isUpdated = DB::table('admin_models')
                ->where('name',$trimName)
                ->update([
                    'model' =>   $model,
                    'admin' =>   $admin,
                    'view' =>   $view,
                    'manage' =>   $manage,
                    'name' => $namenew,
                    'ip' => $ip,
                ]);



            $toBeAjax = DB::select('SELECT * FROM admin_models');

            return view('admin',['ipaddress' =>  $toBeAjax]);

        }catch(\Exception $e){
            dump($e);
        }
    }

    public function addAdmin(Request $request){




        $userIpAddress = $request->input('slot1').".".$request->input('slot2').".".$request->input('slot3').".".$request->input('slot4');
        $name = $request->input('name');
        $area = $request->input('area');
        $manage = $request->input('manage');
        $model = $request->input('model');
        $view = $request->input('view');
        $admin = $request->input('admin');

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
        if(   $admin == null){
            $admin = 'off';
            //dd($view);
        }

        // dump($userIpAddress,$name,$area,$manage,$model,$view);

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
                                ],
                                'admin' => [
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
                'admin' => $admin,
                'view' => $view,
                'addedBy' => request()->ip(),
                'created_At' => now(),
                'update_At' => now(),
            ]);
            $toBeAjax = $this->isGetAllIp =  DB::select('SELECT * FROM admin_models');
            if($dataInsert){
                return view('admin',['success' => $request->input('name') . " is added with I.P address " .$userIpAddress
                                        ,'ipaddress' =>  $toBeAjax]);
            }
        }catch(\Illuminate\Database\QueryException $e){

            $toBeAjax = $this->isGetAllIp =  DB::select('SELECT * FROM admin_models');
            if(str_contains( $e->errorInfo[2],"'name'")){

                return view('admin',['error' => "Name ".$name . " already exist" ,'ipaddress' =>  $toBeAjax]);

            }else{

                return view('admin',['error' => "I.P address ".$userIpAddress . " already exist" ,'ipaddress' =>  $toBeAjax ]);

            }

        }catch (\Exception $e) {

            $toBeAjax = $this->isGetAllIp =  DB::select('SELECT * FROM admin_models');
            return view('admin', ['error' => 'An unexpected error occurred.' ,'ipaddress' =>  $toBeAjax]);
        }





    }


}
