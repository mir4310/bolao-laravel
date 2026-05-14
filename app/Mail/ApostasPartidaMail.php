<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class ApostasPartidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $partida;

    public function __construct($partida)
    {
        $this->partida = $partida;
    }

    public function build()
    {
        return $this->subject('Apostas da Partida')
                    ->view('games.jogosapostas');
    }
}