<?php

/**
 * Base Path
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
   $base_path = __DIR__ . "/" . $path;
   if (file_exists($base_path)) return $base_path;
   else echo "Path $path does not exist";
}

/**
 * Load View
 * 
 * @param string $name
 * @return void 
 * 
 */

function loadView($name)
{
   $base_path = basePath("view/{$name}.php");
   if (file_exists($base_path)) require $base_path;
   else echo "Path $name.php does not exist";
}

/**
 * Load Partials
 * 
 * @param string $name
 * @return void 
 * 
 */

function loadPartial($name)
{
   $base_path = basePath("view/partials/{$name}.php");
   if (file_exists($base_path)) require $base_path;
   else echo "Path $name.php does not exist";
}

/**
 * Inspect Value
 *
 * @param mixed $value
 *@return void
 */

function inspect($value)
{
   echo "<pre>";
   var_dump($value);
   echo "</pre>";
}

/**
 * Inspect Value
 *
 * @param mixed $value
 *@return void
 */

function inspectDie($value)
{
   echo "<pre>";
   var_dump($value);
   echo "</pre>";
}
