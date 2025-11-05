<h1>Upload i kriptiranje dokumenata</h1>

<p><strong>Informacije:</strong></p>
<ul>
    <li>Dozvoljeni formati: PDF, JPEG, PNG</li>
    <li>Maksimalna veličina: 5 MB</li>
</ul>

<form action="upload_handler.php" method="post" enctype="multipart/form-data">
    <label>Odaberite dokument:</label><br>
    <input type="file" name="dokument" accept=".pdf,.jpg,.jpeg,.png" required><br><br>
    <input type="submit" value="Upload i kriptiraj">
</form>

<p><a href="prikazi_dokumente.php">Pregled dokumenata</a></p>