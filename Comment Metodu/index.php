<?php
require_once "baglanti.php";
$baglanti = new baglanti();


//Database`ə Göndərmə
if(isset($_POST['gonder']))
{
    $ad = strip_tags($_POST['ad']);
    $soyad = strip_tags($_POST['soyad']);
    $email = strip_tags($_POST['email']);
    $mesaj = strip_tags($_POST['mesaj']);
    $tarix = date("Y-m-d");

    if(!empty($ad) and !empty($soyad) and !empty($email) and !empty($mesaj))
    {
        $sorgu = $baglanti->db->prepare("INSERT INTO defter(ad,soyad,email,mesaj,tarix)VALUES(?,?,?,?,?)");
        $execute = $sorgu->execute(array($ad,$soyad,$email,$mesaj,$tarix));

        if($execute)
        {
            echo "Dəftərə yazdınız";
        }
        else
        {
            echo "Dəftərə yazılmadı";
        }
    }
    else
    {
        echo "Lütfən bütün ünvanları doldurun";
    }
}


?>

<html>
<head>
    <title>Ziyarətçi Dəftəri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Ziyarətçi Dəftəri</h2>




<?php
//Databasedən çəkmə

$sorgu = $baglanti->db->prepare("SELECT * FROM defter order by id DESC"); //Son yazılan mesajın ən üstə çıxması üçün DESC
$sorgu->execute();
$cek = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if(count($cek) != 0) //Əgər massivin içindəki dəyərlərin sayı(count) 0-a bərabər deyilsə
{
foreach ($cek as $key => $value)
{
    echo '<div class="list"><span>'.$value['ad'].'</span> <span>'.$value['soyad'].'</span> <span>'.$value['email'].'</span> ('.$value['tarix'].')<p>'.$value['mesaj'].'</p></div>';
}
}
else
{
    echo "Hələ ki bir rəy əlavə olunmayıb";
}





?>




<form action="" method="POST">

    <div class="form">
        <span>İsminiz</span>
        <input type="text" name="isim">
    </div>

    <div class="form">
        <span>Soyisminiz</span>
        <input type="text" name="soyisim">
    </div>

    <div class="form">
        <span>Emailiniz</span>
        <input type="text" name="email">
    </div>

    <div class="form">
        <span>İsminiz</span>
        <textarea name="mesaj" id="" cols="30" rows="10"></textarea>
    </div>

    <div class="form">
        <input style="padding: 7px; border: 0; background: #afffa4; color:black;" type="submit" name="gonder" value="Gönder">
    </div>

</form>

</body>
</html>