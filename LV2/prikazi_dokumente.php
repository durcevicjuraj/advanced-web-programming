<?php
$encryption_key = hash('sha256', 'moj_tajni_kljuc_2024');
$cipher = 'AES-256-CBC';
$metadata_files = glob('uploads_encrypted/meta_*.json');
?>

<h1>Prikaz dokumenata</h1>

<?php if (empty($metadata_files)): ?>
    <p>Nema dokumenata.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Naziv</th>
            <th>Datum</th>
            <th>Tip</th>
            <th>Akcija</th>
        </tr>
        <?php foreach ($metadata_files as $meta_file): ?>
            <?php $meta = json_decode(file_get_contents($meta_file), true); ?>
            <tr>
                <td><?php echo $meta['original_name']; ?></td>
                <td><?php echo $meta['upload_date']; ?></td>
                <td><?php echo $meta['extension']; ?></td>
                <td><a href="download.php?file=<?php echo $meta['encrypted_filename']; ?>">Preuzmi</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="upload_form.php">Natrag</a></p>