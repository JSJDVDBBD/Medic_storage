<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Venta;
use App\Models\Alerta;
use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DetalleVenta;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicamentos = Medicamento::count();
        $categoriasCount = Categoria::count();
        $productosProximosCaducar = Medicamento::proximosCaducar()->count();
        $productosStockBajo = Medicamento::stockBajo()->count();
        
        // Ventas de hoy
        $ventasHoy = Venta::whereDate('created_at', today())->sum('total');
        $ventasCount = Venta::whereDate('created_at', today())->count();
        
        // Ventas últimos 7 días para la gráfica
        $ventasUltimos7Dias = Venta::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        // Métodos de pago últimos 7 días
        $metodosPago = Venta::selectRaw('metodo_pago, SUM(total) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('metodo_pago')
            ->get();
        
        // Top 5 productos más vendidos (últimos 30 días)
        $topProductos = DetalleVenta::with('medicamento')
            ->selectRaw('medicamento_id, SUM(cantidad) as total_vendido')
            ->whereHas('venta', function($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->groupBy('medicamento_id')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();
        
        // 5 productos próximos a caducar (más urgentes)
        $proximosCaducar = Medicamento::proximosCaducar()
            ->orderBy('fecha_caducidad')
            ->limit(5)
            ->get();
        
        // Alertas no resueltas
        $alertasPendientes = Alerta::with('medicamento')
            ->where('resuelta', false)
            ->orderBy('fecha_alerta')
            ->limit(5)
            ->get();
        
        $alertasPendientesCount = Alerta::where('resuelta', false)->count();

        return view('dashboard', compact(
            'totalMedicamentos',
            'categoriasCount',
            'productosProximosCaducar',
            'productosStockBajo',
            'ventasHoy',
            'ventasCount',
            'ventasUltimos7Dias',
            'metodosPago',
            'topProductos',
            'proximosCaducar',
            'alertasPendientes',
            'alertasPendientesCount'
        ));
    }
}