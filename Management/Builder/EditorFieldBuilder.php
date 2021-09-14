<?php

namespace Management\Builder;

/**
 * Description of EditorFieldBuilder
 */
class EditorFieldBuilder {
    
    private bool $required = false;
    private string $label = '';
    private string $description = '';
    private string $width = '';
    private string $height = '';
    private string $placeholder = '';
    
    public function __construct() {
    }
    
    public function getPlaceholder(): string {
        return $this->placeholder;
    }
        
    public function placeholder(string $placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }
        
    public function required(bool $isRequiredField) {
        $this->required = $isRequiredField;
        return $this;
    }
    
    public function label(string $label) {
        $this->label = $label;
        return $this;
    }
    
    public function description(string $description) {
        $this->description = $description;
        return $this;
    }
    
    public function width(string $width) {
        $this->width = $width;
        return $this;
    }
    
    public function height(string $height) {
        $this->height = $height;
        return $this;
    }
    
    public function isRequired(): bool {
        return $this->required === true;
    }

    public function getLabel(): string {
        return $this->label ? $this->label : $this->placeholder;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getWidth(): string {
        return $this->width;
    }

    public function getHeight(): string {
        return $this->height;
    }

}
