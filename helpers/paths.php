<?php

/**
 * Function to get file config
 * @param   string File for get
 * @return  mixed
 */
function config($filename){
  $filename = str_replace('.','/', $filename);
  return require __DIR__ . '/../config/' . $filename . '.php';
}

/**
 * Function to render a view
 * @param   string View 
 * @return  string 
 */
function views(string $view){
  return resource($view, 'html');
}

function resource(string $resource, string $extension) {
  $file = __DIR__ . '/../resources/views/' . $resource . '.' . $extension;
  return file_exists($file) ? file_get_contents($file) : '';
}

function env(string $key, $default = ''){
  return getenv($key) ?? $default;
}