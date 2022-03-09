<div class="menu">
    <div class="menu-butts">
        <div class="ham">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <?php
        $type = $_SESSION['user']['uprawnienia'];
        if ($type == "administrator" || $type == "moderator") {
            if ($_SESSION['activePage'] == "adminPanel") {
                if ($_SESSION['activePage'] == "konto") echo '<a href="../konto.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Moje konto</p></a>';
                else echo '<a href="../konto.php" class="link"><p class="menu-select">Moje konto</p></a>';
                if ($_SESSION['activePage'] == "galeria") echo '<a href="../galeria.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Galeria</p></a>';
                else echo '<a href="../galeria.php" class="link"><p class="menu-select">Galeria</p></a>';
                if ($_SESSION['activePage'] == "dodaj-album") echo '<a href="../dodaj-album.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Załóż album</p></a>';
                else echo '<a href="../dodaj-album.php" class="link"><p class="menu-select">Załóż album</p></a>';
                if ($_SESSION['activePage'] == "dodaj-foto") echo '<a href="../dodaj-foto.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Dodaj zdjęcie</p></a>';
                else echo '<a href="../dodaj-foto.php" class="link"><p class="menu-select">Dodaj zdjęcie</p></a>';
                if ($_SESSION['activePage'] == "top-foto") echo '<a href="../top-foto.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Najlepiej oceniane</p></a>';
                else echo '<a href="../top-foto.php" class="link"><p class="menu-select">Najlepiej oceniane</p></a>';
                if ($_SESSION['activePage'] == "nowe-foto") echo '<a href="../nowe-foto.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Najnowsze</p></a>';
                else echo '<a href="../nowe-foto.php" class="link"><p class="menu-select">Najnowsze</p></a>';
                if ($_SESSION['activePage'] == "adminPanel") echo '<a href="index.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Panel administracyjny</p></a>';
                else echo '<a href="admin/index.php" class="link"><p class="menu-select">Panel administracyjny</p></a>';
            } else {
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['activePage'] == "konto") echo '<a href="konto.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Moje konto</p></a>';
                    else echo '<a href="konto.php" class="link"><p class="menu-select">Moje konto</p></a>';
                }
                if ($_SESSION['activePage'] == "galeria") echo '<a href="galeria.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Galeria</p></a>';
                else echo '<a href="galeria.php" class="link"><p class="menu-select">Galeria</p></a>';
                if ($_SESSION['activePage'] == "dodaj-album") echo '<a href="dodaj-album.php" class="link">
                    <p class="menu-select" style="background-color:#66CCFF;">Załóż album</p></a>';
                else echo '<a href="dodaj-album.php" class="link"><p class="menu-select">Załóż album</p></a>';
                if ($_SESSION['activePage'] == "dodaj-foto") echo '<a href="dodaj-foto.php" class="link">
                    <p class="menu-select" style="background-color:#66CCFF;">Dodaj zdjęcie</p></a>';
                else echo '<a href="dodaj-foto.php" class="link"><p class="menu-select">Dodaj zdjęcie</p></a>';
                if ($_SESSION['activePage'] == "top-foto") echo '<a href="top-foto.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Najlepiej oceniane</p></a>';
                else echo '<a href="top-foto.php" class="link"><p class="menu-select">Najlepiej oceniane</p></a>';
                if ($_SESSION['activePage'] == "nowe-foto") echo '<a href="nowe-foto.php" class="link">
					<p class="menu-select" style="background-color:#66CCFF;">Najnowsze</p></a>';
                else echo '<a href="nowe-foto.php" class="link"><p class="menu-select">Najnowsze</p></a>';
                if ($_SESSION['activePage'] == "adminPanel") echo '<a href="admin/index.php" class="link">
						<p class="menu-select" style="background-color:#66CCFF;">Panel administracyjny</p></a>';
                else echo '<a href="admin/index.php" class="link"><p class="menu-select">Panel administracyjny</p></a>';
            }
        } else {
            if (isset($_SESSION['user'])) {
                if ($_SESSION['activePage'] == "konto") echo '<a href="konto.php" class="link">
				    <p class="menu-select" style="background-color:#66CCFF;">Moje konto</p></a>';
                else echo '<a href="konto.php" class="link"><p class="menu-select">Moje konto</p></a>';
            }
            if ($_SESSION['activePage'] == "galeria") echo '<a href="galeria.php" class="link">
				<p class="menu-select" style="background-color:#66CCFF;">Galeria</p></a>';
            else echo '<a href="galeria.php" class="link"><p class="menu-select">Galeria</p></a>';
            if ($_SESSION['activePage'] == "dodaj-album") echo '<a href="dodaj-album.php" class="link">
				<p class="menu-select" style="background-color:#66CCFF;">Załóż album</p></a>';
            else echo '<a href="dodaj-album.php" class="link"><p class="menu-select">Załóż album</p></a>';
            if ($_SESSION['activePage'] == "dodaj-foto") echo '<a href="dodaj-foto.php" class="link">
				<p class="menu-select" style="background-color:#66CCFF;">Dodaj zdjęcie</p></a>';
            else echo '<a href="dodaj-foto.php" class="link"><p class="menu-select">Dodaj zdjęcie</p></a>';
            if ($_SESSION['activePage'] == "top-foto") echo '<a href="top-foto.php" class="link">
				<p class="menu-select" style="background-color:#66CCFF;">Najlepiej oceniane</p></a>';
            else echo '<a href="top-foto.php" class="link"><p class="menu-select">Najlepiej oceniane</p></a>';
            if ($_SESSION['activePage'] == "nowe-foto") echo '<a href="nowe-foto.php" class="link">
				<p class="menu-select" style="background-color:#66CCFF;">Najnowsze</p></a>';
            else echo '<a href="nowe-foto.php" class="link"><p class="menu-select">Najnowsze</p></a>';
        }

        if (isset($_SESSION['user'])) {
            if ($type == "administrator" || $type == "moderator") {
                if ($_SESSION['activePage'] == "adminPanel") {
                    echo '<form class ="back" method="post" action="../wyloguj.php">
						<input class="logout" type="submit" value="Wyloguj się" name="backb">
                        </form>';
                    $_SESSION['backb'] = true;
                } else {
                    echo '<form class ="back" method="post" action="wyloguj.php">
						<input class="logout" type="submit" value="Wyloguj się" name="backb">
                        </form>';
                    $_SESSION['backb'] = true;
                }
            } else {
                echo '<form class ="back" method="post" action="wyloguj.php">
						<input class="logout" type="submit" value="Wyloguj się" name="backb">
				</form>';
                $_SESSION['backb'] = true;
            }
        } else {
            echo '<a href="index.php#log" class="link"><p class="login">Zaloguj się</p></a>
				<a href="index.php#reg" class="link"><p class="registry">Rejestracja</p></a>';
        }
        ?>
    </div>
</div>