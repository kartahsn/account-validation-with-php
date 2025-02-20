<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>Login</title>
  </head>
  <body class="bg-dark bg-opacity-25">
    <div class="container mt-5">
      <div class="container-fluid">
        <div class="row bg-primary text-white pt-5 pb-5 rounded">
          <span class="h1 text-center">REGISTER</span>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-2">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="username" minlength="5" required />
            </div>
            <div class="mb-2">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="blablabla@gmail.com" required />
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" minlength="5" required />
            </div>
            <div class="pt-3">
              <div class="row">
                <div class="col">
                  <input type="reset" class="form-control" />
                </div>
                <div class="col">
                  <input type="submit" class="form-control" name="submit" value="Register" />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
  include('../config/connection.php'); //memanggil koneksi database

  if(isset($_POST['submit'])){ //jika tombol submit/register diklik maka akan langsung eksekusi disini
    $rand     = md5(rand(10000,50000)); //membuat angka acak berupa key validasi nya, lalu di encrypt berupa md5 
    $pass     = md5($_POST['password']);  //mengambil data yang sudah disubmit berupa password lalu diencrypt
    $name     = $_POST['username'];       //mengambil data yang sudah disubmit berupan username
    $headers  = "From: karta@gmail.com";  //header untuk membuat/proses pengiriman email
    $to       = $_POST['email'];          //mengambil data yang sudah disubmit berupa email
    $subject  = "REGISTER";               //subject buat nanti dikirim pada email
    $message  = 'Hai '.$name.'<br>'.      //pesan buat penerima/ user yang sudah melakukan register 
                'Terimakasih sudah mendaftar<br>'.
                'Silahkan klik dibawah ini untuk mengaktifkan akun anda:<br>'.
                '<a href="https://domain.com/verif/?email='.$to.'&key='.$rand.'">KLIK DISINI</a>';
    
    if (mail($to, $subject, $message, $headers)){ //fungsi buat kirim email, jika berhasil dikirim maka langsung di eksekusi 
      mysqli_query($con, "insert into reg(`name`, `email`, `password`, `key`) values ('$name', '$to', '$pass', '$rand')");
          // jika berhasil maka data langsung di input ke database sehingga nanti bisa di proyeksi pada saat user mengklik link verifikasi
      header('location: ../login/'); //dan langsung ditujukan ke halaman login, jadi user tidak perlu lagi mengklik menu login
    }
    else{ //dan jika gagal mengirim email maka akan di alihkan lagi kehalaman registrasi
      header('location: ../register');
    }
  }
?>
