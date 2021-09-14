<?php

namespace Management\DataProvider;

use Management\Utils\ClassNameAdapter;
use Management\CMS\CMS;
use Management\CMS\Contract\CmsInterface;

/**
 * Поставляет данные в зависимости от маршрута
 */
final class CMSDataProvider {

    private $entityCode;
    private $entity;
    private $entityClassPath;
    private $routeName;
    private $cms;
    private $data = [];

    public function __construct(CmsInterface $cms) {
        $this->routeName = \Request::route()->getName();
        $this->cms = $cms;

        $router = \Request::route();

        switch ($this->getRouteName()) {

            // Удалить данные
            case CMS::NAME_ROUTE_REMOVE_DATA_ENTITY:
                $id = $router->parameters['id'];
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $this->entity = $this->entityClassPath::find($id);
                $this->entity->delete();
                break;

            // Список данных
            case CMS::NAME_ROUTE_LIST_ENTITIES:
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $entitiesListBuilder = $this->getCms()->getListEntitiesBuilder();
                $fields = $entitiesListBuilder->getFieldsForEntity($this->getEntityClassPath());
                $listEntities = $this->entityClassPath::all();

                $typeEntities = [];
                if (!empty($fields['list_fields'])) {
                    foreach ($listEntities as $entity) {
                        
                        $typeEntities[$entity->id] = [];
                        
                        foreach ($fields['list_fields'] as $propertyCode => $listBuilderData) {
                            $typeEntities[$entity->id][$propertyCode] = new $listBuilderData['type_class_path']($entity, $propertyCode, null, $listBuilderData['list_builder']);
                        }
                    }
                }

                $data = [
                    'list' => $listEntities,
                    'fields' => $fields,
                    'type_entities' => $typeEntities
                ];
                
                $this->data = $data;
                break;

            // Добавление новых данных
            case CMS::NAME_ROUTE_GET_ADD_ENTITY:
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $this->entity = new $this->entityClassPath();
                $entitiesBuilder = $this->getCms()->getEditorEntitiesBuilder();
                $fields = $entitiesBuilder->getFieldsForEntity($this->getEntityClassPath());

                $data = [];

                if (!empty($fields['editors_fields'])) {
                    foreach ($fields['editors_fields'] as $propCode => $fieldData) {
                        $editorBuilder = $fieldData['editor_builder'];
                        $type = new $fieldData['type_class_path']($this->getEntity(), $propCode, $editorBuilder);
                        $data[] = [
                            'type' => $type
                        ];
                    }
                }
                $this->data = $data;
                break;

            case CMS::NAME_ROUTE_POST_ADD_ENTITY:
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $this->entity = new $this->entityClassPath();
                $entitiesBuilder = $this->getCms()->getEditorEntitiesBuilder();
                $fields = $entitiesBuilder->getFieldsForEntity($this->getEntityClassPath());

                $data = [];

                if (!empty($fields['editors_fields'])) {
                    foreach ($fields['editors_fields'] as $propCode => $fieldData) {
                        $editorBuilder = $fieldData['editor_builder'];
                        $type = new $fieldData['type_class_path']($this->getEntity(), $propCode, $editorBuilder);
                        $newValue = $type->getNewValueFromRequest($this->getCms()->getRequest());
                        $type->setNewValue($newValue);
                        $data[] = [
                            'type' => $type
                        ];
                    }
                    $saved = $this->getEntity()->save();

                    if ($saved) {
                        $id = $this->getEntity()->id;
                        $redirectUrl = route(CMS::NAME_ROUTE_GET_EDIT_ENTITY, [
                            'entity_code' => $this->getEntityCode(),
                            'id' => $id
                        ]);
                        header("Location:" . $redirectUrl);
                        die;
                    }
                }
                $this->data = $data;
                break;

            // Редактирование данных
            case CMS::NAME_ROUTE_GET_EDIT_ENTITY:
                $id = $router->parameters['id'];
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $this->entity = $this->entityClassPath::find($id);
                $entitiesBuilder = $this->getCms()->getEditorEntitiesBuilder();
                $fields = $entitiesBuilder->getFieldsForEntity($this->getEntityClassPath());

                $data = [];

                if (!empty($fields['editors_fields'])) {
                    foreach ($fields['editors_fields'] as $propCode => $fieldData) {
                        $editorBuilder = $fieldData['editor_builder'];
                        $type = new $fieldData['type_class_path']($this->getEntity(), $propCode, $editorBuilder);
                        $data[] = [
                            'type' => $type
                        ];
                    }
                }
                $this->data = $data;
                break;

            case CMS::NAME_ROUTE_POST_EDIT_ENTITY:
                $router = \Request::route();
                $id = $router->parameters['id'];
                $this->entityCode = $router->parameters['entity_code'];
                $this->entityClassPath = ClassNameAdapter::fromString($this->entityCode);
                $this->entity = $this->entityClassPath::find($id);
                $entitiesBuilder = $this->getCms()->getEditorEntitiesBuilder();
                $fields = $entitiesBuilder->getFieldsForEntity($this->getEntityClassPath());

                $data = [];

                if (!empty($fields['editors_fields'])) {
                    foreach ($fields['editors_fields'] as $propCode => $fieldData) {
                        $editorBuilder = $fieldData['editor_builder'];
                        $type = new $fieldData['type_class_path']($this->getEntity(), $propCode, $editorBuilder);
                        $newValue = $type->getNewValueFromRequest($this->getCms()->getRequest());
                        $type->setNewValue($newValue);
                        $data[] = [
                            'type' => $type
                        ];
                    }
                    $saved = $this->getEntity()->update();

                    if ($saved) {
                        $id = $this->getEntity()->id;
                        $redirectUrl = route(CMS::NAME_ROUTE_GET_EDIT_ENTITY, [
                            'entity_code' => $this->getEntityCode(),
                            'id' => $id
                        ]);
                        header("Location:" . $redirectUrl);
                        die;
                    }
                }
                $this->data = $data;
                break;
        }
    }

    public function getData() {
        return $this->data;
    }

    public function getCms() {
        return $this->cms;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getEntityCode() {
        return $this->entityCode;
    }

    public function getEntityClassPath() {
        return $this->entityClassPath;
    }

    public function getRouteName() {
        return $this->routeName;
    }

}
