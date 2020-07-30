<?php

/*
 * This file is part of studosi/alexandria.
 *
 * Copyright (c) 2020 Studosi.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Studosi\Alexandria;

use Flarum\Extend;
use Studosi\Alexandria\Api\Controllers\LinkControllers\{
    CreateLinkController,
    DeleteLinkController,
    ListRulesController,
    UpdateLinkController,
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
            ListRulesController::class,
        )
        ->post(
            '/studosi-alexandria_links',
            'studosi-alexandria_links.create',
            CreateLinkController::class,
        )
        ->delete(
            '/studosi-alexandria_links/{id}',
            'studosi-alexandria_links.delete',
            DeleteLinkController::class,
        )
        ->patch(
            '/studosi-alexandria_links/{id}',
            'studosi-alexandria_links.update',
            UpdateLinkController::class,
        ),
];
