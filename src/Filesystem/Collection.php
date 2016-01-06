<?php

namespace Recca0120\Support\Filesystem;

use File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    protected $directory = null;

    public function __construct($items = [], $directory = null)
    {
        if ($directory !== null) {
            // $items = collect(File::files($directory))->map(function ($item) {
            //     return $this->parseFile($item);
            // })->sortByDesc(function ($item) {
            //     return $item['filectime'];
            // });
            $items = [];
            foreach (File::files($directory) as $file) {
                $items[] = $this->parseFile($file);
            }
            $this->directory = $directory;
        }
        parent::__construct($items);
    }

    protected function parseFile($file)
    {
        return new SplFileInfo($file);
    }

    public function getDirectory()
    {
        if (File::isDirectory($this->directory) === false) {
            File::makeDirectory($this->directory, 0755, true);
        }

        return trim($this->directory, '/').'/';
    }

    public function select()
    {
        return $this;
    }

    public function findOrFail($id)
    {
        return $this->where('id', $id)->first();
    }

    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $total = $this->count();
        $results = $this->forPage($page, $perPage);

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    public function delete($id)
    {
        return File::delete($this->keyBy('id')->get($id)->path);
    }
}
