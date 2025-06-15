<?php

namespace App\Services\Front;

use App\Http\Requests\Front\Message\CreateMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageService
{

    public function create()
    {
        return view("front.contact_us");
    }

    public function store(CreateMessageRequest $request)
    {
        $validated = $request->only('message_content');
        $validated['user_id'] = Auth::guard("web")->user()->id;
        $validated['seen'] = 0;
        $validated['message_content'] = nl2br($validated['message_content']);
        Message::create($validated);
        return back()->with("success", "Your message have been delivered");
    }
}
