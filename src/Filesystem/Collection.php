<?php

namespace Recca0120\Support\Filesystem;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    protected $directory = null;

    protected $filesystem;

    public function __construct($items = [], $directory = null, Filesystem $filesystem = null)
    {
        $this->filesystem = ($filesystem === null) ? new Filesystem() : $filesystem;
        if ($directory !== null) {
            // $items = collect($this->filesystem->files($directory))->map(function ($item) {
            //     return $this->parseFile($item);
            // })->sortByDesc(function ($item) {
            //     return $item['filectime'];
            // });
            $items = [];
            foreach ($this->filesystem->files($directory) as $file) {
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
        if ($this->filesystem->isDirectory($this->directory) === false) {
            $this->filesystem->makeDirectory($this->directory, 0755, true);
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
        return $this->filesystem->delete($this->keyBy('id')->get($id)->getPathname());
    }
}
