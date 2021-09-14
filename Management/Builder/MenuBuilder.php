<?php

namespace Management\Builder;

use Management\Utils\ClassNameAdapter;

class MenuBuilder {

    private array $links = [];

    public function addLink(string $link, string $name) {
        $this->links[] = [
            'link' => $link,
            'name' => $name
        ];
    }

    public static function getLinkAddEntity(string $classNameEntity) {
        return '/' . env('ADMIN_PREFIX', 'management') . '/add/' . ClassNameAdapter::toString($classNameEntity) . '/';
    }

    public function addLinkAddEntity(string $classNameEntity, string $name) {
        $this->addLink(
            self::getLinkAddEntity($classNameEntity),
            $name
        );
    }

    public static function getLinkListEntity(string $classNameEntity) {
        return '/' . env('ADMIN_PREFIX', 'management') . '/list/' . ClassNameAdapter::toString($classNameEntity) . '/';
    }

    public function addLinkListEntity(string $classNameEntity, string $name) {
        $this->addLink(
            self::getLinkListEntity($classNameEntity),
            $name
        );
    }

    public static function getLinkEditEntity(string $classNameEntity, string $id) {
        return '/' . env('ADMIN_PREFIX', 'management') . '/edit/' . ClassNameAdapter::toString($classNameEntity) . '/' . $id;
    }

    public function addLinkEditEntity(string $classNameEntity, string $id, string $name) {
        $this->addLink(
            self::getLinkEditEntity($classNameEntity, $id),
            $name
        );
    }

    public static function getLinkRemoveEntity(string $classNameEntity, string $id) {
        return '/' . env('ADMIN_PREFIX', 'management') . '/remove/' . ClassNameAdapter::toString($classNameEntity) . '/' . $id;
    }

    public function getLinks(): array {
        return $this->links;
    }

    public function getHtml(): ?string {
        if (!empty($this->getLinks())) {
            $view = '<ul>';
            $nowUrl = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
            foreach ($this->getLinks() as $link) {
                $isActive = $nowUrl === rtrim($link['link'], '/');
                if ($isActive) {
                    $view .= '<li class="bg-white p-2 rounded-l-lg"><a href="' . $link['link'] . '">' . $link['name'] . '</a></li>';
                } else {
                    $view .= '<li class="p-2"><a href="' . $link['link'] . '">' . $link['name'] . '</a></li>';
                }
            }
            $view .= '</ul>';

            return $view;
        }

        return null;
    }

}
