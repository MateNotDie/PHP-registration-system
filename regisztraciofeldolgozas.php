<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

if(!isset($_POST['regisztraciogomb'])) {
    header("location:regisztracio.php");
    exit();
}

if(!preg_match('/^[a-zA-Z0-9_-]{4,10}$/', $_POST['nev'])) {
    $_SESSION['nevHiba'][] = "A felhasználónév nem felel meg a feltételeknek!";
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['emailHiba'][] = "Nem létezik ilyen e-mail cím!";
}

if(!preg_match('/^.{6,15}$/', $_POST['jelszo'])) {
    $_SESSION['jelszoHiba'] = "A jelszó nem felel meg a feltételeknek!";
}

if($_POST['jelszo'] != $_POST['jelszo2']) {
    $_SESSION['jelszo2Hiba'] = "A jelszavak nem egyeznek meg!";
}

$_SESSION['ertekek'] = [
    'nev' => $_POST['nev'] ?? '',
    'email' => $_POST['email'] ?? ''
];

if(!empty($_SESSION['nevHiba']) || !empty($_SESSION['emailHiba']) || !empty($_SESSION['jelszoHiba']) || !empty($_SESSION['jelszo2Hiba'])) {
    header("location:regisztracio.php");
    exit();
}

regisztralas();

function regisztralas() {
    $_SESSION['nev'] = $_POST['nev'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['jelszo'] = $_POST['jelszo'];
    $mysqli = new mysqli($_ENV['dbgep'], $_ENV['dbnev'], $_ENV['dbjelszo'], $_ENV['db']);
    if ($mysqli->connect_errno) {
        error_log("Hiba: " . $mysqli->connect_error);
        return false;
    }
    $felhasznalonev = $mysqli->real_escape_string($_POST['nev']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $nevKereses = "select id from DragaTagok where nev='{$felhasznalonev}'";
    $emailKereses = "select id from DragaTagok where email='{$email}'";
    $nevEredmeny = $mysqli->query($nevKereses);
    $emailEredmeny = $mysqli->query($emailKereses);
    $nevSor = $nevEredmeny->fetch_assoc();
    $emailSor = $emailEredmeny->fetch_assoc();
    if(isset($nevSor['id']) && $nevSor['id'] != "") {
        $_SESSION['nevHiba'][] = "Ez a felhasználónév már foglalt!";
        header("Location: regisztracio.php");
        exit();
    }
    if(isset($emailSor['id']) && $emailSor['id'] != "") {
        $_SESSION['emailHiba'][] = "Ezzel az e-mail címmel már létezik felhasználó!";
        header("Location: regisztracio.php");
        exit();
    }
    $_SESSION['kod'] = random_int(100000, 999999);
    $_SESSION['kodLetrehozva'] = time();
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 1025;
        $mail->SMTPAuth = false;
        $mail->setFrom('teszt@local.test', 'PC Forge');
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Hitelesitő kód';
        $kod = $_SESSION['kod'];
        $mail->Body = "
        <h2>Szia!</h2><br><br>A hitelesítő kódod: <b>{$kod}</b><br>
        <p>A kód <b>5 percig</b> érvényes.</p><br><br>
        <p>Ez egy rendszerüzenet, kérlek ne válaszolj rá.</p>";
        $mail->CharSet = 'UTF8';
        $mail->send();
        $_SESSION['hitelesitesInditva'] = true;
        $_SESSION['hitelesitesUzenet'] = true;
        header("Location: hitelesites.php");
        exit();
    } catch (Exception $e) {
       echo "Hiba: " . $mail->ErrorInfo;
       exit();
    }
}
?>