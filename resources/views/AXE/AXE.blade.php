@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
   
@stop

@section('content')
    <center><h1 style="color:#209fb7;">Bienvenidos al sistema AXE .</h1></center> 
    <center>
    <h3>Este sistema tiene como objetivo llevar el control </h3>
    <h3>de matriculas de un colegio</h3>
    </center>



    
    <table cellspacing="10" cellpadding="10" class="Table table-responsive table-dark table-striped mt-1" style="border:2px solid cyan;">
 <thead>

 <th>
     <div class="small-box bg-info">
         <div class="inner">
            <h3>150</h3>
            <p>New Orders</p>
          </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
          </a>
      </div>
  </th>
  
  <th>
  <div class="small-box bg-gradient-success">
  <div class="inner">
    <h3>44</h3>
    <p>User Registrations</p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="#" class="small-box-footer">
    More info <i class="fas fa-arrow-circle-right"></i>
  </a>
 </div>
</th>

<th>    

<div class="info-box bg-success">
  <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Likes</span>
    <span class="info-box-number">41,410</span>
    <div class="progress">
      <div class="progress-bar" style="width: 70%"></div>
    </div>
    <span class="progress-description">
      70% Increase in 30 Days
    </span>
  </div>
</div>

</th>

<th>
<div class="info-box">
  <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Bookmarks</span>
    <span class="info-box-number">41,410</span>
    <div class="progress">
      <div class="progress-bar bg-info" style="width: 70%"></div>
    </div>
    <span class="progress-description">
      70% Increase in 30 Days
    </span>
  </div>
</div>
</th>

 </thead>
 </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop