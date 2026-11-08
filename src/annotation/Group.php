<?php

namespace YouVision\ThinkApidoc\annotation;

use Attribute;
use YouVision\ThinkApidoc\utils\AbstractAnnotation;

/**
 * 分组
 * @package YouVision\ThinkApidoc\annotation
 * @Annotation
 * @Target({"CLASS"})
 */
#[Attribute(Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class Group extends AbstractAnnotation
{
    /**
     * @param string $name 分组
     */
    public function __construct(...$value)
    {
        parent::__construct(...$value);
    }
}
