<?php


namespace Modules\Common\Utils\ApiEncrypt\RSA\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Modules\Common\Utils\ApiEncrypt\RSA\Entities\Secret;
use Modules\Common\Utils\ApiEncrypt\RSA\RSA;

class RSAController
{
    public $successStatus = 200;
    public $vaildStatus = 401;

    private $serverKey = '';

    /**
     * register API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        $input = [];
        if (!$request->input('username')) {
            return response()->json(['failure' => 'username parameter error'], $this->vaildStatus);
        }

        if (!$request->input('publicKey')) {
            return response()->json(['failure' => 'publicKey parameter error'], $this->vaildStatus);
        }

        $input['username'] = $request->input('username');
        $input['publicKey'] = $request->input('publicKey');

        // if user not exist, return false.
        $secId = Secret::getUserId($input);

        if ($secId) {
            return response()->json(['failure' => 'The user already exist.'], $this->vaildStatus);
        }

        $ret = Secret::insertUserData($input);

        if (!$ret) {
            return response()->json(['failure' => 'Register failed.'], $this->vaildStatus);
        }

        return response()->json(['success' => $ret], $this->successStatus);
    }

    /**
     * getServerKey API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServerKey() {

        $this->serverKey = config('app.key');

        return response()->json(['success' => $this->serverKey], $this->successStatus);
    }

    private function validateStoreSignature($request) {
        $input['publicKey'] = $request->input('key');
        $input['username'] = $request->input('username');

        return Secret::validateStoreSignature($input);
    }

    /**
     * storeSecret API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSecret(Request $request) {

        if (!$this->validateStoreSignature($request)) {
            return response()->json(['failure' => 'Request Validation failed.'], $this->vaildStatus);
        }

        if (!$request->input('username')) {
            return response()->json(['failure' => 'username parameter error'], $this->vaildStatus);
        }
        $input['username'] = $request->input('username');

        if (!$request->input('secretName')) {
            return response()->json(['failure' => 'secretName parameter error'], $this->vaildStatus);
        }
        $input['secretName'] = $request->input('secretName');

        if (!$request->input('encryptedSecret')) {
            return response()->json(['failure' => 'encryptedSecret parameter error'], $this->vaildStatus);
        }
        $input['encryptedSecret'] = $request->input('encryptedSecret');

        $secId = Secret::getUserId($input);

        if (!$secId) {
            return response()->json(['failure' => 'No User. Please register first.'], $this->vaildStatus);
        }

        try {
            $decryptedMessage = decrypt($input['encryptedSecret']);
        } catch (DecryptException $e) {
            return response()->json(['failure' => 'Decryption failed'], $this->vaildStatus);
        }

        $input['secId'] = $secId;

        $ret = Secret::insertMessageData($input);

        if (!$ret) {
            return response()->json(['failure' => 'Failed.'], $this->vaildStatus);
        }

        return response()->json(['success' => $ret], $this->successStatus);
    }

    /**
     * getSecret API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecret(Request $request) {
        if (!$request->input('username')) {
            return response()->json(['failure' => 'username parameter error'], $this->vaildStatus);
        }
        $input['username'] = $request->input('username');

        if (!$request->input('secretName')) {
            return response()->json(['failure' => 'secretName parameter error'], $this->vaildStatus);
        }
        $input['secretName'] = $request->input('secretName');

        $secId = Secret::getUserId($input);

        if (!$secId) {
            return response()->json(['failure' => 'No User. Please register first.'], $this->vaildStatus);
        }

        $messages = Secret::getMessage($input);

        if (!$messages) {
            return response()->json(['failure' => 'No message'], $this->vaildStatus);
        }

        $key = $this->serverKey;
        $ret = '';

        try {
            $ret = decrypt($messages->encryptedSecret);
        } catch (DecryptException $e) {
            return response()->json(['failure' => 'Decryption failed'], $this->vaildStatus);
        }

        $publicKey = str_replace("\\n", "\n", $messages->publicKey);

        $rsa = new RSA($publicKey);
        $ret = "-----start-----" . $ret . "-----end-----";
        $encryptedMessage = $rsa->base64Encrypt($ret);

        return response()->json(['success' => $encryptedMessage], $this->successStatus);
    }
}
