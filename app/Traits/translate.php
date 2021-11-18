<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

/**
 * This Traits For Sending Message To Endpoints Api
 */

trait translate
{

    public function CREATE_TRANSLATE($table){

        return (App::getLocale() === 'en' ?  (__('tables.SUCCESS') .  __('tables.' . $table)) : (__('tables.CREATD') . __('tables.' . $table) . __('tables.SUCCESS')));
    }

    public function UPDATE_TRANSLATE($table){

        return (App::getLocale() === 'en' ?  (__('tables.UPDATE') .  __('tables.' . $table)) : (__('tables.UPDATE') . __('tables.' . $table) . __('tables.SUCCESS')));
    }

    public function DELETE_TRANSLATE($table){

        return (App::getLocale() === 'en' ?  (__('tables.DELETE') .  __('tables.' . $table)) : (__('tables.DELETE') . __('tables.' . $table) . __('tables.SUCCESS')));
    }

    public function FAILED_DELETE_TRANSLATE($table){

        return (__('tables.FAILED_DELETE') .  __('tables.' . $table));
    }

    public function SEND_TRANSLATE($table){

        return (App::getLocale() === 'en' ?  (__('tables.SEND') .  __('tables.' . $table)) : (__('tables.SEND') . __('tables.' . $table) . __('tables.SUCCESS')));
    }

    public function SEND_FAILED_TRANSLATE($table){

        return (__('tables.SEND_FAILED') .  __('tables.' . $table));
    }

    public function STATUS_TRANSLATE($table){

        return (App::getLocale() === 'en' ?  (__('tables.UPDATE') .  __('tables.' . $table) .  __('tables.STATUS'))  : (__('tables.UPDATE') . __('tables.STATUS') . __('tables.' . $table)));
    }

    public function DELETE_IMAGE_TRANSLATE(){

        return (App::getLocale() === 'en' ?  (__('tables.DELETE') .  __('tables.IMAGE')) : (__('tables.DELETE') . __('tables.IMAGE') . __('tables.SUCCESS')));
    }
}
