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

namespace Studosi\Alexandria\Commands\ScopeCommands;

use Flarum\User\User;

class CreateScope
{
    public $actor;
    public $data;

    public function __construct(User $actor, array $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }
}

class DeleteScope
{
    public $link_id;
    public $actor;

    public function __construct($scope_id, User $actor)
    {
        $this->scope_id = $scope_id;
        $this->actor = $actor;
    }
}

class UpdateScope
{
    public $scope_id;

    public $actor;
    public $data;

    public function __construct($scope_id, User $actor, array $data)
    {
        $this->scope_id = $scope_id;
        $this->actor = $actor;
        $this->data = $data;
    }
}
