<?php
class Respon {
    public $status;
    public $message;
    public $data;

    // fungsi untuk menyimpan status, pesan, dan data
    public function __construct(bool $status, string $message, $data = null) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }
}