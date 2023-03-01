<?php
namespace App\Traits\ResponceHandling;
trait ApiResponceTrait
{
    public function apiResponse($data = null, $status = 200, $message = "ok")
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
        if ($data === null) {
            unset($response['data']);
        }
        return response()->json($response);
    }
}
