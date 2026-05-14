<?php

namespace App\Constants;

enum ApiUrl: string
{
    case DIVISIONS = '/Divisions/datatable';
    case DIVISIONS_CREATE = '/Divisions';
    case CATEGORIES = '/Categories/datatable';
    case CATEGORIES_CREATE = '/Categories';
    case VENDORS = '/Vendors/datatable';
    case VENDORS_CREATE = '/Vendors';
    case USERS = '/Users';
    case PRODUCTS = '/Products/datatable';
    case PRODUCTS_CREATE = '/Products';
    case ROLES = '/roles/datatable';
    case ROLES_CREATE = '/roles';
    case PROCUREMENT_REQUESTS_DATATABLE = '/procurement-requests/datatable';
    case PROCUREMENT_REQUESTS = '/procurement-requests';
}
