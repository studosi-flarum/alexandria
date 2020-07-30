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

namespace Studosi\Alexandria\Handlers\LinkHandlers;

use Flarum\User\AssertPermissionTrait;
use Studosi\Alexandria\Commands\LinkCommands\{CreateLink, DeleteLink, UpdateLink};
use Studosi\Alexandria\Link;
use Studosi\Alexandria\Validators\LinkValidator;

class CreateLinkHandler
{
    use AssertPermissionTrait;

    protected $validator;

    public function __construct(LinkValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(CreateLink $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $this->assertAdmin($actor);
        $attributes = array_get($data, "attributes", []);

        $link = Link::build(
            $attributes["repo_id"],
            $attributes["path"],
            $attributes["nick"],
        );

        $this->validator->assertValid($link->getAttributes());
        $link->save();

        return $link;
    }
}

class DeleteLinkHandler
{
    use AssertPermissionTrait;

    public function handle(DeleteLink $command)
    {
        $actor = $command->actor;
        $this->assertAdmin($actor);

        $link = Link::where("id", $command->link_id)->firstOrFail();
        $link->delete();

        return $link;
    }
}

class UpdateLinkHandler
{
    use AssertPermissionTrait;

    protected $validator;

    public function __construct(LinkValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(UpdateLink $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $attributes = array_get($data, "attributes", []);
        $validate = [];

        $this->assertAdmin($actor);

        $link = Link::where("id", $command->link_id)->firstOrFail();

        if (isset($attributes["repo_id"]) && "" !== $attributes["repo_id"]) {
            $validate["repo_id"] = $attributes["repo_id"];
            $link->updateRepoID($attributes["repo_id"]);
        }

        if (isset($attributes["path"]) && "" !== $attributes["path"]) {
            $validate["path"] = $attributes["path"];
            $link->updatePath($attributes["path"]);
        }

        if (isset($attributes["nick"]) && "" !== $attributes["nick"]) {
            $validate["nick"] = $attributes["nick"];
            $link->updateNick($attributes["nick"]);
        }

        $this->validator->assertValid(array_merge($link->getDirty(), $validate));
        $link->save();

        return $link;
    }
}
