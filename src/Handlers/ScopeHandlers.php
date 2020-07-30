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

namespace Studosi\Alexandria\Handlers\ScopeHandlers;

use Flarum\User\AssertPermissionTrait;
use Studosi\Alexandria\Commands\ScopeCommands\{CreateScope, DeleteScope, UpdateScope};
use Studosi\Alexandria\Scope;
use Studosi\Alexandria\Validators\ScopeValidator;

class CreateScopeHandler
{
    use AssertPermissionTrait;

    protected $validator;

    public function __construct(ScopeValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(CreateScope $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $this->assertAdmin($actor);
        $attributes = array_get($data, "attributes", []);

        $scope = Scope::build(
            $attributes["type"],
            $attributes["upload_path"],
            $attributes["download_path"],
            $attributes["nick"],
        );

        $this->validator->assertValid($scope->getAttributes());
        $scope->save();

        return $scope;
    }
}

class DeleteScopeHandler
{
    use AssertPermissionTrait;

    public function handle(DeleteScope $command)
    {
        $actor = $command->actor;
        $this->assertAdmin($actor);

        $scope = Scope::where("id", $command->scope_id)->firstOrFail();
        $scope->delete();

        return $scope;
    }
}

class UpdateScopeHandler
{
    use AssertPermissionTrait;

    protected $validator;

    public function __construct(ScopeValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(UpdateScope $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $attributes = array_get($data, "attributes", []);
        $validate = [];

        $this->assertAdmin($actor);

        $scope = Scope::where("id", $command->scope_id)->firstOrFail();

        if (isset($attributes["type"]) && "" !== $attributes["type"]) {
            $validate["type"] = $attributes["type"];
            $scope->updateType($attributes["type"]);
        }

        if (isset($attributes["upload_path"]) && "" !== $attributes["upload_path"]) {
            $validate["upload_path"] = $attributes["upload_path"];
            $scope->updateUploadPath($attributes["upload_path"]);
        }

        if (
            isset($attributes["download_path"]) &&
            "" !== $attributes["download_path"]
        ) {
            $validate["download_path"] = $attributes["download_path"];
            $scope->updateDownloadPath($attributes["download_path"]);
        }

        if (isset($attributes["name"]) && "" !== $attributes["name"]) {
            $validate["name"] = $attributes["name"];
            $scope->updateName($attributes["name"]);
        }

        $this->validator->assertValid(array_merge($scope->getDirty(), $validate));
        $scope->save();

        return $scope;
    }
}
