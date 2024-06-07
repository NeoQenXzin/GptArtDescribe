<?php

namespace App\Tests;

use App\Entity\Image;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AddImageTest extends WebTestCase
{
    public function testAddImage()
    {
        $client = static::createClient();
        $container = static::getContainer();
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setPassword(
            $passwordHasher->hashPassword($user, 'password')
        );

        $entityManager->persist($user);
        $entityManager->flush();
        $client->loginUser($user);

        $crawler = $client->request('GET', '/add/image');

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Add Image'); // Vérifiez que votre template a un h1 avec "Add Image"

        $form = $crawler->selectButton('Submit')->form();

        $tempFile = tempnam(sys_get_temp_dir(), 'upl');
        file_put_contents($tempFile, 'dummy content');

        $uploadedFile = new UploadedFile(
            $tempFile,
            'dummy.txt',
            'text/plain',
            null,
            true // Test mode
        );

        $form['image_form[path]'] = $uploadedFile;
        $form['image_form[name]'] = 'Test Image';

        $client->submit($form);
        $this->assertResponseRedirects('/add/image');
        $client->followRedirect();

        $image = $entityManager->getRepository(Image::class)->findOneBy(['name' => 'Test Image']);
        $this->assertNotNull($image);

        $this->assertEquals($user->getId(), $image->getUserId()->getId());
    }
}
