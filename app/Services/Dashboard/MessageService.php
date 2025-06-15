<?php

namespace App\Services\Dashboard;

use App\Models\Message;

class MessageService
{
    public function index()
    {
        $messages = Message::with('user')->orderBy("seen")->orderBy('id', "DESC")->paginate(15);
        return view("dashboard.messages.index", compact("messages"));
    }

    public function destroy(string $id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return back()->with("success", "Message deleted successfully");
    }

    public function readMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->seen = true;
        $message->save();
        return response()->json(['success' => true]);
    }
}
