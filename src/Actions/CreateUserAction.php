<?php

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CreateUserAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestData = $request->getParsedBody();

        return $this->store($requestData);
    }

    public function store(array $data)
    {
        if (!isset($data['name'])) {
            return new JsonResponse('Name field is required', 409);
        }

        if (!isset($data['surname'])) {
            return new JsonResponse('Surname field is required', 409);
        }

        $jsonData = json_decode(file_get_contents(__DIR__ . '/../../data/users.txt'), true);

        if ($jsonData === null) {
            $jsonData = [];
        }

        $jsonData[] = json_encode($data);

        file_put_contents(__DIR__ . '/../../data/users.txt', json_encode($jsonData));

        return new JsonResponse(true);
    }
}
