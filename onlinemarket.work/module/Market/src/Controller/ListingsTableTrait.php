<?php
declare(strict_types=1);
namespace Market\Controller;
use Model\Table\ListingsTable;
trait ListingsTableTrait
{
    public $table;
    public function setListingsTable(ListingsTable $table)
    {
        $this->table = $table;
    }
}
