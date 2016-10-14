<?php

namespace Tests\Unit\Domain\Handlers;

use Tests\TestCase;
use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Commands\ResetPasswordCommand;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;
use LaravelItalia\Domain\Commands\Handlers\ResetPasswordCommandHandler;

class ResetPasswordCommandHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|PasswordResetRepository
     */
    private $passwordRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserRepository
     */
    private $userRepositoryMock;

    /* @var ResetPasswordCommandHandler */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->userMock = $this->createMock(User::class);
        $this->passwordRepositoryMock = $this->createMock(PasswordResetRepository::class);
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
    }

    public function testCanResetPasswordCorrectly()
    {
        $this->passwordRepositoryMock->expects($this->once())
            ->method('findByEmailAndToken');

        $this->userMock->expects($this->once())
            ->method('setNewPassword');

        $this->userRepositoryMock->expects($this->once())
            ->method('save');

        $this->passwordRepositoryMock->expects($this->once())
            ->method('removeByEmail');

        $this->handler = new ResetPasswordCommandHandler(
            $this->passwordRepositoryMock,
            $this->userRepositoryMock
        );

        $this->handler->handle(new ResetPasswordCommand(
            $this->userMock, 'TEST_TOKEN', 'NEW_PASSWORD'
        ));
    }

    /**
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testThrowsExceptionIfResetNotFound()
    {
        $this->passwordRepositoryMock->expects($this->once())
            ->method('findByEmailAndToken')
            ->willThrowException(new \LaravelItalia\Exceptions\NotFoundException());

        $this->userMock->expects($this->never())
            ->method('setNewPassword');

        $this->userRepositoryMock->expects($this->never())
            ->method('save');

        $this->passwordRepositoryMock->expects($this->never())
            ->method('removeByEmail');

        $this->handler = new ResetPasswordCommandHandler(
            $this->passwordRepositoryMock,
            $this->userRepositoryMock
        );

        $this->handler->handle(new ResetPasswordCommand(
            $this->userMock, 'TEST_TOKEN', 'NEW_PASSWORD'
        ));
    }
}
