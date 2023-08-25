<?php

namespace App\Service;

class Invoice
{
    public function __construct(private EmailService $emailService)
    {
    }

    public function process(string $email, float $total){
        $message = "Votre commande d’un montant de ".$total."€ est confirmée";
        $result = $this->emailService->send($email, $message);
        return $result;
    }
}
