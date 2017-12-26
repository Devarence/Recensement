<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Session;

class IepController extends Controller
{
    public function manageVue()
    {
        return view('iep');
    }

    public function index()
    {   
        $iep = DB::table('Iep')
        ->select('*')
        ->get();
        return view('iep.index', ['iep' => $iep]); 
        
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $dren = DB::table('Dren')
        ->select('ID')
        ->distinct()
        ->get();
        
        return View ('iep.create',['dren'=>$dren]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             DB::table('Iep')->insert(
                ['ID' =>$request->input('id'),
                'Nom' => $request->input('name'),
                'DrenID' => $request->input('code_dren'),
                ]
            );

            // redirect
            $request->session()->flash('message', 'iep créée avec succès!');
            return redirect('iep');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $iep = DB::table('Iep')
        ->select('*')
        ->where('ID', $id)
        ->get();
        return view('iep.show', ['iep' => $iep]);
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $dren = DB::table('Dren')
        ->select('*')
        ->distinct()
        ->get();

       $iep = DB::table('Iep')
        ->select('*')
        ->where('ID', $id)
        ->get();
        session(['id'=> $id]);
       
        return view('iep.edit', ['iep' => $iep,'dren'=>$dren]); 
    }

    public function update(Request $request)
    {
       DB::table('Iep')
        ->where('ID',session('id'))
        ->update(
            ['ID' =>$request->input('id'),
            'Nom' => $request->input('name'),
            'DrenID' => $request->input('code_dren'),
        ]);

        // redirect
        $request->session()->flash('message', 'iep modifiée avec succès!');
        return redirect('iep');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       DB::table('Iep')
       ->where('ID',$id)
       ->delete();
         // redirect
         $request->session()->flash('message', 'iep supprimée avec succès!');
         return redirect('iep');
    }
   
}
