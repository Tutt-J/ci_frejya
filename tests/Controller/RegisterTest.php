<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        //Créer le client
        $this->client = static::createClient();

        //Créer l'entity manager
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testRenderRegisterPage()
    {
        // Faire la requête
        $this->client->request("GET", "/register");

        // Vérifier qu'elle est en succès
        $this->assertResponseIsSuccessful();

        // Vérifier que la page contient bien le titre
        $this->assertSelectorTextContains("h1", "Inscription");
    }

    public function testSuccessfulRegister()
    {
        // Faire la requête
        $this->client->request("GET", "/register");

        // Soumettre le formulaire
        $this->client->submitForm('Inscription', [
         'registration_form[firstname]' => 'John',
         'registration_form[lastname]' => 'Doe',
         'registration_form[email]' => 'j.doe@mail.com',
         'registration_form[plainPassword]' => '123456'
        ]);

        // Vérifier qu'on est bien redirigé vers le login
        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/login', $location);

        // Vérifier qu'on retrouve bien l'utilisateur en BDD
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => "j.doe@mail.com"]);
        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('j.doe@mail.com', $user->getEmail());
        $this->assertTrue(password_verify("123456", $user->getPassword()));
    }

    public function testInvalidEmail()
    {
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Supprimer l'utilisateur qu'on vient de créer en BDD
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => "j.doe@mail.com"]);
        if($user){
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        // Remettre client et entity manager à null
        $this->client = null;
        $this->entityManager = null;
    }
}
