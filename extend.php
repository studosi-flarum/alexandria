<?php

/*
 * Copyright 2020 Studosi
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Studosi\Alexandria;

use Flarum\Extend;
use Studosi\Alexandria\Api\Controllers\LinkControllers\{
    CreateLinkController,
    DeleteLinkController,
    ListLinksController,
    UpdateLinkController,
};
use Studosi\Alexandria\Api\Controllers\ScopeControllers\{
    CreateScopeController,
    DeleteScopeController,
    ListScopesController,
    UpdateScopeController,
};

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\Routes('api'))
        ->get(
            '/studosi-alexandria_links',
            'studosi-alexandria_links.index',
            ListLinksController::class,
        )
        ->get(
            '/studosi-alexandria_scopes',
            'studosi-alexandria_scopes.index',
            ListScopesController::class,
        )
        ->post(
            '/studosi-alexandria_links',
            'studosi-alexandria_links.create',
            CreateLinkController::class,
        )
        ->post(
            '/studosi-alexandria_scopes',
            'studosi-alexandria_scopes.create',
            CreateScopeController::class,
        )
        ->delete(
            '/studosi-alexandria_links/{id}',
            'studosi-alexandria_links.delete',
            DeleteLinkController::class,
        )
        ->delete(
            '/studosi-alexandria_scope/{id}',
            'studosi-alexandria_scopes.delete',
            DeleteScopeController::class,
        )
        ->patch(
            '/studosi-alexandria_links/{id}',
            'studosi-alexandria_links.update',
            UpdateLinkController::class,
        )
        ->patch(
            '/studosi-alexandria_scopes/{id}',
            'studosi-alexandria_scopes.update',
            UpdateScopeController::class,
        ),
];
