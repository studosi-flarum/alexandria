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

namespace Studosi\Alexandria\Api\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;
use Studosi\Alexandria\Scope;

class LinkSerializer extends AbstractSerializer
{
    protected $type = "studosi-alexandria_scopes";

    protected function getDefaultAttributes($scope)
    {
        if (!($scope instanceof Scope)) {
            throw new InvalidArgumentException(
                get_class($this) .
                    " can only serialize instances of " .
                    Scope::class,
            );
        }

        return [
            "type" => $scope->type,
            "upload_path" => $scope->upload_path,
            "download_path" => $scope->download_path,
            "name" => $scope->name,
        ];
    }
}
