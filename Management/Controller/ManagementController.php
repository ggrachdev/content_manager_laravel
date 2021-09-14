<?php

namespace Management\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Management\CMS\Contract\CmsInterface;
use Management\View\CmsView;

class ManagementController extends Controller {

    public function dashboardScreen(CmsInterface $cms) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function listEntityScreen(CmsInterface $cms, $entity_code) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function showEditEntityScreen(CmsInterface $cms, $entity_code, $id) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function removeEntityData(CmsInterface $cms, $entity_code, $id) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function addEntityScreen(CmsInterface $cms, $entity_code) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function postNewEntityScreen(CmsInterface $cms, $entity_code) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    public function editEntityScreen(CmsInterface $cms, $entity_code, $id) {
        $cmsView = new CmsView($cms);
        $this->setParamsCmsView($cmsView);
        return $cmsView->generateHTML();
    }

    private function setParamsCmsView(CmsView $cmsView) {
        $cmsView->setParams('LOGO_TEXT', 'Агенство Недвижимости: <span class="font-bold">MReal</span>');
    }

}
