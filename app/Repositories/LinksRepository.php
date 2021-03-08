<?php


namespace App\Repositories;


use App\Models\Link;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Collection;

class LinksRepository
{
    /** @var Collection */
    protected $collection;

    public function __construct()
    {
        $json = json_decode(file_get_contents(storage_path('data/links.json')), true);
        $collection =Link::hydrate($json);
        $this->collection = $collection->flatten();
    }

    public function find($name)
    {
        $row = $this->collection->firstWhere('link', '=', $name);
        if($row) {
            return ['type' => 'short', 'result' => $row];
        }
        $row = $this->collection->firstWhere('short', '=', $name);
        if($row) {
            return ['type' => 'link', 'result' => $row];
        }
        return null;
    }
}
