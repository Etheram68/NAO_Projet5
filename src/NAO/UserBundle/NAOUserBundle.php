<?php

namespace NAO\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NAOUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
