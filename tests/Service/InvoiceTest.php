<?php

use App\Service\EmailService;
use App\Service\Invoice;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvoiceTest extends KernelTestCase
{
    public function testProcess()
    {
        $emailServiceMock = $this->createMock(EmailService::class);
        $emailServiceMock
        ->expects($this->once())
        ->method("send")
        ->willReturn(true);

        $invoice = new Invoice($emailServiceMock);
        $result = $invoice->process("j.doe@mail.com", 100);
        $this->assertTrue($result);
    }
}
