<?php

namespace App\Service\Interfaces;

use App\Entity\User;

interface UserInterface
{
    public function addUser(User $user, $form);

    //public function deleteUser(User $id);

    //public function getUserById(User $id);setIsVerified
    // public function setIsVerified(User $user);
}
