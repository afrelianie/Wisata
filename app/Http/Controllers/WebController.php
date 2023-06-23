<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesananModel;
use App\Models\Destinasi;
use App\Models\Testimoni;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Http\Request;

class WebController extends Controller
{
    

    public function welcome(Request $request)
    {
        $destinasi = DB::table('destinasi');
        
        if($request->keyword != nuLL){
            $destinasi = $destinasi->orWhere('destinasi.nama_destinasi','like','%'.$request->keyword.'%');
            $destinasi = $destinasi->orWhere('destinasi.harga','like','%'.$request->keyword.'%');
            $destinasi = $destinasi->orWhere('destinasi.alamat_destinasi','like','%'.$request->keyword.'%');
        }

        return view('welcome',['destinasi' => $destinasi]);

        // dd($destinasi);
    }


    public function art(Request $request)
    {
        $destinasi = Destinasi::all();
        
            if(isset($_GET['query']) && strlen($_GET['query']) > 3){
            $search_text = $_GET['query'];
            $data = DB::table('destinasi')->where('nama_destinasi','LIKE','%'.$search_text.'%')->paginate(3);
            // $data = DB::table('destinasi')->where('harga','LIKE','%'.$search_text.'%')->paginate(3);
            $data->appends($request->all());
            return view('web.search', $destinasi, ['data'=>$data]);


        }else{
            return view('web.search', $destinasi);
        }

        // dd($destinasi);
    }




    public function destinasi()
    {
        $destinasi = Destinasi::all();
        $testimoni = Testimoni::all();
        return view('web.destinasi', compact('destinasi','testimoni'));
    }


    public function about()
    {
        return view('web.about');
    }

    public function contact()
    {
        return view('web.contact');
    }
    
}