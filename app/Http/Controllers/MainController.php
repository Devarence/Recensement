<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Session;


class MainController extends Controller
{ 


    public function getSessionVariable($user)
    {
        foreach ($user as $op)
        {
            session(['UserID' => $op->ID]);
            
            session(['UserName' => $op->Name]);
            
            session(['UserEmail' => $op->Email]);
            
            session(['UserContact' => $op->Contact]);
            
            session(['SchoolID' => $op->SchoolID]);
            
            session(['SchoolName' => $op->SchoolName]);

            session(['CycleID' => $op->CycleID]);

            session(['Attribut' => $op->Attribut]);

            session(['RemplirStatus' => $op->Status]);

        }
    }


    public function process()
    {
        // getting questions with their answer options
        $arr = array();
        $quest = DB::table('Question')
        ->select('Question.*')
        ->where('Formulaire.CycleID', session('CycleID'))
        ->join('Formulaire', 'Question.FormulaireID', '=', 'Formulaire.ID')
        ->get();
    
        foreach ($quest as $que)
        {
            $object = new \stdClass();
            $res = DB::table('OptionReponse')
            ->select('*')
            ->where('QuestionID', $que->ID)
            ->get();
            $object->Question = $que;
            $object->OptionReponse = $res;
            array_push($arr, $object);
        }


         //getting the responses
         $res = DB::table('Reponse')
         ->select('*')
         ->where([
            ['Reponse.UserID', session("UserID")],
            ['Year', date("Y")],
        ])
         ->get();
 
         $arvo = array();
 
         foreach ($res as $quai )
         {
             array_push($arvo, $quai);
         }
 
 
         // opening the formulaire view
         return view('formulaire',['question' => $arr], ['reponse' => $arvo]);
    }


    public function formu()
    {
        // getting all formulaires (primaire or secondaire)
        $res = DB::table('Formulaire')
        ->select('*')
        ->where('Formulaire.CycleID', session('CycleID'))
        ->get();

        $Formulaire = array();
        
        foreach ($res as $mandala)
        {
            array_push($Formulaire, $mandala);
        }
        
        session(['Formulaire' => $Formulaire]);
        


        // get the number of formulaires we have
        $result = DB::table('Formulaire')
        ->select('*')
        ->where([
            ['SchoolCycle.SchoolID', session('SchoolID')],
            ['Formulaire.CycleID', session('CycleID')],
        ])
        ->join('SchoolCycle', 'SchoolCycle.CycleID', '=', 'Formulaire.CycleID')
        ->get();
                                    
        session(['NombreFormulaire' => count($result)]);
    }


    public function logout(Request $request)
    {
        //flush session variables
        //$request->session()->flush();


        // error message when authentication has failed
        $message_display = "You logged out successfully";
        
        return view('index', ['message_display' => $message_display]);
    }



