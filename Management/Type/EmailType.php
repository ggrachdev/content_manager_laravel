<?php

namespace Management\Type;

use Management\Type\Contract\TypeInterface;
use Management\Builder\EditorFieldBuilder;
use Management\Builder\FieldInListBuilder;
use Illuminate\Http\Request;

class EmailType implements TypeInterface {

    private $entityObject;
    private $fieldCode;
    private $editorFieldBuilder;
    private $fieldInListBuilder;

    public function __construct($entityObject, string $fieldCode, ?EditorFieldBuilder $editorFieldBuilder = null, ?FieldInListBuilder $fieldInListBuilder = null) {
        $this->entityObject = $entityObject;
        $this->fieldCode = $fieldCode;
        $this->editorFieldBuilder = $editorFieldBuilder;
        $this->fieldInListBuilder = $fieldInListBuilder;
    }

    public function generateHtmlFieldList(): ?string {
        return view('management.type.email.list_field', [
            'value' => $this->getValue(),
        ])->render();
    }
    
    public function generateHtmlField(): ?string {
        $editorField = $this->getEditorFieldBuilder();
        
        return view('management.type.email.edit_field', [
            'is_required' => $editorField->isRequired(),
            'name' => $this->fieldCode,
            'placeholder' => $editorField->getPlaceholder(),
            'value' => $this->getValue(),
            'label' => $editorField->getLabel()
        ])->render();
    }

    public function getNewValueFromRequest(Request $request) {
        return $request->get($this->fieldCode);
    }

    public function getValue() {
        return $this->entityObject->{$this->fieldCode};
    }

    public function setNewValue($newValue) {
        $this->entityObject->{$this->fieldCode} = $newValue;
    }

    public function getEditorFieldBuilder(): ?EditorFieldBuilder {
        return $this->editorFieldBuilder;
    }

    public function getFieldInListBuilder(): ?FieldInListBuilder {
        return $this->fieldInListBuilder;
    }

}
