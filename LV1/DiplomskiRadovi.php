<?php

require('iRadovi.php');


class DiplomskiRadovi implements iRadovi{

    public $naziv_rada;
    public $tekst_rada;
    public $link_rada;
    public $oib_tvrtke;

    public function create($data) {
        $this->naziv_rada = $data['naziv_rada'];
        $this->tekst_rada = $data['tekst_rada'];
        $this->link_rada = $data['link_rada'];
        $this->oib_tvrtke = $data['oib_tvrtke'];
    }

    public function save() {
    }

    public function read() {
        return array(
            'naziv_rada' => $this->naziv_rada,
            'tekst_rada' => $this->tekst_rada,
            'link_rada' => $this->link_rada,
            'oib_tvrtke' => $this->oib_tvrtke
        );
    }

}

?>