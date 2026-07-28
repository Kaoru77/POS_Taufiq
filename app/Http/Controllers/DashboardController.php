<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\LaporanPenjualanService;
use App\Service\MonitoringStokService;  
use illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        private LaporanPenjualanService $laporanService,
        private MonitoringStokService $StokService
    ) {}


    public function index()
    {
        $ringkasan = $this->laporanService->ringkasanHariIni();

        return view('dashboard',[
            'tanggalHariIni' => Carbon::now(),
            'ringkasan' => $ringkasan,
            'produkTerlaris' => $this->laporanService->produkTerlarisHariIni(),
            'produkStokRendah' => $this->StokService->produkStokRendah(),
            'produkStokHabis' => $this->StokService->produkStokHabis()
        ]);
    }
}
