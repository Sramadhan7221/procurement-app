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
    case PROCUREMENT_PLACE_ORDER_SUFFIX = '/place-order';
    case PROCUREMENT_GOODS_RECEIPT_SUFFIX = '/goods-receipt';
    case PROCUREMENT_INVOICE_SUFFIX = '/invoice';
    case PROCUREMENT_INVOICE_DISPUTE_RESOLVE_SUFFIX = '/invoice/dispute/resolve';
    case PROCUREMENT_INVOICE_VERIFY_SUFFIX = '/invoice/verify';
    case PROCUREMENT_PAYMENT_SUFFIX = '/payment';
    case PROCUREMENT_PAYMENT_APPROVE_SUFFIX = '/payment/approve';
    case PROCUREMENT_PAYMENT_MARK_PAID_SUFFIX = '/payment/mark-paid';
    case PROCUREMENT_TIMELINE_SUFFIX = '/timeline';
    case PROCUREMENT_PURCHASE_ORDER_SUFFIX = '/purchase-order';
}
