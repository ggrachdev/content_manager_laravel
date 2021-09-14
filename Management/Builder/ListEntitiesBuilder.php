<?php

namespace Management\Builder;

use Management\Builder\FieldInListBuilder;
use Management\Utils\ClassNameAdapter;

class ListEntitiesBuilder {

    private array $entities = [];
    private string $nowEntity;

    public function addEntity(string $entityClassPath): self {

        $entityAlias = ClassNameAdapter::toString($entityClassPath);
        $this->nowEntity = $entityAlias;
        
        $this->entities[$entityAlias] = [
            'list_fields' => []
        ];
        return $this;
    }

    public function addField(string $propertyCode, $typeIntefaceClass): FieldInListBuilder {
        $listFieldBuilder = new FieldInListBuilder();
        $this->entities[$this->nowEntity]['list_fields'][$propertyCode] = [
            'type_class_path' => $typeIntefaceClass,
            'list_builder' => $listFieldBuilder
        ];
        return $listFieldBuilder;
    }

    public function getFieldsForEntity(string $entityClassPath) {

        $entityAlias = ClassNameAdapter::toString($entityClassPath);
        
        if (\array_key_exists($entityAlias, $this->entities)) {
            return $this->entities[$entityAlias];
        }
    }
}
