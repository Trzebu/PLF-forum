<?php
namespace Libs;
use Libs\DataBase\DataBase;
use Libs\TimeConverter;

class Model extends DataBase {

    protected $_table = null;

    public function __construct () {
        parent::__construct();
    }

    public function diffToHuman ($time) {
        return TimeConverter::diffToHuman($time);
    }

    public function dateTimeAlphaMonth ($date) {
        return TimeConverter::dateTimeWithAlphaMonth($date);
    }

    public function paginateRender () {
        require_once(__ROOT__ . "/libs/templates/paginate.php");
    }

}