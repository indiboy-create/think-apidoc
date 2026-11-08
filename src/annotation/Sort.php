<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 排序
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"CLASS"})
 */
#[Attribute(Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class Sort extends AbstractAnnotation
{
    /**
     * @param string|int $value 排序
     */
    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
