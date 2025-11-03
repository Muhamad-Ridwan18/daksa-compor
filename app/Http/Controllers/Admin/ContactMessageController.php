<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewing
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }
        
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => true]);
        
        return back()->with('success', 'Pesan telah ditandai sebagai dibaca.');
    }

    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => false]);
        
        return back()->with('success', 'Pesan telah ditandai sebagai belum dibaca.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return redirect()->route('admin.contact-messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
