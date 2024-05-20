<?php

use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders(
        [
            ...(require __DIR__ . '/providers.php'),
        ],
        false
    )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([]);

        $middleware->api(append: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            'signed' => \App\Http\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, \Throwable $exception) {
            $code = $response->getStatusCode() ?? 0;
            $title = match ((string) $code) {
                '0'            => 'Error desconocido',
                '100'          => 'Continuar',
                '101'          => 'Protocolos de conmutación',
                '102'          => 'Procesando',
                '200'          => 'OK',
                '201'          => 'Creado',
                '202'          => 'Aceptado',
                '203'          => 'Información no autorizada',
                '204'          => 'Sin contenido',
                '205'          => 'Restablecer contenido',
                '206'          => 'Contenido parcial',
                '207'          => 'Multiestado',
                '208'          => 'Ya Reportado',
                '226'          => 'Estoy usado',
                '300'          => 'Múltiples opciones',
                '301'          => 'Movido permanentemente',
                '302'          => 'Encontrado',
                '303'          => 'Ver otros',
                '304'          => 'No modificado',
                '305'          => 'Usa proxy',
                '307'          => 'Redirección temporal',
                '308'          => 'Redirección permanente',
                '400'          => 'Solicitud incorrecta',
                '401'          => 'No autorizado',
                '402'          => 'Pago requerido',
                '403'          => 'Prohibido',
                '404'          => 'No encontrado',
                '405'          => 'Método no permitido',
                '406'          => 'Inaceptable',
                '407'          => 'Se requiere autenticación proxy',
                '408'          => 'Solicitud de tiempo de espera',
                '409'          => 'Conflicto',
                '410'          => 'Recurso no disponible',
                '411'          => 'Longitud requerida',
                '412'          => 'Error de condición previa',
                '413'          => 'Solicitud demasiado grande',
                '414'          => 'URI demasiado largo',
                '415'          => 'Tipo de medio no admitido',
                '416'          => 'Rango no satisfactorio',
                '417'          => 'Expectativa fallida',
                '418'          => 'Soy una tetera',
                '419'          => 'La sesión ha expirado',
                '421'          => 'Solicitud mal dirigida',
                '422'          => 'Entidad no procesable',
                '423'          => 'Bloqueado',
                '424'          => 'Dependencia fallida',
                '425'          => 'Demasiado temprano',
                '426'          => 'Se requiere actualización',
                '428'          => 'Precondición requerida',
                '429'          => 'Demasiadas solicitudes',
                '431'          => 'Campos de encabezado de solicitud demasiado grandes',
                '444'          => 'Conexión cerrada sin respuesta',
                '449'          => 'Reintentar con',
                '451'          => 'No disponible por razones legales',
                '499'          => 'Solicitud cerrada del cliente',
                '500'          => 'Error interno del servidor',
                '501'          => 'No se ha implementado',
                '502'          => 'Mala puerta de enlace',
                '503'          => 'Modo de mantenimiento',
                '504'          => 'Tiempo de espera de puerta de enlace',
                '505'          => 'Versión HTTP no compatible',
                '506'          => 'Variante También Negocia',
                '507'          => 'Espacio insuficiente',
                '508'          => 'Bucle detectado',
                '509'          => 'Límite de ancho de banda excedido',
                '510'          => 'no extendido',
                '511'          => 'Se requiere autenticación de red',
                '520'          => 'Error desconocido',
                '521'          => 'El servidor web está caído',
                '522'          => 'Tiempo de conexión agotado',
                '523'          => 'El origen es inalcanzable',
                '524'          => 'Se produjo un tiempo de espera',
                '525'          => 'Protocolo de enlace SSL fallido',
                '526'          => 'Certificado SSL no válido',
                '527'          => 'Error de cañón de riel',
                '598'          => 'Error de tiempo de espera de lectura de red',
                '599'          => 'Error de tiempo de espera de conexión de red',
                'unknownError' => 'Error desconocido',
            };
            return response()->json(['exception' => ['title' => $title, 'text' => $exception->getMessage(), 'code' => $code]], $code);
        });
    })->create();
