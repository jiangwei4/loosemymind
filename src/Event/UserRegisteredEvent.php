<?php
namespace App\Event;

use App\Entity\Users;
use Symfony\Component\EventDispatcher\Event;

class UserRegisteredEvent extends Event {
    const NAME = 'users.registered';

    protected $user;

    public function __construct(Users $user)
    {
        $this->user =$user;
    }
    public function getUser(): Users{
        return $this->user;
    }
}