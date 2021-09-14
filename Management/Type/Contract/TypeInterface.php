<?php

namespace Management\Type\Contract;

use Illuminate\Http\Request;
use Management\Builder\EditorFieldBuilder;
use Management\Builder\FieldInListBuilder;

interface TypeInterface {
    public function __construct($entityObject, string $fieldCode, EditorFieldBuilder $editorFieldBuilder);
    
    public function generateHtmlField(): ?string;
    
    public function generateHtmlFieldList(): ?string;
    
    public function setNewValue($newValue);
    
    public function getValue();
    
    public function getNewValueFromRequest(Request $request);
    
    public function getEditorFieldBuilder(): ?EditorFieldBuilder;
    
    public function getFieldInListBuilder(): ?FieldInListBuilder;
}
