<?php

namespace Statamic\Stache\Repositories;

use Statamic\Stache\Stache;
use Statamic\Globals\GlobalCollection;
use Statamic\Contracts\Globals\GlobalSet;
use Illuminate\Support\Collection as IlluminateCollection;
use Statamic\Contracts\Globals\GlobalRepository as RepositoryContract;

class GlobalRepository implements RepositoryContract
{
    protected $stache;
    protected $store;

    public function __construct(Stache $stache)
    {
        $this->stache = $stache;
        $this->store = $stache->store('globals');
    }

    public function make($handle = null)
    {
        return (new \Statamic\Globals\GlobalSet)->handle($handle);
    }

    public function all(): GlobalCollection
    {
        $keys = $this->store->paths()->keys();

        return GlobalCollection::make($this->store->getItems($keys));
    }

    public function find($id): ?GlobalSet
    {
        return $this->store->getItem($id);
    }

    public function findByHandle($handle): ?GlobalSet
    {
        $key = $this->store->index('handle')->items()->flip()->get($handle);

        return $this->find($key);
    }

    public function save($global)
    {
        $this->store->save($global);
    }

    public function delete($global)
    {
        $this->store->delete($global);
    }
}
