<?php

// A modifier
namespace Kaito\tests;

use Kaito\TestUnitaire\UserManager;
use PHPUnit\Framework\TestCase;

// A mettre dans UserManager.php
//
// public function resetTable(): void {
//     $stmt = $this->db->prepare("DELETE FROM users; ALTER TABLE users AUTO_INCREMENT = 1;  ");
//     $stmt->execute();
// }

class UserManagerTest extends TestCase
{

    //testAddUser
    public function  testAddUser()
    {
        $userManager = new UserManager();
        $userManager->addUser("Toto", "toto1234@gmail.com");

        $user = $userManager->getUser(1);
        $this->assertEquals("Toto", $user["name"]);
        $this->assertEquals("toto1234@gmail.com", $user["email"]);

        $userManager->resetTable();
    }

    //testUpdateUser
    public function testUpdateUser()
    {
        $userManager = new UserManager();
        $userManager->addUser("Toto", "toto1234@gmail.com");

        // Verifier l'insertion
        $user = $userManager->getUser(1);
        $this->assertEquals("Toto", $user["name"]);

        $userManager->updateUser(1, "Toto2", "toto5678@gmail.com");
        $updatedUser = $userManager->getUser(1);
        $this->assertEquals("Toto2", $updatedUser["name"]);
        $this->assertEquals("toto5678@gmail.com", $updatedUser["email"]);

        $userManager->resetTable();
    }

    //testRemoveUser
    public function testRemoveUser()
    {
        $userManager = new UserManager();
        $userManager->addUser("Toto", "toto1234@gmail.com");

        // Verifier l'insertion
        $user = $userManager->getUser(1);
        $this->assertEquals("Toto", $user["name"]);

        $userManager->removeUser(1);
        $users = $userManager->getUsers();
        $this->assertCount(0, $users);

        $userManager->resetTable();
    }

    //testGetUsers
    public function testGetUsers()
    {
        $userManager = new UserManager();
        $userManager->addUser("Toto", "toto1234@gmail.com");

        $users = $userManager->getUsers();
        $this->assertCount(1, $users);
        $this->assertEquals("Toto", $users[0]["name"]);
        $this->assertEquals("toto1234@gmail.com", $users[0]["email"]);

        $userManager->resetTable();
    }

    //testAddUserEmailException
    public function testAddUserEmailException()
    {
        $userManager = new UserManager();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Email invalide.");
        $userManager->addUser("Toto", "toto1234");
    }

    //testInvalidUpdateThrowsException
    public function testInvalidUpdateThrowsException()
    {
        $userManager = new UserManager();
        $this->expectException(\Exception::class);
        $userManager->updateUser(99, "Toto", "toto1234@gmail.com");
    }

    //testInvalidDeleteThrowsException
    public function testInvalidDeleteThrowsException()
    {
        $userManager = new UserManager();
        $this->expectException(\Exception::class);
        $userManager->removeUser(99);
    }
}