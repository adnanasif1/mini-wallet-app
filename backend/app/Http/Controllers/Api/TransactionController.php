<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use App\Models\User;

class TransactionController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->middleware('auth:sanctum');
        $this->walletService = $walletService;
    }

    public function listTransactions(Request $request)
    {
        $user = $request->user();

        $transactions = Transaction::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'balance' => $user->balance,
            'transactions' => $transactions,
        ]);
    }

    public function transferFunds(StoreTransactionRequest $request)
    {
 
        $sender = $request->user();
        $receiverId = $request->input('receiver_id');
        $amountCents = $request->input('amount_cents');

        $transaction = $this->walletService->transfer($sender->id, $receiverId, $amountCents);

        return response()->json([
            'message' => 'Funds transfer successful',
            'transaction' => $transaction,
        ], 201);
    }
}
