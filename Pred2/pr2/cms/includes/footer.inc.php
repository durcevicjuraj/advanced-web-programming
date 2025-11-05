<!-- # footer.inc.php -->
    <div class="footerBox">
        <footer class="threeColumns">
            <article>
                <h1>Navigacija</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Naslovnica</a></li><li><a href="#">Arhiva</a></li><li><a href="#">Kontakt</a></li><li><?php if ($user) { echo '<a href="logout.php">Logout</a>'; } else { echo '<a href="login.php">Login</a>'; } ?></li><li><a href="#">Registriraj se</a></li>
                    </ul>
                </nav>
            </article>
            <article>
                <h1>Reklamni prostor:</h1>
                <img src="images/book.png" class="alignright">
                <p>Tekst reklamnog prostora u kojem možete opisati reklamu</p>
                <p><a href="#">više..</a></p>
            </article>
            <article>
                <h1>Korisni linkovi</h1>
                <ul>
                    <?php if ($user && $user->canCreatePage()) echo '<li><a href="add_page.php">Dodaj novu objavu</a></li>'; ?>
                    <li><a href="#">Link 1</a></li>
                    <li><a href="#">Link 2</a></li>
                    <li><a href="#">Link 3</a></li>
                    <li><a href="#">Link 4</a></li>
                </ul>
            </article>
            <small>&copy; <?php echo date('Y'); ?> Prava...</a></small>
        </footer>
    </div>
</body>
</html>