<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FolderController;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BenefController;
use App\Http\Controllers\UnidadesorgController;
use App\Http\Controllers\EtapasprocController;
use App\Http\Controllers\ProcesoscontController;
use App\Http\Controllers\TrayectoriaController;
use App\Http\Controllers\ListaverifController;
use App\Http\Controllers\PacController;

// use App\Http\Controlers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])
    ->name('account')
    ->group(function () {
        Route::get('/account', function () {
            return view('users.account');
        });
});

// middleware superadmin access
Route::middleware(['auth', 'verified', 'can:crud-usuario'])
    ->name('dashboard')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        });
});

Route::middleware(['auth', 'role:Administrador'])->group(function () {
        Route::get('/benef', [BenefController::class, 'index'])->name('benef.index');
        Route::get('benef/crear', [BenefController::class, 'create'])->name('benef.crear');
        Route::post('benef/store', [BenefController::class, 'store'])->name('benef.store');
        Route::get('benef/{id}/editar', [BenefController::class, 'edit'])->name('benef.editar');
        Route::put('benef/{id}/update', [BenefController::class, 'update'])->name('benef.update');
        Route::delete('benef/{id}/delete', [BenefController::class, 'destroy'])->name('benef.destroy');
        
        Route::get('/unidadesorg', [UnidadesorgController::class, 'index'])->name('unidadesorg.index');
        Route::get('unidadesorg/crear', [UnidadesorgController::class, 'create'])->name('unidadesorg.crear');
        Route::post('unidadesorg/store', [UnidadesorgController::class, 'store'])->name('unidadesorg.store');
        Route::get('unidadesorg/{id}/editar', [UnidadesorgController::class, 'edit'])->name('unidadesorg.editar');
        Route::put('unidadesorg/{id}/update', [UnidadesorgController::class, 'update'])->name('unidadesorg.update');
        Route::delete('unidadesorg/{id}/delete', [UnidadesorgController::class, 'destroy'])->name('unidadesorg.destroy');
        
        Route::get('/etapasproc', [EtapasprocController::class, 'index'])->name('etapasproc.index');
        Route::get('etapasproc/crear', [EtapasprocController::class, 'create'])->name('etapasproc.crear');
        Route::post('etapasproc/store', [EtapasprocController::class, 'store'])->name('etapasproc.store');
        Route::get('etapasproc/{id}/editar', [EtapasprocController::class, 'edit'])->name('etapasproc.editar');
        Route::put('etapasproc/{id}/update', [EtapasprocController::class, 'update'])->name('etapasproc.update');
        Route::delete('etapasproc/{id}/delete', [EtapasprocController::class, 'destroy'])->name('etapasproc.destroy');

});

