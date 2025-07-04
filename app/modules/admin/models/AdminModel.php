<?php

require_once (__DIR__ . '/../../../core/Model.php');

class AdminModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

}

?>