    public function loguser(Request $request)
    {
        // checking if the user exist
        $username = $request->input('email');

        $password = $request->input('password');

        $user = DB::table('User')
                    ->select('User.*', 'School.ID as SchoolID', 'School.Name as SchoolName', 'School.Attribut', 'RemplirCycle.*')
                    ->where([
                            ['Username', $username],
                            ['Password', $password],
                            ])
                    ->join('School', 'User.SchoolID', '=', 'School.ID')
                    ->join('RemplirCycle', 'User.ID', '=', 'RemplirCycle.UserID')
                    ->get();
                                
        $nombre = count($user);

        if ($nombre == 0)
        {
            //flush session variables
            // $request->session()->flush();

            // error message when authentication has failed
            $message_display = "Username et / ou Password erroné(s)";
            
            return view('index', ['message_display' => $message_display]);

        }
        else if ($nombre == 1)
        {
            // storing information in session variables
            $this->getSessionVariable($user);

            if (session('RemplirStatus') == 1)
            {
                return view('done');
            }
            else
            {
                // getting formulaires information
                $this->formu();
            
                // getting questions and answers + page launch
                return $this->process();
            }
            
        }
        else
        {
            // storing information in session variables
            $this->getSessionVariable($user);

            return view('dashboard');
        }
    }


    
    //fonction pour le login des institutions autre que les ecoles
    public function logInstitution(Request $request)
    {
         // checking if the user exist
        $choix = $request->input("admin");
        $choix2 = $choix . "ID";
        $username = $request->input('email');
        $password = $request->input('password');

        if ($choix=='Ministere')
        {
            $user = DB::table('User')
            ->select('User.*', 'User.DrenID', 'User.IepID')
            ->where([
                    ['Username', $username],
                    ['Password', $password],
                    ['SchoolID', NULL],
                    ['DrenID', NULL],
                    ['IepID', NULL],
                    ])
            ->get(); 
            $nombre = count($user);


            if ($nombre == 0)
            {
                //flush session variables
                // $request->session()->flush();
    
                // error message when authentication has failed
                $message_display = "Username et / ou Password erroné(s)";
                
                return view('institution', ['message_display' => $message_display]);
    
            }
            else
            {
                

                return view('ministere');
            }
        }

        if ($choix == null)
        {
            // error message when authentication has failed
            $message_display = "VEUILLEZ COCHER UNE INSTITUTION ET RESAISIR VOTRE USERNAME ET LE MOT DE PASSE";
            
            return view('institution', ['message_display' => $message_display]);    
        }

        $user = DB::table('User')
        ->select('User.*', 'User.DrenID', 'User.IepID')
        ->where([
                ['Username', $username],
                ['Password', $password],
                ])
        ->join($choix, 'User.' . $choix2 , '=', $choix . ".ID")
        ->get();



        $nombre = count($user);
        
                if ($nombre == 0)
                {
                    //flush session variables
                    // $request->session()->flush();
        
                    // error message when authentication has failed
                    $message_display = "Username et / ou Password erroné(s)";
                    
                    return view('institution', ['message_display' => $message_display]);
        
                }
                else
                {
        
                    $arr = array();
                   
        
                    if ($choix == "Iep")
                    {   
                        foreach ($user as $will)
                        {
                            $iepID = $will->IepID;
                        }

                        //nombre total des questions du primaire
                        $NbreQuestionPrimaire = DB::table("OptionReponse")
                        ->select('OptionReponse.QuestionID')
                        ->join('Question', 'OptionReponse.QuestionID', '=', 'Question.ID')
                        ->join('Formulaire', 'Question.FormulaireID', '=', 'Formulaire.ID')
                        ->where('Formulaire.CycleID', '=', 1)
                        ->distinct()
                        ->count();

                        //nombre total des questions du secondaire
                        $NbreQuestionSecondaire = DB::table("OptionReponse")
                        ->select('OptionReponse.QuestionID')
                        ->join('Question', 'OptionReponse.QuestionID', '=', 'Question.ID')
                        ->join('Formulaire', 'Question.FormulaireID', '=', 'Formulaire.ID')
                        ->where('Formulaire.CycleID', '=', 2)
                        ->distinct()
                        ->count();

                        //information sur les écoles
                        $NbreParEcole = DB::table("User")
                        ->select('User.ID as UserID','Cycle.ID as CycleID', 'User.Name as UserName', 
                        'User.Email', 'School.ID', 'School.Name', 
                        'School.Attribut', 'Cycle.Libelle')
                        ->join('School', 'School.ID', '=', 'User.SchoolID')
                        ->join('RemplirCycle', 'User.ID', '=', 'RemplirCycle.UserID')
                        ->join('Cycle', 'RemplirCycle.CycleID', '=', 'Cycle.ID')
                        ->where([
                            ['SchoolID', '<>', NULL],
                            ['School.IepID', $iepID],
                            ])
                        ->get(); 

                       

                        foreach ($NbreParEcole as $que)
                        {
                            $object = new \stdClass();
                            //nombre total des questions repondues par ecole
                            $res = DB::table('Reponse')
                            ->select('QuestionID')
                            ->join('Question', 'Reponse.QuestionID', '=', 'Question.ID')
                            ->join('Formulaire', 'Question.FormulaireID', '=', 'Formulaire.ID')
                            ->where([
                                ['Formulaire.CycleID', $que->CycleID],
                                ['UserID', $que->UserID],
                                ['Reponse', '<>', NULL],
                                ['Question.Status', '=', 0],
                                ])
                            ->distinct()
                            ->count();
                            
                            $object->ParEcole = $que;
                            $object->NbreUserReponse = $res;

                            if($que->CycleID == 1)
                            {
                                $object->NbreQuestion = $NbreQuestionPrimaire;
                            } 
                            elseif ($que->CycleID == 2) 
                            {
                                $object->NbreQuestion = $NbreQuestionSecondaire;  
                            }                        
                            array_push($arr, $object);
                        }
                       
                        return view('iep', ['inforeponseuser' => $arr]);
                    }
                   
                   
                    else if ($choix == "Dren")
                    {
                        foreach ($user as $will)
                        {
                            $drenID = $will->DrenID;
                        }

                        $NbreParIep = DB::table("Iep")
                        ->select('*')
                        ->where('DrenID', '=', $drenID)
                        ->get();

                        

                        foreach ($NbreParIep as $que)
                        {
                            $object = new \stdClass();
                            
                            //Liste des ecoles gerees par une iep
                            $ListeEcole = DB::table("User")
                            ->select('User.ID as UserID','Cycle.ID as CycleID', 'User.Name as UserName', 'User.Email', 'School.ID', 'School.Name', 
                            'School.Attribut', 'Cycle.Libelle')
                            ->join('School', 'School.ID', '=', 'User.SchoolID')
                            ->join('RemplirCycle', 'User.ID', '=', 'RemplirCycle.UserID')
                            ->join('Cycle', 'RemplirCycle.CycleID', '=', 'Cycle.ID')
                            ->where([
                                ['SchoolID', '<>', NULL],
                                ['School.IepID', $que->ID],
                                ])
                            ->get();

                            //Nombre total des ecoles gerees par une iep
                            $NbreTotalEcole = DB::table("User")
                            ->select('*')
                            ->join('School', 'School.ID', '=', 'User.SchoolID')
                            ->join('RemplirCycle', 'User.ID', '=', 'RemplirCycle.UserID')
                            ->join('Cycle', 'RemplirCycle.CycleID', '=', 'Cycle.ID')
                            ->where([
                                ['SchoolID', '<>', NULL],
                                ['School.IepID', $que->ID],
                                ])
                            ->count();

                            //nombre total des ecoles ayant 100% de question remplit
                            $NbreTotalEcoleRempli = DB::table("User")
                            ->select('*')
                            ->join('School', 'School.ID', '=', 'User.SchoolID')
                            ->join('RemplirCycle', 'User.ID', '=', 'RemplirCycle.UserID')
                            ->join('Cycle', 'RemplirCycle.CycleID', '=', 'Cycle.ID')
                            ->where([
                                ['SchoolID', '<>', NULL],
                                ['School.IepID', $que->ID],
                                ['RemplirCycle.Status','=', 1],
                                ])
                            ->count();

                         //calcul du pourcentage
                         $percent = ($NbreTotalEcoleRempli *100)/ $NbreTotalEcole; 
                         
                        $object->ListeIep = $que;
                        $object->TotalEcole = $NbreTotalEcole;
                        $object->Pourcentage = $percent;
                        array_push($arr, $object);                                                               
                        }
 
                        return view('dren', ['infoieppourcentage' => $arr]);
                      }
                    
                }

    }




