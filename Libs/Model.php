<?php
namespace Libs;
use Libs\DataBase\DataBase;
use Libs\TimeConverter;

class Model extends DataBase {

    protected $_table = null;

    public function __construct () {
        parent::__construct();
    }

    public function calcTimeDiff ($time) {
        return TimeConverter::calcTimeDifference($time);
    }

    public function diffToHuman ($time) {
        return TimeConverter::diffToHuman($time);
    }

    public function dateTimeAlphaMonth ($date, $short_notation = false) {
        return TimeConverter::dateTimeWithAlphaMonth($date, $short_notation);
    }

    public function paginateRender () {
        require_once(__ROOT__ . "/Libs/templates/paginate.php");
    }

}