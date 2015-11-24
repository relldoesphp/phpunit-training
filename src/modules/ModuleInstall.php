<?php

abstract class ModuleInstall
{
    abstract function install();
    abstract function uninstall();
    abstract function requires($v);
}