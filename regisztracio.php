<?php
session_start();

$hibak = [];
if (!empty($_SESSION['nevHiba'])) {
    $hibak['nev'] = $_SESSION['nevHiba'];
    unset($_SESSION['nevHiba']);
}
if (!empty($_SESSION['emailHiba'])) {
    $hibak['email'] = $_SESSION['emailHiba'];
    unset($_SESSION['emailHiba']);
}
if (!empty($_SESSION['jelszoHiba'])) {
    $hibak['jelszo'] = $_SESSION['jelszoHiba'];
    unset($_SESSION['jelszoHiba']);
}
if (!empty($_SESSION['jelszo2Hiba'])) {
    $hibak['jelszo2'] = $_SESSION['jelszo2Hiba'];
    unset($_SESSION['jelszo2Hiba']);
}

$ertekek = [];
if (!empty($_SESSION['ertekek'])) {
    $ertekek = $_SESSION['ertekek'];
    unset($_SESSION['ertekek']);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció | PC Forge</title>
    <link rel="icon" type="image/png" href="pcforgelogo.png">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <button class="menugomb" onclick="toggleMenu()">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <div id="overlay" onclick="closeMenu()"></div>
    <nav id="menu" class="menu">
        <a href="index.php">
            <ion-icon name="home-outline"></ion-icon>
            Főoldal
        </a>
        <a href="start.php">
            <ion-icon name="construct-outline"></ion-icon>
            Start
        </a>
        <a href="beallitasok.php">
            <ion-icon name="settings-outline"></ion-icon>
            Beállítások
        </a>
        <a href="tamogatas.php">
            <ion-icon name="diamond-outline"></ion-icon>
            Támogatás
        </a>
        <a href="sugo.html">
            <ion-icon name="information-circle-outline"></ion-icon>
            Súgó
        </a>
        <a href="csapattagok.php">
            <ion-icon name="people-outline"></ion-icon>
            Csapattagok
        </a>
        <a href="statisztikak.php">
            <ion-icon name="bar-chart-outline"></ion-icon>
            Statisztikák
        </a>
    </nav>
    <h1>Regisztráció</h1>
    <hr style="width: 700px">
    <form id="regisztracio" method="POST" action="regisztraciofeldolgozas.php" autocomplete="off" spellcheck="false">
        <label for="nev"><ion-icon name="person-outline"></ion-icon>Felhasználónév: </label>
        <input type="text" id="nev" name="nev" value="<?php echo htmlspecialchars($ertekek['nev'] ?? ''); ?>">
        <?php
        if(!empty($hibak['nev'])){
            foreach($hibak['nev'] as $nevHiba){
                echo "<p class='hibas'><ion-icon name='alert-circle-outline'></ion-icon> $nevHiba</p>";
            }
        }
        ?><br>
        <div class="info"><ion-icon name="information-circle-outline"></ion-icon>
        Minimum 4 betű, maximum 10 betű, csak az angol abc betűi.</div><br>
        <hr>
        <label for="email"><ion-icon name="mail-outline"></ion-icon>Email: </label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($ertekek['email'] ?? ''); ?>">
        <?php
        if(!empty($hibak['email'])){
            foreach($hibak['email'] as $emailHiba){
                echo "<p class='hibas'><ion-icon name='alert-circle-outline'></ion-icon> $emailHiba</p>";
            }
        }
        ?><br>
        <hr>
        <label for="jelszo"><ion-icon name="lock-closed-outline"></ion-icon>Jelszó: </label>
        <input type="password" id="jelszo" name="jelszo">
        <?php
        if(!empty($hibak['jelszo'])) {
            echo "<p class='hibas'><ion-icon name='alert-circle-outline'></ion-icon> {$hibak['jelszo']}</p>";
        }
        ?><br>
        <div class="info"><ion-icon name="information-circle-outline"></ion-icon>
        Minimum 6 karakter, maximum 15 karakter.</div><br>
        <hr>
        <label for="jelszo2"><ion-icon name="lock-closed-outline"></ion-icon>Jelszó megerősítése: </label>
        <input type="password" id="jelszo2" name="jelszo2">
        <?php
        if(!empty($hibak['jelszo2'])) {
            echo "<p class='hibas'><ion-icon name='alert-circle-outline'></ion-icon> {$hibak['jelszo2']}</p>";
        }
        ?><br>
        <label class="checkbox">
            <input type="checkbox" id="elfogadas">
            <span class="doboz"></span>
            <span class="text">Elfogadom az <a href="aszf.html">ÁSZF</a>-et és 
             az <a href="adatvedelem.html">Adatvédelmi Nyilatkozat</a>-ot.</span>
            </label><br>
        <br>
        <input type="submit" id="regisztraciogomb" name="regisztraciogomb" value="Regisztráció" disabled>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <script src="index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7/dist/ionicons/ionicons.js"></script>
</body>
</html>