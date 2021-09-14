<?php

use Illuminate\Support\Facades\Route;
use Management\Controller\ManagementController;
use Management\CMS\CMS;

Route::group(['prefix' => env('ADMIN_PREFIX', 'management')], function () {
    // Панель управления
    Route::get('/dashboard', [ManagementController::class, 'dashboardScreen'])->name('dashboardManagementScreen');
    
    // Редактирование сущностей
    Route::get('/edit/{entity_code}/{id}', [ManagementController::class, 'showEditEntityScreen'])->name(CMS::NAME_ROUTE_GET_EDIT_ENTITY);
    Route::post('/edit/{entity_code}/{id}', [ManagementController::class, 'editEntityScreen'])->name(CMS::NAME_ROUTE_POST_EDIT_ENTITY);
    
    // Добавление новых данных сущности
    Route::get('/add/{entity_code}', [ManagementController::class, 'addEntityScreen'])->name(CMS::NAME_ROUTE_GET_ADD_ENTITY);
    Route::post('/add/{entity_code}', [ManagementController::class, 'postNewEntityScreen'])->name(CMS::NAME_ROUTE_POST_ADD_ENTITY);
    
    // Список данных сущности
    Route::get('/list/{entity_code}', [ManagementController::class, 'listEntityScreen'])->name(CMS::NAME_ROUTE_LIST_ENTITIES);
    
    // Удаление данных сущности
    Route::get('/remove/{entity_code}/{id}', [ManagementController::class, 'removeEntityData'])->name(CMS::NAME_ROUTE_REMOVE_DATA_ENTITY);
});