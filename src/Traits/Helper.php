<?php
namespace Leafwrap\RoleSanctions\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait Helper
{
    protected function serverError($exception): Response | Application | ResponseFactory
    {
        return response(['status' => 'server_error', 'statusCode' => 500, 'message' => $exception->getMessage()], 500);
    }

    protected function validateError($data, $override = false): Response | Application | ResponseFactory
    {
        $errors       = [];
        $errorPayload = !$override ? $data->getMessages() : $data;

        foreach ($errorPayload as $key => $value) {
            $errors[$key] = $value[0];
        }

        return response(['status' => 'validate_error', 'statusCode' => 422, 'data' => $errors], 422);
    }

    protected function messageResponse($message = 'No data found', $statusCode = 404, $status = 'error'): Response | Application | ResponseFactory
    {
        return response(['status' => $status, 'statusCode' => $statusCode, 'message' => $message], $statusCode);
    }

    protected function entityResponse($data = null, $statusCode = 200, $status = 'success', $message = null): Response | Application | ResponseFactory
    {
        $payload = ['status' => $status, 'statusCode' => $statusCode, 'data' => $data];

        if ($message) {
            $payload['message'] = $message;
        }

        return response($payload, $statusCode);
    }

    protected function paginate($payload): array
    {
        return [
            'data'         => $payload['data'],
            'current_page' => $payload['current_page'],
            'last_page'    => $payload['last_page'],
            'per_page'     => $payload['per_page'],
            'from'         => $payload['from'],
            'to'           => $payload['to'],
            'total'        => $payload['total'],
        ];
    }

    protected function permissionDenyMessage(): Response | Application | ResponseFactory
    {
        return $this->messageResponse("Sorry, You don't have permission for this.", 403);
    }
}
