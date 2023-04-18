<?php

class Image
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "SELECT * 
                      FROM content 
                      JOIN comments on content.id = comments.id_image 
                      ORDER BY comments.date_comment DESC;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $result = json_encode($result);
            $result = json_decode($result);
            $images = array();
            foreach ($result as $image) {
                if (array_search($image->id_image, array_column($images, 'id')) === false) {
                    array_push(
                        $images,
                        array(
                            'id' => $image->id_image,
                            'image_url' => $image->image_url,
                            'comments' => array(
                                array(
                                    'id' => $image->id,
                                    'user' => $image->user,
                                    'text_comment' => $image->text_comment,
                                    'date_comment' => $image->date_comment
                                )
                            )
                        )
                    );
                } else {
                    $key = array_search($image->id_image, array_column($images, 'id'));
                    $comments = $images[$key]['comments'];
                    array_push(
                        $comments,
                        array(
                            'id' => $image->id,
                            'user' => $image->user,
                            'text_comment' => $image->text_comment,
                            'date_comment' => $image->date_comment
                        )
                    );
                    $images[$key]['comments'] = $comments;
                }
            }
            return $images;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

?>