<?php
namespace In2it\Test\Phpunit\Service;

use In2it\Phpunit\Service\Filesystem;
use org\bovigo\vfs\vfsStream;

class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    protected $filesystem;

    protected function setUp()
    {
        parent::setUp();
        $this->filesystem = vfsStream::setup('root');
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset ($this->filesystem);
    }

    /**
     * @covers \In2it\Phpunit\Service\Filesystem::delete
     */
    public function testFilesystemCanRemoveFiles()
    {
        // Let's first assert the file does not exist
        $this->assertFalse($this->filesystem->hasChild('filename.ext'));

        // Let's put contents in that file
        file_put_contents(vfsStream::url('root/filename.ext'), 'This is some random contents');

        // Test the file is now created
        $this->assertTrue($this->filesystem->hasChild('filename.ext'));

        // Run our business logic
        $filesystem = new Filesystem();
        $filesystem->delete(vfsStream::url('root/filename.ext'));

        // Assert the file is now removed
        $this->assertFalse($this->filesystem->hasChild('filename.ext'));
    }

}