<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('laravel@comments.com', 'Commentator'),
            subject: "Comment Posted on {{ $this->comment->commentable->title}} blog post",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.posts.commented',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
//            Attachment::fromPath(storage_path('app/public/'.$this->comment->user->image->path))
//                ->as('The hacker.jpg')
//            Attachment::fromStorage($this->comment->user->image->path)
//                ->as('someone.jpg')
//            Attachment::fromStorageDisk('puplic', $this->comment->user->image->path)
//            ->as('name.file')
        ];
    }
}
