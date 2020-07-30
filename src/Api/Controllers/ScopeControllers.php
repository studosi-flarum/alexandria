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
use Studosi\Alexandria\Api\Serializers\ScopeSerializer;
use Studosi\Alexandria\Commands\ScopeCommands\{
    CreateScope,
    DeleteScope,
    UpdateScope,
};
use Studosi\Alexandria\Scope;
use Tobscure\JsonApi\Document;

class CreateScopeController extends AbstractCreateController
{
    public $serializer = ScopeSerializer::class;
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new CreateScope(
                $request->getAttribute("actor"),
                array_get($request->getParsedBody(), "data", []),
            ),
        );
    }
}

class DeleteScopeController extends AbstractDeleteController
{
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function delete(ServerRequestInterface $request)
    {
        $this->bus->dispatch(
            new DeleteScope(
                array_get($request->getQueryParams(), "id"),
                $request->getAttribute("actor"),
            ),
        );
    }
}

class ListScopesController extends AbstractListController
{
    public $serializer = ScopeSerializer::class;

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return Scope::all();
    }
}

class UpdateScopeController extends AbstractShowController
{
    public $serializer = ScopeSerializer::class;
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new UpdateScope(
                array_get($request->getQueryParams(), "id"),
                $request->getAttribute("actor"),
                array_get($request->getParsedBody(), "data", []),
            ),
        );
    }
}
