<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 接口Url
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Url extends AbstractAnnotation
{
    /**
     * @param string $value 接口Url
     */
    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
