<?php

use model\Comment;
use model\Image;

class CommentController {
    
    private $db;
    private $requestMethod;
    private $commentId;

    private $comment;

    public function __construct($db, $requestMethod, $commentId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->commentId = $commentId;

        $this->comment = new Comment($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getCommentByImageId($imageId);
                break;
            case 'POST':
                $response = $this->createComment();
                break;
            case 'DELETE':
                $response = $this->deleteComment($this->commentId);
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

    private function getCommentByImageId($id)
    {
        $result = $this->comment->findByImageId($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createComment()
    {
        $input = (array) json_decode(file_get_contents('php//input'), TRUE);
        if (! $this->validateComment($input)) {
            return $this.unprocessableEntityResponse();
        }
        $this->comment->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function deleteComment($id)
    {
        $result = $this->comment->find($id);
        if (! $result){
            return $this->notFoundResponse();
        }
        $this->comment->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateComment($input)
    {
        if (! isset($input['user'])) {
            return false;
        }
        if (! isset($input['text_comment'])) {
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