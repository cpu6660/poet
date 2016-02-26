<?php
namespace Poet\Framework\Util\Contract;
use Closure;
abstract class BaseMiddleware {

    public abstract function handle($params,Closure $next);
}