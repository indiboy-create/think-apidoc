<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 不使用配置中的全局请求Headers参数
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NotHeaders extends AbstractAnnotation
{

    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
