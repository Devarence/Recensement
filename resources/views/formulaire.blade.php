<!doctype html>
<html lang="fr">
<head>
<title>Formulaire Wizard</title>
<!-- Required meta tags -->
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="./css/jquery.steps.css">

        <script src="./js/jquery.steps.js"></script>
        <script src="./js/jquery.steps.min.js"></script>
        
        
</head>
<body>

@include('header')

        <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12" style="display: block; padding: 0 auto;">
                <center><h1>Formulaire</h1></center>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    
                    <form id="example-advanced-form" action ="lolipop" method="post">
                    {{ csrf_field() }}
					<?php
					
					$var = array();

					$varr = array();

					//if (session('CycleID') == 1)
					//{
					//	$i = 1;
					//}
					//else if (session('CycleID') == 2)
					//{
					//	$i = 18;
					//}

					// $v = $i + session('NombreFormulaire');

					// While ($i != $v)
					//for ($i = 1; $i <= session('NombreFormulaire'); $i++)
					$i = 1;
					
					foreach (session('Formulaire') as $quenta)
                    {
                        echo "<h3>" . $i . "</h3>";
						echo "<fieldset>";
						
                        // echo json_encode($question);
                        foreach ($question as $ques)
                        {
                            if ($ques->Question->FormulaireID == $quenta->ID)
                            {
								echo "<label>" . $ques->Question->NumeroQuestion . " - " . $ques->Question->Libelle ."</label> ";

                                foreach ($ques->OptionReponse as $op)
                                {

                                    if ($op->Type == "input")
                                    {
                                        // echo "<input name='" . $op->Type . $ques->Question->ID . "' type='text' class='form-control no-border' id='nom'>";
										
										if ($reponse)
										{	
											echo "<input name=" . $op->ID . " type='text' class='form-control no-border' value='"; foreach ($reponse as $qui){if ($qui->QuestionID == $ques->Question->ID && $qui->OptionReponseID == $op->ID){ echo $qui->Reponse; }}; echo "'>";
											
										}
										else
										{
											echo "<input name=" . $op->ID . " type='text' class='form-control no-border'>";
										}

										array_push($var, $op->ID);

										array_push($varr, $op->QuestionID);
                                    }
                                    else if ($op->Type == "radio")
                                    {
                                        // echo "<input type='radio' name='" . $op->Type . $ques->Question->ID . "' value=" . $op->Value . ">" . " " . $op->Value . " " ;
										if ($reponse)
										{

											echo "<input type='radio' name=" . $op->ID . " value='" . $op->Value; 
											
											foreach ($reponse as $qui)
											{
												if ($qui->QuestionID == $ques->Question->ID && $op->Value == $qui->Reponse && $qui->OptionReponseID == $op->ID)
												{ 
													echo "' checked"; 
												}
												else if ($qui->QuestionID == $ques->Question->ID && $qui->OptionReponseID == $op->ID)
												{
													echo "'";
												}
											}; 

											echo "> " . $op->Value . "   ";
										}
										else
										{
											echo "<input type='radio' name=" . $op->ID . " value='" . $op->Value . "'> " . $op->Value . "   ";
										}

										array_push($var, $op->ID);

										array_push($varr, $op->QuestionID);
									}
									else if ($op->Type == "checkbox")
                                    {
                                        // echo "<input type='radio' name='" . $op->Type . $ques->Question->ID . "' value=" . $op->Value . ">" . " " . $op->Value . " " ;
										if ($reponse)
										{

											echo "<input type='checkbox' name=" . $op->ID . " value='" . $op->Value; 
											
											foreach ($reponse as $qui)
											{
												if ($qui->QuestionID == $ques->Question->ID && $op->Value == $qui->Reponse && $qui->OptionReponseID == $op->ID)
												{ 
													echo "' checked"; 
												}
												else if ($qui->QuestionID == $ques->Question->ID && $qui->OptionReponseID == $op->ID)
												{
													echo "'";
												}
											} 

											echo "> " . $op->Value . "   ";
										}
										else
										{
											echo "<input type='checkbox' name=" . $op->ID . " value='" . $op->Value . "'> " . $op->Value . "   ";
										}

										array_push($var, $op->ID);

										array_push($varr, $op->QuestionID);
                                    }
                                }
                                
                                echo "<br/>";
                                echo "<br/>";
                                

                            }

						}
						
						echo "</fieldset>";

						$i++;
					}

					session(['OptionReponseID' => $var]);

					session(['Question' => $varr]);

					echo "<input type='submit' style='width:40%; margin:auto; display:block;' name='submit' id='submit' value='Enregistrer Etape' class='btn btn-lg btn-primary btn-block'><br>";
					?>
					</form> 
					<div style='text-align: center;'>
						<a href="finish"><button style='width:20%; margin:auto; display:block;' class='btn btn-lg btn-primary btn-block'>Soumettre</button></a><br>
					</div>
                </div>
            </div>
        </div>

        

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script>
            var form = $("#example-advanced-form").show();
            
			form.steps({
				headerTag: "h3",
				bodyTag: "fieldset",
				enableAllSteps: true,
				transitionEffect: "slideLeft",
				enableFinishButton: false,
				enablePagination: true,
				saveState: true,
				labels: {
						cancel: "Cancel",
						current: "current step:",
						pagination: "Pagination",
						finish: "Finish",
						next: "Suivant",
						previous: "Precedent",
						loading: "Loading ..."
						}
					});

		
        </script>

        
</body>
</html>