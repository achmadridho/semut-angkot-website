<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Carbon\Carbon ;
use MongoDate;
use DateTime;
use Hash;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;

class CUser extends Controller
{
    public function loginadmin(Request $request)
    {
        $this->validate($request, [
            'Password' => 'required'
        ]);
        $documents = DB::collection('tb_user')
            ->where('Email', $request['Email'])
            ->get();
        if ($documents) {

            foreach ($documents as $value) {
                $password = $value['Password'];
                $ID = $value['_id'];
                $Role = $value['ID_role'];
            }
            if (md5($request['Password'])== $password) {
                if ($Role != 21) {
                    Session::flash('message', 'Anda Bukan Admin');
                    return Redirect::to('/login');
                } else {
                    session(['Email' => $request['Email'],
                        'ID' => $ID]);
                    return Redirect::to('/');
                }

            } else {
                Session::flash('message', 'Password Salah');
                return Redirect::to('/login');
            }
        } else {
            Session::flash('message', 'Email Belum Terdaftar');
            return Redirect::to('/login');
        }
    }
    public function getlistuserangkot()
    {
        $documents = DB::collection('tb_user')
            ->where('ID_role', '=', 20)
            ->select('Name', 'Angkot','Email','PhoneNumber')
            ->get();
        $dataset = array();
        foreach ($documents as $value) {
            $value['_id'] = (string)$value['_id'];
            $value['Coordinates']=$value['Angkot']['location']['coordinates'];
            $value['Longitude']=$value['Coordinates'][0];
            $value['Latitude']=$value['Coordinates'][1];
            array_push($dataset, $value);
        }
        return $dataset;
    }
    public function reportlist()
    {
        $documents = DB::collection('tb_post_angkot')
            ->where('tanggal','>', new DateTime())
            ->get();
        $dataset = array();
        foreach ($documents as $value) {
            $value['_id'] = (string)$value['_id'];
            foreach ($value['tanggal'] as $dates){
                $value['date']=date("D, d-m-Y", $dates/1000);
                $value['time']=date("H:i:s", $dates/1000);
            }
            array_push($dataset, $value);
        }
        return $dataset;
    }
    public function logout()
    {
        session()->flush();
        return Redirect::to('/');
    }

    public function delete(Request $request)
    {
        $_id = $request['_id'];
        $documents = DB::collection('tb_user')
            ->where('_id', $_id)
            ->delete();
        if ($documents) {

            return Session::flash('message', 'User Berhasil Dihapus');
        } else {

            return Session::flash('message', 'User Gagal Dihapus');
        }
    }
}
