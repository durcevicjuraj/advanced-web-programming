<?php 
/*  Atributi: id, userType, username, email, pass, and dateAdded.
 *  Metode: 
 *  - getId()
 *  - isAdmin()
 *  - canEditPage()
 *  - canCreatePage()
 */
class User {
    
    protected $id = null;
    protected $userType = null;
    protected $username = null;
    protected $email = null;
    protected $pass = null;
    protected $dateAdded = null;
    
    //Vraća user ID
    function getId() {
        return $this->id;
    }
    
    // Je li user administrator
    function isAdmin() {
        return ($this->userType == 'admin');
    }
    
    //Je li user administrator ili autor
    function canEditPage(Page $page) {
        return ($this->isAdmin() || ($this->id == $page->getCreatorId()));
    }
    
    //Je li user administrator ili autor
    function canCreatePage() {
        return ($this->isAdmin() || ($this->userType == 'author'));
    }
    
}