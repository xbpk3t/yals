<?php


namespace Modules\Common\Utils\ApiEncrypt\RSA\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Secret extends Model
{
    public static function insertUserData($input)
    {
        try {
            DB::table('secret')->insert(
                array(
                    'username' => $input['username'],
                    'publicKey' => $input['publicKey']
                )
            );
        } catch (QueryException $e) {
            return false;
        }

        return true;
    }

    public static function getUserId($input)
    {
        $result = DB::table('secret')->where('username', $input['username'])->first();

        if (!$result)
            return false;

        return $result->id;
    }

    public static function validateStoreSignature($input)
    {
        $result = DB::table('secret')
            ->where('username', $input['username'])
            ->first();

        if (!$result)
            return false;

        $plain1_temp = str_replace("\\n", '', $result->publicKey);
        $plain1 = str_replace("\n", '', $plain1_temp);

        $plain2_temp = str_replace("\\n", '', $input['publicKey']);
        $plain2 = str_replace("\n", '', $plain2_temp);

        if ($plain1 != $plain2)
            return false;

        return true;
    }

    public static function insertMessageData($input)
    {
        try {
            DB::table('messages')->insert(
                array(
                    'sec_id' => $input['sec_id'],
                    'secretName' => $input['secretName'],
                    'encryptedSecret' => $input['encryptedSecret']
                )
            );
        } catch (QueryException $e) {
            return false;
        }

        return true;
    }

    public static function getMessage($input)
    {
        $result = DB::table('messages')
            ->leftjoin('secret', 'messages.sec_id', '=', 'secret.id')
            ->where('messages.secretName', '=', $input['secretName'])
            ->where('secret.username', '=', $input['username'])
            ->select('messages.encryptedSecret', 'secret.publicKey')
            ->first();

        if (!$result)
            return FALSE;

        return $result;
    }
}
