<?php


namespace App\Http\Helpers;


class Helpers
{
    const SUCCESS_MESSAGE = 'Thành công';
    const FAIL_MESSAGE = 'Hệ thống bận vui lòng thử lại sau';
    const SHORT_PARAM = 'Truyền thiếu tham số';

    const SUCCESS_CODE = 0;
    const FAIL_CODE = 1;

    public static function formatResponse($errorCode, $data, $message)
    {
        return response()->json([
            'errorCode' => $errorCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    // response try catch
    public static function formatResponseSystemBusy($e)
    {
        return self::formatResponse(self::FAIL_CODE, $e->getMessage(), self::FAIL_MESSAGE);
    }

    // respone thanh cong
    public static function formatResponseSuccess($data)
    {
        return self::formatResponse(self::SUCCESS_CODE, $data, self::SUCCESS_MESSAGE);
    }

}
