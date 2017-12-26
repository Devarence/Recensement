<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Session;


class DrenController extends Controller
{
    public function manageVue()
    {
        return view('dren');
    }

    public function index()
    {   
        $dren = DB::table('Dren')
        ->select('*')
        ->get();
        return view('dren.index', ['dren' => $dren]); 
        
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
         return View ('dren.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             DB::table('Dren')->insert(
                ['ID' =>$request->input('id'),
                'Nom' => $request->input('name'),
                ]
            );

            // redirect
            $request->session()->flash('message', 'dren créée avec succès!');
            return redirect('dren');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $dren = DB::table('Dren')
        ->select('*')
        ->where('ID', $id)
        ->get();
        return view('dren.show', ['dren' => $dren]);
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
        ->where('ID', $id)
        ->get();
       session(['id'=> $id]);
       
        return view('dren.edit',['dren' => $dren]); 
    }

    public function update(Request $request)
    {
       DB::table('Dren')
        ->where('ID',session('id'))
        ->update(
            ['ID' =>$request->input('id'),
            'Nom' => $request->input('name'),
          ]);

        // redirect
        $request->session()->flash('message', 'dren modifiée avec succès!');
        return redirect('dren');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       DB::table('Dren')
       ->where('ID',$id)
       ->delete();
         // redirect
         $request->session()->flash('message', 'dren supprimée avec succès!');
         return redirect('dren');
    }
    
}
