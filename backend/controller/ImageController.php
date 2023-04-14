<?php

use model\Image;

class ImageController {

    private $db;
    private $imageId;
    private $requestMethod;

    private $image;

    public function __construct($db, $requestMethod,$imageId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->imageId = $imageId;

        $this->image = new Image($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getImage($imageId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getImage($id)
    {
        $result = $this->image->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}

?>