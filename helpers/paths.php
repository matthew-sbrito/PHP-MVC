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
 * Function to get file resources
 * @param   string File to get
 * @return  mixed
 */
function resources($filename){
  return require RESOURCES . '/' . $filename;
}

/**
 * Function to render a view
 * @param   string View 
 * @return  string 
 */
function views(string $view){
  $file = __DIR__ . '/../resources/views/' . $view . '.html';
  return file_exists($file) ? file_get_contents($file) : '';
}