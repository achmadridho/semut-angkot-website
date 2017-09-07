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
    public function editUserAngkot(Request $r)
    {
        $selectionOptions = [1 => 'Cimindi pasar sederhana 24', 2 => 'St hall gunung batu 14', 3 => 'Stasiun Hall - Sarijadi'];
        $selectedTrayek=(int)$r['Trayek1'];
        $selected = $selectionOptions[$selectedTrayek];
        if($r->hasFile('Image'))
        {
            if ($r->file('Image')->isValid()) {
                $image = Input::file('Image');
                $filename  = time() . '.' . $image->getClientOriginalExtension();
                $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
                $contentType = mime_content_type($image->getRealPath());

                if(! in_array($contentType, $allowedMimeTypes) ){
                    Session::flash('error', 'Silahkan Upload Foto Lain');
                }else{

                    $ftp_server = "ftp.pptik.id";
                    $ftp_user_name = "ftp.pptik.id|ftppptik";
                    $ftp_user_pass = "XxYyZz123!";
                    $destination_file = "/SEMUTANGKOTFILE/".$filename;
                    $source_file = $image->getRealPath();
                    $conn_id = ftp_connect($ftp_server);
                    ftp_pasv($conn_id, true);
                    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                    if ((!$conn_id) || (!$login_result)) {
                        Session::flash('message', "FTP connection has failed!");
                    } else {
                        $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
                        if (!$upload) {
                            Session::flash('message', 'Gagal Update Data');
                        } else {
                            $fileHostingname="http://filehosting.pptik.id";
                            $result= DB::table('tb_user')
                                ->where('_id', $r['_id'])
                                ->update(
                                    ['Name' => $r['Name1'],
                                        'Email'=> $r['Email1'],
                                        'PhoneNumber'=> $r['PhoneNumber1'],
                                        'Angkot.PlatNomor'=> $r['Plat_motor1'],
                                        'Angkot.Trayek.Nama'=> $selected,
                                        'Angkot.Trayek.TrayekID'=> $selectedTrayek,
                                        'Path_foto'=>$fileHostingname.$destination_file]);
                            if ($result){
                                Session::flash('success', 'Berhasil Edit Data');
                            }else{
                                Session::flash('message', 'Gagal Edit Data');
                            }
                        }
                    }
                }

            }

        }else{
            $result= DB::table('tb_user')
                ->where('_id', $r['_id'])
                ->update(
                    ['Name' => $r['Name1'],
                        'Email'=> $r['Email1'],
                        'username'=> $r['Username1'],
                        'PhoneNumber'=> $r['PhoneNumber1'],
                        'Angkot.Trayek.Nama'=> $selected,
                        'Angkot.Trayek.TrayekID'=> $selectedTrayek,
                        'Angkot.PlatNomor'=> $r['Plat_motor1']
                    ]);
            if ($result){
                Session::flash('success', 'Berhasil Edit Data');
            }else{
                Session::flash('message', 'Gagal Edit Data');
            }
        }
        return Redirect::to('/admin/dashboard');
    }
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
    public function getListUserAngkotToday()
    {
        //$dt = Carbon::now()->subDay();
		$dt = Carbon::today();
        $documents = DB::collection('tb_user')
            ->where('ID_role', '=', 20)
            ->where("Angkot.LastUpdate",">",$dt)
            ->select('Name', 'Angkot','Email','PhoneNumber')
            ->get();
        $dataset = array();
        foreach ($documents as $value) {
            $value['_id'] = (string)$value['_id'];
            $value['Coordinates']=$value['Angkot']['location']['coordinates'];
            $value['Longitude']=$value['Coordinates'][0];
            $value['Latitude']=$value['Coordinates'][1];
            foreach ($value['Angkot']['LastUpdate'] as $dates){
                $value['date']=date("D, d-m-Y", $dates/1000);
                $value['time']=date("H:i:s", $dates/1000);
            }
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
