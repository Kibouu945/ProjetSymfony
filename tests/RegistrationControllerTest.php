<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        // Access the registration page
         $crawler = $client->request('POST', '/inscription');

        // Add assertions to check the registration form and submission
        $this->assertSelectorExists('form[name="registration_form"]');
        $form = $crawler->filter('form[name="registration_form"]')->form();

        // Fill out the form with valid data
        $form['registration_form[Firstname]'] = 'test';
        $form['registration_form[Lastname]'] = 'test';
        $form['registration_form[email]'] = 'test@example.com';
        $form['registration_form[agreeTerms]'] = true;
        $form['registration_form[Adress]'] = '7 rue des templiers';
        $form['registration_form[plainPassword]'] = 'password123';

        // Submit the form
        $client->submit($form);
    }
}
