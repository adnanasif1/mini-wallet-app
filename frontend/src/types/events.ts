export interface TransactionEvent {
  id: number
  sender_id: number
  receiver_id: number
  amount: number
  commission_fee: number
  sender_balance: number
  receiver_balance: number
  created_at: string
}