```php

public function register() {
      $this->app->singleton(CmsInterface::class, function ($app) {
          $request = app(\Illuminate\Http\Request::class);
          $cms = new CMS($request);

          $menuBuilder = $cms->getLeftMenuBuilder();            
          $menuBuilder->addLinkListEntity(User::class, 'Список пользователей');

          $menuBuilder->addLink('/management/dashboard', 'Панель управления');
          $menuBuilder->addLink('/', 'Перейти на сайт');
          $menuBuilder->addLink('//fredtm.ru', 'Перейти на fredtm.ru');

          $editor = $cms->getEditorEntitiesBuilder();
          $editor->addEntity(User::class);
          $editor->addField('email', EmailType::class)->required(true)->placeholder('Введите email пользователя')->label('Email пользователя');
          $editor->addField('name', TextType::class)->required(true)->placeholder('Введите имя пользователя');
          $editor->addField('password', PasswordType::class)->required(true)->placeholder('Введите пароль пользователя');

          $listBuilder = $cms->getListEntitiesBuilder();
          $listBuilder->addEntity(User::class);
          $listBuilder->addField('id', TextType::class)->columnName('ID пользователя');
          $listBuilder->addField('name', TextType::class)->columnName('Имя пользователя');
          $listBuilder->addField('email', EmailType::class)->columnName('Email пользователя');

          $cms->initializeDataProvider();

          return $cms;
      });
  }
