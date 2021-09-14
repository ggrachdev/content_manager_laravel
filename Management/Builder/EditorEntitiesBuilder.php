<?php

namespace Management\Builder;

use Management\Builder\EditorFieldBuilder;
use Management\Utils\ClassNameAdapter;

/**
 * Description of EditorEntitiesBuilder
 *
 * @author ggrachdev
 */
class EditorEntitiesBuilder {

    private array $entities = [];
    private string $nowEntity;

    public function addEntity(string $entityClassPath): self {

        $entityAlias = ClassNameAdapter::toString($entityClassPath);
        $this->nowEntity = $entityAlias;
        
        $this->entities[$entityAlias] = [
            'editors_fields' => []
        ];
        return $this;
    }

    public function addField(string $propertyCode, $typeIntefaceClass): EditorFieldBuilder {
        $editorFieldBuilder = new EditorFieldBuilder();
        $this->entities[$this->nowEntity]['editors_fields'][$propertyCode] = [
            'type_class_path' => $typeIntefaceClass,
            'editor_builder' => $editorFieldBuilder
        ];
        return $editorFieldBuilder;
    }

    public function getFieldsForEntity(string $entityClassPath) {

        $entityAlias = ClassNameAdapter::toString($entityClassPath);
        
        if (\array_key_exists($entityAlias, $this->entities)) {
            return $this->entities[$entityAlias];
        }
    }

}
