<?php

namespace Tests\Unit\Domain\Observers;

use Tests\TestCase;
use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;
use LaravelItalia\Domain\Observers\RemoveFileWhenDeletingMedia;

class RemoveFileWhenDeletingMediaTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Media
     */
    private $mediaMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Request
     */
    private $requestMock;

    public function setUp()
    {
        $this->mediaMock = $this->createMock(Media::class);
        $this->requestMock = $this->createMock(Request::class);

        parent::setUp();
    }

    public function testRemoval()
    {
        \Storage::shouldReceive('delete')->once();

        $mediaUploader = new RemoveFileWhenDeletingMedia($this->requestMock);
        $mediaUploader->deleting($this->mediaMock);
    }
}
