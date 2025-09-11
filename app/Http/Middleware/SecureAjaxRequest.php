<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response;

class SecureAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws RandomException
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se a requisição é ajax
        if (!$request->ajax()) {
            abort(403, 'Apenas requisições AJAX são permitidas.');
        }

        // Pega os valores do header do ajax
        $tokenHeader = $request->header('X-Dynamic-Session-Token');
        $tabId = $request->header('X-tabId');

        // inicializa array de tokens válidos
        $allTokens = session('dynamic_tokens', []);

        if (empty($tabId) || !array_key_exists($tabId, $allTokens)) {
            abort(403, 'Aba inválida');
        }

        $tokens = $allTokens[$tabId] ?? [];

        //$currentToken = session('dynamic_token'); // vai sair

        // valida header
        if (empty($tokenHeader) || !in_array($tokenHeader, $tokens)) {
            abort(403, 'Token de sessão inválido ou ausente, recarregue a página.');
        }

        #region Log
        //  Faz log do token que veio no header
        //Log::info('Token recebido no header: ' . $tokenHeader);
        //Log::info('Token recebido na sessão: ' . ($currentToken ?? 'NENHUM'));
        //Log::info('Id da aba: ' . ($tabId ?? 'NENHUM'));
        //  Faz log da lista de tokens válidos da sessão
        //Log::debug('Tokens válidos atuais: ', $tokens);
        #endregion

        // Retorna o tipo de resposta da próxima função que trata essa request, o controller
        $response = $next($request);

        // Se a função que recebe essa request no controller retornar json, $response será uma instância json.
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $newToken = bin2hex(random_bytes(16));
            $tokens[] = $newToken;

            $limit = config('secure.dynamic_tokens_tolerance', 5);
            $allTokens[$tabId] = array_slice($tokens, -$limit);

            // atualiza sessão da aba
            session(['dynamic_tokens' => $allTokens]);

            // Envia no header para o axios interceptar e usar na próxima requisição
            $response->headers->set('X-Dynamic-Session-Token', $newToken);
        }

        return $response;
    }
}
