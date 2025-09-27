<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class TransactionCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction->load(['sender','receiver']);
    }

    public function broadcastOn()
    {
        // here created private channels for both
        return [
            new PrivateChannel('user.' . $this->transaction->sender_id),
            new PrivateChannel('user.' . $this->transaction->receiver_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->transaction->id,
            'sender_id' => $this->transaction->sender_id,
            'receiver_id' => $this->transaction->receiver_id,
            'amount' => $this->transaction->amount,
            'commission_fee' => $this->transaction->commission_fee
        ];
    }

    public function broadcastAs()
    {
        return 'transaction.created';
    }
}
