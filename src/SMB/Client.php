<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 12/10/2023
 * Time: 11:58 PM
 */

namespace App\SMB;


use App\DB\Command;

abstract class Client extends Command
{

    static function HostAddress()
    {
        return gethostbyaddr($_SERVER['REMOTE_ADDR']);
    }


    static function Logger($params = "")
    {
        $cmd = new Command();
        $auth = new Auth();

        if (!empty($params)) {
            $log = $params;
            @$log += [
                'tbl_scheme' => $cmd->logger,
                'remote_address' => $_SERVER['REMOTE_ADDR'],
                'host_address' => self::HostAddress(),
            ];
            $user = $auth->AuthUser();
            if (!empty($user)) {
                $log += [
                    'user' => $user->username,
                    'full_name' => $auth->AuthName()
                ];
            }
            $cmd->createRecord($log);
        }

    }


    static function ClassName($obj)
    {
        return (new \ReflectionClass($obj))->getShortName();
    }

    static function ModelName($obj)
    {
        @$unqual_class = end(explode('\\', get_class($obj)));
        preg_match_all('/.[^A-Z]*/', $unqual_class, $matches);
        return (implode('_', $matches[0]));
    }

    static function MethodNameExplode($obj)
    {
        @$result = end(explode('\\', ($obj)));
        @$result = end(explode('::', ($result)));
        return $result;
    }
}