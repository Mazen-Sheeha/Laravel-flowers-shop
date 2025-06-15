<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Message\CreateMessageRequest;
use App\Services\Front\MessageService;

class MessageController extends Controller
{

    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        return $this->messageService = $messageService;
    }

    public function create()
    {
        return $this->messageService->create();
    }

    public function store(CreateMessageRequest $request)
    {
        return $this->messageService->store($request);
    }
}
