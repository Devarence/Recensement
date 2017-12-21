<!doctype html>
<html lang="en">
  <head>
    <title>DREN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--permet l'utilisation de datatable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" />
    
    <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  </head>
  <body>

  @include('header')

		<div class="container-fluid">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br><br>
				<center><h1>EVOLUTION DES IEP</h1></center>
                <div class="table-responsive">
                  <table id="myTable" class="table table-bordered datatable">
                    <thead>
                      <tr>
                        <th>Code de l'IEP</th>
                        <th>Info IEP</th>
                        <th>Nombre total d'ecole</th>
                        <th>Pourcentage</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                         if($infoieppourcentage)
                          {  
                            foreach($infoieppourcentage as $roito) 
                            {

                              echo "<tr>";
                              echo "<td>" . $roito->ListeIep->ID . "</td>";
                              echo "<td>" . $roito->ListeIep->Nom . "</td>";
                              echo "<td>" . $roito->TotalEcole . "</td>";
                              echo "<td>" . $roito->Pourcentage . " % </td>";
                              echo "</tr>";                              
                            } 
                          } 
                        ?> 
                    </tbody>
                  </table>
                </div>
				
			</div>
		</div>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

<script type="text/javascript">

$( document ).ready(function() 
{
  $('#myTable').DataTable(
  {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
  });
});
</script>
  </body>
</html>