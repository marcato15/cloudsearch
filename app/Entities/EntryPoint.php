<?php

namespace Search\Entities;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * The representation of an event within the api system.
 *
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route("entrypoint")
 * )
 *
 * @Hateoas\Relation(
 *     "pageSearch",
 *     href = @Hateoas\Route("pageSearch")
 * )
 *
 * @Hateoas\Relation(
 *     "objectSearch",
 *     href = @Hateoas\Route("objectSearch")
 * )
 *
 **/

class EntryPoint {

}
