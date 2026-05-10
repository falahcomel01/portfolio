<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return view('admin.contact-show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        try {
            DB::transaction(function () use ($contact) {
                $contact->delete();
            });

            return redirect()->route('admin.contacts')->with('success', 'Pesan berhasil dihapus!');
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('admin.contacts')->with('error', 'Pesan gagal dihapus. Silakan coba lagi.');
        }
    }

    public function bulkDestroyUnread()
    {
        try {
            $deletedCount = DB::transaction(function () {
                return Contact::query()
                    ->where('is_read', false)
                    ->delete();
            });

            if ($deletedCount === 0) {
                return redirect()->route('admin.contacts')->with('error', 'Tidak ada pesan belum dibaca yang bisa dihapus.');
            }

            return redirect()->route('admin.contacts')->with('success', "{$deletedCount} pesan belum dibaca berhasil dihapus.");
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('admin.contacts')->with('error', 'Bulk delete gagal dijalankan. Silakan coba lagi.');
        }
    }
}
