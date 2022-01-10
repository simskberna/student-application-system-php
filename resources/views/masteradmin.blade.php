<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <title>Application System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
    crossorigin="anonymous"
  />
  <!-- BOX ICONS CSS-->
  <link
    href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css"
    rel="stylesheet"
  />
  <script src="https://code.iconify.design/2/2.1.0/iconify.min.js"></script>
  
 <style>
           * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
 
body {
  min-height: 100vh;
  
}

.side-navbar {
  width: 180px;
  height: 100%;
  position: fixed;
  margin-left: -300px;
  background-color: #100901;
  transition: 0.5s;
}

.nav-link:active,
.nav-link:focus,
.nav-link:hover {
  background-color: #ffffff26;
}

.my-container {
  transition: 0.4s;
}

.active-nav {
  margin-left: 0;
}
.top-navbar{
  margin-left: -2px;
  margin-right: -2px;
  margin-top: -3px
}
.px-5{
    border-radius: 5px;
    padding-left: 5rem!important;
    background-color: #00476317 !important;
}
/* for main section */
.active-cont {
  margin-left: 250px;
}

#menu-btn {
  background-color: #100901;
  color: #fff;
  margin-left: -62px;
}

.my-container input {
  border-radius: 2rem;
  padding: 2px 20px;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  min-height: 100vh;
  background-color: #5eb5d7;
}

.side-navbar {
  width: 250px;
  height: 100%;
  position: fixed;
  margin-left: -300px;
  background-color: #004763;
  transition: 0.5s;
}


.nav-link:hover {
  background-color: #ffffff26;
}
.nav-link:active,
.nav-link:focus{
  background-color: #ffffff26;
}
.nav-link{
    
    color:#fff!important;
}
.nav-link:nth-child(1){
    color:#fff !important;
}
.my-container {
  transition: 0.4s;
}

.active-nav {
  margin-left: 0;
}
 

/* for main section */
 
#menu-btn {
  background-color: #004763;
  color: #fff;
  margin-left: -62px;
}

.my-container input {
  border-radius: 2rem;
  padding: 2px 20px;
}
.wrapper{
    background-color:#5eb5d7; 
}

 </style>
</head>

<body>
    @section('sidebar')
    <div class="wrapper">
         <!-- Side-Nav -->
    <div
    class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column"
    id="sidebar"
  >
    <ul class="nav flex-column text-white w-100">
      <a href="#" class="nav-link h3 text-white my-2" style="color:hsl(7, 100%, 71%) !important ;font-size:15px;margin-top:-15% !important;">
      
      </a>
      <a href="read" class="nav-link" style="margin-top: 20% !important;">
        <i class="bx bx-user-check" style="color:hsl(7, 100%, 71%)"></i>
        <span class="mx-2">Profil</span>
      </a>
      <a href="basvurular" class="nav-link">
        <i class="bx bxs-dashboard" style="color:hsl(7, 100%, 71%)"></i>
        <span class="mx-2">Başvurular</span>
      </a>
     
<style>
  #nav-link-logout:hover{
      background-color: hsl(340, 100%, 71%) !important;
  }
</style>
      <a href="signOut"  class="nav-link" id="nav-link-logout" style="background-color:hsl(7, 100%, 71%); color:#000000 !important;" >
        <i class="iconify" data-icon="ri:logout-box-r-fill" color="#000"></i>
        <span class="mx-2">Log Out</span>
      </a>
    </ul>

    
  </div>

  <!-- Main Wrapper -->
  <div class="p-1 my-container active-cont">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-light px-5">
      <a class="btn border-0" id="menu-btn"><i class="bx bx-menu"></i></a>
    </nav>
  </div>

  <!-- bootstrap js -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"
  ></script>
  <!-- custom js -->
  <script>
    var menu_btn = document.querySelector("#menu-btn");
    var sidebar = document.querySelector("#sidebar");
    var container = document.querySelector(".my-container");
   
    menu_btn.addEventListener("click", () => {
      sidebar.classList.toggle("active-nav");
      container.classList.toggle("active-cont");
    });
  </script>
        @section('content')
        <div id="content"> 
         
        </div>
        @show
    </div>
   
    
</body>

</html>