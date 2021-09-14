<?php

namespace Management\View;

use Management\CMS\Contract\CmsInterface;
use Management\CMS\CMS;
use Management\Builder\MenuBuilder;

final class CmsView {

    private CmsInterface $cms;
    private array $params = [
        'TITLE' => 'Fred CMS',
        'LOGO_TEXT' => 'Fred CMS'
    ];

    public function __construct(CmsInterface $cms) {
        $this->cms = $cms;
    }

    public function setParams(string $key, string $value) {
        $this->params[$key] = $value;
        return $this;
    }

    public function generateHTML(): ?string {
        return \view('management/base', array_merge([
            'menu' => $this->generateLeftMenu(),
            'work_region' => $this->generateRightSection()
        ], $this->params));
    }

    public function getCms(): CmsInterface {
        return $this->cms;
    }

    private function generateLeftMenu(): ?string {
        return $this->getCms()->getLeftMenuBuilder()->getHtml();
    }

    private function generateRightSection(): ?string {
        $nameNowRoute = $this->getCms()->getDataProvider()->getRouteName();
        $view = '';

        switch ($nameNowRoute) {
            case CMS::NAME_ROUTE_LIST_ENTITIES:
                $view = $this->generateHtmlListEntities();
                break;

            case CMS::NAME_ROUTE_GET_ADD_ENTITY;
                $view = $this->generateHtmlScreenNewEntity();
                break;

            case CMS::NAME_ROUTE_POST_ADD_ENTITY:
                $view = $this->generateHtmlScreenPostNewEntity();
                break;

            case CMS::NAME_ROUTE_GET_EDIT_ENTITY:
                $view = $this->generateHtmlScreenEditEntity();
                break;
        }
        return $view;
    }

    private function generateHtmlListEntities() {
        $dataProvider = $this->getCms()->getDataProvider();
        $data = $dataProvider->getData();

        $viewColumns = '';

        if (!empty($data['fields']['list_fields'])) {
            $viewColumns .= '<tr class="text-left text-gray-400">';
            foreach ($data['fields']['list_fields'] as $listField) {
                $viewColumns .= "<th class=\"pr-5\">{$listField['list_builder']->getColumnName()}</th>";
            }

            $viewColumns .= '<th>Операции</th>';
            $viewColumns .= '</tr>';
        }

        $viewRows = '';

        if (!empty($data['fields']['list_fields'])) {
            foreach ($data['type_entities'] as $idEntity => $typesEntity) {
                $viewRows .= '<tr>';
                foreach ($typesEntity as $propCode => $typeEntity) {
                    $viewRows .= "<th class=\"pr-5 pb-5 pt-5\">{$typeEntity->generateHtmlFieldList()}</th>";
                }

                $linkEdit = MenuBuilder::getLinkEditEntity($dataProvider->getEntityCode(), $idEntity);
                $linkRemoveEntity = MenuBuilder::getLinkRemoveEntity($dataProvider->getEntityCode(), $idEntity);
                
                $viewRows .= "<th>"
                    . "<a class=\"inline-block pr-3\" target=\"_blank\" href=\"$linkEdit\">Редактировать</a>"
                    . "<a onclick=\"removeConfirm('$linkRemoveEntity', 'Вы действительно хотите удалить {$dataProvider->getEntityCode()} с id = {$idEntity} ?')\" class=\"inline-block pr-1\" href=\"#\">Удалить</a></th>";
                $viewRows .= '</tr>';
            }
        }
        
        $linkAddNew = MenuBuilder::getLinkAddEntity($dataProvider->getEntityCode());
        
        return "
            <h1 class=\"mb-5\">Экран данных - {$dataProvider->getEntityClassPath()}</h1>
            <a target=\"_blank\" href=\"$linkAddNew\" class=\"bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 mb-5 inline-block rounded focus:outline-none focus:shadow-outline\">Добавить</a>
            <table class=\"table-auto\">
            <thead>
                $viewColumns
            </thead>
            <tbody>
              $viewRows
            </tbody>
          </table>
        ";
    }

    private function generateHtmlScreenEditEntity() {
        $dataProvider = $this->getCms()->getDataProvider();
        $data = $dataProvider->getData();
        $idEntity = $dataProvider->getEntity()->id;

        $view = "<h1 class=\"mb-5\">Экран редактирования данных - {$dataProvider->getEntityClassPath()} ID=$idEntity</h1>";
        $view .= '<form name="add_new_data_entity" action="' . route(CMS::NAME_ROUTE_POST_EDIT_ENTITY, ['entity_code' => $dataProvider->getEntityCode(), 'id' => $idEntity]) . '" method="post">';

        if (!empty($data)) {
            $view .= '<div class="flex flex-wrap">';
            foreach ($data as $dataField) {
                $view .= $dataField['type']->generateHtmlField();
            }
            $view .= '</div>';
        }

        $view .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $view .= '<button class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Изменить</button>';
        $view .= '</form>';

        return $view;
    }

    private function generateHtmlScreenPostNewEntity() {
        $dataProvider = $this->getCms()->getDataProvider();
        $data = $dataProvider->getData();

        $view = "<h1 class=\"mb-5\">Экран обработки добавления новых данных - {$dataProvider->getEntityClassPath()}</h1>";
        $view .= '<form name="add_new_data_entity" action="' . route(CMS::NAME_ROUTE_POST_ADD_ENTITY, ['entity_code' => $dataProvider->getEntityCode()]) . '" method="post">';

        if (!empty($data)) {
            $view .= '<div class="flex flex-wrap">';
            foreach ($data as $dataField) {
                $view .= $dataField['type']->generateHtmlField();
            }
            $view .= '</div>';
        }

        $view .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $view .= '<button class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Добавить</button>';
        $view .= '</form>';

        return $view;
    }

    private function generateHtmlScreenNewEntity() {
        $dataProvider = $this->getCms()->getDataProvider();
        $data = $dataProvider->getData();

        $view = "<h1 class=\"mb-5\">Экран добавления новых данных - {$dataProvider->getEntityClassPath()}</h1>";
        $view .= '<form name="add_new_data_entity" action="' . route(CMS::NAME_ROUTE_POST_ADD_ENTITY, ['entity_code' => $dataProvider->getEntityCode()]) . '" method="post">';

        if (!empty($data)) {
            $view .= '<div class="flex flex-wrap">';
            foreach ($data as $dataField) {
                $view .= $dataField['type']->generateHtmlField();
            }
            $view .= '</div>';
        }

        $view .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $view .= '<button class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Добавить</button>';
        $view .= '</form>';

        return $view;
    }

}
