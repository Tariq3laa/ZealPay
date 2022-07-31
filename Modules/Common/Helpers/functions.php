<?php

use Dompdf\Dompdf;
use Illuminate\Support\Str;
use Modules\Mobile\Enums\ReportTypes;
use Modules\Website\Resale\Entities\Resale;

function jsonResponse($code = 200, $message = '', $data = [])
{
    return response()->json([
        'code'    => $code,
        'message' => $message,
        'data'    => $data ?? [],
    ], $code);
}

function uploadFile($file, $path, $edit = false, $oldFile = null)
{
    $destination = env('SYSTEM_PATH')() . '/' . $path;
    $oldDestination = env('SYSTEM_PATH')() . '/' . $path . '/' . $oldFile;
    if ($edit && is_file($oldDestination)) {
        $name = explode('.', $oldFile)[0];
        if ($name != 'default') {
            unlink($oldDestination);
        }
    }
    $ext = $file->getClientOriginalExtension();
    $name = time() . Str::random(5);
    $fileName = $name . '.' . $ext;
    $file->move($destination, $fileName);
    return $fileName;
}


function getCode($code)
{
    $list = [501, 500, 415, 412, 406, 405, 404, 403, 401, 400, 307, 304, 303, 302, 301, 204, 202, 201, 200,];
    return in_array($code, $list) ? $code : 400;
}


function FCMPush($title, $body, $type, $token = null, $topic = null, $extra = [])
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $data = [
        "title"             => $title,
        "body"              => $body,
        "type"              => $type,
        //"data"  => $extra,
        'content_available' => true,
        'vibrate'           => 1,
        'sound'             => true,
        'priority'          => 'high',
    ];
    foreach ($extra as $key => $value) {
        $data[$key] = $value;
    }

    if ($topic != null) {
        $fields = [
            'to'           => '/topics/' . $topic,
            'notification' => $data,
            'priority'     => 'high'
        ];
    } else {
        $fields = [
            'to'           => $token,
            'notification' => $data,
            'priority'     => 'high'
        ];
    }
    $fcmApiKey = env('FIREBASE_TOKEN');
    $headers = [
        'Authorization: key=' . $fcmApiKey,
        'Content-Type:application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === false) {
        die('cUrl faild: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}


function lang($keyword)
{
    return trans('lang.' . $keyword);
}

function permissions($roles)
{
    $list = [
        "system"         => [
            "view"   => true,
            "edit"   => true,
            "add"    => true,
            "delete" => true,
        ],
        "admins"          => [
            "view"   => true,
            "edit"   => true,
            "add"    => true,
            "delete" => true,
        ],
        "dashboard"      => [
            "view" => true
        ]
    ];

    $objected = $keys = [];
    foreach ($roles as $rolePermission) {
        $key = explode('.', $rolePermission)[0];
        $keys[] = $key;
    }
    $keys = array_unique($keys);

    foreach ($list as $key => $value) {
        $permissionsOptionsKeys = array_keys($value);
        //$key = 'system_values';
        //permissionsOptionsKeys = [ "view", "edit" ];
        foreach ($permissionsOptionsKeys as $permissionsOptionsKey) {
            if (in_array($key . '.' . $permissionsOptionsKey, $roles)) {
                $objected[$key][$permissionsOptionsKey] = true;
            } else {
                $objected[$key][$permissionsOptionsKey] = false;
            }
        }
    }
    foreach ($objected as $object) {
        $object = (object)$object;
    }
    return (object)$objected;
}

function getPermissions($permissions)
{
    $result = [];
    $permissions = (array)$permissions;
    $permissionsListKeys = array_keys($permissions);
    foreach ($permissionsListKeys as $key) {
        $permission = (array)($permissions[$key]);
        $item = [];
        foreach ($permission as $Itemkey => $permissionAccessability) {
            if ($permissionAccessability) {
                $result[] = $key . '.' . $Itemkey;
            }
        }
    }
    return $result;
}

function randomStr()
{
    return str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
}

if (!function_exists('generateResaleListingId')) {
    function generateResaleListingId()
    {
        $latest_id = Resale::query()->orderBy('id', 'desc')->first()->id ?? 0;
        return ($latest_id + 1) . randomStr();
    }
}

if (!function_exists('generatePdf')) {
    function generatePdf($data)
    {
        $html = view($data['template']['path'], $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->output();
    }
}
