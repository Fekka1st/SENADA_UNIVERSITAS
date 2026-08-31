<?php

namespace App\Events;

use App\Models\Notifikasi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifikasiBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifikasi;

    /**
     * Create a new event instance.
     */
    public function __construct(Notifikasi $notifikasi)
    {
        $this->notifikasi = $notifikasi;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifikasi-user.' . $this->notifikasi->user_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notifikasi.baru';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notifikasi->id,
            'jenis' => $this->notifikasi->jenis,
            'judul' => $this->notifikasi->judul,
            'pesan' => $this->notifikasi->pesan,
            'data' => $this->notifikasi->data,
            'icon' => $this->notifikasi->icon,
            'url' => $this->notifikasi->url,
            'waktu_relatif' => $this->notifikasi->waktu_relatif,
            'created_at' => $this->notifikasi->created_at->toISOString(),
        ];
    }
}
