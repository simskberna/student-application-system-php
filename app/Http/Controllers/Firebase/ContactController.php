<?php

namespace App\Http\Controllers\Firebase;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Storage;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserRecord;
class ContactController extends Controller
{   
    public function __construct(Database $database, Auth $auth,Storage $storage)
    { 
   
      $this->auth = $auth;
      $this->database = $database;
      $this->storage = $storage;
      $this->tablename = 'contacts';
    }
    
    public function index(){
      return view('firebase.login');
    }
    public function create(){
      return view('firebase.login');
    }
   
    public function signIn(Request $request)
    {
     
      $password = $request->input('password');
      $email = $request->input('email');

        
      $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
      
      Session::put('firebaseUserId', $signInResult->firebaseUserId());
      $uid = $signInResult->firebaseUserId();
      Session::put('idToken', $signInResult->idToken());
      Session::save();
      //dump($signInResult->data()['displayName']);

      return redirect('read');
           
         // $this->read();
    }
    public function read(){
     
        //(\Session::get('yetki'))
        $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi'); 
        $snapshot = $reference->getSnapshot()->getValue();
        if($snapshot){
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();
        
          $name = $value['name'];$lname = $value['lname'];$email = $value['email'];$bolum = $value['bolum'];$yetki =$value['yetki'];$profil_foto = $value['profil_foto'];$id=$value['id'];
          return view('profilepage',compact('name','lname','email','bolum','yetki','profil_foto','id'));
          //return view('masterhome',compact('name','lname','email'));
          
        }else{
          $reference = $this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();
          $name = $value['name'];$lname = $value['lname'];$email = $value['email'];$bolum = $value['bolum'];$yetki =$value['yetki'];$profil_foto = $value['profil_foto'];
          return view('adminprofile',compact('name','lname','email','bolum','yetki','profil_foto'));
         // return view('masterhome',compact('name','lname','email'));
        }
      
       // dd($snapshot);
       
    
    }
   public function edit(Request $request){
    
    if(($this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()) !== null){
      $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
     
    }
    else{
      $reference = $this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
    }
 
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();
    $name = $value['name'];$lname = $value['lname'];$email = $value['email'];$yetki =$value['yetki'];$profil_foto = $value['profil_foto'];$bolum = $value['bolum'];
   
    //return view('masterhome',compact('name','lname','email'));
     
      if($value){
        
        return view('profilduzenle',compact('name','lname','email','yetki','profil_foto','bolum'));
      }
      else{
        return redirect('profilepage')->with('status','Kullanıcı Bilgileri Bulunamadı.');
      }
   }
    public function signUp(Request $request)
    {
        $password = $request->input('password_create');
        //$email = $request->input('email_create');
        $yetki = $request->input('yetki');
        $image = $request->profil;
        $id = $request->id.'@kou.edu.tr';
          //profil foto yükleme BAŞ
          $storage = app('firebase.storage'); 
          $defaultBucket = $storage->getBucket();
           
          $name = $id . '.' . $image->getClientOriginalExtension();
          
          $pathName = $image->getPathName();
          $file = fopen($pathName, 'r');
          $object = $defaultBucket->upload($file, [
              'name' => $name,
              'predefinedAcl' => 'publicRead'
          ]);
          $image_url = 'https://storage.googleapis.com/'.env('FIREBASE_PROJECT_ID').'.appspot.com/'.$name;
            //profil foto yükleme SON
      
        
            $newUser = $this->auth->createUserWithEmailAndPassword($id, $password);
           
             $user =[
              'name' => $request->first_name,
              'lname' => $request->last_name,
              'email' => $request->id.'@kou.edu.tr',
              'bolum' => $request->bolum,
              'id' => $request->id,
              'password' => $request->password_create,
              'uid' => $newUser->uid,
              'profil_foto' => $image_url,
              'yetki' => $request->yetki,
             ];
             
             $reference = $this->database->getReference('kullanıcılar/'.$yetki.'/'.$newUser->uid.'/kullanıcıBilgi')->set($user);


            // dd($newUser->uid);
           // return $this->writeUserData($user->uid);
           
            //dd($newUser);
            if($newUser)
            {
              return redirect('/login')->with('status','Başarıyla Kayıt Olundu');
            }
            else
            {
              return redirect('/login')->with('status','Kayıt Olunamadı');
            }
    }

  
  public function signOut()
  {
      if (Session::has('firebaseUserId') && Session::has('idToken')) {
          
          $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
          Session::forget('firebaseUserId');
          Session::forget('idToken');
          Session::save();
          //dd("User  logout.");

          return redirect('/login')->with('status','Başarıyla Çıkış Yapıldı');
      } else {
          //dd("User should login first.");
          return redirect('/login')->with('statu','Çıkış Yapılamadı');
      }
  }
   
