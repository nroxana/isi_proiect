<?php

class User {
    public function __construct()
    {
        if (isset($_POST["add_line_btn"])) {
            $this->AddLine();
        }
        if (isset($_POST["del_line_btn"])) {
            $this->DeleteLine();
        }
        if (isset($_POST["export_btn"])) {
            $this->Export();
        }
    }
    
    private function AddLine(){
    
    }
    private function DeleteLine(){
    
    }
    private function Export(){
    
    }
}