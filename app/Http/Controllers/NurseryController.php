<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use File;
use Response;
use Spatie\ArrayToXml\ArrayToXml;
use JWTAuth;


class NurseryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $nurseries = DB::table('rz_instytucje')->paginate(25);
        return view('nursery', ['nurseries' => $nurseries]);
    }

    public function search(Request $request){
        
        $search = $request->input('search');
        $nurseries = DB::table('rz_instytucje')->where('institution_type', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->paginate(25);
        $nurseries->appends($request->all());
        return view('nursery', ['nurseries'=>$nurseries]);
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
        //return gettype($request->file->extension());
        $extension = $request->file->extension();
        $validatedData = $request->validate([
            'file' => 'required|file',
        ]);
    
        $fileName = "Plik" . '_' . time() . '.'. $extension; 
        $request->file->move(public_path('file'), $fileName);

    try 
    {
        DB::transaction( function () use ($extension, $fileName) {
        if ($extension=="txt")
        {
            $nurseries = json_decode(file_get_contents(public_path('file')."\\".$fileName), true);
            $arr = array();
            foreach ($nurseries as $nursery => $n) 
            {
                foreach ($n as $x => $y){
                    if ($x=='id'){
                        $arr[$x] = null;
                    }
                    else $arr[$x] = $y;
                }
                DB::table('rz_instytucje')->insert($arr);
            }
            return view('import_view', ["nurseries" => $arr]);
        }

        else if ($extension == "xml")
        {
            $xmlfile = file_get_contents(public_path('file')."\\".$fileName);
            $con = json_encode(simplexml_load_string($xmlfile));
            $new = json_decode($con,true);
            $todb = array();
            print_r($new);
            foreach ($new as $key => $val){
                foreach ($val as $k => $v){
                    if ($v == Array() ){
                        $todb[$k] = '';
                    }
                    else if ($k == 'id'){
                        $todb[$k] = null;
                    }
                    else $todb[$k] = $v;
                }
                
            }
            DB::table('rz_instytucje')->insert($todb);
            $x = response()->xml(['nursery'=>$todb])->getContent();
            return view('import_view', ["nurseries" => $x]);    
        } 
        return view('import_view', ["nurseries" => 'Bad extension']);    
    });
    } catch (\Exception $exception) {
        return view('import_view',['nurseries' => 'Error :(']);
    }
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
        //return $request->all();
        $occupied = DB::select('select amount_of_registrations_children from rz_instytucje where id = ?', [$id]);
        if($request->submit == "update")
        {
            
            $result = DB::table('rz_instytucje')->where('id', $id)->update(array('amount_of_registrations_children' => $occupied[0]->amount_of_registrations_children+1));
            $request->session()->put('zarezerwuj', 'disabled');
            $request->session()->put('anuluj', 'enabled');
        } else
        {
            $result = DB::table('rz_instytucje')->where('id', $id)->update(array('amount_of_registrations_children' => $occupied[0]->amount_of_registrations_children-1));
            $request->session()->put('zarezerwuj', 'enabled');
            $request->session()->put('anuluj', 'disabled');
        }

        if($result)
        {
            return redirect()->route('show', $id);
        }

        return "Nie udało się zarezerwować miejsce";
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
    public function sort_by_price(Request $request){
        $min = $request->input('min');
        $max = $request->input('max');
        $nurseries = DB::table('rz_instytucje')->whereBetween('monthly_payment',[$min,$max])->orderBy('monthly_payment')->paginate(25);
        $nurseries->appends($request->all());
        return view('nursery', compact('nurseries'));
    }

    public function exportToJSON()
    {
        $nurseries = DB::table('rz_instytucje')->get();
        $fileName = time() . '_datafile.json';
        File::put(public_path($fileName), json_encode($nurseries, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_QUOT));
        return Response::download(public_path($fileName));
    }

    public function exportToXML(){

        $nurseries = json_decode(json_encode(DB::table('rz_instytucje')->where('id','=','1')->get(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_QUOT),TRUE);
        $fileName = time() . '_datafile.xml';
        File::put(public_path($fileName), response()->xml(['nursery'=>$nurseries])->getContent());
}


    public function showNursery($id)
    {
        $nursery = DB::table('rz_instytucje')->whereId($id)->get();
        
        $nursery[0]->institution_localization = str_replace(" >", "", $nursery[0]->institution_localization);
        $arr = explode(" ", $nursery[0]->institution_localization);
        $nursery[0]->institution_localization = implode("%20", $arr);
        
        return view('nursery_view', ['nursery'=>json_decode($nursery, true)[0]]);
    }

}
    // https://github.com/mtownsend5512/response-xml
    // composer require tymon/jwt-auth:"dev-develop"   #JWT
    // composer update
    // config/app.php add lines:
    //under PROVIDES
    //Tymon\JWTAuth\Providers\LaravelServiceProvider::class,

    //under ALIASES
    // 'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
    // 'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,

    // php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    // php artisan jwt:secret 
    // can check key at .env file at the bottom