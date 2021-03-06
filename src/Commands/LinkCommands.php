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

namespace Studosi\Alexandria\Commands\LinkCommands;

use Flarum\User\User;

class CreateLink
{
    public $actor;
    public $data;

    public function __construct(User $actor, array $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }
}

class DeleteLink
{
    public $link_id;
    public $actor;

    public function __construct($link_id, User $actor)
    {
        $this->link_id = $link_id;
        $this->actor = $actor;
    }
}

class UpdateLink
{
    public $link_id;

    public $actor;
    public $data;

    public function __construct($link_id, User $actor, array $data)
    {
        $this->link_id = $link_id;
        $this->actor = $actor;
        $this->data = $data;
    }
}
