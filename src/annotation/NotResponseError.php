<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 不使用异常响应体返回数据
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NotResponseError extends AbstractAnnotation
{

    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
