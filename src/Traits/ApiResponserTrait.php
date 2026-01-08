<?php

namespace MahmoudAbdelhamid\PatternGenerator\Traits;

trait ApiResponserTrait
{
    public function successResponse($status = 'success', $data, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($data, $code = 400)
    {
        return response()->json([
            'status' => "failed",
            'error' => [
                'message' => $data
            ],
            'code' => $code,
        ], $code);
    }
}
