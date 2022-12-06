<?php
class Helpers {
    static function responsejson($status,$message,$data = null)
        {
            $response = [
                'status'=>$status,
                'message'=>$message,
                'data'=>$data,
            ];
            return json_encode($response, JSON_PRETTY_PRINT);
        }
}
