<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Session;

class EcoleController extends Controller
{
    public function manageVue()
    {
        return view('ecole');
    }

    public function index()
    {   
        $ecole = DB::table('School')
        ->select('*')
        ->get();
        return view('ecoles/ecole', ['ecole' => $ecole]); 
        
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createecole()
    {

        $iep = DB::table('Iep')
        ->select('ID')
        ->distinct()
        ->get();
        
        return View ('ecoles/createecole',['iep'=>$iep]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeecole(Request $request)
    {
             DB::table('School')->insert(
                ['ID' =>$request->input('id'),
                'Name' => $request->input('name'),
                'Attribut' => $request->input('attribut'),
                'IepID' => $request->input('code_iep'),
                ]
            );

            // redirect
            $request->session()->flash('message', 'Ecole créée avec succès!');
            return redirect('ecoles/ecole');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showecole($id)
    {
        $ecole = DB::table('School')
        ->select('*')
        ->where('ID', $id)
        ->get();
        return view('ecoles/showecole', ['ecole' => $ecole]);
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editecole($id)
    {
       $iep = DB::table('Iep')
        ->select('*')
        ->distinct()
        ->get();

       $ecole = DB::table('School')
        ->select('*')
        ->where('ID', $id)
        ->get();
        session(['id'=> $id]);
       
        return view('ecoles/editecole', ['ecole' => $ecole,'iep'=>$iep]); 
    }

    public function updateecole(Request $request)
    {
       DB::table('School')
        ->where('ID',session('id'))
        ->update(
            ['ID' =>$request->input('id'),
            'Name' => $request->input('name'),
            'Attribut' => $request->input('attribut'),
            'IepID' => $request->input('code_iep'),
        ]);

        // redirect
        $request->session()->flash('message', 'ecole modifiée avec succès!');
        return redirect('ecoles/ecole');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyecole(Request $request, $id)
    {
       DB::table('School')
       ->where('ID',$id)
       ->delete();
         // redirect
         $request->session()->flash('message', 'Utilisateur supprimé avec succès!');
         return redirect('ecoles');
    }
    
}
