<?php

namespace Recca0120\Support\Filesystem;

use Illuminate\Support\Fluent as BaseFluent;
use SplFileInfo;

class Fluent extends BaseFluent
{
    protected $fileinfo;

    public function __construct($fileinfo)
    {
        if (($fileinfo instanceof SplFileInfo) === false) {
            $fileinfo = new SplFileInfo($fileinfo);
        }
        parent::__construct($this->parseFileInfo($fileinfo));
        $this->fileinfo = $fileinfo;
    }

    protected function parseFileInfo($fileinfo)
    {
        $data = [];
        $data['id'] = $fileinfo->getBasename();
        $data['path'] = $fileinfo->getPath();
        $data['filename'] = $fileinfo->getFilename();
        $data['extension'] = $fileinfo->getExtension();
        $data['basename'] = $fileinfo->getBasename();
        $data['pathname'] = $fileinfo->getPathname();
        $data['perms'] = $fileinfo->getPerms();
        $data['inode'] = $fileinfo->getInode();
        $data['size'] = $fileinfo->getSize();
        $data['owner'] = $fileinfo->getOwner();
        $data['group'] = $fileinfo->getGroup();
        $data['aTime'] = $fileinfo->getATime();
        $data['mTime'] = $fileinfo->getMTime();
        $data['cTime'] = $fileinfo->getCTime();
        $data['type'] = $fileinfo->getType();
        $data['isWritable'] = $fileinfo->isWritable();
        $data['isReadable'] = $fileinfo->isReadable();
        $data['isExecutable'] = $fileinfo->isExecutable();
        $data['isFile'] = $fileinfo->isFile();
        $data['isDir'] = $fileinfo->isDir();
        $data['isLink'] = $fileinfo->isLink();
        // $data['linkTarget'] = $fileinfo->getLinkTarget();
        $data['realPath'] = $fileinfo->getRealPath();

        return $data;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->fileinfo, $method], $parameters);
    }
}
