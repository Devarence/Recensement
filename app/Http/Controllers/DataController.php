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
class DataController extends Controller
{ 
    public function add_answer(Request $request)
    {
            $toto1 = array();
            
            $k = 0;
            
            foreach (session('OptionReponseID') as $key => $value)
            {
                array_push($toto1, $value);
                $k++;
            }        
        
            
            for ($i = 0; $i < $k; $i++)
            {
            
                $res = DB::table('OptionReponse')
                ->select('*')
                ->where('ID', $toto1[$i])
                ->get();
                $cloclo = $request->input($toto1[$i]);
                foreach ($res as $quet)
                {
                    $questionID = $quet->QuestionID;
                    $id = $quet->ID;
                    $type = $quet->Type;
                }
                
                //if (empty($cloclo) == false)
                if ($cloclo != null)
                {
                        // check if row already exist
                        $restuf = DB::table('Reponse')
                        ->select('*')
                        ->where([
                            ['QuestionID', $questionID],
                            ['OptionReponseID', $id],
                            ['UserID', session('UserID')],
                            ['Year', date("Y")],
                            ])
                        ->get();
                        if(count($restuf) == 0)
                        {
                            DB::table('Reponse')->insert(
                                ['QuestionID' => $questionID,
                                'OptionReponseID' => $id,
                                'Reponse' => $cloclo,
                                'UserID' => session('UserID'),
                                'Year' => date("Y"),
                                'DateSave' => date("Y-m-d H:i:s"),
                                ]
                            );
                        }
                        else
                        {
                            foreach ($restuf as $quete)
                            {
                                $value = $quete->Reponse;
                            }
                            $now = date("Y-m-d H:i:s");
                            if ($value != $cloclo)
                            {
                                DB::table('Reponse')
                                ->where([
                                    ['QuestionID', $questionID],
                                    ['OptionReponseID', $id],
                                    ['UserID', session('UserID')],
                                    ['Year', date("Y")],
                                    ])
                                ->update(['Reponse' => $cloclo, 'DateSave' => $now]);
                            }
                        }
                }
                
                else
                {
                    // check if row already exist
                    $restof = DB::table('Reponse')
                    ->select('*')
                    ->where([
                        ['QuestionID', $questionID],
                        ['OptionReponseID', $id],
                        ['UserID', session('UserID')],
                        ['Year', date("Y")],
                        ])
                    ->get();
                    if (count($restof) != 0)
                    {
                        foreach ($restof as $quete)
                        {
                            $value = $quete->Reponse;
                        }
                        $now = date("Y-m-d H:i:s");
                        if ($value != null)
                        {
                            DB::table('Reponse')
                            ->where([
                                ['QuestionID', $questionID],
                                ['OptionReponseID', $id],
                                ['UserID', session('UserID')],
                                ['Year', date("Y")],
                                ])
                            ->update(['Reponse' => null, 'DateSave' => $now]);
                        }
                    }
                    else
                    {
                        DB::table('Reponse')->insert(
                            ['QuestionID' => $questionID,
                            'OptionReponseID' => $id,
                            'Reponse' => null,
                            'UserID' => session('UserID'),
                            'Year' => date("Y"),
                            'DateSave' => date("Y-m-d H:i:s"),
                            ]
                        );
                    }                       
                }
            }
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
    public function finish()
    {
        $left = array();
        
        $title = array();
        
        foreach (session('Question') as $value)
        {
            $restif = DB::table('Reponse')
            ->select('*')
            ->where([
                ['QuestionID', $value],
                ['UserID', session('UserID')],
                ])
            ->join('Question', 'Reponse.QuestionID', '=', 'Question.ID')
            ->get();
            if (count($restif) != 0)
            {
                foreach ($restif as $val)
                {
                    if ($val->Reponse == null && $val->Status == 0)
                    {
                        if (in_array($val->NumeroQuestion, $left) == false)
                        {
                            array_push($left, $val->NumeroQuestion);
                            array_push($title, $val->Libelle);
                        }
                    }
                }  
            }
            else
            {
                $res = DB::table('Question')
                ->select('*')
                ->where('ID', $value)
                ->get();
                foreach ($res as $val)
                {
                    if ($val->Status == 0)
                    {
                        if (in_array($val->NumeroQuestion, $left) == false)
                        {
                            array_push($left, $val->NumeroQuestion);
                            array_push($title, $val->Libelle);
                        }
                    }
                } 
            }
        }  
        
        if (count($left) == 0)
        {
            $valueStatus = 1;
            DB::table('RemplirCycle')
            ->where([
                ['CycleID', session('CycleID')],
                ['UserID', session('UserID')],
                ])
            ->update(['Status' => $valueStatus]); 
            // opening the result view
            return view('finish');
        }
        else
        {
            // opening the result view
            return view('result',['questionid' => $left], ['libelle' => $title]);
        } 
    }
}
