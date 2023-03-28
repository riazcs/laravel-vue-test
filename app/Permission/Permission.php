<?php

namespace App\Permission;

class Permission
{
    public function admin(Type $var = null)
    {
        $item = [
            'edit' => true,
            'delete' => true,
            'view' => true,
        ];
        return $item;
    }

    public function client(Type $var = null)
    {
        $item = [
            'edit' => false,
            'delete' => false,
            'view' => true,
        ];
        return $item;
    }

    public function modarator(Type $var = null)
    {
        $item = [
            'edit' => true,
            'delete' => false,
            'view' => true,
        ];
        return $item;
    }
}
