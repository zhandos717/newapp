<?php

namespace App\controllers;
use App\core\Controller;
use SimpleMail;
class AuthorizationController extends Controller
{
    public function login()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            \header('Location: /');
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error(['Wrong email address']);
            \header('Location: /login');
            die('Wrong email address'); 
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error(['Wrong password']);
            \header('Location: /login');
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->flash->error(['Email not verified']);
            \header('Location: /login');
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error(['Too many requests']);
            \header('Location: /login');
            die('Too many requests');
        }
    }
    public function registration ()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                SimpleMail::make()
                ->setTo($_POST['email'], $_POST['username'])
                ->setSubject('Подвеждение аккаунта через почту')
                ->setMessage('Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)')->send();
                $this->flash->message(['На вашу почту отправлено сообщение!']);
                \header('Location: /register');
            });
            echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error(['Invalid email address']);
            \header('Location: /register');
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error(['Invalid password!']);
            \header('Location: /register');
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error(['Такой пользователь уже есть!']);
            \header('Location: /register');
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error(['Too many requests!']);
            \header('Location: /register');
            die('Too many requests');
        }
    }
    public function emailVerification()
    {   
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            echo 'Email address has been verified';
            $this->flash->info(['Email address has been verified']);
            \header('Location: /register');
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $this->flash->error(['Invalid token']);
            \header('Location: /register');
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            $this->flash->error(['Token expired']);
            \header('Location: /register');
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error(['Email address already exists']);
            \header('Location: /register');
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error(['Too many requests']);
            \header('Location: /register');
            die('Too many requests');
        }
    }
    public function logout()
    {
        try {
            $this->auth->logOutEverywhere();
            \header('Location: /');
        } catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
    }
};