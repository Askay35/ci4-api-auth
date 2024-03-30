<?php

namespace App\Libraries;
use CodeIgniter\HTTP\ResponseInterface;

trait ApiResponseTrait {
    
    /**
     * Used on success.
     *
     * @param array|string|null $data
     *
     * @return ResponseInterface
     */
    protected function respondSuccess($data = null)
    {
        return $this->response->setJSON(array_merge(['data'=>$data],['success' => true]));
    }

    
    /**
     * Used on success.
     *
     * @param array|string|null $data
     *
     * @return ResponseInterface
     */
    protected function respondFail($data = null)
    {
        return $this->response->setJSON(array_merge($data,['success' => false]));
    }
    /**
     * Used on success.
     *
     * @param array|string|null $data
     *
     * @return ResponseInterface
     */
    protected function respondErrors($errors = null)
    {
        return $this->respondFail(['errors'=>$errors]);
    }

}