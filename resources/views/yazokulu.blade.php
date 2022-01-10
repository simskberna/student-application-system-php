@extends('masterhome')
 
@section('sidebar')
    @parent
    
@stop
 @section('content')

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;700;900&display=swap");
  
 

    .containerCust {
        
        background-color: #5eb5d7;
        color: hsl(240, 100%, 100%);
        padding: 3rem;
        width:100%;
        height: 100%;
        position: fixed;
        margin-left: 250px
         
    }

    .form-left {
        float: left;
        width: 50%;
        margin-top: 0.375rem;
    }

    .form-right {
        float: right;
        width: 50%;
        margin-top: 0.375rem;
    }

    .form-row:after {
        content: "";
        display: table;
        clear: both;
    }
   
    label {
        padding: 0.75rem 0.75rem 0.75rem 0;
        font-family: "Source Sans Pro", sans-serif;
        display: inline-block;
    }

    label::after {
        content: ":";
    }

    input,
    textarea {
        width: 100%;
        font-family: "Source Sans Pro", sans-serif;
        font-size: 1.1rem;
        padding: 0.75rem;
        border: 0.063rem solid #ccc;
        border-radius: 0.25rem;
        box-sizing: border-box;
        resize: vertical;
    }

    input[type="submit"],
    input[type="reset"] {
        color: white;
        font-family: "Source Sans Pro", sans-serif;
        font-size: 1.1rem;
        padding: 0.75rem 1.25rem;
        /* margin: 0.125rem; */
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        margin-top: 0.375rem;
    }

    input[type="submit"] {
        background-color: #004763;
    }

    input[type="reset"] {
        background-color: hsl(0, 0%, 37%);
    }

    @media screen and (max-width: 640px) {

        .form-left,
        .form-right {
            width: 100%;
            margin-top: 0rem;
        }

        input[type="submit"] {
            margin-top: 0.375rem;
        }
    }
    .form-row{
        margin-right: 250px
    }

  </style>
  <div class="containerCust">
      <form action="{{ url('basvuru')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row"
        style="
        background-color: #00476317;
        text-align: center !important;
        height: 83px !important;
        margin-top: -52px !important;
        margin-right:202px !important;
        margin-left:-48px !important;
        margin-bottom:-5px !important;
        ">
        
          <h2 style="padding-top: 0px;font-weight:bold;">YAZ OKULU BAŞVURUSU</h2>
          
        </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="first-name" >İsim</label>
              </div>
              <div class="form-right">
                  <input type="text" id="first-name" name="first_name" placeholder="İsim">
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="last-name">Soyisim</label>
              </div>
              <div class="form-right">
                  <input type="text" id="last-name" name="last_name" placeholder="Soyisim">
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="birth-date">Doğum Tarihi</label>
              </div>
              <div class="form-right">
                  <input type="date" id="birth-date" name="birth_date">
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="email-address">E-posta</label>
              </div>
              <div class="form-right">
                  <input type="email" id="email-address" name="email_address" placeholder="E-posta Adresi">
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="phone-number">Telefon</label>
              </div>
              <div class="form-right">
                  <input type="tel" id="phone-number" name="phone_number" placeholder="Telefon">
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">
                  <label for="belge">Belge Yükle</label>
              </div>
              <div class="form-right">
                <input type="file" id="belge" name="belge" multiple />
              </div>
          </div>
          <div class="form-row">
              <div class="form-left">

              </div>
              <div class="form-right">
                  <input type="submit" id="btn-submit" name="btn-submit" value="Başvur">
              </div>
          </div>
          <div class="form-row">
            <div class="form-left">

            </div>
            <div class="form-right" style="visibility: hidden">
                <input type="text" id="basvuru_tipi" name="basvuru_tipi" value="YazOkuluBasvurusu">
            </div>
        </div>
         
          <div class="form-row">
            @csrf
            @if(session('failed'))
            <h4 style="color:red">{{session('failed')}}</h4>
            @endif
          </div>
          
          
          <div class="form-row">
            @csrf
            @if(session('success'))
            <h4 style="color:green">{{session('success')}}</h4>
            @endif
          </div>
          
      </form>
  </div>
 @stop