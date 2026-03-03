use App\Http\Controllers\Api\EmiController;
use App\Http\Controllers\Api\ToolJobController;

Route::post('/emi', [EmiController::class, 'calculate']);

// generic tool job endpoints (merge, split, compress, pdf->image, etc.)
Route::post('tools/{slug}', [ToolJobController::class, 'store']);
Route::get('jobs/{id}', [ToolJobController::class, 'show']);