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

namespace Studosi\Alexandria\Api\Controllers\LinkControllers;

use Flarum\Api\Controller\AbstractCreateController;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Studosi\Alexandria\Api\Serializers\LinkSerializer;
use Studosi\Alexandria\Commands\LinkCommands\{
    CreateLink,
    DeleteLink,
    UpdateLink,
};
use Studosi\Alexandria\Link;
use Tobscure\JsonApi\Document;

class CreateLinkController extends AbstractCreateController
{
    public $serializer = LinkSerializer::class;
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new CreateLink(
                $request->getAttribute("actor"),
                array_get($request->getParsedBody(), "data", []),
            ),
        );
    }
}

class DeleteLinkController extends AbstractDeleteController
{
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function delete(ServerRequestInterface $request)
    {
        $this->bus->dispatch(
            new DeleteLink(
                array_get($request->getQueryParams(), "id"),
                $request->getAttribute("actor"),
            ),
        );
    }
}

class ListRulesController extends AbstractListController
{
    public $serializer = LinkSerializer::class;

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return Link::all();
    }
}

class UpdateLinkController extends AbstractShowController
{
    public $serializer = LinkSerializer::class;
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new UpdateLink(
                array_get($request->getQueryParams(), "id"),
                $request->getAttribute("actor"),
                array_get($request->getParsedBody(), "data", []),
            ),
        );
    }
}
