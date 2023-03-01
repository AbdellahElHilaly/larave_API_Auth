<?php

namespace App\Traits\ExceptionHandling;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

trait ExceptionHandlerTrait
{

    private function getForeignIdError($errorMessage)
    {
        preg_match('/FOREIGN KEY \(`([^\)]+)\) REFERENCES/', $errorMessage, $matches);
        if (count($matches) >= 2) {
            return "foreign key error : " . $matches[1] . " not found !";
        }
        return null;
    }




    private function handleException(\Exception $e)
    {


        if ($e instanceof ModelNotFoundException) {
            return $this->apiResponse(null, Response::HTTP_NOT_FOUND, "Item not found");
        } else if ($e instanceof ValidationException) {
            return $this->apiResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        } else if ($e instanceof QueryException) {
            if ($e->errorInfo[1] == 1062) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'for key \'article_tag_article_id_tag_id_unique\'') !== false) {
                    return $this->apiResponse(null, Response::HTTP_CONFLICT, "Database error: Duplicate tags not allowed for the same Item");
                } else {
                    return $this->apiResponse(null, Response::HTTP_CONFLICT, "Database error : this item is already exists !");
                }
            } else if ($e->errorInfo[1] == 2002) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, "Unable to connect to database");
            } else if ($e->errorInfo[1] == 1701) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, "Cannot truncate a table referenced in a foreign key constraint");
            } else if ($e->errorInfo[1] == 1452) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, $this->getForeignIdError($e->getMessage()));
            }
        }

        return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
    }

}
