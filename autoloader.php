<?php

return function($directories, $fileFormat = null, $namespaceAliases = null, $classAliases = null) {
	$fileFormat = $fileFormat ?: '%s.php';
	$namespaceAliases = $namespaceAliases ?: array();
	$classAliases = $classAliases ?: array();

	spl_autoload_register(function($class) use ($fileFormat, $directories, $namespaceAliases, $classAliases) {
			$realClass = (isset($classAliases[$class]) === false ? $class : $classAliases[$class]);

			foreach ($namespaceAliases as $alias => $namespace)
			{
				$aliasLength = strlen($alias);

				if ($realClass !== $alias && strncmp($alias, $realClass, $aliasLength) === 0)
				{
					$realClass = $namespace . substr($class, $aliasLength);

					break;
				}
			}

			if ($realClass === $class || class_exists($realClass, false) === false) foreach ($directories as $namespace => $directory)
			{
				$namespaceLength = strlen($namespace);

				if ($realClass !== $namespace && strncmp($namespace, $realClass, $namespaceLength) === 0)
				{
					$path = $directory . sprintf($fileFormat, str_replace('\\', DIRECTORY_SEPARATOR, substr($realClass, $namespaceLength)));

					if (is_file($path) === true)
					{
						require $path;
					}

					break;
				}
			}

			if ($realClass !== $class && class_exists($realClass, false) === true)
			{
				class_alias($realClass, $class);
			}
		}
	);
};