    public function back()
    {
        // getting questions and answers + page launch
        return $this->process();
    }



    public function primaireform()
    {
        session(['CycleID' => 1]);

        $res = DB::table('RemplirCycle')
                ->select('*')
                ->where([
                    ['CycleID', session('CycleID')],
                    ['UserID', session('UserID')],
                    ])
                ->get();
        
        foreach ($res as $vell)
        {
            $value = $vell->Status;
        }

        session(['RemplirStatus' => $value]);

        if (session('RemplirStatus') == 1)
        {
            return view('done');
        }
        else
        {
            // getting formulaires information
            $this->formu();
        
            // getting questions and answers + page launch
            return $this->process();
        }

    }


    public function secondaireform()
    {
        session(['CycleID' => 2]);

        $res = DB::table('RemplirCycle')
        ->select('*')
        ->where([
            ['CycleID', session('CycleID')],
            ['UserID', session('UserID')],
            ])
        ->get();

        foreach ($res as $vell)
        {
            $value = $vell->Status;
        }

        session(['RemplirStatus' => $value]);

        if (session('RemplirStatus') == 1)
        {
            return view('done');
        }
        else
        {
            // getting formulaires information
            $this->formu();
        
            // getting questions and answers + page launch
            return $this->process();
        }
    }

    public function showAllUser()
    {    
        $user = DB::table('User')
        ->select('*')
        ->get();
        return view('users', ['user' => $user]);
    }
    
}
