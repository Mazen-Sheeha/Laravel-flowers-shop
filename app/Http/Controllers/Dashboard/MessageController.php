<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\MessageService;

class MessageController extends Controller
{

    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        return $this->messageService = $messageService;
    }

    public function index()
    {
        return $this->messageService->index();
    }

    public function destroy(string $id)
    {
        return $this->messageService->destroy($id);
    }

    public function readMessage(string $id)
    {
        return $this->messageService->readMessage($id);
    }
}
