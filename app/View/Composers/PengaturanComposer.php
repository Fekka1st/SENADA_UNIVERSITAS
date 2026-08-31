<?php
 
namespace App\View\Composers;

use App\Models\Pengaturan;
use Illuminate\View\View;
 
class PengaturanComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // dapatkan data berdasarakan "id"
        $pengaturan = Pengaturan::first();
        
        // tampilkan data ke view
        $view->with('pengaturan', $pengaturan);
    }
}