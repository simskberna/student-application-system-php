@extends('masteradmin')
 
@section('sidebar')
    @parent
    
@stop
@section('content')
    
       <form action="{{url('edit')}}" method="GET" enctype="multipart/form-data">
        <div class="card" style="margin-left:40%; margin-top:3% ">
          <div class="img" style="margin-bottom:10px;margin-left:20px">
            <img src={{$profil_foto}}>
          </div>
          <div class="infos">
            <div class="name">
              <h2 >{{$name}} {{$lname}}</h2>
              <h4 >{{$email}}</h4>
            </div>
            <p style="font-size:12px !important"class="text">
             {{$yetki}}
            </p>
            <ul class="stats">
              <li>
                <h3>Bölüm</h3>
                <h4  >{{$bolum}}</h4>
              </li>
  
              <li>
                <h3></h3>
                <h4></h4>
              </li>
            </ul>
            <div style="padding-left:30%" class="links">
              <button type="submit" name="update_data" class="view">Düzenle</button>
            </div>
            <div>@if(session('status'))<h4>{{session('status')}}</h4>@endif</div>
          </div>
           
        </div>
       </form>
          <style>
              @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

 
img {
  max-width: 100%;
  display: block;
}
ul {
  list-style: none;
}

/* Utilities */
.card::after,
.card img {
  border-radius: 50%;
}
.card,
.stats {
  display: flex;
}

.card {
  padding: 2.5rem 2rem;
  border-radius: 10px;
  background-color: rgba(255, 255, 255, .5);
  max-width: 500px;
  box-shadow: 0 0 30px rgba(0, 0, 0, .15);
  margin: 1rem;
  margin-top: 3% !important;
  position: relative;
  transform-style: preserve-3d;
  overflow: hidden;
}
.card::before,
.card::after {
  content: '';
  position: absolute;
  z-index: -1;
}
.card::before {
  width: 100%;
  height: 100%;
  border: 1px solid #FFF;
  border-radius: 10px;
  top: -.7rem;
  left: -.7rem;
}
.card::after {
  height: 15rem;
  width: 15rem;
  background-color: #4172f5aa;
  top: -8rem;
  right: -8rem;
  box-shadow: 2rem 6rem 0 -3rem #FFF
}

.card img {
  width: 10rem;
  height: 10rem;
  box-shadow: 0 0 0 5px #FFF;
}

.infos {
  margin-left: 1.5rem;
}

.name {
  margin-bottom: 1rem;
}
.name h2 {
  font-size: 1.3rem;
}
.name h4 {
  font-size: .8rem;
  color: #333
}

.text {
  font-size: .9rem;
  margin-bottom: 1rem;
}

.stats {
  margin-bottom: 1rem;
}
.stats li {
  min-width: 5rem;
}
.stats li h3 {
  font-size: .99rem;
}
.stats li h4 {
  font-size: .75rem;
}

.links button {
  font-family: 'Poppins', sans-serif;
  min-width: 120px;
  padding: .5rem;
  border: 1px solid #222;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: all .25s linear;
}
.links .follow,
.links .view:hover {
  background-color: #222;
  color: #FFF;
}
.links .view,
.links .follow:hover{
  background-color: transparent;
  color: #222;
}

@media screen and (max-width: 450px) {
  .card {
    display: block;
  }
  .infos {
    margin-left: 0;
    margin-top: 1.5rem;
  }
  .links button {
    min-width: 100px;
  }
}

          </style>
     
@stop