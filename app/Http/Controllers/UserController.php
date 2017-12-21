<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Session;


class UserController extends Controller
{

    public function manageVue()
    {
        return view('users');
    }
   
    
    public function index()
    {   
        $user = DB::table('User')
        ->select('*')
        ->get();
        return view('users', ['user' => $user]); 
        
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createuser()
    {
        $dren = DB::table('Dren')
        ->select('ID')
        ->distinct()
        ->get();

        $iep = DB::table('Iep')
        ->select('ID')
        ->distinct()
        ->get();

        $ecole = DB::table('School')
        ->select('ID')
        ->distinct()
        ->get();
        
        return View ('createuser', ['dren' => $dren, 'iep'=>$iep, 'ecole'=>$ecole]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeuser(Request $request)
    {
             DB::table('User')->insert(
                ['Name' => $request->input('name'),
                'Email' => $request->input('email'),
                'Contact' => $request->input('contact'),
                'Username' => $request->input('username'),
                'Password' => $request->input('mdp'),
                'SchoolID' => $request->input('code_ecole'),
                'DrenID' => $request->input('code_dren'),
                'IepID' => $request->input('code_iep'),
                ]
            );

            // redirect
            $request->session()->flash('message', 'Utilisateur créé avec succès!');
            return redirect('logInstitution/utilisateur');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showuser($id)
    {
        $user = DB::table('User')
        ->select('*')
        ->where('ID', $id)
        ->get();
        return view('showuser', ['user' => $user]); 
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edituser($id)
    {
        
        $dren = DB::table('Dren')
        ->select('*')
        ->distinct()
        ->get();

        $iep = DB::table('Iep')
        ->select('*')
        ->distinct()
        ->get();

        $ecole = DB::table('School')
        ->select('*')
        ->distinct()
        ->get();

        $user = DB::table('User')
        ->select('*')
        ->where('ID', $id)
        ->get();
        session(['id'=> $id]);
       
        return view('edituser', ['user' => $user, 'dren' => $dren, 'iep'=>$iep, 'ecole'=>$ecole]); 
    }

    public function updateuser(Request $request)
    {
        DB::table('User')
        ->where('ID',session('id'))
        ->update(
            ['Name' => $request->input('name'),
            'Email' => $request->input('email'),
            'Contact' => $request->input('contact'),
            'Username' => $request->input('username'),
            'Password' => $request->input('mdp'),
            'SchoolID' => $request->input('code_ecole'),
            'DrenID' => $request->input('code_dren'),
            'IepID' => $request->input('code_iep'),
        ]);

        // redirect
        $request->session()->flash('message', 'Utilisateur modifié avec succès!');
        return redirect('logInstitution/utilisateur');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyuser(Request $request, $id)
    {
       DB::table('User')
       ->where('ID',$id)
       ->delete();
         // redirect
         $request->session()->flash('message', 'Utilisateur supprimé avec succès!');
         return redirect('logInstitution/utilisateur');
    }
}
