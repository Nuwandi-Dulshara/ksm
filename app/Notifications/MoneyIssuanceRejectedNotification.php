<?php

namespace App\Notifications;

use App\Models\MoneyIssuance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MoneyIssuanceRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MoneyIssuance $moneyIssuance,
        public string $approverName,
        public string $rejectionReason = '',
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Money Issuance Rejected')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A money issuance has been rejected by ' . $this->approverName . '.')
            ->line('**Details:**')
            ->line('Recipient: ' . ($this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown'))
            ->line('Amount: ' . number_format($this->moneyIssuance->amount, 2) . ' IQ')
            ->line('Reason: ' . $this->moneyIssuance->reason)
            ->line('Date: ' . $this->moneyIssuance->issued_date->format('d M Y'))
            ->when($this->rejectionReason, function ($message) {
                return $message->line('**Rejection Reason:** ' . $this->rejectionReason);
            })
            ->action('View Details', route('money-issuances.show-report', $this->moneyIssuance))
            ->line('Thank you for using Accosys!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Money Issuance Rejected',
            'message' => 'Money issuance of ' . number_format($this->moneyIssuance->amount, 2) . ' IQ for ' . ($this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown') . ' has been rejected.',
            'money_issuance_id' => $this->moneyIssuance->id,
            'approver_name' => $this->approverName,
            'amount' => $this->moneyIssuance->amount,
            'recipient' => $this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown',
            'reason' => $this->moneyIssuance->reason,
            'rejection_reason' => $this->rejectionReason,
            'type' => 'money_issuance_rejected',
        ];
    }
}
