<?php

namespace Mc;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD)]
class Route
{
	public string $path;
	public array $methods;

	public function __construct(string $path, array $methods = ['GET'])
	{
		$this->path = $path;

		$normalizedMethods = [];
		foreach ($methods as $method) {
			$normalizedMethod = strtoupper(trim((string) $method));
			if ($normalizedMethod !== '') {
				$normalizedMethods[] = $normalizedMethod;
			}
		}

		if (empty($normalizedMethods)) {
			$normalizedMethods = ['GET'];
		}

		$this->methods = array_values(array_unique($normalizedMethods));
	}
}
