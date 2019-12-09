<?php

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ListUsersAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new JsonResponse($this->read());
    }

    public function read(): array
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/users.txt'), true);
        $users = [];

        foreach ($data as $datum) {
            $users[] = json_decode($datum, true);
        }

        return $users;
    }
}