  public function basvuru(Request $request)
  { 
          $basvuruTipi = $request -> input('basvuru_tipi');

          //storage'a belge eklemek için BAŞ
          $storage = app('firebase.storage'); // This is an instance of Google\Cloud\Storage\StorageClient from kreait/firebase-php library
          $defaultBucket = $storage->getBucket();
          $image = $request->belge;
          
          $name = (string) $basvuruTipi.'_'.(\Session::get('firebaseUserId')).'.'.$image->getClientOriginalExtension(); // use Illuminate\Support\Str;
          
          $pathName = $image->getPathName();
          $file = fopen($pathName, 'r');
          $object = $defaultBucket->upload($file, [
              'name' => $name,
              'predefinedAcl' => 'publicRead'
          ]);
          $image_url = 'https://storage.googleapis.com/'.env('FIREBASE_PROJECT_ID').'.appspot.com/'.$name;
            //storage'a belge eklemek için  SON
            
        $currentDate = Carbon::now();
        
        $basvuru = [
            'first_name' => $request -> first_name,
            'last_name' => $request -> last_name,
            'email_address' => $request -> email_address,
            'phone_number' => $request -> phone_number,
            'belge' => $image_url,
            'onay' => 'Onay Bekliyor',
            'basvuru_tarihi' => $currentDate -> format("Y-m-d"),

        ];
        $reference = $this -> database -> getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).
            '/basvuruBilgi/'.$basvuruTipi) -> set($basvuru);

        if ($reference) {
          if($basvuruTipi === 'DgsBasvurusu'){return redirect('dgsbasvuru') -> with('success', 'Başvuru Yapıldı.');}
          else if($basvuruTipi === 'YatayGecisBasvurusu'){ return redirect('yataygecis') -> with('success', 'Başvuru Yapıldı.');}
          else if($basvuruTipi === 'YazOkuluBasvurusu'){ return redirect('yazokulu') -> with('success', 'Başvuru Yapıldı.');}
          else if($basvuruTipi === 'DersIntibaki'){return redirect('dersintibaki') -> with('success', 'Başvuru Yapıldı.');}
          else if($basvuruTipi === 'CapBasvurusu'){return redirect('capbasvuru') -> with('success', 'Başvuru Yapıldı.');}
        } else {
            return redirect('yazokulu') -> with('failed', 'Başvuru Yapılamadı.');
            return redirect('yataygecis') -> with('failed', 'Başvuru Yapılamadı.');
            return redirect('dersintibaki') -> with('success', 'Başvuru Yapılamadı.');
            return redirect('dgsbasvuru') -> with('success', 'Başvuru Yapılamadı.');
            return redirect('capbasvuru') -> with('success', 'Başvuru Yapılamadı.');
        }
             
    }
    public function update(Request $request){
      
      $image = $request->profil;
      $tip = 'profilfotografi';
      //foto güncellemek için BAŞ
     if($image !== null ){     
      $storage = app('firebase.storage'); 
      $defaultBucket = $storage->getBucket();  
      $name = (string) $tip.'_'.(\Session::get('firebaseUserId')).'.'.$image->getClientOriginalExtension(); 
      $pathName = $image->getPathName();
       
      $file = fopen($pathName, 'r');
      
      $object = $defaultBucket->upload($file, [
          'name' => $name,
          'predefinedAcl' => 'publicRead'
      ]);
      
      $image_url = 'https://storage.googleapis.com/'.env('FIREBASE_PROJECT_ID').'.appspot.com/'.$name;
     
     }else{
       
       $image_url = $request->profil_foto;
     }
        //foto güncellemek içib SON


        $updates = [
          'name' => $request->name,
          'lname' =>$request->lname,
          'email'=>$request->email,
          'profil_foto'=>$image_url,
        ];
         
        if($this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null){
          $res_updated = $this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->update($updates);
        }else{
          $res_updated = $this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->update($updates);
        }
        


        if($res_updated){
          $type;
          
          if($this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()===null){
              $reference =  $this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
              $type='admin';
          }
          else{
            $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi');
            $type='kullanıcı';
          }  
          
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();
          $name = $value['name'];$lname = $value['lname'];$email = $value['email'];$yetki =$value['yetki'];$profil_foto = $value['profil_foto'];$bolum = $value['bolum'];
         if($type ==='admin'){
         
          return view('adminprofile',compact('name','lname','email','bolum','yetki','profil_foto'));
         }else{
           
          return view('profilepage',compact('name','lname','email','bolum','yetki','profil_foto'));
         }
        
        }
        else{
          return redirect('profilduzenle')->with('status','Profil Bilgileri Güncellenemedi.');
        }
    }
   
    public function basvuruOnayla($userid,$basvuruTip){
      
      if($userid){
      $updates = [
        'onay' =>'Başvuru Onaylandı',
      ];
       $res_updated = $this->database->getReference('kullanıcılar/kullanıcı/'.$userid.'/basvuruBilgi/'.$basvuruTip.'/')->update($updates); 
    } 
    else{
      echo 'NO';
    }
      
  }
  public function DgsListele(Request $request){
      
    if($this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null)
    { 
     
      $basvuruTip = 'DgsBasvurusu';
      
       $users = $this->auth -> listUsers();
        foreach($users as $user){
          
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/belge');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();     
          //$tri = trim($snapshot->getValue(),"pdf");
         
          if($value!==null){
            $basvuruDurum = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/');
            $shot = $basvuruDurum->getSnapshot();
            $val = $shot->getValue();   
           
            /*$pieces = explode($tri ,$value);
            var_dump($pieces);*/
          
            $kullanıcı = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/kullanıcıBilgi/id')->getValue();
              
             
            echo '</br>';
            echo '<h4 class="fancy">Öğrenci No:'.$kullanıcı.'</h4>';
            echo '<a class="fancy" target="_blank" href='."$value".'>Belge LINK</a>';
            
            if($val['onay'] === 'Onay Bekliyor'){
              ?> <form method="get" >&nbsp;&nbsp;&nbsp;<a style="color: red !important;" href="#">
              <?=$val['onay']?></a><button type="submit" name ="submit" value ="Save" onClick="<?=$this->basvuruOnayla($user->uid,$basvuruTip);
              ?>"style="margin-left:20px" >
               Onayla</button><hr>
               </form>
              <?php
             
            }
           
           
          }  
        }
       
        echo '</br></br><button  type="button" class="btn btn-warning"><a href="basvurular">GERİ</a></button>';
        return view('dgsbasvurulari');
    }
    else{
      echo '</br>' .'Sayfaya Erişiminiz Yok';
    }        
  }
  public function İntibakListele(Request $request){
      
    if($this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null)
    { 
     
      $basvuruTip = 'DersIntibaki';
      
       $users = $this->auth -> listUsers();
        foreach($users as $user){
          
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/belge');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();     
          //$tri = trim($snapshot->getValue(),"pdf");
         
          if($value!==null){
            $basvuruDurum = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/');
            $shot = $basvuruDurum->getSnapshot();
            $val = $shot->getValue();   
           
            /*$pieces = explode($tri ,$value);
            var_dump($pieces);*/
          
            $kullanıcı = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/kullanıcıBilgi/id')->getValue();
              
             
            echo '</br>';
            echo '<h4 class="fancy">Öğrenci No:'.$kullanıcı.'</h4>';
            echo '<a class="fancy" target="_blank" href='."$value".'>Belge LINK</a>';
            
            if($val['onay'] === 'Onay Bekliyor'){
              ?> <form method="get" >&nbsp;&nbsp;&nbsp;<a style="color: red !important;" href="#">
              <?=$val['onay']?></a><button type="submit" name ="submit" value ="Save"
              onClick="<?=$this->basvuruOnayla($user->uid,$basvuruTip);
              ?>" style="margin-left:20px" >
               Onayla</button><hr>
               </form>
              <?php
             
            }
           
           
          }  
         
        }
        
        echo '</br></br><button  type="button" class="btn btn-warning"><a href="basvurular">GERİ</a></button>';
        return view('dersintibaki');
    }
    else{
      echo '</br>' .'Sayfaya Erişiminiz Yok';
    }        
  }
  public function CapListele(Request $request){
      
    if($this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null)
    { 
     
      $basvuruTip = 'CapBasvurusu';
      
       $users = $this->auth -> listUsers();
        foreach($users as $user){
          
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/belge');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();     
          //$tri = trim($snapshot->getValue(),"pdf");
         
          if($value!==null){
            $basvuruDurum = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/');
            $shot = $basvuruDurum->getSnapshot();
            $val = $shot->getValue();   
           
            /*$pieces = explode($tri ,$value);
            var_dump($pieces);*/
          
            $kullanıcı = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/kullanıcıBilgi/id')->getValue();
              
             
            echo '</br>';
            echo '<h4 class="fancy">Öğrenci No:'.$kullanıcı.'</h4>';
            echo '<a class="fancy" target="_blank" href='."$value".'>Belge LINK</a>';
            
            if($val['onay'] === 'Onay Bekliyor'){
              ?> <form method="get" >&nbsp;&nbsp;&nbsp;<a style="color: red !important;" href="#">
              <?=$val['onay']?></a><button type="submit" name ="submit" value ="Save"
              onClick="<?=$this->basvuruOnayla($user->uid,$basvuruTip);
              ?>" style="margin-left:20px" >
               Onayla</button><hr>
               </form>
              <?php
             
            }
           
           
          }  
         
        }
      
        echo '</br></br><button  type="button" class="btn btn-warning"><a href="basvurular">GERİ</a></button>';
        return view('capbasvurulari');
    }
    else{
      echo '</br>' .'Sayfaya Erişiminiz Yok';
    }        
  }
  public function YatayBasvuruListele(Request $request){
      
    if($this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null)
    { 
     
      $basvuruTip = 'YatayGecisBasvurusu';
      
       $users = $this->auth -> listUsers();
        foreach($users as $user){
          
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/belge');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();     
          //$tri = trim($snapshot->getValue(),"pdf");
         
          if($value!==null){
            $basvuruDurum = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/');
            $shot = $basvuruDurum->getSnapshot();
            $val = $shot->getValue();   
           
            /*$pieces = explode($tri ,$value);
            var_dump($pieces);*/
          
            $kullanıcı = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/kullanıcıBilgi/id')->getValue();
              
             
            echo '</br>';
            echo '<h4 class="fancy">Öğrenci No:'.$kullanıcı.'</h4>';
            echo '<a class="fancy" target="_blank" href='."$value".'>Belge LINK</a>';
            
            if($val['onay'] === 'Onay Bekliyor'){
              ?> <form method="get" >&nbsp;&nbsp;&nbsp;<a style="color: red !important;" href="#">
              <?=$val['onay']?></a><button type="submit" name ="submit" value ="Save"
              onClick="<?=$this->basvuruOnayla($user->uid,$basvuruTip);
              ?>" style="margin-left:20px" >
               Onayla</button><hr>
               </form>
              <?php
             
            }
           
           
          }  
         
        }
       
        echo '</br></br><button  type="button" class="btn btn-warning"><a href="basvurular">GERİ</a></button>';
        return view('yataygecisbasvurulari');
    }
    else{
      echo '</br>' .'Sayfaya Erişiminiz Yok';
    }        
  }
  public function YazBasvuruListele(Request $request){
    
    if($this->database->getReference('kullanıcılar/admin/'.(\Session::get('firebaseUserId')).'/kullanıcıBilgi')->getValue()!==null)
    { 
      
      $basvuruTip = 'YazOkuluBasvurusu';
      
        $users = $this->auth -> listUsers();
        foreach($users as $user){
          
          $reference = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/belge');
          $snapshot = $reference->getSnapshot();
          $value = $snapshot->getValue();     
          //$tri = trim($snapshot->getValue(),"pdf");
          
          if($value!==null){
            $basvuruDurum = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/basvuruBilgi/'.$basvuruTip.'/');
            $shot = $basvuruDurum->getSnapshot();
            $val = $shot->getValue();   
          
            /*$pieces = explode($tri ,$value);
            var_dump($pieces);*/
            
            $kullanıcı = $this->database->getReference('kullanıcılar/kullanıcı/'.$user->uid.'/kullanıcıBilgi/id')->getValue();
            
            echo '</br>';
            echo '<h4 class="fancy">Öğrenci No:'.$kullanıcı.'</h4>';
            echo '<a class="fancy" target="_blank" href='."$value".'>Belge LINK</a>';
            
            if($val['onay'] === 'Onay Bekliyor'){
              
              ?> <form method="get" >&nbsp;&nbsp;&nbsp;<a style="color: red !important;" href="#">
              <?=$val['onay']?></a><button type="submit" name ="submit" value ="Save"
              onClick="<?=$this->basvuruOnayla($user->uid,$basvuruTip);
            ?>" style="margin-left:20px" >
                Onayla</button><hr>
                </form>
              <?php
              
            }       
            
          }  
          
        }
        
        echo '</br></br><button  type="button" class="btn btn-warning"><a href="basvurular">GERİ</a></button>';
        return view('yazokulubasvurulari');
    }
    else{
      echo '</br>' .'Sayfaya Erişiminiz Yok';
    }        
  }
   
}
