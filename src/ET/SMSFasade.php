<?php
namespace Aliraqi\ET;

use Illuminate\Support\Facades\Facade;

class SMSFasade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'sms'; }
}