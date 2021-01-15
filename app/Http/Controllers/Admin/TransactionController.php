<?php

namespace App\Http\Controllers\Admin;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionDetail;

class TransactionController extends Controller
{
     public function index()
    {

        if (request()->ajax()) {
            $transaction = TransactionDetail::with(['transaction.user', 'product.galleries']);
            // dd($category);
            return DataTables::of($transaction)
                ->make();
        }

        return view('pages.admin.transaction.index');
    }
}
