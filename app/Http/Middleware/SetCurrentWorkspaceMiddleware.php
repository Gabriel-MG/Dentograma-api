<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentWorkspaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        [$workspaceId, $source] = $this->resolveWorkspaceId($request);

        if (!$workspaceId) {
            abort(400, 'No se pudo determinar el workspace.');
        }

        $user = $request->user();
        if (!$user || !$user->workspaces()->where('workspaces.id', $workspaceId)->exists()) {
            abort(403, 'No perteneces a este workspace.');
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId($workspaceId);
        $request->attributes->set('workspace_id', $workspaceId);
        $request->attributes->set('workspace_source', $source);


        return $next($request);
    }

    protected function resolveWorkspaceId(Request $request): array
    {
        $route = $request->route();
        $hdr   = $request->header('X-Workspace-Id');

        if ($workspace = $route?->parameter('workspace') ?? $route?->parameter('workspace_id')) {
            $id = is_object($workspace) ? $workspace->id : (int)$workspace;

            // Si además vino header y NO coincide -> conflicto explícito
            if ($hdr && (int)$hdr !== $id) {
                abort(400, 'Workspace conflict: URL vs Header.');
            }
            return [$id, 'route'];
        }

        foreach ($route?->parameters() ?? [] as $param) {
            if (is_object($param) && isset($param->workspace_id)) {
                return [(int)$param->workspace_id, 'model'];
            }
        }

        if ($this->isApiRequest($request) && $hdr) {
            return [(int)$hdr, 'header'];
        }

        if ($request->session()->has('current_workspace_id')) {
            return [(int)$request->session()->get('current_workspace_id'), 'session'];
        }

        return [null, null];
    }

    protected function isApiRequest(Request $request): bool
    {
        // Ajusta a tu convención
        return Str::startsWith($request->path(), 'api/')
            || $request->expectsJson();
    }
}
