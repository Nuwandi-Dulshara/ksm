<?php

namespace App\Notifications;

use App\Models\MoneyIssuance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MoneyIssuanceApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MoneyIssuance $moneyIssuance,
        public string $approverName,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Money Issuance Approved')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A money issuance has been approved by ' . $this->approverName . '.')
            ->line('**Details:**')
            ->line('Recipient: ' . ($this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown'))
            ->line('Amount: ' . number_format($this->moneyIssuance->amount, 2) . ' IQ')
            ->line('Reason: ' . $this->moneyIssuance->reason)
            ->line('Date: ' . $this->moneyIssuance->issued_date->format('d M Y'))
            ->action('View Details', route('money-issuances.show-report', $this->moneyIssuance))
            ->line('Thank you for using Accosys!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Money Issuance Approved',
            'message' => 'Money issuance of ' . number_format($this->moneyIssuance->amount, 2) . ' IQ for ' . ($this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown') . ' has been approved.',
            'money_issuance_id' => $this->moneyIssuance->id,
            'approver_name' => $this->approverName,
            'amount' => $this->moneyIssuance->amount,
            'recipient' => $this->moneyIssuance->issued_to ?? $this->moneyIssuance->issuedTo?->name ?? 'Unknown',
            'reason' => $this->moneyIssuance->reason,
            'type' => 'money_issuance_approved',
        ];
    }
}
