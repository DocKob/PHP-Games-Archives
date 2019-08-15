<?php

class NameAlreadyInUseException extends Exception {
    function NameAlreadyInUseException($msg=""){
        Exception::__construct($msg);
    }
}