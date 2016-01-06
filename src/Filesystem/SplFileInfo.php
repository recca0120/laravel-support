<?php

namespace Recca0120\Support\Filesystem;

use ArrayAccess;
use SplFileInfo as BaseSplFileInfo;

class SplFileInfo extends BaseSplFileInfo implements ArrayAccess
{
    public $id;

    public $path;

    public $filename;

    public $extension;

    public $basename;

    public $pathname;

    public $perms;

    public $inode;

    public $size;

    public $owner;

    public $group;

    public $aTime;

    public $mTime;

    public $cTime;

    public $type;

    public $isWritable;

    public $isReadable;

    public $isExecutable;

    public $isFile;

    public $isDir;

    public $isLink;

    public $linkTarget;

    public $realPath;

    public function __construct($filename)
    {
        parent::__construct($filename);
        $this['id'] = $this->getBasename();
        $this['path'] = $this->getPath();
        $this['filename'] = $this->getFilename();
        $this['extension'] = $this->getExtension();
        $this['basename'] = $this->getBasename();
        $this['pathname'] = $this->getPathname();
        $this['perms'] = $this->getPerms();
        $this['inode'] = $this->getInode();
        $this['size'] = $this->getSize();
        $this['owner'] = $this->getOwner();
        $this['group'] = $this->getGroup();
        $this['aTime'] = $this->getATime();
        $this['mTime'] = $this->getMTime();
        $this['cTime'] = $this->getCTime();
        $this['type'] = $this->getType();
        $this['isWritable'] = $this->isWritable();
        $this['isReadable'] = $this->isReadable();
        $this['isExecutable'] = $this->isExecutable();
        $this['isFile'] = $this->isFile();
        $this['isDir'] = $this->isDir();
        $this['isLink'] = $this->isLink();
        $this['linkTarget'] = $this->getLinkTarget();
        $this['realPath'] = $this->getRealPath();
    }

    /**
     * Get an attribute from the container.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function __get($key)
    {
        return $this->{$key};
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    /**
     * Get the value for a given offset.
     *
     * @param  string  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string  $offset
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
}
