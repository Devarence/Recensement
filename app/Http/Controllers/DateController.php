<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Session;

class DateController extends Controller
{
    public function manageVue()
    {
        return view('date');
    }

    public function index()
    {   
        $date = DB::table('Deadline')
        ->select('*')
        ->get();
        return view('date.index', ['date' => $date]); 
        
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return View ('date.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             DB::table('Deadline')->insert(
                ['ID' =>$request->input('id'),
                'DateDebut' => $request->input('datedebut'),
                'Data\eFin' => $request->input('datefin'),
                'Year' => $request->input('year'),
                ]
            );

            // redirect
            $request->session()->flash('message', 'date créée avec succès!');
            return redirect('date');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $date = DB::table('Deadline')
        ->select('*')
        ->where('ID', $id)
        ->get();
        return view('date.show', ['date' => $date]);
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
 
       $date = DB::table('Deadline')
        ->select('*')
        ->where('ID', $id)
        ->get();
        session(['id'=> $id]);
       
        return view('date.edit', ['date' => $date]); 
    }

    public function update(Request $request)
    {
       DB::table('Deadline')
        ->where('ID',session('id'))
        ->update(
            ['ID' =>$request->input('id'),
            'DateDebut' => $request->input('datedebut'),
            'DateFin' => $request->input('datefin'),
            'Year' => $request->input('year'),
        ]);

        // redirect
        $request->session()->flash('message', 'date modifiée avec succès!');
        return redirect('date');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       DB::table('Deadline')
       ->where('ID',$id)
       ->delete();
         // redirect
         $request->session()->flash('message', 'date supprimée avec succès!');
         return redirect('date');
    }
    
}
