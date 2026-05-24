<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan dihapus.');
    }
}