<?php
namespace App\Service;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
//use App\Service\Interfaces\UserInterface;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Service\Exception\UserServiceException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;
    private $userManager;
    private $passwordEncoder;
    private $emailVerifier;

    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $userManager, 
                                UserPasswordEncoderInterface $passwordEncoder,
                                EmailVerifier $emailVerifier) 
    {
        $this->userRepository = $userRepository;
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->emailVerifier = $emailVerifier;;
    }

    public function addUser(User $user, $form)
    {
        try {   
            
            // encode the plain password
            $user->setDateInscription(new \DateTime(date('Y-m-d')));

            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->userManager->persist($user);
            $this->userManager->flush();  

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('aurel5994@gmail.com', 'Test Symfony'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

        } 
        catch (DriverException $e) {
            throw new UserServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getUsers()
    {
        try {
            $users = $this->userRepository->findAll();
            return $users;     
        } 
        catch (DriverException $e) {
            throw new UserServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getUserById(Object $id)
    {
        try {
            $user = $this->userRepository->find($id);
            return $user; 
        } 
        catch (DriverException $e) {
            throw new UserServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function deleteUser(Object $id)
    {
        try {
            $user = $this->userRepository->find($id);
            $this->userManager->remove($user);
            $this->userManager->flush();
        } 
        catch (DriverException $e) {
            throw new UserServiceException("Un problème technique est survenu", $e->getCode());
        }
    }
}