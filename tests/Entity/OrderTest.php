<?php

use App\Entity\User;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
    public function testEntity()
    {
        $user = new User();
        $user->setEmail("john.doe@mail.com");
        $order = new Order();
        $order->setNumber("AZ59-2023");
        $order->setTotalPrice(500);
        $order->setUser($user);

        $this->assertEquals("AZ59-2023", $order->getNumber());
        $this->assertEquals(500, $order->getTotalPrice());
        $this->assertEquals("john.doe@mail.com", $order->getUser()->getEmail());
    }
}
