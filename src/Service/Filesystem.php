<?php
namespace In2it\Phpunit\Service;

class Filesystem
{
    public function delete($filePath)
    {
        unlink($filePath);
    }
}