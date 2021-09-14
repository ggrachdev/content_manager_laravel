<?php

namespace Management\Builder;

class FieldInListBuilder {
    
    private bool $required = false;
    private string $columnName = '';
    private string $description = '';
    private string $width = '';
    private string $height = '';
    
    public function __construct() {
    }
        
    public function required(bool $isRequiredField) {
        $this->required = $isRequiredField;
        return $this;
    }
    
    public function columnName(string $columnName) {
        $this->columnName = $columnName;
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

    public function getColumnName(): string {
        return $this->columnName;
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
