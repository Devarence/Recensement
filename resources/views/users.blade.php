<!doctype html>
<html lang="en">
  <head>
    <title>utilisateurs</title>
      <!-- Required meta tags -->
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <meta id="token" name="token" value="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">
    <script type="text/javascript" src="./assets/js/item.js"></script>

  <style>
        body,html{
    height: 100%;
  }

  nav.sidebar, .main{
    -webkit-transition: margin 200ms ease-out;
      -moz-transition: margin 200ms ease-out;
      -o-transition: margin 200ms ease-out;
      transition: margin 200ms ease-out;
  }

  .main{
    padding: 10px 10px 0 10px;
  }

 @media (min-width: 765px) {

    .main{
      position: absolute;
      width: calc(100% - 40px); 
      margin-left: 40px;
      float: right;
    }

    nav.sidebar:hover + .main{
      margin-left: 200px;
    }

    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }

    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }
    
    nav.sidebar a{
      padding-right: 13px;
    }

    nav.sidebar .navbar-nav > li:first-child{
      border-top: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav > li{
      border-bottom: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      margin-bottom: 0px;
    }

    nav.sidebar li {
      width: 100%;
    }

    nav.sidebar:hover{
      margin-left: 0px;
    }

    .forAnimate{
      opacity: 0;
    }
  }
   
  @media (min-width: 1330px) {

    .main{
      width: calc(100% - 200px);
      margin-left: 200px;
    }

    nav.sidebar{
      margin-left: 0px;
      float: left;
    }

    nav.sidebar .forAnimate{
      opacity: 1;
    }
  }

  nav.sidebar .navbar-nav .open .dropdown-menu>li>a:hover, nav.sidebar .navbar-nav .open .dropdown-menu>li>a:focus {
    color: #CCC;
    background-color: transparent;
  }

  nav:hover .forAnimate{
    opacity: 1;
  }
  section{
    padding-left: 15px;
  }
  
 
  </style>

   </head>
  <body>
  @include('header')
	<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="../logInstitution">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li  class="active"><a href="#">Utilisateurs<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>        
        <li ><a href="#">Ecole<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-book"></span></a></li>
        <li ><a href="#">IEP<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-list-alt"></span></a></li>
        <li ><a href="#">DREN<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-folder-open"></span></a></li>
        <li ><a href="#">Date limite<span style="font-size:16px;" class="pull-right hidden-xs showopacity 	glyphicon glyphicon-calendar"></span></a></li>
      </ul>
    </div>
</nav>
<div class="container-fluid">
			<div class="col-xs-6 col-sm-6 col-md-10">
				<br><br>
				<center><h1>TOUS LES UTILISATEURS</h1></center>
			

<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('logInstitution/utilisateur') }}">Voir les utilisateurs</a></li>
        <li><a href="{{ URL::to('creerutilisateur') }}">Creer un nouvel utilisateur</a>
    </ul>
</nav>

<!-- affichera un message après chaque operation -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
       <tr>
         <td>Nom</td>
				 <td>Email</td>
         <td>Contact</td>
				 <td>Username</td>
         <td>Mot de passe</td>
				 <td>Code école</td>
         <td>Code DREN</td>
				 <td>Code IEP</td>

			  	<td width="100px">Action</td>
       </tr>
    </thead>
    <tbody>
    @foreach($user as $key => $item)
        <tr>
				<td>{{ $item->Name }}</td>
				<td>{{ $item->Email }}</td>
        <td>{{ $item->Contact }}</td>
				<td>{{ $item->Username }}</td>
        <td>{{ $item->Password }}</td>
				<td>{{ $item->SchoolID }}</td>
        <td>{{ $item->DrenID }}</td>
				<td>{{ $item->IepID }}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>
                <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('voiruser/' . $item->ID) }}">VOIR</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to( $item->ID) }}">MODIFIER</a>

                <!-- bouton de suppression -->
                {{ Form::open(array('url' => 'supprimeruser/' . $item->ID, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('SUPPRIMER', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}

            </td>
        </tr>
    @endforeach
    </tbody>
</table>


       
      </div>
		</div>
		
 </body>
 </html>