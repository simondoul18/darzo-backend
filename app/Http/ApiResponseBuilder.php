<?php

namespace App\Http;

use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ApiResponseBuilder extends ResponseBuilder
{
    protected function buildResponse(
        bool $success,
        int $api_code,
        $msg_or_api_code,
        array $placeholders = null,
        $data = null,
        array $debug_data = null
    ): array {
        // tell ResponseBuilder to do all the heavy lifting first
        $response = parent::buildResponse($success, $api_code, $msg_or_api_code, $placeholders, $data, $debug_data);
        $response['data'] = $data;

        // finally, return what $response holds
        return $response;
    }
}
