<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('article')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Comment berhasil disetujui.');
    }

    public function unapprove(Comment $comment)
    {
        $comment->update(['is_approved' => false]);
        return redirect()->back()->with('success', 'Comment berhasil ditolak.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment berhasil dihapus.');
    }
}

