<?php 
require('includes/utilities.inc.php');

////Preusmjeri ako user nema pravo pristupa
if (!$user->canCreatePage()) {
    header("Location:index.php");
    exit;
}  
  if (isset($_GET['id']))  {
  $edit_id=$_GET['id'];
  $q = "SELECT id, title, content, DATE_FORMAT(dateAdded, '%e %M %Y') AS dateAdded FROM pages WHERE id=$edit_id"; 
    $r = $pdo->query($q);
    
    //Ako ima redaka
    if ($r && $r->rowCount() > 0) {

        //Dohvati retke
        $r->setFetchMode(PDO::FETCH_CLASS, 'Page');
        $page = $r->fetch();
    }

  }  
//Stvori novu formu
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/local/pear/share/pear/');
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('editPageForm');

//Polje title
$id = $form->addElement('hidden', 'id');
$title = $form->addElement('text', 'title');
$title->setLabel('Naslov');
if (isset($_GET['id'])) { 
  $title->setValue($page->getTitle());
  $id->setValue($edit_id);
}
$title->addFilter('strip_tags');
$title->addRule('required', 'Molimo unesite naslov.');

//Polje content
$content = $form->addElement('textarea', 'content');
$content->setLabel('Sadržaj');
$content->addFilter('trim');
$content->addRule('required', 'Molimo unesite saržaj.');
if (isset($_GET['id']))  $content->setValue($page->getContent());

//Submit
$submit = $form->addElement('submit', 'submit', array('value'=>'Uredi'));

//Slanje
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    
    // Validacija
    if ($form->validate()) {
        //Update baze podataka
        $q = "UPDATE pages SET title=:title, content=:content WHERE id=:edit_id";
        $stmt = $pdo->prepare($q);
        //$stmt->bindParam(':title', $title->getValue(), PDO::PARAM_STR);
        //$stmt->bindParam(':content', $content->getValue(), PDO::PARAM_STR); 
        //$stmt->bindParam(':edit_id', $edit_id, PDO::PARAM_INT); 
        $r = $stmt->execute(array(':edit_id' => $id->getValue(), ':title' => $title->getValue(), ':content' => $content->getValue()));
        //$r=$stmt->execute(); 
        //Zamrzni
        if ($r) {
            $form->toggleFrozen(true); 
            $form->removeChild($submit);
        }
                
    } 
    
}

// Show the page:
$pageTitle = 'Uredi stranicu';
include('includes/header.inc.php');
include('views/edit_page.html');
include('includes/footer.inc.php');
?>