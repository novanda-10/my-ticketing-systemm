<?php

namespace App\Traits;


trait ApiResponses {

    protected function ok($massage) {
       return  $this->succsess($massage , 200);
    }


    protected function succsess($massage , $statusCode =200 ) {
        return response()->json([
            'massage' => $massage,
            'status' =>  $statusCode,
        ], $statusCode);
    }
}