/**
 * Grupo de rutas protegidas por el middleware 'auth'.
 *
 * Todas las rutas dentro de este grupo requieren que el usuario esté autenticado para acceder a ellas.
 * Este grupo de rutas abarca las funcionalidades relacionadas con la gestión de perfiles de usuario,
 */

 Route::get('/home', [UserController::class, 'home'])->name('home');
 
 Route::middleware(['auth', 'role:Operador|Administrador'])->group(function () {

    // Rutas que solo pueden ser accedidas por usuarios con el rol 'Operador'
    Route::get('/procesoscont', [ProcesoscontController::class, 'index'])->name('procesoscont.index');
    Route::get('procesoscont/crear', [ProcesoscontController::class, 'create'])->name('procesoscont.crear');
    Route::post('procesoscont/store', [ProcesoscontController::class, 'store'])->name('procesoscont.store');
    Route::get('procesoscont/{id}/editar', [ProcesoscontController::class, 'edit'])->name('procesoscont.editar');
    Route::put('procesoscont/{id}/update', [ProcesoscontController::class, 'update'])->name('procesoscont.update');
    Route::delete('procesoscont/{id}/delete', [ProcesoscontController::class, 'destroy'])->name('procesoscont.destroy');

    Route::get('procesoscont/{idp}/crear_docstec', [ProcesoscontController::class, 'crear_docstec'])->name('procesoscont.crear_docstec');
    Route::post('procesoscont/store_docstec', [ProcesoscontController::class, 'store_docstec'])->name('procesoscont.store_docstec');
    Route::post('procesoscont/store_docstec_os', [ProcesoscontController::class, 'store_docstec_os'])->name('procesoscont.store_docstec_os');
    Route::post('procesoscont/store_docstec_oc', [ProcesoscontController::class, 'store_docstec_oc'])->name('procesoscont.store_docstec_oc');
    Route::get('procesoscont/{doctec}/pdfdt', [ProcesoscontController::class, 'pdfdt'])->name('procesoscont.pdfdt');
    Route::get('procesoscont/{doctec}/pdfdt2', [ProcesoscontController::class, 'pdfdt2'])->name('procesoscont.pdfdt2');
    Route::get('procesoscont/{doctec}/pdfos', [ProcesoscontController::class, 'pdfos'])->name('procesoscont.pdfos');
    Route::get('procesoscont/{doctec}/pdfos2', [ProcesoscontController::class, 'pdfos2'])->name('procesoscont.pdfos2');
    Route::get('procesoscont/{doctec}/pdfoc', [ProcesoscontController::class, 'pdfoc'])->name('procesoscont.pdfoc');
    Route::get('procesoscont/{doctec}/pdfoc2', [ProcesoscontController::class, 'pdfoc2'])->name('procesoscont.pdfoc2');    
    Route::get('procesoscont/{proceso}/pdf_proc', [ProcesoscontController::class, 'pdf_proc'])->name('procesoscont.pdf_proc');    
    Route::get('procesoscont/{idproc}/{idtray}/autorizar', [ProcesoscontController::class, 'autorizar'])->name('procesoscont.autorizar');    
    
    Route::get('/trayectoria', [TrayectoriaController::class, 'index'])->name('trayectoria.index');
    Route::get('trayectoria/{id}/iniciar', [TrayectoriaController::class, 'iniciarproc'])->name('trayectoria.iniciarproc');
    //Route::get('trayectoria/{id}/iniciarpac', [TrayectoriaController::class, 'iniciarpac'])->name('trayectoria.iniciarpac');
    Route::get('trayectoria/{id}/recibir/', [TrayectoriaController::class, 'recibirproc'])->name('trayectoria.recibirproc');
    Route::get('trayectoria/{id}/derivar', [TrayectoriaController::class, 'derivarproc'])->name('trayectoria.derivarproc');
    
    Route::get('trayectoria/{idproc}/{deproc}/seguir', [TrayectoriaController::class, 'seguirproc'])->name('trayectoria.seguirproc');
    
    Route::post('trayectoria/storenew', [TrayectoriaController::class, 'storenew'])->name('trayectoria.storenew');
    Route::get('trayectoria/{id}/storenewp', [TrayectoriaController::class, 'storenewp'])->name('trayectoria.storenewp');
    Route::post('trayectoria/storerec', [TrayectoriaController::class, 'storerec'])->name('trayectoria.storerec');
    Route::post('trayectoria/storeder', [TrayectoriaController::class, 'storeder'])->name('trayectoria.storeder');
    Route::get('trayectoria/{id}/descargar', [TrayectoriaController::class, 'descargararch'])->name('trayectoria.descargararch');
    Route::get('trayectoria/plantilla', [TrayectoriaController::class, 'descargarplanti'])->name('trayectoria.descargarplanti');
    Route::get('trayectoria/{id}/finalizar', [TrayectoriaController::class, 'finalizarproc'])->name('trayectoria.finalizarproc');
    //Route::post('listaverif/store', [ListaverifController::class, 'store'])->name('listaverif.store');//no está en uso

    //09/02/2024 se definió habilitar PACs a usuario rol:Operador
    Route::get('/pacs', [PacController::class, 'index'])->name('pacs.index');
    Route::get('pacs/crear', [PacController::class, 'create'])->name('pacs.crear');
    Route::post('pacs/store', [PacController::class, 'store'])->name('pacs.store');
    Route::get('pacs/{id}/editar', [PacController::class, 'edit'])->name('pacs.editar');
    Route::put('pacs/{id}/update', [PacController::class, 'update'])->name('pacs.update');
    Route::delete('pacs/{id}/delete', [PacController::class, 'destroy'])->name('pacs.destroy');
    Route::get('pacs/{programa}/pdfpac', [PacController::class, 'pdfpac'])->name('pacs.pdfpac');

 });

 Route::middleware('auth')->group(function () {
    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cuenta de usuario
    Route::get('/account', [UserController::class, 'account_details'])->name('users.account');
    
});

// routes defaults make crud
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
