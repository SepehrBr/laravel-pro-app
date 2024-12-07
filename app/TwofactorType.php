<?php

namespace App;

enum TwofactorType: string
{
    case Off = 'off';
    case Sms = 'sms';
}
