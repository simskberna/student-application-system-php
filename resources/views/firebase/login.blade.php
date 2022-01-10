<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GİRİŞ / KAYIT</title>


  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat|Quicksand');

*{
    font-family: 'quicksand',Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}

body{
    background:#fff;
}

.form-modal{
    position:relative;
    width:450px;
    height:auto;
    margin-top:4em;
    left:50%;
    transform:translateX(-50%);
    background:#fff;
    border-top-right-radius: 20px;
    border-top-left-radius: 20px;
    border-bottom-right-radius: 20px;
    box-shadow:0 3px 20px 0px rgba(0, 0, 0, 0.1)
}

.form-modal button{
    cursor: pointer;
    position: relative;
    text-transform: capitalize;
    font-size:1em;
    z-index: 2;
    outline: none;
    background:#fff;
    transition:0.2s;
}

.form-modal .btn{
    border-radius: 20px;
    border:none;
    font-weight: bold;
    font-size:1.2em;
    padding:0.8em 1em 0.8em 1em!important;
    transition:0.5s;
    border:1px solid #ebebeb;
    margin-bottom:0.5em;
    margin-top:0.5em;
}

.form-modal .login , .form-modal .signup{
    background:#57b846;
    color:#fff;
}

.form-modal .login:hover , .form-modal .signup:hover{
    background:#222;
}

.form-toggle{
    position: relative;
    width:100%;
    height:auto;
}

.form-toggle button{
    width:50%;
    float:left;
    padding:1.5em;
    margin-bottom:1.5em;
    border:none;
    transition: 0.2s;
    font-size:1.1em;
    font-weight: bold;
    border-top-right-radius: 20px;
    border-top-left-radius: 20px;
}

.form-toggle button:nth-child(1){
    border-bottom-right-radius: 20px;
}

.form-toggle button:nth-child(2){
    border-bottom-left-radius: 20px;
}

#login-toggle{
    background:#57b846;
    color:#ffff;
}

.form-modal form{
    position: relative;
    width:90%;
    height:auto;
    left:50%;
    transform:translateX(-50%);  
}

#login-form , #signup-form{
    position:relative;
    width:100%;
    height:auto;
    padding-bottom:1em;
}

#signup-form{
    display: none;
}


#login-form button , #signup-form button{
    width:100%;
    margin-top:0.5em;
    padding:0.6em;
}

.form-modal input{
    position: relative;
    width:100%;
    font-size:1em;
    padding:1.2em 1.7em 1.2em 1.7em;
    margin-top:0.6em;
    margin-bottom:0.6em;
    border-radius: 20px;
    border:none;
    background:#ebebeb;
    outline:none;
    font-weight: bold;
    transition:0.4s;
}

.form-modal input:focus , .form-modal input:active{
    transform:scaleX(1.02);
}

.form-modal input::-webkit-input-placeholder{
    color:#222;
}


.form-modal p{
    font-size:16px;
    font-weight: bold;
}

.form-modal p a{
    color:#57b846;
    text-decoration: none;
    transition:0.2s;
}

.form-modal p a:hover{
    color:#222;
}


.form-modal i {
    position: absolute;
    left:10%;
    top:50%;
    transform:translateX(-10%) translateY(-50%); 
}

.fa-google{
    color:#dd4b39;
}

.fa-linkedin{
    color:#3b5998;
}

.fa-windows{
    color:#0072c6;
}

.-box-sd-effect:hover{
    box-shadow: 0 4px 8px hsla(210,2%,84%,.2);
}

@media only screen and (max-width:500px){
    .form-modal{
        width:100%;
    }
}

@media only screen and (max-width:400px){
    i{
        display: none!important;
    }
}
  </style>
  <script>
    function toggleSignup(){
   document.getElementById("login-toggle").style.backgroundColor="#fff";
    document.getElementById("login-toggle").style.color="#222";
    document.getElementById("signup-toggle").style.backgroundColor="#57b846";
    document.getElementById("signup-toggle").style.color="#fff";
    document.getElementById("login-form").style.display="none";
    document.getElementById("signup-form").style.display="block";
}

function toggleLogin(){
    document.getElementById("login-toggle").style.backgroundColor="#57B846";
    document.getElementById("login-toggle").style.color="#fff";
    document.getElementById("signup-toggle").style.backgroundColor="#fff";
    document.getElementById("signup-toggle").style.color="#222";
    document.getElementById("signup-form").style.display="none";
    document.getElementById("login-form").style.display="block";
}

  </script>
</head>
<body>
  <div class="form-modal">
    
    <div class="form-toggle">
        <button id="login-toggle" onclick="toggleLogin()">Giriş Yap</button>
        <button id="signup-toggle" onclick="toggleSignup()">Kayıt Ol</button>
    </div>

    <div id="login-form">
        <form  action="{{ url('signIn')}}" method="GET">
            @csrf
             @if(session('status'))
                <h4 style="color:#57b846">{{session('status')}}</h4>
            @elseif(session('statu'))
                <h4 style="color:#d80a0a !important;">{{session('statu')}}</h4>
            @endif
            <input type="text" name="email" placeholder="Öğrenci No veya E-posta"/>
            <input type="password" name="password" placeholder="Şifre"/>
            <button type="submit" class="btn login">Giriş</button>
            <!--<p><a href="javascript:void(0)">Forgotten account</a></p>-->
            <hr/>

        </form>
    </div>

    <div id="signup-form">
        <form action="{{ url('signUp')}}" method="POST" enctype="multipart/form-data">
             
            @csrf
          
            <input type="text" name="first_name" placeholder="Ad"/>
            <input type="text" name="last_name" placeholder="Soyad"/>
            <input type="text" name="id" placeholder="Okul No (Yöneticiler bu alana kullanıcı adı yazmalıdır."/>
            <input type="text" name="bolum" placeholder="Bölüm"/>
            <!--<input type="text"  name="yetki" placeholder="Kullanıcı Tipi (Admin/Kullanıcı)"/> -->
            <select required name="yetki" style="font-size:15px;font-weight:bold;margin-left:3px !important;margin-top:5px;margin-bottom:5px;width: 400px;height:55px" >
                <option value="" style="font-weight:bold" disabled selected>Yetki Seç</option>
                <option value="kullanıcı"  style="font-weight:bold"  name="kullanıcı">kullanıcı</option>
                <option value="admin"  style="font-weight:bold"  name="admin">admin</option>
            </select>
        <?php
            if(isset($_POST['submit'])){
            if(!empty($_POST['yetki'])) {
                $selected = $_POST['yetki'];
                echo 'You have chosen: ' . $selected;
            } else { echo 'Please select the value.';}}
        ?>
            <input type="password" name="password_create" placeholder="Şifre"/>
            <label for="profil" class="profil">Profil Fotoğrafı Seçin</label>
            <input type="file" id="profil" name="profil"  multiple />
            <button type="submit" class="btn signup">Kayıt Ol</button>
            <p><strong>Kayıt Ol</strong>'a tıklamak tüm<a href="javascript:void(0)"> hizmet şartlarımızı</a>  kabul ettiğiniz anlamına gelir.</p>
            <hr/>
            
        </form>
    </div>

</div>

</body>
</html>