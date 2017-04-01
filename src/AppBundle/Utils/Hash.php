<?php
namespace AppBundle\Utils;


class Hash {

    public function generateHash($length){
        return substr(str_shuffle(base64_encode(random_bytes($length))), 0, $length);
    }
}