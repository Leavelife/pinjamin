<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;

class HistoryController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang','user'])
            ->orderBy('created_at','desc')->get()
            ->map(fn($p) => [
                'type'=>'pinjam',
                'title'=>$p->barang?->nama ?? '-',
                'subtitle'=>'Dipinjam oleh '.($p->user?->name ?? '-'),
                'status'=>$p->status ?? 'diajukan',
                'date'=>$p->created_at,
                'meta'=>$p,
                'url'=> isset($p->barang->id) ? route('barang.detail', $p->barang->id) : '#',
            ]);

        $barangs = Barang::with('user')
            ->orderBy('created_at','desc')->get()
            ->map(fn($b) => [
                'type'=>'tawarkan',
                'title'=>$b->nama ?? '-',
                'subtitle'=>'Ditawarkan oleh '.($b->user?->name ?? '-'),
                'status'=>$b->status ?? 'tersedia',
                'date'=>$b->created_at,
                'meta'=>$b,
                'url'=> route('barang.detail', $b->id),
            ]);

        $items = $peminjamans->concat($barangs)->sortByDesc('date')->values();

        return view('user.history', compact('items'));
    }
}