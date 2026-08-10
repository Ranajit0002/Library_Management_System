<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\BookIssue;
use Illuminate\Support\Facades\Route;

class BookDueReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected BookIssue $bookIssue;
    public function __construct(BookIssue $bookIssue)
    {
        $this->bookIssue = $bookIssue;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $actionRoute = Route::has('member.book_issues.my') ? route('member.book_issues.my') : (Route::has('book_issues.my') ? route('book_issues.my') : url('/member/book-issues/my'));

        return (new MailMessage)
            ->subject('Library Notice: Book Due Date Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is a friendly reminder that the book "' . optional($this->bookIssue->book)->title . '" is due for return on ' . $this->bookIssue->due_date . '.')
            ->line('Please return or renew it on time to avoid late fines.')
            ->action('View My Borrowings', $actionRoute)
            ->line('Thank you for using our library system!');
    }

    public function toArray($notifiable)
    {
        return [
            'book_issue_id' => $this->bookIssue->id,
            'book_title' => optional($this->bookIssue->book)->title,
            'due_date' => $this->bookIssue->due_date,
            'message' => 'Your book "' . optional($this->bookIssue->book)->title . '" is due on ' . $this->bookIssue->due_date . '.',
        ];
    }
}
