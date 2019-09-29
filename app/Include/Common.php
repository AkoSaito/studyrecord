<?php
namespace App\Include;
class Common
{
    public function formatDateSql($dateString){
        return $dateString . " " . "00:00:00";
    }
}
