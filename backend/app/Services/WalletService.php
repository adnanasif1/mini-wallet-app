<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\TransactionCreated;
use Illuminate\Validation\ValidationException;

class WalletService
{
    private const COMMISSION_RATE = 0.015; // 1.5%

    public function transfer(int $senderId, int $receiverId, int $amountInCents) : Transaction
    {

        if ($amountInCents <= 0) {
            throw ValidationException::withMessages(['amount' => 'Please specify amount']);
        }

        if ($senderId === $receiverId) {
            throw ValidationException::withMessages(['receiver_id' => 'Sender and Receiver can not be same']);
        }
        
        $newTransaction =  DB::transaction(function () use ($senderId, $receiverId, $amountInCents) {
            
            // Here we lock both users to handle deadlock issues
            $ids = [$senderId, $receiverId];
            sort($ids);

            $users = User::whereIn('id', $ids)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $sender = $users->get($senderId);
            $receiver = $users->get($receiverId);

            $commissionCents = round($amountInCents * self::COMMISSION_RATE);

            $totalDebitAmount = $amountInCents + $commissionCents;

            $senderBalance = $sender->getMyBalance();

            if ($senderBalance < $totalDebitAmount) {
                throw ValidationException::withMessages(['amount' => 'Insufficient balance.']);
            }

            $receiverBalance =  $receiver->getMyBalance();

            $senderBalanceNew = $senderBalance - $totalDebitAmount;
            $receiverBalanceNew = $receiverBalance + $amountInCents;

            // sender balance update
            $sender->setMyBalance($senderBalanceNew);
            $sender->save();

            // receiver balance update
            $receiver->setMyBalance($receiverBalanceNew);
            $receiver->save();

            // Create transaction
            $transaction = Transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amountInCents,
                'commission_fee' => $commissionCents,
            ]);

            event(new TransactionCreated($transaction));

            return $transaction;
        });

        return $newTransaction;
    }
}
