<?php

namespace Management\CMS\Contract;

// @todo - запрос заменить на адаптер, чтобы не зависеть от ларавела
use Illuminate\Http\Request;
use Management\Builder\MenuBuilder;
use Management\Builder\ListEntitiesBuilder;
use Management\Builder\EditorEntitiesBuilder;
use Management\DataProvider\CMSDataProvider;

interface CmsInterface {
    public function __construct(Request $request);
    public function getLeftMenuBuilder(): MenuBuilder;
    public function getListEntitiesBuilder(): ListEntitiesBuilder;
    public function getEditorEntitiesBuilder(): EditorEntitiesBuilder;
    public function getDataProvider(): CMSDataProvider;
    public function getRequest(): Request;
}
