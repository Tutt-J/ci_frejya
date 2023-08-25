<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        //Créer le client
        $this->client = static::createClient();
    }

    public function testLoginPageIsRender()
    {
        // Faire la requête
        $this->client->request("GET", "/login");

        // Vérifier qu'elle est en succès
        $this->assertResponseIsSuccessful();

        // Vérifier que la page contient bien le titre
        $this->assertSelectorTextContains("h1", "Connexion");
    }

    public function testSuccessfulLogin()
    {
        // Faire la requête
        $this->client->request("GET", "/login");

        // Soumettre le formulaire
        $this->client->submitForm('Connexion', [
            '_username' => 'email0@mail.com',
            '_password' => 'azerty'
        ]);

        // Vérifier qu'on est bien redirigé vers la page d'accueil
        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/', $location);

        // Vérifier que la page d'accueil contient bien les bons textes
        $this->client->followRedirect();
        $this->assertSelectorTextContains("h1", "Vous êtes connecté");
        $this->assertSelectorTextContains("a", "Se déconnecter");
    }

    public function testWrongLogin()
    {
        // Faire la requête
        $this->client->request("GET", "/login");

        // Soumettre le formulaire
        $this->client->submitForm('Connexion', [
            '_username' => 'email0@mail.com',
            '_password' => 'wrongpass'
        ]);

        // Vérifier qu'on est bien redirigé vers la page login
        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/login', $location);

        // Vérifier que la page contient le message d'erreur
        $this->client->followRedirect();
        $this->assertSelectorTextContains("div", "Invalid credentials.");
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Remettre client à null
        $this->client = null;
    }
}
