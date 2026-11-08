<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 调试时请求类型
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ContentType extends AbstractAnnotation
{
    /**
     * @param string $value 调试时请求类型
     */
    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
