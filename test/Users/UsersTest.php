<?php

namespace Alvo16\Users;

/**
 *  A test class for Users
 */
class UsersTest extends \PHPUnit_Framework_TestCase
{
    // public function testGetCurrentMonth()
    // {
    //     $cal = new Calendar();
    //     $this->assertEquals('current', $cal->isCurrent(date('Y-n-j')));
    //     $this->assertInternalType('string', $cal->isCurrent(date('Y-n-j')));
    // }
    //
    // public function testIsHoliday()
    // {
    //     $cal = new Calendar();
    //     $this->assertInternalType('string', $cal->isHoliday(date('l')));
    // }

    public function testEncryptPassword()
    {
        $usr = new Users();
        $this->assertInternalType('string', $usr->encryptPassword('test'));
        $this->assertEquals(true, $usr->verifyPassword('123', $usr->encryptPassword('123')));
    }
}
