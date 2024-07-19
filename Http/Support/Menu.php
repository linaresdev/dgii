<?php

return (new class {

    public function items() {

        $items = null;

        ## ENTITY
        $entity["icon"]     = 'bank';
        $entity["label"]    = __('words.entities');
        $entity["url"]      = __url('admin/entities');
        $items[]            = $entity;

        ## USERS
        $user["icon"]   = "account-circle";
        $user["label"]  = __("words.users");
        $user["url"]    = __url("admin/users");
        $items[]        = $user;

        ## SEGURIDAD
        $guard["icon"]   = "shield-link-variant-outline";
        $guard["label"]  = __("words.security");
        $guard["url"]    = __url("admin/stacks");
        $items[]         = $guard;
       
       return $items;
    }
});