<?php

namespace Management\Type;

use Management\Type\Contract\TypeInterface;
use Management\Builder\EditorFieldBuilder;
use Management\Builder\FieldInListBuilder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PasswordType implements TypeInterface {

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
        return view('management.type.password.list_field', [
            'value' => $this->getValue(),
        ])->render();
    }

    public function generateHtmlField(): ?string {
        $editorField = $this->getEditorFieldBuilder();
        $view = view('management.type.password.edit_field', [
            'is_required' => $editorField->isRequired(),
            'name' => $this->fieldCode,
            'placeholder' => $editorField->getPlaceholder(),
            'value' => $this->getValue(),
            'label' => $editorField->getLabel()
        ])->render();
        return $view;
    }

    public function getNewValueFromRequest(Request $request) {
        return $request->get($this->fieldCode);
    }

    public function getValue() {
        return $this->entityObject->{$this->fieldCode};
    }

    public function setNewValue($newValue) {
        $oldValue = $this->getValue();
        if ($newValue != $oldValue) {
            $this->entityObject->{$this->fieldCode} = Hash::make($newValue);
        }
    }

    public function getEditorFieldBuilder(): ?EditorFieldBuilder {
        return $this->editorFieldBuilder;
    }

    public function getFieldInListBuilder(): ?FieldInListBuilder {
        return $this->fieldInListBuilder;
    }

}
