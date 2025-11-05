<?php 
//Stranica prikazuje formu za dodavanje stranice

require('includes/utilities.inc.php');

//Preusmjeri ako user nema pravo pristupa
if (!$user->canCreatePage()) {
    header("Location:index.php");
    exit;
}
    
//Stvori novu formu
//Direktorij gdje je instaliran QuickForm2
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/local/pear/share/pear/');
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('addPageForm');

//Polje title
$title = $form->addElement('text', 'title');
$title->setLabel('Naslov');
$title->addFilter('strip_tags');
$title->addRule('required', 'Molimo unesite naslov.');

//Polje content 
$content = $form->addElement('textarea', 'content');
$content->setLabel('Sadržaj');
$content->addFilter('trim');
$content->addRule('required', 'Molimo unesite sadržaj.');

//Gumb submit
$submit = $form->addElement('submit', 'submit', array('value'=>'Dodaj'));

//Ako je forma submitana
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    
    // Validacija podataka
    if ($form->validate()) {
        
        //Unos u bazu
        $q = 'INSERT INTO pages (creatorId, title, content, dateAdded) VALUES (:creatorId, :title, :content, NOW())';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':creatorId' => $user->getId(), ':title' => $title->getValue(), ':content' => $content->getValue()));

        //Zamrzni formu nakon unosa
        if ($r) {
            $form->toggleFrozen(true);
            $form->removeChild($submit);
        }
                
    } 
    
}

//Prikaži stranicu
$pageTitle = 'Dodaj stranicu';
include('includes/header.inc.php');
include('views/add_page.html');
include('includes/footer.inc.php');
?>