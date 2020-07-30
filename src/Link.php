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

use Flarum\Database\AbstractModel;

class Link extends AbstractModel
{
    protected $table = "studosi-alexandria_links";

    public static function build($repo_id, $path, $nick)
    {
        $link = new static();

        $link->repo_id = $repo_id;
        $link->path = $path;
        $link->nick = $nick;

        return $link;
    }

    public function updateRepoID($repo_id)
    {
        $this->repo_id = $repo_id;

        return $this;
    }

    public function updatePath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function updateNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }
}
