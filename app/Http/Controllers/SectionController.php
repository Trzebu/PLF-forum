<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;

final class SectionController extends Controller {

    public function viewCategories ($sectionId) {
        $section = new Section();
        $this->view->categories = null;

        if ($section->getSectionCategories($sectionId) !== null) {
            $this->view->categories = $section->getSectionCategories($sectionId);
            $this->view->section_details = $section->getSection($sectionId);
        }

        $this->view->render("section.viewCategories");
    }

}