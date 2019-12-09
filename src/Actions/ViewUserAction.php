<?php

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ViewUserAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userName = $request->getAttribute('name');
        $foundUser = $this->readUser($userName);
        if ($foundUser === null) {
            return new JsonResponse(false, 404);
        }

        return new JsonResponse($foundUser);
    }

    public function readUser($userName): ?array
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/users.txt'), true);
        foreach ($data as $userData) {
            $decodedUserData = json_decode($userData, true);
            if ($decodedUserData['name'] === $userName) {
                return $decodedUserData;
            }
        }

        return null;
    }
}
