<?php
 
namespace Fet\CookieConsent\Events;
 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
 
class ConfigLoaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public function __construct(
        public object $cookieConsent,
    ) {}
}