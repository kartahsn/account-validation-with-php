<?php       
    include('../config/connection.php'); //memanggil koneksi database

    $email  = $_GET['email'];   //lalu mengambil data yang ada pada url berupa email
    $key    = $_GET['key'];     //lalu mengambil data yang ada pada url berupa key yang tadi sudah di encrypt

    $sql    = "select email, key from reg where email=$email and key=md5($key) and verif=0";   //string proses proyeksi dan seleksi
                                //yang mana jika email dan key nya cocok serta verif nya berupa 0 maka akan langsung di seleksi
    $query  = mysqli_query($con, $sql)  
    if(mysqli_num_row($query) > 0){     //jika query berhasil dan terdapat di database
        mysqli_query($con, "update reg set verif=1 where email=$email and key=md5($key)"; //maka akan langsung dilakukan update 
                                    //data verif yang tadi nya bernilai 0 berubah menjadi 1 dengan mencocokan email serta key nya
                                    //lalu mengirimkan pesan berupa popup dengan bantuan alert dari javascript
        echo '<script>
            alert('Akun berhasil diaktifkan');
            </script>'; 
    } 
    else{                           //sebaliknya jika gagal maka akan menampilkan pesan kesalahan
        echo '<script>
            alert('Kesalahan tidak diketahui');
            </script>'; 
    } 
?>
