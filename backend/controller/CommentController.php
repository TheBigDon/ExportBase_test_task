<?php

include('model\Comment.php');

class CommentController
{

    private $db;
    private $requestMethod;
    private $uri;

    private $comment;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $this->comment = new Comment($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createComment();
                break;
            case 'DELETE':
                if (!isset($uri[2])) {
                    $response = $this->notFoundResponse();
                    break;
                }
                $response = $this->deleteComment();
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

    private function createComment()
    {
        $input = (array) json_decode(file_get_contents('php//input'), TRUE);
        if (!$this->validateComment($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->comment->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function deleteComment()
    {
        $commentId = (int) $this->uri[2];
        $this->comment->delete($commentId);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateComment($input)
    {
        if (!isset($input['user'])) {
            return false;
        }
        if (!isset($input['text_comment'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
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