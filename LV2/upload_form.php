<h1>Upload i kriptiranje dokumenata</h1>


<form action="upload_handler.php" method="post" enctype="multipart/form-data">
    <label>Odaberite dokument:</label><br>
    <input type="file" name="dokument" accept=".pdf,.jpg,.jpeg,.png" required><br><br>
    <input type="submit" value="Upload i kriptiraj">
</form>

<p><a href="prikazi_dokumente.php">Pregled dokumenata</a></p>