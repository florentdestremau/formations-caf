<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

class TrainingReimbursementControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/training-reimbursement');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        // $client->loginUser(new InMemoryUser('admin@cafannecy.fr', 'cafannecy', ['ROLE_ADMIN']));
        $username = 'admin@cafannecy.fr';
        $password = 'test';

        // Encode the credentials
        $encodedCredentials = base64_encode("$username:$password");
        // Set the Authorization header for basic auth
        $client->setServerParameter('HTTP_AUTHORIZATION', 'Basic '.$encodedCredentials);

        $client->request('GET', '/training-reimbursement');
        $this->assertResponseIsSuccessful();
    }
}
