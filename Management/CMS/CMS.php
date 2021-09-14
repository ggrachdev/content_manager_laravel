<?php

namespace Management\CMS;

use Management\CMS\Contract\CmsInterface;
use Illuminate\Http\Request;
use Management\Builder\MenuBuilder;
use Management\DataProvider\CMSDataProvider;
use Management\Builder\EditorEntitiesBuilder;
use Management\Builder\ListEntitiesBuilder;

/**
 * Description of CMS
 *
 * @author ggrachdev
 */
final class CMS implements CmsInterface {
    
    // Маршрут отображение экрана с формой добавления новых данных сущности
    public const NAME_ROUTE_GET_ADD_ENTITY = 'addNewEntityManagementScreen';
    
    // Маршрут отображение экрана с отправкой формы добавления новых данных сущности
    public const NAME_ROUTE_POST_ADD_ENTITY = 'postNewEntityManagementScreen';
    
    // Маршруты отображения данных формы редактирования сущности
    public const NAME_ROUTE_GET_EDIT_ENTITY = 'getEditEntityManagementScreen';
    
    // Маршруты отправки данных формы редактирования сущности
    public const NAME_ROUTE_POST_EDIT_ENTITY = 'editEntityManagementScreen';
    
    // Маршрут отображение экрана со списком всех данных сущности
    public const NAME_ROUTE_LIST_ENTITIES = 'listEntitiesManagementScreen';
    
    // Удаление данных
    public const NAME_ROUTE_REMOVE_DATA_ENTITY = 'removeEntityManagementScreen';

    private MenuBuilder $menuBuilder;
    private CMSDataProvider $cmsDataProvider;
    private EditorEntitiesBuilder $editorEntitiesBuilder;
    private ListEntitiesBuilder $listEntitiesBuilder;
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->menuBuilder = new MenuBuilder();
        $this->editorEntitiesBuilder = new EditorEntitiesBuilder();
        $this->listEntitiesBuilder = new ListEntitiesBuilder();
    }

    public function initializeDataProvider() {
        $dataProvider = new CMSDataProvider($this);
        $this->cmsDataProvider = $dataProvider;
    }

    public function getLeftMenuBuilder(): MenuBuilder {
        return $this->menuBuilder;
    }

    public function getDataProvider(): CMSDataProvider {
        return $this->cmsDataProvider;
    }

    public function getEditorEntitiesBuilder(): EditorEntitiesBuilder {
        return $this->editorEntitiesBuilder;
    }

    public function getListEntitiesBuilder(): ListEntitiesBuilder {
        return $this->listEntitiesBuilder;
    }
    
    public function getRequest(): Request {
        return $this->request;
    }

}
