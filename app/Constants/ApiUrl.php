<?php

namespace App\Constants;

enum ApiUrl: string
{
    case DIVISIONS = '/Divisions/datatable';
    case DIVISIONS_CREATE = '/Divisions';
    case USERS = '/Users';
}
