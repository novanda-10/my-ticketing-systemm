<?php

namespace App\Traits;


trait ApiResponses {

    protected function ok($massage , $data =[]) {
       return  $this->succsess($massage ,$data, 200);
    }


    protected function succsess($massage , $data =[] , $statusCode =200 ) {
        return response()->json([
            'data' => $data,
            'massage' => $massage,
            'status' =>  $statusCode,
        ], $statusCode);
    }


    protected function error($massage , $statusCode) {
        return response()->json([
            'massage' => $massage,
            'status' =>  $statusCode,
        ], $statusCode);
    }
}